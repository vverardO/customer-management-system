<?php

namespace Tests\Feature\Livewire\Authentication;

use App\Http\Livewire\Authentication\Register;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Register::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function the_user_can_register()
    {
        Livewire::test(Register::class)
            ->set('user_name', 'user name')
            ->set('user_email', 'user@email.com')
            ->set('user_password', 'password')
            ->set('company_name', 'company name')
            ->set('company_identificator', '78.118.120/0001-85')
            ->call('register')
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(
            User::whereName('user name')
                ->whereEmail('user@email.com')
                ->exists()
        );

        $this->assertTrue(
            Company::whereName('company name')
                ->whereIdentificator('78.118.120/0001-85')
                ->exists()
        );
    }

    /** @test */
    public function the_user_structure_is_required()
    {
        Livewire::test(Register::class)
            ->set('company_name', 'company name')
            ->set('company_identificator', '78.118.120/0001-85')
            ->call('register')
            ->assertHasErrors([
                'user_name' => 'required',
                'user_email' => 'required',
                'user_password' => 'required',
            ]);
    }

    /** @test */
    public function the_company_structure_is_required()
    {
        Livewire::test(Register::class)
            ->set('user_name', 'user name')
            ->set('user_email', 'user@email.com')
            ->set('user_password', 'password')
            ->call('register')
            ->assertHasErrors([
                'company_name' => 'required',
                'company_identificator' => 'required',
            ]);
    }
}
