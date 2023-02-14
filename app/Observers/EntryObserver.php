<?php

namespace App\Observers;

use App\Models\Entry;
use Illuminate\Support\Facades\DB;

class EntryObserver
{
    public function created(Entry $entry): void
    {
        DB::table('items')
            ->where('id', $entry->item_id)
            ->where('company_id', $entry->company_id)
            ->increment('quantity', $entry->quantity);
    }

    public function deleted(Entry $entry): void
    {
        DB::table('items')
            ->where('id', $entry->item_id)
            ->where('company_id', $entry->company_id)
            ->decrement('quantity', $entry->quantity);
    }
}
