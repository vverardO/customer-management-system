<?php

namespace App\Http\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Edit extends Component
{
    public Customer $customer;

    protected $rules = [
        'customer.name' => ['required', 'max:128'],
        'customer.general_record' => ['required', 'digits:10'],
        'customer.registration_physical_person' => ['required', 'size:14'],
    ];

    protected $messages = [
        'customer.name.required' => 'Necessário informar o nome',
        'customer.general_record.required' => 'Necessário informar o RG',
        'customer.general_record.digits' => 'O RG precisa ter 10 digitos e ser numérico',
        'customer.registration_physical_person.required' => 'Necessário informar o CPF',
        'customer.registration_physical_person.size' => 'O CPF precisa ter 14 dígitos (formatado)',
    ];

    public function store()
    {
        $this->validate();

        $this->customer->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('customers.index');
    }

    public function mount($id)
    {
        $this->customer = Customer::find($id);
    }

    public function render()
    {
        return view('livewire.customers.edit');
    }
}