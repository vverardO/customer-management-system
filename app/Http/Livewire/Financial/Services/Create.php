<?php

namespace App\Http\Livewire\Financial\Services;

use App\Enums\ItemType;
use App\Models\Item;
use Livewire\Component;

class Create extends Component
{
    public $value;

    public Item $service;

    protected $rules = [
        'service.name' => ['required', 'min:3'],
        'value' => ['required'],
    ];

    protected $messages = [
        'service.name.required' => 'Insira o nome',
        'service.name.min' => 'Mínimo 3 letras',
        'value.required' => 'Insira o valor',
    ];

    public function store()
    {
        $this->validate();

        $this->service->company_id = auth()->user()->company_id;
        $this->service->type = ItemType::Service;
        $this->service->value = str_replace(',', '.', str_replace('.', '', $this->value));

        $this->service->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('services.index');
    }

    public function mount()
    {
        $this->service = new Item();
    }

    public function render()
    {
        return view('livewire.financial.services.create');
    }
}
