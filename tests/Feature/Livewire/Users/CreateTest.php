<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Create;
use App\Models\AccessRole;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
    public function user_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create();

        Livewire::test(Create::class)
            ->set('user.name', 'user name')
            ->set('user.email', 'user@email.com')
            ->set('user.password', 'password')
            ->set('user.access_role_id', AccessRole::isAdmin()->first()->id)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('users.index'));

        $this->assertTrue(
            User::whereName('user name')
                ->whereEmail('user@email.com')
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('user.name', '')
            ->set('user.email', '')
            ->set('user.password', '')
            ->set('user.access_role_id', '')
            ->call('store')
            ->assertHasErrors([
                'user.name' => 'required',
                'user.email' => 'required',
                'user.password' => 'required',
                'user.access_role_id' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $this->actingAs(User::factory()->create());

        $userName = Str::random(129);

        Livewire::test(Create::class)
            ->set('user.name', $userName)
            ->call('store')
            ->assertHasErrors([
                'user.name' => 'max',
            ]);
    }
}
