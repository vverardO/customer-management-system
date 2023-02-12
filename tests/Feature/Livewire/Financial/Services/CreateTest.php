<?php

namespace Tests\Feature\Livewire\Financial\Services;

use App\Enums\ItemType;
use App\Http\Livewire\Financial\Services\Create;
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
    public function service_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('service.name', 'service name')
            ->set('value', 12.00)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('services.index'));

        $this->assertTrue(
            Item::whereName('service name')
                ->where('type', ItemType::Service)
                ->whereValue(12.00)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('service.name', '')
            ->set('value', '')
            ->call('store')
            ->assertHasErrors([
                'service.name' => 'required',
                'value' => 'required',
            ]);
    }
}
