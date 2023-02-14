<?php

namespace App\Http\Livewire\Stock\Outputs;

use App\Models\Item;
use App\Models\Output;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Output $output;

    public Collection $items;

    protected $rules = [
        'output.quantity' => ['required', 'integer'],
        'output.item_id' => ['required', 'integer'],
    ];

    protected $messages = [
        'output.quantity.required' => 'Insira a quantidade',
        'output.item_id.required' => 'Selecione o produto',
    ];

    public function store()
    {
        $this->validate();

        $this->output->company_id = auth()->user()->company_id;
        $this->output->save();

        session()->flash('message', 'Saída realizada com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('outputs.index');
    }

    public function mount()
    {
        $this->output = new Output();
        $this->items = Item::isProduct()->select(['name', 'id'])->get();
    }

    public function render()
    {
        return view('livewire.stock.outputs.create');
    }
}
