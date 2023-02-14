<?php

namespace App\Http\Livewire\Stock\Entries;

use App\Models\Entry;
use App\Models\Item;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Entry $entry;

    public Collection $items;

    protected $rules = [
        'entry.quantity' => ['required', 'integer'],
        'entry.item_id' => ['required', 'integer'],
    ];

    protected $messages = [
        'entry.quantity.required' => 'Insira a quantidade',
        'entry.item_id.required' => 'Selecione o produto',
    ];

    public function store()
    {
        $this->validate();

        $this->entry->company_id = auth()->user()->company_id;
        $this->entry->save();

        session()->flash('message', 'Entrada realizada com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('entries.index');
    }

    public function mount()
    {
        $this->entry = new Entry();
        $this->items = Item::isProduct()->select(['name', 'id'])->get();
    }

    public function render()
    {
        return view('livewire.stock.entries.create');
    }
}
