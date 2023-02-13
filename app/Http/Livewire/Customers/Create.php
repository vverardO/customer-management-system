<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use App\Services\AddressSearch\AddressSearch;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Customer $customer;

    public string $postcode = '';

    public array $address;

    public Collection $customerAddresses;

    protected $rules = [
        'customer.name' => ['required', 'max:128'],
        'customer.general_record' => ['required', 'digits:10'],
        'customer.registration_physical_person' => ['required', 'size:14'],
    ];

    protected $messages = [
        'customer.name.required' => 'Necessário informar o nome',
        'customer.name.max' => 'Tamanho excedido',
        'customer.general_record.required' => 'Necessário informar o RG',
        'customer.general_record.digits' => 'O RG precisa ter 10 digitos e ser numérico',
        'customer.registration_physical_person.required' => 'Necessário informar o CPF',
        'customer.registration_physical_person.size' => 'O CPF precisa ter 14 dígitos (formatado)',
    ];

    public function getAddress()
    {
        try {
            $response = app(AddressSearch::class)->handle($this->postcode);
        } catch (Exception $exception) {
            return $this->emit('alert', [
                'type' => 'danger',
                'message' => 'Insira um CEP Válido!',
            ]);
        }

        $this->address = $response;
    }

    public function pushAddress()
    {
        $this->customerAddresses[] = $this->address;

        $this->refresh();
    }

    public function removeAddress($key)
    {
        unset($this->customerAddresses[$key]);
    }

    public function refresh()
    {
        $this->postcode = '';
        $this->address = [];
    }

    public function store()
    {
        $this->validate();

        $this->customer->company_id = auth()->user()->company_id;

        $this->customer->save();

        try {
            $this->customer->addresses()->delete();

            collect($this->customerAddresses)->each(function ($address) {
                $this->customer->addresses()->create($address);
            });
        } catch (Exception $exception) {
            session()->flash('message', 'Erro ao salvar os endereços!');
            session()->flash('type', 'warning');

            return redirect()->route('customers.index');
        }

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('customers.index');
    }

    public function mount()
    {
        $this->customer = new Customer();

        $this->customerAddresses = collect([]);
    }

    public function render()
    {
        return view('livewire.customers.create');
    }
}
