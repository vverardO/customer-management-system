<?php

namespace App\Http\Livewire\Authentication;

use App\Models\AccessRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public User $user;
    public Company $company;
    public string $user_name = '';
    public string $user_email = '';
    public string $user_password = '';
    public string $company_name = '';
    public string $company_identificator = '';

    protected $rules = [
        'user_name' => ['required', 'max:128'],
        'user_email' => ['required', 'email', 'max:128', 'unique:users,email'],
        'user_password' => ['required', 'min:6'],
        'company_name' => ['required', 'max:128'],
        'company_identificator' => ['required', 'max:128'],
    ];

    protected $messages = [
        'user_name.required' => 'Necessário seu nome',
        'user_name.max' => 'Tamanho excedido',
        'user_password.required' => 'Necessário inserir a senha',
        'user_password.min' => 'Necessário mínimo 6 digitos',
        'user_email.required' => 'Necessário informar seu email',
        'user_email.email' => 'Necessário informar um email válido',
        'user_email.max' => 'Tamanho excedido',
        'user_email.unique' => 'Este email já está em uso, tente acessar o sistema',
        'company_name.required' => 'Necessário o nome da empresa',
        'company_name.max' => 'Tamanho excedido',
        'company_identificator.required' => 'Necessário informar o cnpj',
        'company_identificator.max' => 'Tamanho excedido',
    ];

    public function register()
    {
        $this->validate();

        $this->company = new Company();
        $this->company->name = $this->company_name;
        $this->company->identificator = $this->company_identificator;
        $this->company->save();

        $this->user = new User();
        $this->user->name = $this->user_name;
        $this->user->email = $this->user_email;
        $this->user->password = Hash::make($this->user_password);
        $this->user->access_role_id = AccessRole::isAdmin()->first()->id;
        $this->user->company_id = $this->company->id;
        $this->user->save();

        session()->flash('message', 'Conta registrada com sucesso!');
        session()->flash('type', 'success');

        Auth::login($this->user);

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.authentication.register')
            ->layout('layouts.authentication');
    }
}
