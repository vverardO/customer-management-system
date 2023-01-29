<?php

namespace App\Http\Livewire\Components\Header;

use Livewire\Component;

class Navbar extends Component
{
    protected array $menus;

    public function mount()
    {
        $accessRoleTitle = auth()->user()->accessRole->title;

        $this->menus = [
            'dashboard' => [
                'title' => 'Dashboard',
                'icon' => 'fas fa-chart-line',
                'route' => route('dashboard'),
                'active' => request()->routeIs('dashboard.*') ? 'active' : '',
            ],
            'customers' => [
                'title' => 'Clientes',
                'icon' => 'fas fa-people-carry',
                'route' => route('customers.index'),
                'active' => request()->routeIs('customers.*') ? 'active' : '',
            ],
            'orders' => [
                'title' => 'Ordens',
                'icon' => 'fas fa-boxes',
                'route' => route('orders.index'),
                'active' => request()->routeIs('orders.*') ? 'active' : '',
            ],
            'services' => [
                'title' => 'Serviços',
                'icon' => 'fas fa-money-bill-wave',
                'route' => route('services.index'),
                'active' => request()->routeIs('services.*') ? 'active' : '',
            ],
            'users' => [
                'title' => 'Usuários',
                'icon' => 'fas fa-users-cog',
                'route' => route('users.index'),
                'active' => request()->routeIs('users.*') ? 'active' : '',
            ],
        ];

        if ($accessRoleTitle == 'Administrador') {
            // ...
        } elseif ($accessRoleTitle == 'Usuário') {
            // ...
        } else {
            unset($this->menus['dashboard']);
            unset($this->menus['customers']);
            unset($this->menus['orders']);
            unset($this->menus['services']);
        }
    }

    public function render()
    {
        return view('livewire.components.header.navbar', ['menus' => $this->menus]);
    }
}
