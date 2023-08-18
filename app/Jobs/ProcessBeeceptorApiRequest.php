<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\BeeceptorResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ProcessBeeceptorApiRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::post('https://wibip.free.beeceptor.com/order', [
            'order_id' => '001',
            'customer_name' => $this->order->customer_name,
            'order_value' => $this->order->order_value,
            'order_date' => $this->order->order_date,
            'order_status' => $this->order->order_status,
            'process_id' => $this->order->process_id,
        ]);
    
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
        }
        $beeceptorResponse = new BeeceptorResponse;
        $beeceptorResponse->order_id = $this->order->id;
        $beeceptorResponse->response = $response;
        $beeceptorResponse->save();
    }
}
