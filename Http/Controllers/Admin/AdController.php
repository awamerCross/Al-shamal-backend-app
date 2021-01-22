<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IAd;
use App\Http\Requests\Admin\Ad\Create;
use App\Repositories\Interfaces\ICity;
use App\Repositories\Interfaces\IUser;
use App\Repositories\Interfaces\ICountry;
use App\Repositories\Interfaces\ICategory;
use  App\Jobs\AcceptAd ;

class AdController extends Controller
{
     protected $Repo;
     protected $countryRepo;
     protected $cityRepo;
     protected $userRepo;
     protected $categoryRepo;

    public function __construct(IAd $repo,ICountry $country,ICity $city,IUser $user,ICategory $category)
    {
        $this->Repo             = $repo;
        $this->countryRepo      = $country;
        $this->cityRepo         = $city;
        $this->userRepo         = $user;
        $this->categoryRepo     = $category;
    }

    /***************************  get all  **************************/
    public function index()
    {
        view()->share([
            'singleName' => 'اعلان',
            'rows'       => $this->Repo->acceptedAds(),
            'countries'  => $this->countryRepo->get(),
            'users'      => $this->userRepo->clients(),
            'categories' => $this->categoryRepo->allCategories(),
            ]);
        return view('admin.ads.index');
    }
    public function unaccepted()
    {
        view()->share([
            'singleName' => 'اعلان',
            'rows'       => $this->Repo->waitAcceptedAds(),
            'countries'  => $this->countryRepo->get(),
            'users'      => $this->userRepo->clients(),
            'categories' => $this->categoryRepo->allCategories(),
            ]);
        return view('admin.ads.index');
    }

    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->Repo->storeAd(array_filter($request->all()));
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $city = $this->Repo->findOrFail($id);
        $this->Repo->update($request->all(),$city);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function acceptUnAccept($id)
    {

        $Ad = $this->Repo->findOrFail($id);
        $status = $this->Repo->acceptUnAccept($Ad);
        $receiver = $Ad->user ;
        if ($receiver->is_notify == 1)
        {
            $data = [
                'sender'      => auth()->id(),
                'title_ar'    => $status == 1 ? 'قبول اعلان': 'رفض اعلان',
                'title_en'    => $status == 1 ? 'Ad Accept': 'Ad Refused',
                'message_ar'  => $status == 1 ? 'تم قبول اعلانك  ' .$Ad->title  : 'تم رفض اعلانك  ' .$Ad->title  ,
                'message_en'  => $status == 1 ? 'Your Ad Accepted ' .$Ad->title  : 'Your Ad Refused ' .$Ad->title,
                'data'          => [
                    'type'       => 3 ,
                    'ad_id'      => $Ad->id ,
                ],
            ];
            dispatch(new AcceptAd($receiver, $data));
        }
        return redirect()->back()->with('success', 'تمت العمليه بنجاح');
    }
}
