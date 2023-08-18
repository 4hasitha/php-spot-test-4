<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessBeeceptorApiRequest;

class OrderController extends Controller
{
    public function newOrder(Request $request)
    {
        if(empty($request->customer_name) or empty($request->order_value)){
            return "Please provide customer name and order value correctly.";
        }

        try {
            DB::beginTransaction();
            $order = new Order;
            $order->customer_name = $request->customer_name;
            $order->order_value = $request->order_value;
            $order->order_date = date("Y-m-d H:i:s");
            $order->order_status = Order::PROCESSING_ID;
            $order->process_id = rand (1,10);
            $order->save();

            ProcessBeeceptorApiRequest::dispatch($order)
            ->onQueue('beeceptor');

            DB::commit();
            return "Order is in processing.";
        } catch (\Exception $e) {
            DB::rollback();
            return "Something went wrong";
        }
    }
}
