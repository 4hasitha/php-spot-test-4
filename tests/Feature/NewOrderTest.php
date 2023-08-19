<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testNewOrder(): void
    {
        $employeeData = [
            'customer_name' => 'Kamal Dias',
            'order_value' => '130'
        ];

        $response = $this->post('/api/order/new', $employeeData);

        $response->assertStatus(302); // Redirect response
    }
}
