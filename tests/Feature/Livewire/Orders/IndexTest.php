<?php

namespace Tests\Feature\Livewire\Orders;

use App\Http\Livewire\Orders\Index;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Str;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(Index::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function search_for_order_number()
    {
        $this->actingAs(User::factory()->create());

        $orderToSee = Order::factory()->create([
            'id' => 120,
            'company_id' => auth()->user()->company_id,
        ]);

        $orderNotToSee = Order::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $orderToSee->id)
            ->call('render')
            ->assertSee($orderToSee->id)
            ->assertDontSee($orderNotToSee->id);
    }

    /** @test */
    public function search_for_order_title()
    {
        $this->actingAs(User::factory()->create());

        Order::factory()->count(2)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $firstOrder = Order::all()->first();

        Livewire::test(Index::class)
            ->set('search', $firstOrder->title)
            ->call('render')
            ->assertSee($firstOrder->title);
    }

    /** @test */
    public function search_for_customer_name()
    {
        $this->actingAs(User::factory()->create());

        Order::factory()->count(2)->hasCustomer()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $firstOrder = Order::with(['customer'])->first();

        Livewire::test(Index::class)
            ->set('search', $firstOrder->customer->name)
            ->call('render')
            ->assertSee($firstOrder->customer->name);
    }

    /** @test */
    public function search_for_order_description()
    {
        $this->actingAs(User::factory()->create());

        Order::factory()->count(2)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $firstOrder = Order::all()->first();

        Livewire::test(Index::class)
            ->set('search', Str::substr($firstOrder->description, 3, 5))
            ->call('render')
            ->assertSee($firstOrder->description_limited);
    }

    /** @test */
    public function destroy_a_order()
    {
        $this->actingAs(User::factory()->create());

        $order = Order::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Order',
                $order->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);

        $this->assertSoftDeleted($order);
    }
}
