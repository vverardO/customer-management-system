<?php

namespace Tests\Feature\Livewire\Customers;

use App\Http\Livewire\Customers\Index;
use App\Models\Customer;
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
    public function search_for_customer_name()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->count(2)->create([
            'company_id' => auth()->user()->company_id
        ]);

        $firstCustomer = Customer::all()->first();
        $lastCustomer = Customer::all()->last();

        Livewire::test(Index::class)
            ->set('search', $firstCustomer->name)
            ->call('render')
            ->assertSee($firstCustomer->name)
            ->assertDontSee($lastCustomer->name);
    }

    /** @test */
    public function search_for_customer_general_record()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->count(2)->create([
            'company_id' => auth()->user()->company_id
        ]);

        $firstCustomer = Customer::all()->first();
        $lastCustomer = Customer::all()->last();

        Livewire::test(Index::class)
            ->set('search', $firstCustomer->general_record)
            ->call('render')
            ->assertSee($firstCustomer->general_record)
            ->assertDontSee($lastCustomer->general_record);
    }

    /** @test */
    public function search_for_customer_registration_physical_person()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->count(2)->create([
            'company_id' => auth()->user()->company_id
        ]);

        $firstCustomer = Customer::all()->first();
        $lastCustomer = Customer::all()->last();

        Livewire::test(Index::class)
            ->set('search', $firstCustomer->registration_physical_person)
            ->call('render')
            ->assertSee($firstCustomer->registration_physical_person)
            ->assertDontSee($lastCustomer->registration_physical_person);
    }

    /** @test */
    public function destroy_a_customer()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Customer',
                $customer->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!'
            ]);

        $this->assertSoftDeleted($customer);
    }
}
