<?php

namespace Tests\Feature\Livewire\Services;

use App\Http\Livewire\Services\Edit;
use App\Models\Service;
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

        $service = Service::factory()->create();

        $component = Livewire::test(Edit::class, [$service->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function service_can_be_edited()
    {
        $this->actingAs(User::factory()->create());

        $service = Service::factory()->create();

        Livewire::test(Edit::class, [$service->id])
            ->set('service.name', 'service name')
            ->set('value', 12.00)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('services.index'));

        $this->assertTrue(
            Service::whereName('service name')
                ->whereValue(12.00)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        $service = Service::factory()->create();

        Livewire::test(Edit::class, [$service->id])
            ->set('service.name', '')
            ->set('value', '')
            ->call('store')
            ->assertHasErrors([
                'service.name' => 'required',
                'value' => 'required',
            ]);
    }
}