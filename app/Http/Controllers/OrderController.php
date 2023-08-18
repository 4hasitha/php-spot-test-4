<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function newOrder(Request $request)
    {
        try {
            if(empty($request->customer_name) or empty($request->order_value)){
                return "Please provide customer name and order value correctly.";
            }
    
            DB::beginTransaction();
            $order = new Order;
            $order->customer_name = $request->customer_name;
            $order->order_value = $request->order_value;
            $order->order_date = date("Y-m-d H:i:s");
            $order->order_status = Order::PROCESSING_ID;
            $order->process_id = rand (1,10);
            $order->save();

            $response = Http::post('https://wibip.free.beeceptor.com/order', [
                'order_id' => '001',
                'customer_name' => $order->customer_name,
                'order_value' => $order->order_value,
                'order_date' => $order->order_date,
                'order_status' => $order->order_status,
                'process_id' => $order->process_id,
            ]);
        
            if ($response->successful()) {
                $responseData = $response->json();
            } else {
                $statusCode = $response->status();
            }

            DB::commit();

            return $response;
        } catch (\Exception $e) {
            DB::rollback();
            return "Something went wrong, try again.";
        }
    }
}
