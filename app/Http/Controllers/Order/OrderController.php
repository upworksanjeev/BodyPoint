<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\EmergencyModeSetting;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function PlaceOrder(Request $request, $order_id){
        // Phase 1 behavior: do not block active/in-progress submit flows server-side.
        // Re-enable this guard in Phase 2 along with full emergency-mode UX controls.
        // if (EmergencyModeSetting::current()->is_enabled) {
        //     return redirect()->back()->with('error', emergencyModeMessage());
        // }

        $customer_po_number = $request->customer_po_number;
        $is_duplicate = $request->is_duplicate;
        $idDuplicate = 'N';
        if($is_duplicate == 'yes'){
            $idDuplicate = 'Y';
        }
        $customer = getCustomer();
        
        if(!$customer->hasPermissionTo('placeOrders')){
            //abort(403);
            return redirect()->route('dashboard');
        }
        try{
            DB::beginTransaction();
            $order = null;

            // First, check the current order status in our database
            $existingOrder = Order::where('purchase_order_no', $order_id)->first();
            if (!$existingOrder) {
                DB::rollBack();
                Log::error('PlaceOrder - Order not found in database:', [
                    'purchase_order_no' => $order_id,
                ]);
                return back()->withInput()->with(['error' => 'Order not found. Please try again or contact support.', 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
            }

            // Verify order exists in Syspro before attempting to place it
            $url = 'GetOrderDetails/' . $order_id;
            $orderDetails = SysproService::getOrderDetails($url);
            if (empty($orderDetails['response']) || !empty($orderDetails['response']['Error'])) {
                DB::rollBack();
                Log::error('PlaceOrder - Order not found in Syspro:', [
                    'purchase_order_no' => $order_id,
                    'response' => $orderDetails,
                ]);
                return back()->withInput()->with(['error' => 'Order details are not available in the system. Please contact support.', 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
            }

            // If order status is not 'F' (Forward Order/Quote), it may already be placed
            if ($existingOrder->status !== 'F') {
                Log::warning('PlaceOrder - Order status is not Forward Order:', [
                    'order_id' => $existingOrder->id,
                    'purchase_order_no' => $order_id,
                    'current_status' => $existingOrder->status,
                ]);
            }

            $url = 'PlaceOrder';
            $response = SysproService::placeOrder($url,$order_id, $customer_po_number,$idDuplicate );

            // Log the full response for debugging
            Log::info('PlaceOrder API Response:', [
                'order_id' => $order_id,
                'customer_po_number' => $customer_po_number,
                'response_code' => $response['code'] ?? null,
                'response' => $response['response'] ?? null,
            ]);

            // Check for errors in multiple formats
            $errorMessage = null;
            if (!empty($response['response']['Error'])) {
                $errorMessage = $response['response']['Message'] ?? $response['response']['Error'];
            } elseif (!empty($response['response']['Message']) &&
                      (stripos($response['response']['Message'], 'not permitted') !== false ||
                       stripos($response['response']['Message'], 'error') !== false ||
                       stripos($response['response']['Message'], 'failed') !== false)) {
                $errorMessage = $response['response']['Message'];
            } elseif (!empty($response['code']) && $response['code'] >= 400) {
                $errorMessage = $response['response']['Message'] ?? 'API request failed';
            }

            if ($errorMessage) {
                DB::rollBack();
                Log::error('PlaceOrder API Error:', [
                    'order_id' => $order_id,
                    'error' => $errorMessage,
                    'full_response' => $response,
                ]);

                // Provide a more user-friendly error message
                $userErrorMessage = $errorMessage;
                if (stripos($errorMessage, 'Change not permitted') !== false) {
                    $userErrorMessage = 'This quote cannot be converted to an order. It may have already been placed or is in a state that prevents changes. Please contact support if you believe this is an error.';
                } elseif (stripos($errorMessage, 'Order detail not available') !== false || stripos($errorMessage, 'not available') !== false) {
                    $userErrorMessage = 'Order details are not available in the system. The order may have been deleted or does not exist. Please contact support.';
                }

                return back()->withInput()->with(['error' => $userErrorMessage, 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
            }

            if(!empty($response['response']['OrderNumber'])){
                $order = Order::where('purchase_order_no',$order_id)->first();
                if ($order) {
                $url = 'GetOrderDetails/' . $order->purchase_order_no;
                $get_order_details = SysproService::getOrderDetails($url);
                $order->update(['status' => $get_order_details['response']['Status'],
                    'customer_po_number' => $get_order_details['response']['CustomerPONumber']
                ]);

                    // Dispatch OrderPlaced event to trigger confirmation email
                    OrderPlaced::dispatch($order);
                } else {
                    Log::warning('Place Order - Order not found:', [
                        'purchase_order_no' => $order_id,
                    ]);
                }
            }
            DB::commit();
            Log::info('Place Order:', [
                'order_id' => $order->id ?? null,
                'purchase_order_no' => $order_id,
                'customer' => $customer,
            ]);
            //return redirect()->route('order')->with('success','Order Placed Successfully');
            return view('order-thank-you', ['order' => $order ?? null]);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error("Error Placing Order: " . $e->getMessage());
            return back()->withInput()->with(['error'=> $e->getMessage(), 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
        }
    }
}
