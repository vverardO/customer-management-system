<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Create extends Component
{
    public Order $order;

    public string $search = '';

    public $customers;

    public $orderServices = [];

    public $total_value;

    protected $rules = [
        'order.title' => ['required', 'max:128'],
        'order.description' => ['max:255'],
        'total_value' => ['sometimes'],
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

        $ordersQuantity = Order::relatedToUserCompany()->count();
        $this->order->number = ++$ordersQuantity;
        $this->order->company_id = auth()->user()->company_id;

        if (str_contains($this->total_value, ',')) {
            $this->order->total_value = str_replace(',', '.', str_replace('.', '', $this->total_value));
        } else {
            $this->order->total_value = $this->total_value;
        }

        $this->order->save();

        try {
            $this->order->services()->detach();

            collect($this->orderServices)->each(function ($service) {
                $this->order->services()->attach($service['id'], ['value' => $service['value']]);
            });
        } catch (Exception $exception) {
            session()->flash('message', 'Erro ao salvar os serviços!');
            session()->flash('type', 'warning');

            return redirect()->route('orders.index');
        }

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('orders.index');
    }

    public function addService(Service $service)
    {
        $this->orderServices[] = [
            'id' => $service->id,
            'name' => $service->name,
            'value' => $service->value,
            'value_formatted' => $service->value_formatted,
        ];

        $this->refresh();
    }

    public function removeService(int $index)
    {
        unset($this->orderServices[$index]);

        $this->refresh();
    }

    private function refresh()
    {
        $totalValue = number_format(collect($this->orderServices)->sum('value'), 2, ',', '.');

        $this->total_value = $totalValue;
    }

    public function mount()
    {
        $this->customers = Customer::select(['name', 'id'])->get();

        $this->total_value = '0,00';

        $this->order = new Order();
    }

    public function render()
    {
        $services = [];

        if (2 <= strlen($this->search)) {
            $services = Service::where(function (Builder $builder) {
                $builder->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                    $query->orWhere('value', $this->search);
                });
            })->relatedToUserCompany()->orderByDesc('created_at')->limit(5)->get();
        }

        return view('livewire.orders.create', compact('services'));
    }
}
