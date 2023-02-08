<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $weekCustomers;

    public $monthCustomers;

    public $weekOrders;

    public $monthOrders;

    public function mount()
    {
        $lastWeekStartAt = Carbon::now()->startOfWeek();
        $lastWeekEndAt = Carbon::now()->endOfWeek();

        $this->weekCustomers = DB::table('customers')->whereBetween('created_at', [$lastWeekStartAt, $lastWeekEndAt])->count();
        
        $this->monthCustomers = DB::table('customers')->whereMonth('created_at', '=', now()->format('m'))->count();

        $this->weekOrders = DB::table('orders')->whereBetween('created_at', [$lastWeekStartAt, $lastWeekEndAt])->count();

        $this->monthOrders = DB::table('orders')->whereMonth('created_at', '=', now()->format('m'))->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
