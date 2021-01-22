<?php

namespace App\Repositories\Eloquent;

use App\Models\Ad;
use App\Traits\UploadTrait;

use App\Models\Category;
use App\Models\AdFeature;
use App\Models\AdImage;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\IAd;

class AdRepository extends AbstractModelRepository implements IAd
{

    use UploadTrait;

    private $category;
    private $adImage;


    public function __construct(Ad $model,AdImage $adImage , Category $category)
    {
        parent::__construct($model);
        $this->category  = $category;
        $this->adImage  = $adImage;

    }

    public function acceptedAds()
    {
        return $this->model->with('country')->with('city')->with('category')->with('user')->with('features')->with('features2')->with('images')->where('accepted',1)->orderBy('created_at','DESC')->get();
    }

    public function acceptedAdsPaginate()
    {
        return $this->model->with('country')->with('city')->with('category')->with('user')->with('features')->with('features2')->with('images')->where('accepted',1)->orderBy('created_at','DESC')->paginate(30);
    }

    public function waitAcceptedAds()
    {
        return $this->model->with('country')->with('city')->with('category')->with('user')->with('features')->with('features2')->with('images')->where('accepted',0)->orderBy('created_at','DESC')->get();
    }

    public function storeAd($attributes=[])
    {
        return $this->store($attributes);
    }

    public function store($attributes = [])
    {
        return  DB::transaction(function ()   use ($attributes) {
            $attributes['title']             = isset($attributes['title_ar']) && isset($attributes['title_en'])  ? $this->setName($attributes['title_ar'],$attributes['title_en']) : $this->setName($attributes['title_ar'],$attributes['title_ar']);
            $attributes['description']       = isset($attributes['description_ar']) && isset($attributes['description_en']) ? $this->setName($attributes['description_ar'],$attributes['description_en']) : $this->setName($attributes['description_ar'],$attributes['description_ar']);
            $attributes['identity']          = $this->setName($attributes['description_ar'],$attributes['description_ar']);
            $attributes['meta_title']        = isset($attributes['meta_title_ar']) ?  $this->setName($attributes['meta_title_ar'],$attributes['meta_title_en']) : $this->setName($attributes['title_ar'],$attributes['title_ar']);
            $attributes['meta_description']  = isset($attributes['meta_description_ar']) ? $this->setName($attributes['meta_description_ar'],$attributes['meta_description_en']) : $this->setName($attributes['description_ar'],$attributes['description_ar']);
            $attributes['meta_keywords']     = isset($attributes['meta_keywords_ar']) ? $this->setName($attributes['meta_keywords_ar'],$attributes['meta_keywords_en']) : $this->setName($attributes['description_ar'],$attributes['description_ar']);
            $attributes['accepted']          = 1 ;
            $attributes['active']            = 1 ;
            $ad                              = $this->model->create($attributes);

             if(isset($attributes['features'])){
                $features = [];
                foreach ($attributes['features'] as $key => $feature) {
                   $features[$key]['value']  = $feature;
                }

                foreach ($attributes['features_ids'] as $key =>  $feature) {
                   $features[$key]['feature_id']  = $feature;
                }
                
                
                foreach ($features as $key => $value) {
                    AdFeature::create([
                        'ad_id'        => $ad->id            ,
                        'feature_id'   => $value['feature_id'] ,
                        'value'        => $value['value']      ,
                    ]);
                }
            }

            // upload
            if(isset($attributes['images'])){
                foreach ($attributes['images'] as $image) {
                    AdImage::create([
                        'ad_id'        => $ad->id            ,
                        'image'        => $image,
                    ]);
                }
            }
            return $ad;
        });
    }

    public function addAd($attributes=[],$user_id)
    {
        return $this->add($attributes+(['user_id' => $user_id]));
    }

