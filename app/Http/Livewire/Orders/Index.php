<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\Traits\Destroyable;
use App\Traits\Showable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    use Showable;
    use Destroyable;

    public string $search = '';

    protected $updatesQueryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->fill(request()->only('search'));
    }

    public function render()
    {
        $orders = Order::with(['customer'])->where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('title', 'like', '%'.$this->search.'%');
                    $query->orWhere('id', $this->search);
                    $query->orWhere('number', $this->search);
                    $query->orWhere('description', 'like', '%'.$this->search.'%');
                    $query->orWhereRelation('customer', 'name', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompany()->orderByDesc('created_at')->get();

        return view('livewire.orders.index', compact(['orders']));
    }
}
