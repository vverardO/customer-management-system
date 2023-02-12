<?php

namespace App\Http\Livewire\Financial\Products;

use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
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

        if (str_contains($this->value, ',')) {
            $this->product->value = str_replace(',', '.', str_replace('.', '', $this->value));
        } else {
            $this->product->value = $this->value;
        }

        $this->product->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('products.index');
    }

    public function mount($id)
    {
        try {
            $this->product = Item::isProduct()->relatedToUserCompany()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Usuário inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('products.index');
        }

        $this->value = $this->product->value;
    }

    public function render()
    {
        return view('livewire.financial.products.edit');
    }
}
