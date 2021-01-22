<?php

namespace App\Observers;

use App\Models\Ad;
use File ;
class AdObserver
{
    /**
     * Handle the ad "created" event.
     *
     * @param  \App\Ad  $ad
     * @return void
     */
    public function created(Ad $ad)
    {
        //
    }

    /**
     * Handle the ad "updated" event.
     *
     * @param  \App\Ad  $ad
     * @return void
     */
    public function updated(Ad $ad)
    {
        //
    }

    /**
     * Handle the ad "deleted" event.
     *
     * @param  \App\Ad  $ad
     * @return void
     */
    public function deleted(Ad $ad)
    {
        if ($ad->icon != 'default.png') {
            File::delete('public/storage/images/products/' . $ad->icon);
        }
    }

    /**
     * Handle the ad "restored" event.
     *
     * @param  \App\Ad  $ad
     * @return void
     */
    public function restored(Ad $ad)
    {
        //
    }

    /**
     * Handle the ad "force deleted" event.
     *
     * @param  \App\Ad  $ad
     * @return void
     */
    public function forceDeleted(Ad $ad)
    {
        //
    }
}
