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
            'financial' => [
                'title' => 'Financeiro',
                'icon' => 'fas fa-money-bill-wave',
                'active' => request()->routeIs('financial.*') ? 'active' : '',
                'sub-menus' => [
                    'services' => [
                        'title' => 'Serviços',
                        'route' => route('services.index'),
                        'active' => request()->routeIs('services.*') ? 'active' : '',
                    ],
                    'products' => [
                        'title' => 'Produtos',
                        'route' => route('products.index'),
                        'active' => request()->routeIs('products.*') ? 'active' : '',
                    ],
                ],
            ],
            'stock' => [
                'title' => 'Estoque',
                'icon' => 'fas fa-truck-loading',
                'active' => request()->routeIs('stock.*') ? 'active' : '',
                'sub-menus' => [
                    'entries' => [
                        'title' => 'Entradas',
                        'route' => route('entries.index'),
                        'active' => request()->routeIs('entries.*') ? 'active' : '',
                    ],
                    'outputs' => [
                        'title' => 'Saídas',
                        'route' => route('outputs.index'),
                        'active' => request()->routeIs('outputs.*') ? 'active' : '',
                    ],
                ],
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
            unset($this->menus['users']);
        } else {
            unset($this->menus['dashboard']);
            unset($this->menus['customers']);
            unset($this->menus['orders']);
            unset($this->menus['users']);
            unset($this->menus['financial']);
            unset($this->menus['stock']);
        }
    }

    public function render()
    {
        return view('livewire.components.header.navbar', [
            'menus' => $this->menus,
        ]);
    }
}
