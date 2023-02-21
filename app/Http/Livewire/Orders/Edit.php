<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
{
    public Order $order;

    public string $search = '';

    public $customers;

    public $addresses;

    public $orderItems = [];

    public $total_value;

    protected $rules = [
        'order.title' => ['required', 'max:128'],
        'order.description' => ['max:255'],
        'order.total_value' => ['sometimes'],
        'order.customer_id' => ['required'],
        'order.address_id' => ['sometimes'],
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

        if (str_contains($this->total_value, ',')) {
            $this->order->total_value = str_replace(',', '.', str_replace('.', '', $this->total_value));
        } else {
            $this->order->total_value = $this->total_value;
        }

        if ('' == $this->order->address_id) {
            $this->order->address_id = null;
        }

        $this->order->save();

        try {
            $this->order->items()->detach();

            collect($this->orderItems)->each(function ($item) {
                $this->order->items()->attach($item['id'], ['value' => $item['value']]);
            });
        } catch (Exception $exception) {
            session()->flash('message', 'Erro ao salvar os serviços!');
            session()->flash('type', 'warning');

            return redirect()->route('orders.index');
        }

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('orders.index');
    }

    public function addItem(Item $item)
    {
        $this->orderItems[] = [
            'id' => $item->id,
            'name' => $item->name,
            'value' => $item->value,
            'value_formatted' => $item->value_formatted,
            'type_formatted' => $item->type_formatted,
        ];

        $this->refresh();
    }

    public function removeItem(int $index)
    {
        unset($this->orderItems[$index]);

        $this->refresh();
    }

    private function refresh()
    {
        $totalValue = number_format(collect($this->orderItems)->sum('value'), 2, ',', '.');

        $this->total_value = $totalValue;
    }

    public function mount($id)
    {
        try {
            $this->order = Order::relatedToUserCompany()->with(['customer'])->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Ordem inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('orders.index');
        }

        $this->customers = Customer::select(['name', 'id'])->get();

        $this->addresses = [];

        $this->total_value = $this->order->total_value;

        if ($this->order->items()->count() > 0) {
            $this->orderItems = $this->order->items->map(function ($orderItem) {
                return [
                    'id' => $orderItem->id,
                    'name' => $orderItem->name,
                    'value' => $orderItem->pivot->value,
                    'value_formatted' => $orderItem->pivot->value_formatted,
                    'type_formatted' => $orderItem->type_formatted,
                ];
            });
        }
    }

    public function render()
    {
        $items = [];

        if (2 <= strlen($this->search)) {
            $items = Item::where(function (Builder $builder) {
                $builder->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                    $query->orWhere('value', $this->search);
                });
            })->relatedToUserCompany()
                ->hasStock()
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();
        }

        if ($this->order->customer_id) {
            $this->addresses = $this->order->customer->addresses;
        }

        return view('livewire.orders.edit', compact('items'));
    }
}
