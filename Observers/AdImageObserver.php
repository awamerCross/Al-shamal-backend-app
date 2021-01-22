<?php

namespace App\Observers;

use App\Models\AdImage;
use File ;
class AdImageObserver
{
    /**
     * Handle the ad image "created" event.
     *
     * @param  \App\Models\AdImage  $adImage
     * @return void
     */
    public function created(AdImage $adImage)
    {
        //
    }

    /**
     * Handle the ad image "updated" event.
     *
     * @param  \App\Models\AdImage  $adImage
     * @return void
     */
    public function updated(AdImage $adImage)
    {
        //
    }

    /**
     * Handle the ad image "deleted" event.
     *
     * @param  \App\Models\AdImage  $adImage
     * @return void
     */
    public function deleted(AdImage $adImage)
    {
        if ($adImage->image != 'default.png') {
            File::delete('public/storage/images/products/' . $adImage->image);
            File::delete('public/storage/resize/images/products/' . $adImage->image);
            File::delete('public/storage/resize400/images/products/' . $adImage->image);
        }
    }

    /**
     * Handle the ad image "restored" event.
     *
     * @param  \App\Models\AdImage  $adImage
     * @return void
     */
    public function restored(AdImage $adImage)
    {
        //
    }

    /**
     * Handle the ad image "force deleted" event.
     *
     * @param  \App\Models\AdImage  $adImage
     * @return void
     */
    public function forceDeleted(AdImage $adImage)
    {
        //
    }
}
