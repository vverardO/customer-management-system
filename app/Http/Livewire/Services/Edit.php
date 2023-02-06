<?php

namespace App\Http\Livewire\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
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

        if (str_contains($this->value, ',')) {
            $this->service->value = str_replace(',', '.', str_replace('.', '', $this->value));
        } else {
            $this->service->value = $this->value;
        }

        $this->service->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('services.index');
    }

    public function mount($id)
    {
        try {
            $this->service = Service::relatedToUserCompany()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Usuário inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('services.index');
        }

        $this->value = $this->service->value;
    }

    public function render()
    {
        return view('livewire.services.edit');
    }
}
