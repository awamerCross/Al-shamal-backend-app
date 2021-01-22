<?php

namespace App\Observers;

use App\Models\PhotoAd;
use File ;
class PhotoAdObserver
{
    /**
     * Handle the photo ad "created" event.
     *
     * @param  \App\PhotoAd  $photoAd
     * @return void
     */
    public function created(PhotoAd $photoAd)
    {
        //
    }

    /**
     * Handle the photo ad "updated" event.
     *
     * @param  \App\PhotoAd  $photoAd
     * @return void
     */

    public function updating (PhotoAd $photoAd)
    {
        if (request()->has('image')) {
            File::delete('public/storage/images/photoads/' . $photoAd->getOriginal('image'));
        }

    }
    public function updated(PhotoAd $photoAd)
    {
        //
    }

    /**
     * Handle the photo ad "deleted" event.
     *
     * @param  \App\PhotoAd  $photoAd
     * @return void
     */
    public function deleted(PhotoAd $photoAd)
    {
        if ($photoAd->image != 'default.png') {
            File::delete('public/storage/images/photoads/' . $photoAd->image);
        }
    }

    /**
     * Handle the photo ad "restored" event.
     *
     * @param  \App\PhotoAd  $photoAd
     * @return void
     */
    public function restored(PhotoAd $photoAd)
    {
        //
    }

    /**
     * Handle the photo ad "force deleted" event.
     *
     * @param  \App\PhotoAd  $photoAd
     * @return void
     */
    public function forceDeleted(PhotoAd $photoAd)
    {
        //
    }
}
