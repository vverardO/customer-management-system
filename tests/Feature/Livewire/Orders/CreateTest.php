<?php

namespace Tests\Feature\Livewire\Orders;

use App\Http\Livewire\Orders\Create;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(Create::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function order_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create();

        Livewire::test(Create::class)
            ->set('order.title', 'order title')
            ->set('order.description', 'order description.')
            ->set('order.customer_id', $customer->id)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('orders.index'));

        $this->assertTrue(
            Order::whereTitle('order title')
                ->whereDescription('order description.')
                ->whereCustomerId($customer->id)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('order.title', '')
            ->set('order.customer_id', '')
            ->call('store')
            ->assertHasErrors([
                'order.title' => 'required',
                'order.customer_id' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $this->actingAs(User::factory()->create());

        $orderTitle = Str::random(129);
        $orderDescription = Str::random(256);

        Livewire::test(Create::class)
            ->set('order.title', $orderTitle)
            ->set('order.description', $orderDescription)
            ->call('store')
            ->assertHasErrors([
                'order.title' => 'max',
                'order.description' => 'max',
            ]);
    }
}