    public function add($attributes = [])
    {
        return  DB::transaction(function ()   use ($attributes) {
            $attributes['title']             = isset($attributes['title_ar']) && isset($attributes['title_en'])  ? $this->setName($attributes['title_ar'],$attributes['title_en']) : $this->setName($attributes['title_ar'],$attributes['title_ar']);
            $attributes['description']       = isset($attributes['description_ar']) && isset($attributes['description_en']) ? $this->setName($attributes['description_ar'],$attributes['description_en']) : $this->setName($attributes['description_ar'],$attributes['description_ar']);
            $attributes['identity']          = $this->setName(str_replace(' ' ,'_',$attributes['title_ar']),str_replace(' ' ,'_',$attributes['title_ar']));
            $attributes['accepted']          = 1 ;
            $attributes['active']            = 1 ;
            $attributes['is_chat']           = $attributes['is_chat']    == 'true' ? 1 : 0;
            $attributes['is_refresh']        = $attributes['is_refresh'] == 'true' ? 1 : 0;
            $attributes['is_phone']          = $attributes['is_phone']   == 'true' ? 1 : 0;
            $ad                              = $this->model->create($attributes);

             if(isset($attributes['features'])){
                $features = [];
                foreach ($attributes['features'] as $key => $feature) {
                   $features[$key]['value']  = $feature['value'];
                   $features[$key]['id']     = $feature['id'];
                }

                foreach ($features as $key => $value) {
                    AdFeature::create([
                        'ad_id'        => $ad->id            ,
                        'feature_id'   => $value['id'] ,
                        'value'        => $value['value']      ,
                    ]);
                }
            }

            // upload 
            if(isset($attributes['images'])){
                $images = [];
                foreach ($attributes['images'] as $image) {
                   $images[]['image']  = $image;
                }
                $ad->images()->createMany($images);
            }

            return $ad;
        });
    }
    
    public function update($attributes = [],$ad)
    {
        $attributes['title']             = $this->setName($attributes['title_ar'],$attributes['title_en']);
        $attributes['description']       = $this->setName($attributes['description_ar'],$attributes['description_en']);
        $attributes['meta_title']        = isset($attributes['meta_title_ar']) ? $this->setName($attributes['meta_title_ar'],$attributes['meta_title_en']) : $this->setName($attributes['title_ar'],$attributes['title_en']);
        $attributes['meta_description']  = isset($attributes['meta_description_ar']) ? $this->setName($attributes['meta_description_ar'],$attributes['meta_description_en']) : $this->setName($attributes['description_ar'],$attributes['description_en']);
        $attributes['meta_keywords']     = isset($attributes['meta_keywords_ar']) ? $this->setName($attributes['meta_keywords_ar'],$attributes['meta_keywords_en']) :$this->setName($attributes['description_ar'],$attributes['description_en']);
        $attributes['is_chat']           = isset($attributes['is_chat']) ? 1 : 0;
        $attributes['is_refresh']        = isset($attributes['is_refresh']) ? 1 : 0;
        $attributes['is_phone']          = isset($attributes['is_phone']) ? 1 : 0;
        $ad->update($attributes);
        if(isset($attributes['features'])){
            $features = [];
            foreach ($attributes['features'] as $key => $feature) {
                $features[$key]['value']  = $feature; 
            }

            foreach ($attributes['features_ids'] as $key =>  $feature) {
                $features[$key]['feature_id']  = $feature; 
            }
            
            AdFeature::where('ad_id',$ad->id)->delete();
            foreach ($features as $key => $value) {
                AdFeature::create([
                    'ad_id'        => $ad->id            ,
                    'feature_id'   => $value['feature_id'] ,
                    'value'        => $value['value']      ,
                ]);
            }
        }
        // upload
        if(isset($attributes['images'])){
            $images = [];
            foreach ($attributes['images'] as $image) {
                $images[]['image']  = $image;
            }
            $ad->images()->createMany($images);
        }
       

        return $ad;
    }

