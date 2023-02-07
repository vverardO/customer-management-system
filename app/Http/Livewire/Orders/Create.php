<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use Livewire\Component;

class Create extends Component
{
    public Order $order;

    public $customers;

    protected $rules = [
        'order.title' => ['required', 'max:128'],
        'order.description' => ['max:255'],
        'order.customer_id' => ['required'],
    ];

    protected $messages = [
        'order.title.required' => 'Necessário informar o título',
        'order.title.max' => 'Tamanho excedido',
        'order.description.max' => 'Tamanho excedido',
        'order.customer_id.required' => 'Selecione o cliente',
    ];

    public function store()
    {
        $this->validate();

        $this->order->company_id = auth()->user()->company_id;
        $this->order->total_value = 100.00;

        $ordersQuantity = Order::relatedToUserCompany()->count();
        $this->order->number = ++ $ordersQuantity;

        $this->order->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('orders.index');
    }

    public function mount()
    {
        $this->customers = Customer::select(['name', 'id'])->get();

        $this->order = new Order();
    }

    public function render()
    {
        return view('livewire.orders.create');
    }
}
