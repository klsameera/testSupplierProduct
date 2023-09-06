<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiRouteTest extends TestCase
{
    public function testSuppliersRoute()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->get('/api/suppliers');

        $response->assertStatus(200); // Adjust the expected status code as needed
        // You can add more assertions to validate the response data or structure
    }

    public function testProductsRoute()
    {
        Passport::actingAs(User::factory()->create());

        $data = [
            'supplier_id' => 1,
        ];

        $response = $this->post('/api/products', $data);

        $response->assertStatus(201); // Adjust the expected status code as needed
        // You can add more assertions to validate the response data or structure
    }
}
