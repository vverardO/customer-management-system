<?php

namespace App\Http\Livewire\Services;

use App\Models\Service;
use Livewire\Component;

class Create extends Component
{
    public $value;

    public Service $service;

    protected $rules = [
        'service.name' => ['required'],
        'value' => ['required'],
    ];

    protected $messages = [
        'service.name.required' => 'Insira o nome',
        'value.required' => 'Insira o valor',
    ];

    public function store()
    {
        $this->validate();

        $this->service->company_id = auth()->user()->company_id;
        $this->service->value = str_replace(',', '.', str_replace('.', '', $this->value));

        $this->service->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('services.index');
    }

    public function mount()
    {
        $this->service = new Service();
    }

    public function render()
    {
        return view('livewire.services.create');
    }
}
