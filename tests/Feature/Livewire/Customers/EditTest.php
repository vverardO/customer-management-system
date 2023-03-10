<?php

namespace Tests\Feature\Livewire\Customers;

use App\Http\Livewire\Customers\Edit;
use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
        $user = User::factory()->create();

        $this->actingAs($user);

        $customer = Customer::factory()->for($user->company)->create();

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
        $user = User::factory()->create();

        $this->actingAs($user);

        $customer = Customer::factory()->for($user->company)->create();

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

    /** @test */
    public function inputs_are_maximum_size()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $customerName = Str::random(129);
        $customerGeneralRecord = Str::random(11);
        $customerRegistrationPhysicalPerson = Str::random(15);

        $customer = Customer::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$customer->id])
            ->set('customer.name', $customerName)
            ->set('customer.general_record', $customerGeneralRecord)
            ->set('customer.registration_physical_person', $customerRegistrationPhysicalPerson)
            ->call('store')
            ->assertHasErrors([
                'customer.name' => 'max',
                'customer.general_record' => 'digits',
                'customer.registration_physical_person' => 'size',
            ]);
    }

    /** @test */
    public function user_can_add_address_and_store()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $customer = Customer::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$customer->id])
            ->set('customer.name', 'customer name')
            ->set('customer.general_record', '7289382761')
            ->set('customer.registration_physical_person', '950.425.060-20')
            ->set('postcode', '97010400')
            ->call('getAddress')
            ->call('pushAddress')
            ->call('store');

        $this->assertTrue(
            Address::wherePostcode('97010400')
                ->whereCustomerId($customer->id)
                ->exists()
        );
    }

    /** @test */
    public function user_can_remove_address_and_store()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $customer = Customer::factory()->for($user->company)->create();

        $address = Address::factory([
            'postcode' => '97010400',
        ])->for($customer)->create();

        Livewire::test(Edit::class, [$customer->id])
            ->call('removeAddress', 0)
            ->call('store');

        $this->assertTrue(
            Address::onlyTrashed()
                ->whereId($address->id)
                ->exists()
        );
    }
}
