<?php

namespace Tests\Feature\Livewire\Stock\Outputs;

use App\Enums\ItemType;
use App\Http\Livewire\Stock\Outputs\Create;
use App\Models\Item;
use App\Models\Output;
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
    public function entry_can_be_created()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $product = Item::factory([
            'type' => ItemType::Product,
        ])->for($user->company)->create();

        Livewire::test(Create::class)
            ->set('output.quantity', 10)
            ->set('output.item_id', $product->id)
            ->call('store')
            ->assertSessionHas('message', 'Saída realizada com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('outputs.index'));

        $this->assertTrue(
            Output::whereItemId($product->id)
                ->whereQuantity(10)
                ->whereCompanyId($user->company_id)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('output.quantity', '')
            ->set('output.item_id', '')
            ->call('store')
            ->assertHasErrors([
                'output.quantity' => 'required',
                'output.item_id' => 'required',
            ]);
    }
}
