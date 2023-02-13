<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use App\Models\Order;
use App\Services\AddressSearch\AddressSearch;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Livewire\Component;

class Edit extends Component
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

        $plus = ['customer_id' => $this->customer->id];

        $this->address = [...$response, ...$plus];
    }

    public function pushAddress()
    {
        $this->customerAddresses[] = $this->address;

        $this->refresh();
    }

    public function removeAddress($key)
    {
        if (isset($this->customerAddresses[$key]['id'])) {
            $hasOrders = Order::whereAddressId($this->customerAddresses[$key]['id'])->count();

            if ($hasOrders) {
                return $this->emit('alert', [
                    'type' => 'error',
                    'message' => 'Não pode excluir o endereço, já vinculado a uma ordem de serviço!',
                ]);
            }
        }

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

        $this->customer->save();

        try {
            $this->customer
                ->addresses()
                ->whereNotIn('id', $this->customerAddresses->pluck('id'))
                ->delete();

            $this->customer
                ->addresses()
                ->toBase()
                ->upsert($this->customerAddresses->toArray(), 'id');
        } catch (Exception $exception) {
            session()->flash('message', 'Erro ao salvar os endereços!');
            session()->flash('type', 'warning');

            return redirect()->route('customers.index');
        }

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('customers.index');
    }

    public function mount($id)
    {
        try {
            $this->customer = Customer::relatedToUserCompany()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Cliente inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('customers.index');
        }

        $this->customerAddresses = collect([]);

        if ($this->customer->addresses()->count() > 0) {
            $this->customerAddresses = $this->customer->addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'postcode' => $address->postcode,
                    'street' => $address->street,
                    'number' => $address->number,
                    'complement' => $address->complement,
                    'neighborhood' => $address->neighborhood,
                    'city' => $address->city,
                    'state' => $address->state,
                    'customer_id' => $address->customer_id,
                ];
            });
        }
    }

    public function render()
    {
        return view('livewire.customers.edit');
    }
}
