<?php

namespace App\Http\Livewire\Stock\Outputs;

use App\Models\Output;
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
        $outputs = Output::with(['item'])->where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->whereRelation('item', 'name', 'like', '%'.$this->search.'%');
                    $query->orWhere('quantity', $this->search);
                });
            }
        })->relatedToUserCompany()->orderBy('id', 'desc')->get();

        return view('livewire.stock.outputs.index', compact(['outputs']));
    }
}
