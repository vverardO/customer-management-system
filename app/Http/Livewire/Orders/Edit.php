<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
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

        $this->order->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('orders.index');
    }

    public function mount($id)
    {
        $this->customers = Customer::select(['name', 'id'])->get();

        try {
            $this->order = Order::relatedToUserCompany()->with(['customer'])->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Ordem inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('orders.index');
        }
    }

    public function render()
    {
        return view('livewire.orders.edit');
    }
}
