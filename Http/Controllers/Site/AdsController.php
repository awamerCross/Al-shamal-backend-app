<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Site\addAdRequest;
use App\Http\Requests\Site\EditAdRequest;

use App\Repositories\Interfaces\IAd;
use App\Repositories\Interfaces\IAdReportReason;
use App\Repositories\Interfaces\IAdReport;
use App\Repositories\Interfaces\ICommentReportReason;
use App\Repositories\Interfaces\ICommentReport;
use App\Repositories\Interfaces\ILastSeen;
use App\Repositories\Interfaces\ICategory;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\ICity;

class AdsController extends Controller
{
    protected $adRepo;
    protected $adReportReasonRepo;
    protected $adReportRepo;
    protected $commentReportReasonRepo;
    protected $commentReportRepo;
    protected $lastSeenRepo;
    protected $CategoryRepo;
    protected $CountryRepo;
    protected $CityRepo;

    public function __construct(IAd $adRepo ,IAdReportReason $adReportReasonRepo,IAdReport $adReportRepo ,ICommentReportReason $commentReportReasonRepo,ICommentReport $commentReportRepo ,ILastSeen $lastSeenRepo,ICategory $CategoryRepo,ICountry $CountryRepo ,ICity $CityRepo )
    {
        $this->adRepo                   = $adRepo;
        $this->adReportReasonRepo       = $adReportReasonRepo;
        $this->adReportRepo             = $adReportRepo;
        $this->commentReportReasonRepo  = $commentReportReasonRepo;
        $this->commentReportRepo        = $commentReportRepo;
        $this->lastSeenRepo             = $lastSeenRepo;
        $this->CategoryRepo             = $CategoryRepo;
        $this->CountryRepo              = $CountryRepo;
        $this->CityRepo                 = $CityRepo;
    }

    public function filterAds(Request $request)
    {
        $ads = $this->adRepo->filterAds($request->all() , $request->page);
        $ads  =  view('site.shared.ad' , ['ads'  => $ads])->render();
        return response()->json(['ads' => $ads]);
    }

    public function adDetailes($id,$identity = null ,$comment2 = null )
    {
        $this->lastSeenRepo->plusLastSeen(['user_id' => auth()->id() , 'ad_id' => $id]);
        $ad              = $this->adRepo->find($id);
        $adReasons       = $this->adReportReasonRepo->get();
        $commentReasons  = $this->commentReportReasonRepo->get();
        $similerAds      = $this->adRepo->similerAds($id);
        return view('site.ad.detailes' , compact('ad','similerAds' ,'adReasons','commentReasons' ,'comment2'));
    }
    public function addAdReport(Request $request)
    {
        $this->adReportRepo->store($request->all()+(['user_id' =>auth()->id()]));
        return response()->json();
    }

    public function addCommentReport(Request $request)
    {
        $this->commentReportRepo->store($request->all()+(['user_id' =>auth()->id()]));
        return response()->json();
    }

    public function chooseAdType()
    {
        return view('site.ad.choose_type');
    }

    public function adTerms()
    {
        return view('site.ad.ad_terms');
    }

    public function addAdForm($id)
    {
        $category    = $this->CategoryRepo->find($id) ;
        $countries   = $this->CountryRepo->get() ;
        $cities      = $this->CityRepo->get() ;
        return view('site.ad.add_ad_form' ,compact('category' ,'countries' ,'cities'));
    }

    public function addAd(addAdRequest $request)
    {
        $this->adRepo->storeAd($request->all()+(['user_id' => auth()->id()]));
        return response()->json(['msg' => __('apis.added')]);
    }


    public function editAdForm($id , $category = null)
    {
        $ad          = $this->adRepo->find($id)  ;
        if ($category != null ){
            $category    = $this->CategoryRepo->find($category) ;
        }else{
            $category    = $ad->category;
        }
        $countries   = $this->CountryRepo->get() ;
        $cities      = $this->CityRepo->get()    ;
        return view('site.ad.edit' ,compact('ad','category' ,'countries' ,'cities'));
    }
    public function deleteImage(Request $request)
    {
        $this->adRepo->deleteImage($request->id);
        return response()->json(['msg' => __('site.deleted')]);
    }

    public function deleteAd(Request $request)
    {
        $ad = $this->adRepo->findOrFail($request->ad_id);
        $this->adRepo->softDelete($ad);
        return response()->json(['msg' => __('site.deleted')]);
    }

    public function editAd(EditAdRequest $request ,$id)
    {
        $ad = $this->adRepo->find($id);
        $ad = $this->adRepo->update($request->all() , $ad);
        return response()->json(['msg' => __('site.edited')]);
    }
}
