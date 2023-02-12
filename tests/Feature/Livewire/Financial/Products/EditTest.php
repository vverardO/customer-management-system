<?php

namespace Tests\Feature\Livewire\Financial\Products;

use App\Http\Livewire\Financial\Products\Edit;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $component = Livewire::test(Edit::class, [$product->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function product_can_be_edited()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Product::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$product->id])
            ->set('product.name', 'product name')
            ->set('value', 12.00)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('products.index'));

        $this->assertTrue(
            Product::whereName('product name')
                ->whereValue(12.00)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Product::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$product->id])
            ->set('product.name', '')
            ->set('value', '')
            ->call('store')
            ->assertHasErrors([
                'product.name' => 'required',
                'value' => 'required',
            ]);
    }
}
