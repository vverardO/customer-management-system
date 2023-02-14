<?php

namespace Tests\Feature\Livewire\Stock\Outputs;

use App\Http\Livewire\Stock\Outputs\Index;
use App\Models\Output;
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
    public function search_for_item_name()
    {
        $this->actingAs(User::factory()->create());

        $outputToSee = Output::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $outputNotToSee = Output::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $outputToSee->item->name)
            ->call('render')
            ->assertSee($outputToSee->item->name)
            ->assertDontSee($outputNotToSee->item->name);
    }

    /** @test */
    public function search_for_quantity()
    {
        $this->actingAs(User::factory()->create());

        $output = Output::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $output->quantity)
            ->call('render')
            ->assertSee($output->quantity)
            ->assertSee($output->item->name);
    }

    /** @test */
    public function destroy_an_entry()
    {
        $this->actingAs(User::factory()->create());

        $output = Output::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Output',
                $output->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);

        $this->assertDatabaseMissing(
            'outputs',
            ['id' => $output->id]
        );
    }
}
