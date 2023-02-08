<?php

namespace App\Http\Livewire\Orders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
{
    public Order $order;

    public string $search = '';

    public $customers;

    public $orderServices = [];

    public $total_value;

    protected $rules = [
        'order.title' => ['required', 'max:128'],
        'order.description' => ['max:255'],
        'order.total_value' => ['sometimes'],
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

        session()->flash('message', 'Atualizado com sucesso!');
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

        $this->total_value = $this->order->total_value;

        if ($this->order->services()->count() > 0) {
            $this->orderServices = $this->order->services->map(function ($orderService) {
                return [
                    'id' => $orderService->id,
                    'name' => $orderService->name,
                    'value' => $orderService->pivot->value,
                    'value_formatted' => $orderService->pivot->value_formatted,
                ];
            });
        }
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

        return view('livewire.orders.edit', compact('services'));
    }
}
