<?php

namespace App\Http\Livewire\Financial\Products;

use App\Enums\ItemType;
use App\Models\Item;
use Livewire\Component;

class Create extends Component
{
    public $value;

    public Item $product;

    protected $rules = [
        'product.name' => ['required', 'min:3'],
        'value' => ['required'],
    ];

    protected $messages = [
        'product.name.required' => 'Insira o nome',
        'product.name.min' => 'Mínimo 3 letras',
        'value.required' => 'Insira o valor',
    ];

    public function store()
    {
        $this->validate();

        $this->product->company_id = auth()->user()->company_id;
        $this->product->type = ItemType::Product;
        $this->product->value = str_replace(',', '.', str_replace('.', '', $this->value));

        $this->product->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('products.index');
    }

    public function mount()
    {
        $this->product = new Item();
    }

    public function render()
    {
        return view('livewire.financial.products.create');
    }
}
