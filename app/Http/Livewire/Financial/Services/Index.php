<?php

namespace App\Http\Livewire\Financial\Services;

use App\Models\Item;
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
        $services = Item::isService()->where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                    $query->orWhere('value', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompany()->orderBy('name')->get();

        return view('livewire.financial.services.index', compact(['services']));
    }
}
