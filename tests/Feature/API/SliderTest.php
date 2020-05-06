<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SliderTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function an_authorized_user_can_store_slider()
    {
        $slider = factory(\App\Slider::class)->make();

        $this->post(route('api.sliders.store'), $slider->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('sliders', ['name' => $slider->name]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_update_slider()
    {
        $old_slider = factory(\App\Slider::class)->create();
        $slider = factory(\App\Slider::class)->make();

        $this->post(route('api.sliders.update', $old_slider->id), $slider->toArray())
            ->assertStatus(200);

        $this->assertDatabaseHas('sliders', [
            'name' => $slider->name,
            'festival_id' => $slider->festival_id
        ]);
    }

    /**
     * @test
     */
    public function an_authorized_user_can_delete_sliders()
    {
        factory(\App\Slider::class, 5)->create();

        $this->post(route('api.sliders.delete'), ['ids' => [1, 3]])
            ->assertStatus(200);

        $this->assertDatabaseMissing('sliders', [
            'id' => 1
        ]);
    }
}
