<?php

namespace App\Providers;

use App\Repositories\Interfaces\IAd;
use App\Repositories\Interfaces\ISeo;
use App\Repositories\Interfaces\IBank;
use App\Repositories\Interfaces\IChat;
use App\Repositories\Interfaces\ICity;
use App\Repositories\Interfaces\IRate;
use App\Repositories\Interfaces\IRole;
use App\Repositories\Interfaces\IUser;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IComment;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\IFeature;
use App\Repositories\Interfaces\IPhotoAd;
use App\Repositories\Interfaces\ISetting;
use App\Repositories\Interfaces\IAdReport;
use App\Repositories\Interfaces\ICategory;
use App\Repositories\Interfaces\IFavorite;
use App\Repositories\Interfaces\ILastSeen;
use App\Repositories\Interfaces\ITransfer;
use App\Repositories\Interfaces\IBanner;
use App\Repositories\Interfaces\IFollowUp;

use App\Repositories\Eloquent\BannerRepository;
use App\Repositories\Eloquent\FollowUpRepository;
use App\Repositories\Eloquent\AdRepository;
use App\Repositories\Eloquent\SeoRepository;
use App\Repositories\Eloquent\BankRepository;
use App\Repositories\Eloquent\ChatRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\RateRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\ICommentReport;
use App\Repositories\Eloquent\CommentRepository;
use App\Repositories\Eloquent\CountryRepository;
use App\Repositories\Eloquent\FeatureRepository;
use App\Repositories\Eloquent\PhotoAdRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Interfaces\IAdReportReason;
use App\Repositories\Eloquent\AdReportRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\FavoriteRepository;
use App\Repositories\Eloquent\LastSeenRepository;
use App\Repositories\Eloquent\TransferRepository;
use App\Repositories\Interfaces\ICommentReportReason;
use App\Repositories\Eloquent\CommentReportRepository;
use App\Repositories\Eloquent\AdReportReasonRepository;
use App\Repositories\Eloquent\CommentReportReasonRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {   
        $this->app->bind(IFollowUp::class              , FollowUpRepository::class               );
        $this->app->bind(IBanner::class                , BannerRepository::class               );
        $this->app->bind(IRate::class                  , RateRepository::class                 );
        $this->app->bind(IFavorite::class              , FavoriteRepository::class             );
        $this->app->bind(ILastSeen::class              , LastSeenRepository::class             );
        $this->app->bind(ISeo::class                   , SeoRepository::class                  );
        $this->app->bind(IChat::class                  , ChatRepository::class                 );
        $this->app->bind(ITransfer::class              , TransferRepository::class             );
        $this->app->bind(IBank::class                  , BankRepository::class                 );
        $this->app->bind(IPhotoAd::class               , PhotoAdRepository::class              );
        $this->app->bind(IComment::class               , CommentRepository::class              );
        $this->app->bind(ICommentReport::class         , CommentReportRepository::class        );
        $this->app->bind(ICommentReportReason::class   , CommentReportReasonRepository::class  );
        $this->app->bind(IAdReport::class              , AdReportRepository::class             );
        $this->app->bind(IAdReportReason::class        , AdReportReasonRepository::class       );
        $this->app->bind(IAd::class                    , AdRepository::class                   );
        $this->app->bind(IFeature::class               , FeatureRepository::class              );
        $this->app->bind(ICategory::class              , CategoryRepository::class             );
        $this->app->bind(IUser::class                  , UserRepository::class                 );
        $this->app->bind(ICountry::class               , CountryRepository::class              );
        $this->app->bind(ICity::class                  , CityRepository::class                 );
        $this->app->bind(IRole::class                  , RoleRepository::class                 );
        $this->app->bind(ISetting::class               , SettingRepository::class              );

      }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
