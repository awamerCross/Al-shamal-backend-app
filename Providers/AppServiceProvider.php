<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Bank;
use App\Models\User;
use App\Models\AdImage;

use App\Models\PhotoAd;
use App\Models\Category;
use App\Observers\AdObserver;
use App\Observers\BankObserver;
use App\Observers\UserObserver;
use App\Observers\AdImageObserver;
use App\Observers\PhotoAdObserver;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ISetting ;

class AppServiceProvider extends ServiceProvider
{
    private $categories ;
    private $settings ;
    private $seo ;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->settings          = resolve(\App\Repositories\Eloquent\SettingRepository::class);
        $settings                = $this->settings->getAppInformation();

        $this->seo               = resolve(\App\Repositories\Eloquent\SeoRepository::class);
        $seo                     = $this->seo->get() ;

        $this->categories        = resolve(\App\Repositories\Eloquent\CategoryRepository::class);
        $categories              = $this->categories->mainCategories2();
        $splicedCategoories      = $categories->splice(5);



        view()->share([
            'settings'              => $settings ,
            'seo'                   => $seo ,
            'allCategories'         => $categories ,
            'splicedCategoories'    => $splicedCategoories ,
        ]);


        AdImage      ::observe(AdImageObserver::class);
        Ad           ::observe(AdObserver::class);
        PhotoAd      ::observe(PhotoAdObserver::class);
        Category     ::observe(CategoryObserver::class);
        User         ::observe(UserObserver::class);
        Bank         ::observe(BankObserver::class);

        // -------------- lang ---------------- \\
            app()->singleton('lang', function (){
                if ( session() -> has( 'lang' ) )
                    return session( 'lang' );
                else
                    return 'ar';

            });
        // -------------- lang ---------------- \\
    }
}
