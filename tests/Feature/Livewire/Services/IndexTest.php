<?php

namespace Tests\Feature\Livewire\Services;

use App\Http\Livewire\Services\Index;
use App\Models\Service;
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
    public function search_for_service_name()
    {
        $this->actingAs(User::factory()->create());

        Service::factory()->count(5)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $service = Service::all()->first();

        Livewire::test(Index::class)
            ->set('search', $service->name)
            ->call('render')
            ->assertSee($service->name);
    }

    /** @test */
    public function search_for_service_value()
    {
        $this->actingAs(User::factory()->create());

        Service::factory()->count(5)->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $service = Service::all()->first();

        Livewire::test(Index::class)
            ->set('search', intval($service->value))
            ->call('render')
            ->assertSee($service->value_formatted);
    }

    /** @test */
    public function destroy_a_service()
    {
        $this->actingAs(User::factory()->create());

        $service = Service::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Service',
                $service->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);

        $this->assertSoftDeleted($service);
    }
}
