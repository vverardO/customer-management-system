<?php

namespace Tests\Feature\Livewire\Users;

use App\Http\Livewire\Users\Index;
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
    public function search_for_user_name()
    {
        $this->actingAs(User::factory()->create());

        User::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $user = User::all()->first();

        Livewire::test(Index::class)
            ->set('search', $user->name)
            ->call('render')
            ->assertSee($user->name);
    }

    /** @test */
    public function search_for_user_email()
    {
        $this->actingAs(User::factory()->create());

        User::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $user = User::all()->first();

        Livewire::test(Index::class)
            ->set('search', $user->email)
            ->call('render')
            ->assertSee($user->email);
    }

    /** @test */
    public function search_for_access_role_title()
    {
        $this->actingAs(User::factory()->create());

        User::factory()->hasAccessRole()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $user = User::with(['accessRole'])->first();

        Livewire::test(Index::class)
            ->set('search', $user->accessRole->title)
            ->call('render')
            ->assertSee($user->accessRole->title);
    }

    /** @test */
    public function destroy_a_user()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'User',
                $user->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);
    }
}
