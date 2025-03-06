<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function PlaceOrder(Request $request, $order_id){
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
            $url = 'PlaceOrder';
            $response = SysproService::placeOrder($url,$order_id, $customer_po_number,$idDuplicate );
            if (!empty($response['response']['Error'])) {
                return back()->withInput()->with(['error'=> $response['response']['Message'], 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
            }
            if(!empty($response['response']['OrderNumber'])){
                $order = Order::where('purchase_order_no',$order_id)->first();
                $url = 'GetOrderDetails/' . $order->purchase_order_no;
                $get_order_details = SysproService::getOrderDetails($url);
                $order->update(['status' => $get_order_details['response']['Status'],
                    'customer_po_number' => $get_order_details['response']['CustomerPONumber']    
                ]);
            }
            DB::commit();
            Log::info('Place Order:', [
                'customer' => $customer,
            ]);
            //return redirect()->route('order')->with('success','Order Placed Successfully');
            return view('order-thank-you', ['order' => $order]);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error("Error Placing Order: " . $e->getMessage());
            return back()->withInput()->with(['error'=> $e->getMessage(), 'customer_po_number' => $request->customer_po_number, 'order_id' => $order_id]);
        }
    }
}
