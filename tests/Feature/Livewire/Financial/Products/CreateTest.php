<?php

namespace Tests\Feature\Livewire\Financial\Products;

use App\Http\Livewire\Financial\Products\Create;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function product_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('product.name', 'product name')
            ->set('value', 12.00)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('products.index'));

        $this->assertTrue(
            product::whereName('product name')
                ->whereValue(12.00)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('product.name', '')
            ->set('value', '')
            ->call('store')
            ->assertHasErrors([
                'product.name' => 'required',
                'value' => 'required',
            ]);
    }
}
