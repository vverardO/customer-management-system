<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public User $user;

    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required',
        'user.password' => 'sometimes',
        'user.company.name' => 'sometimes',
        'user.access_role.title' => 'sometimes',
    ];

    protected $messages = [
        'user.name.required' => 'Necessário informar o nome',
        'user.email.required' => 'Necessário informar o email',
    ];

    public function store()
    {
        $this->validate();
        unset($this->user->access_role); // removing

        if ($this->user->password) {
            $this->user->password = Hash::make($this->user->password);
        } else {
            unset($this->user->password);
        }

        $this->user->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Atualizado com sucesso!',
        ]);

        unset($this->user->password);
    }

    public function mount()
    {
        $this->user = User::with([
            'accessRole',
            'company',
        ])->find(auth()->user()->id)->makeHidden('password');
    }

    public function render()
    {
        return view('livewire.users.profile');
    }
}
