## Instalação

O Sistema de Gerenciamento de Clientes tem como requerimento [Laravel](https://laravel.com/docs/9.x) v9+ and [Laravel - Livewire](https://laravel-livewire.com/docs/2.x/installation) v2+ para rodar normalmente.

Instale as dependencias e inicie o server.

```sh
git clone https://github.com/vverardO/customer-management-system.git
cd customer-management-system
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```