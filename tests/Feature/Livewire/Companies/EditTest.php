<?php

namespace Tests\Feature\Livewire\Companies;

use App\Http\Livewire\Companies\Edit;
use App\Models\Company;
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

        $component = Livewire::test(Edit::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function the_user_can_edit_company()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Edit::class)
            ->set('company.name', 'company name')
            ->set('company.identificator', '78.118.120/0001-85')
            ->call('store')
            ->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Atualizado com sucesso!'
            ]);
 
        $this->assertTrue(
            Company::whereName('company name')
                ->whereIdentificator('78.118.120/0001-85')
                ->exists()
        );
    }

    /** @test */
    public function name_and_identificator_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Edit::class)
            ->set('company.name', '')
            ->set('company.identificator', '')
            ->call('store')
            ->assertHasErrors([
                'company.name' => 'required',
                'company.identificator' => 'required',
            ]);
    }
}
