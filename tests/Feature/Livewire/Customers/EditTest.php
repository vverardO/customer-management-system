<?php

namespace Tests\Feature\Livewire\Customers;

use App\Http\Livewire\Customers\Edit;
use App\Models\Customer;
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

        $customer = Customer::factory()->create();

        $component = Livewire::test(Edit::class, [$customer->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function customer_can_be_edited()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create();

        Livewire::test(Edit::class, [$customer->id])
            ->set('customer.name', 'customer name')
            ->set('customer.general_record', '7289382761')
            ->set('customer.registration_physical_person', '950.425.060-20')
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('customers.index'));

        $this->assertTrue(
            Customer::whereName('customer name')
                ->whereGeneralRecord('7289382761')
                ->whereRegistrationPhysicalPerson('950.425.060-20')
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create();

        Livewire::test(Edit::class, [$customer->id])
            ->set('customer.name', '')
            ->set('customer.general_record', '')
            ->set('customer.registration_physical_person', '')
            ->call('store')
            ->assertHasErrors([
                'customer.name' => 'required',
                'customer.general_record' => 'required',
                'customer.registration_physical_person' => 'required',
            ]);
    }
}
