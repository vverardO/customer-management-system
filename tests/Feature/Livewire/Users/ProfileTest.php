<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(Profile::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_his_profile()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Profile::class)
            ->set('user.name', 'user name')
            ->set('user.email', 'user@name.com')
            ->set('user.password', 'teste')
            ->call('store')
            ->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Atualizado com sucesso!'
            ]);
 
        $this->assertTrue(
            User::whereName('user name')
                ->whereEmail('user@name.com')
                ->exists()
        );
    }

    /** @test */
    public function name_and_email_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Profile::class)
            ->set('user.name', '')
            ->set('user.email', '')
            ->call('store')
            ->assertHasErrors([
                'user.name' => 'required',
                'user.email' => 'required',
            ]);
    }

    /** @test */
    public function user_can_change_his_password()
    {
        $this->actingAs(User::factory()->create());

        $password = '123!@#qweQWE'; // random password

        Livewire::test(Profile::class)
            ->set('user.password', $password)
            ->call('store')
            ->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Atualizado com sucesso!'
            ]);
    }
}
