<?php

namespace Tests\Feature\Livewire\Orders;

use App\Enums\ItemType;
use App\Http\Livewire\Orders\Create;
use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemOrder;
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

    /** @test */
    public function user_can_search_service()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $service = Item::factory([
            'type' => ItemType::Service,
        ])->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->assertSeeHtmlInOrder(['id="items-table"', $service->name]);
    }

    /** @test */
    public function user_can_search_product()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Item::factory([
            'type' => ItemType::Product,
            'quantity' => 100,
        ])->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('search', $product->name)
            ->assertSet('search', $product->name)
            ->assertSeeHtmlInOrder(['id="items-table"', $product->name]);
    }

    /** @test */
    public function user_can_search_and_add_service()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $service = Item::factory([
            'type' => ItemType::Service,
        ])->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->call('addItem', $service->id)
            ->assertSeeHtmlInOrder(['id="order-items-table"', $service->name]);
    }

    /** @test */
    public function user_can_search_and_add_product()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Item::factory([
            'type' => ItemType::Product,
        ])->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('search', $product->name)
            ->assertSet('search', $product->name)
            ->call('addItem', $product->id)
            ->assertSeeHtmlInOrder(['id="order-items-table"', $product->name]);
    }

    /** @test */
    public function user_can_search_and_add_service_and_product_and_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Item::factory([
            'type' => ItemType::Product,
        ])->for($user->company)->create();

        $service = Item::factory([
            'type' => ItemType::Service,
        ])->for($user->company)->create();

        $customer = Customer::factory()->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('order.title', 'order title')
            ->set('order.description', 'order description.')
            ->set('order.customer_id', $customer->id)
            ->set('search', $service->name)
            ->assertSet('search', $service->name)
            ->call('addItem', $service->id)
            ->set('search', $product->name)
            ->assertSet('search', $product->name)
            ->call('addItem', $product->id)
            ->call('store');

        $this->assertTrue(
            Order::whereTitle('order title')
                ->whereDescription('order description.')
                ->whereCustomerId($customer->id)
                ->exists()
        );

        $this->assertTrue(
            ItemOrder::whereItemId($service->id)
                ->exists()
        );

        $this->assertTrue(
            ItemOrder::whereItemId($product->id)
                ->exists()
        );
    }
}
