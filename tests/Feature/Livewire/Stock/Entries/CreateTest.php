<?php

namespace Tests\Feature\Livewire\Stock\Entries;

use App\Enums\ItemType;
use App\Http\Livewire\Stock\Entries\Create;
use App\Models\Entry;
use App\Models\Item;
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
            ->set('entry.quantity', 10)
            ->set('entry.item_id', $product->id)
            ->call('store')
            ->assertSessionHas('message', 'Entrada realizada com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('entries.index'));

        $this->assertTrue(
            Entry::whereItemId($product->id)
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
            ->set('entry.quantity', '')
            ->set('entry.item_id', '')
            ->call('store')
            ->assertHasErrors([
                'entry.quantity' => 'required',
                'entry.item_id' => 'required',
            ]);
    }
}
