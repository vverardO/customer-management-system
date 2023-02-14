<?php

namespace Tests\Feature\Livewire\Stock\Entries;

use App\Http\Livewire\Stock\Entries\Index;
use App\Models\Entry;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
    public function search_for_item_name()
    {
        $this->actingAs(User::factory()->create());

        $entryToSee = Entry::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $entryNotToSee = Entry::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $entryToSee->item->name)
            ->call('render')
            ->assertSee($entryToSee->item->name)
            ->assertDontSee($entryNotToSee->item->name);
    }

    /** @test */
    public function search_for_quantity()
    {
        $this->actingAs(User::factory()->create());

        $entry = Entry::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $entry->quantity)
            ->call('render')
            ->assertSee($entry->quantity)
            ->assertSee($entry->item->name);
    }

    /** @test */
    public function destroy_an_entry()
    {
        $this->actingAs(User::factory()->create());

        $entry = Entry::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Entry',
                $entry->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);

        $this->assertDatabaseMissing(
            'entries',
            ['id' => $entry->id]
        );
    }
}
