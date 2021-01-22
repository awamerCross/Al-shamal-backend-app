<?php

namespace App\Observers;

use App\Models\Bank;
use File ;

class BankObserver
{
    /**
     * Handle the bank "created" event.
     *
     * @param  \App\Bank  $bank
     * @return void
     */
    public function created(Bank $bank)
    {
        //
    }

    /**
     * Handle the bank "updated" event.
     *
     * @param  \App\Bank  $bank
     * @return void
     */

    public function updating (Bank $bank)
    {
        if (request()->has('icon')) {
            File::delete('public/storage/images/banks/' . $bank->getOriginal('icon'));
        }

    }
    public function updated(Bank $bank)
    {
        //
    }

    /**
     * Handle the bank "deleted" event.
     *
     * @param  \App\Bank  $bank
     * @return void
     */
    public function deleting(Bank $bank)
    {
    }

    public function deleted(Bank $bank)
    {
        File::delete('public/storage/images/banks/' . $bank->icon);
    }

    /**
     * Handle the bank "restored" event.
     *
     * @param  \App\Bank  $bank
     * @return void
     */
    public function restored(Bank $bank)
    {
        //
    }

    /**
     * Handle the bank "force deleted" event.
     *
     * @param  \App\Bank  $bank
     * @return void
     */
    public function forceDeleted(Bank $bank)
    {
        //
    }
}
