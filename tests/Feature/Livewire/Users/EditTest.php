<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Edit;
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

        $user = User::factory()->create();

        $component = Livewire::test(Edit::class, [$user->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function user_can_edit_his_profile()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->create();

        Livewire::test(Edit::class, [$user->id])
            ->set('user.name', 'user name')
            ->set('user.email', 'user@name.com')
            ->set('user.password', 'teste')
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('users.index'));

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

        $user = User::factory()->create();

        Livewire::test(Edit::class, [$user->id])
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

        $user = User::factory()->create();

        Livewire::test(Edit::class, [$user->id])
            ->set('user.password', $password)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('users.index'));
    }
}
