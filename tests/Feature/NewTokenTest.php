<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewTokenTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testNewToken(): void
    {
        $userData = [
            'email' => '4hasitha@gmail.com',
            'password' => '12345678',
            'device_name' => 'lap'
        ];

        $response = $this->post('/api/sanctum/token', $userData);

        $response->assertStatus(200); // Redirect response
    }
}
