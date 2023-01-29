<?php

namespace App\Http\Livewire\Authentication;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    protected $rules = [
        'email' => ['required', 'email', 'exists:users,email'],
        'password' => ['required'],
    ];

    protected $messages = [
        'password.required' => 'Necessário inserir a senha',
        'email.required' => 'Necessário informar seu email ou usuário',
        'email.email' => 'Necessário informar um email válido',
        'email.exists' => 'Email não encontrado, faça seu cadastro!',
    ];

    public function login()
    {
        $credentials = $this->validate();

        return Auth::attempt($credentials)
            ? redirect()->intended('/')
            : $this->addError('email', 'Usuário ou senha inválido!');
    }

    public function render()
    {
        return view('livewire.authentication.login')
            ->layout('layouts.authentication');
    }
}
