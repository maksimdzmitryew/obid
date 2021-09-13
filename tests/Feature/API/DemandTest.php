<?php

namespace Tests\Feature;

use Tests\TestCase;
use                   Modules\Demand\Database\Demand;
#use Illuminate\Foundation\Testing\RefreshDatabase;

class DemandTest extends TestCase
{
#    use RefreshDatabase;

    /**
     * @ test
     */
/*
    public function testProductCategorySync()
    {
        $service = Mockery::mock(\App\Services\Product::class);
        app()->instance(\App\Services\Product::class, $service);

        $service->shouldReceive('sync')->once();

        $response = $this->post('/api/v1/sync/eventsCallback', [
            "eventType" => "PRODUCT_SYNC"
        ]);

        $response->assertStatus(200);
    }
*/
/*
https://habr.com/ru/post/457866/

    public function testChangeCart()
    {
        Event::fake();

        $user = factory(User::class)->create();
        Passport::actingAs(
            $user
        );

        $response = $this->post('/api/v1/cart/update', [
            'products' => [
                [
                    // our changed data
                ]
            ],
        ]);

       $data = json_decode($response->getContent());

        $response->assertStatus(200);

        $this->assertEquals($user->id, $data->data->userId);
    // and assert other data from response

        Event::assertDispatched(CartChanged::class);
    }
*/

}
