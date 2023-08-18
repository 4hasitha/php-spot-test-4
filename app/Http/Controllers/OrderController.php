<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function newOrder(Request $request)
    {
        $order = new Order;
        $order->customer_name = $request->customer_name;
        $order->order_value = $request->order_value;
        $order->order_date = date("Y-m-d H:i:s");
        $order->order_status = Order::PROCESSING_ID;
        $order->process_id = rand (1,10);
        $order->save();

        return "Success";
    }
}
