<?php

namespace App\Observers;

use App\Models\Output;
use Illuminate\Support\Facades\DB;

class OutputObserver
{
    public function created(Output $output): void
    {
        DB::table('items')
            ->where('id', $output->item_id)
            ->where('company_id', $output->company_id)
            ->decrement('quantity', $output->quantity);
    }

    public function deleted(Output $output): void
    {
        DB::table('items')
            ->where('id', $output->item_id)
            ->where('company_id', $output->company_id)
            ->increment('quantity', $output->quantity);
    }
}
