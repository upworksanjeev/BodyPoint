<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SysproService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function PlaceOrder($order_id){
        try{
            DB::beginTransaction();
            $url = 'PlaceOrder';
            $response = SysproService::placeOrder($url,$order_id);
            if (!empty($response['response']['Error'])) {
                return back()->with('error',$response['response']['Message']);
            }
            $order = Order::where('purchase_order_no',$order_id)->first();
            $order->update(['status', 'S']);
            DB::commit();
            return redirect()->route('order')->with('success','Order Placed Successfully');
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error("Error Placing Order: " . $e->getMessage());
            return back()->with('error',$e->getMessage());
        }
    }
}