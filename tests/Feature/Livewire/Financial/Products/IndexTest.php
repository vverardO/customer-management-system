<?php

namespace Tests\Feature\Livewire\Financial\Products;

use App\Http\Livewire\Financial\Products\Index;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

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
    public function search_for_product_name()
    {
        $this->actingAs(User::factory()->create());

        Product::factory()->count(5)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $product = Product::all()->first();

        Livewire::test(Index::class)
            ->set('search', $product->name)
            ->call('render')
            ->assertSee($product->name);
    }

    /** @test */
    public function search_for_product_value()
    {
        $this->actingAs(User::factory()->create());

        Product::factory()->count(5)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $product = Product::all()->first();

        Livewire::test(Index::class)
            ->set('search', intval($product->value))
            ->call('render')
            ->assertSee($product->value_formatted);
    }

    /** @test */
    public function destroy_a_product()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'product',
                $product->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);

        $this->assertSoftDeleted($product);
    }
}
