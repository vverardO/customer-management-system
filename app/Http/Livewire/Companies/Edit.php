<?php

namespace App\Http\Livewire\Companies;

use App\Models\Company;
use Livewire\Component;

class Edit extends Component
{
    public Company $company;

    protected $rules = [
        'company.name' => ['required'],
        'company.identificator' => ['required'],
    ];

    protected $messages = [
        'company.name.required' => 'Necessário informar o nome',
        'company.identificator.required' => 'Necessário informar o cnpj',
    ];

    public function store()
    {
        $this->validate();

        $this->company->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Atualizado com sucesso!',
        ]);
    }

    public function mount()
    {
        $this->company = Company::find(auth()->user()->company_id);
    }

    public function render()
    {
        return view('livewire.companies.edit');
    }
}
