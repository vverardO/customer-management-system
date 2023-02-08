<?php

namespace Tests\Feature\Livewire\Orders;

use App\Http\Livewire\Orders\Edit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $order = Order::factory()->create();

        $component = Livewire::test(Edit::class, [$order->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function order_can_be_edited()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $order = Order::factory()->for($user->company)->create();

        $customer = Customer::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
            ->set('order.title', 'order title')
            ->set('order.description', 'order description.')
            ->set('order.customer_id', $customer->id)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
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
        $user = User::factory()->create();

        $this->actingAs($user);

        $order = Order::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
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
        $user = User::factory()->create();

        $this->actingAs($user);

        $orderTitle = Str::random(129);
        $orderDescription = Str::random(256);

        $order = Order::factory()->hasCustomer()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
            ->set('order.title', $orderTitle)
            ->set('order.description', $orderDescription)
            ->call('store')
            ->assertHasErrors([
                'order.title' => 'max',
                'order.description' => 'max',
            ]);
    }

    /** @test */
    public function user_can_search_service()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $service = Service::factory()->for($user->company)->create();

        $order = Order::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->assertSeeHtmlInOrder(['id="services-table"', $service->name]);
    }

    /** @test */
    public function user_can_search_and_add_service()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $service = Service::factory()->for($user->company)->create();

        $order = Order::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->call('addService', $service->id)
            ->assertSeeHtmlInOrder(['id="order-services-table"', $service->name]);
    }

    /** @test */
    public function user_can_search_and_add_service_and_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $service = Service::factory()->for($user->company)->create();

        $customer = Customer::factory()->for($user->company)->create();

        $order = Order::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$order->id])
            ->set('order.title', 'order title')
            ->set('order.description', 'order description.')
            ->set('order.customer_id', $customer->id)
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->call('addService', $service->id)
            ->call('store');

        $this->assertTrue(
            Order::whereTitle('order title')
                ->whereDescription('order description.')
                ->whereCustomerId($customer->id)
                ->exists()
        );

        $this->assertTrue(
            OrderService::whereServiceId($service->id)
                ->exists()
        );
    }
}