    public function updateAd($attributes = [],$ad)
    {
        $attributes['title']             = $this->setName($attributes['title_ar'],$attributes['title_en']);
        $attributes['description']       = $this->setName($attributes['description_ar'],$attributes['description_en']);
        $attributes['is_chat']           = isset($attributes['is_chat']) ? 1 : 0;
        $attributes['is_refresh']        = isset($attributes['is_refresh']) ? 1 : 0;
        $attributes['is_phone']          = isset($attributes['is_phone']) ? 1 : 0;
        $ad->update($attributes);
        AdFeature::where('ad_id',$ad->id)->delete();
        if(isset($attributes['features'])){
            $features = [];
            foreach ($attributes['features'] as $key => $feature) {
                $features[$key]['value']  = $feature['value'];
                $features[$key]['id']     = $feature['id'];
            }

            foreach ($features as $key => $value) {
                AdFeature::create([
                    'ad_id'        => $ad->id            ,
                    'feature_id'   => $value['id'] ,
                    'value'        => $value['value']      ,
                ]);
            }
        }

        // upload
        if(isset($attributes['images'])){
            $images = [];
            foreach ($attributes['images'] as $image) {
                $images[]['image']  = $image;
            }
            $ad->images()->createMany($images);
        }
        return $ad;
    }

    public function acceptUnAccept($Ad)
    {
        $Ad->accepted = $Ad->accepted == 1 ? 0 : 1 ;
        $Ad->save();
        return $Ad->accepted;
    }

    public function filterAds($attributes = [] , $page = 0)
    {
        $data = [];
        $blogs = $this->model->query();

        if (isset($attributes['ids']) && $attributes['ids']!= null && $attributes['ids']!= '' )
            $blogs = $blogs->whereIn('id', $attributes['ids']);

        if (isset($attributes['city_id']) && $attributes['city_id']!= null && $attributes['city_id']!= '' )
            $blogs = $blogs->where('city_id', $attributes['city_id']);

        if (isset($attributes['country_id']) && $attributes['country_id']!= null && $attributes['country_id']!= '' )
            $blogs = $blogs->where('country_id', $attributes['country_id']);

        if (isset($attributes['category_id']) && $attributes['category_id']!= null && $attributes['category_id']!= '' ){
            $categoriesIdsArray      =  $this->category->find($attributes['category_id'])->getAllChildren()->pluck('id')->toArray();
            $categoriesIdsArray[]    = (int) $attributes['category_id'];
            $blogs                   = $blogs->whereIn('category_id',$categoriesIdsArray);
        }

        if (isset($attributes['keyword']) && $attributes['keyword']!= null ){
            $blogs = $blogs->where('title', 'like', '%' . $attributes['keyword'] . '%')
                           ->orwhere('description' , 'like', '%' . $attributes['keyword'] . '%');
        }

        if (isset($attributes['latitude']) && isset($attributes['longitude'])  && $attributes['longitude']!= null && $attributes['latitude']!= null ) {
            $longitude = $attributes['longitude'];
            $latitude = $attributes['latitude'];
            $blogs = $blogs->having('distance', '<=', '50')->select(DB::raw("*,
                         (3959 * ACOS(COS(RADIANS($latitude))
                               * COS(RADIANS(latitude))
                               * COS(RADIANS($longitude) - RADIANS(longitude))
                               + SIN(RADIANS($latitude))
                               * SIN(RADIANS(latitude)))) AS distance")
            );
        } else {
            $blogs = $blogs->orderBy('created_at', 'DESC');
        }

        $blogs = $blogs->with([ 'category' , 'city' ,'user' , 'category' ])->accepted()->active()->latest()->paginate(10);
        return $blogs;
    }

    public function lastSeenAds($ids)
    {
        $ads = $this->model->whereIn('id' , $ids) ->get() ;
        return $ads ; 
    }

     public function similerAds($ad_id){
        $ad = $this->model->find($ad_id);
         return  $this->model->active()->accepted()
            ->where('category_id', $ad->category_id)
            ->orWhere('title', 'like', '%' .$ad->title . '%')
            ->orWhere('description', 'like', '%' .$ad->description . '%')
            ->inRandomOrder()->limit(11)->get()->except($ad_id);
    }

    public function deleteImage($id)
    {
        return $this->adImage->find($id)->delete();
        return ;
    }
 }
