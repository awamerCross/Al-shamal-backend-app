<?php

namespace App\Observers;

use App\Banner;
use File ;


class BannerObserver
{
    /**
     * Handle the banner "created" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function created(Banner $banner)
    {
        //
    }

    /**
     * Handle the banner "updated" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */

    public function updating (Banner $banner)
    {
        if (request()->has('icon')) {
            File::delete('public/storage/images/banners/' . $banner->getOriginal('icon'));
        }

    }

    public function updated(Banner $banner)
    {
        //
    }

    /**
     * Handle the banner "deleted" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function deleted(Banner $banner)
    {
        File::delete('public/storage/images/banners/' . $banner->icon);
    }

    /**
     * Handle the banner "restored" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function restored(Banner $banner)
    {
        //
    }

    /**
     * Handle the banner "force deleted" event.
     *
     * @param  \App\Banner  $banner
     * @return void
     */
    public function forceDeleted(Banner $banner)
    {
        //
    }
}
