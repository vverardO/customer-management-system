<?php

namespace App\Http\Livewire\Components\Header;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dropdown extends Component
{
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
