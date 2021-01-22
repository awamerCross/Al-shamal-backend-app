<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IUser;
use App\Repositories\Interfaces\IPhotoAd;
use App\Http\Requests\Admin\PhotoAd\Create;
use App\Http\Requests\Admin\PhotoAd\Update;

class PhotoAdController extends Controller
{
    protected $Repo;
    protected $userRepo;

    public function __construct(IPhotoAd $repo,IUser $user)
    {
        $this->Repo             = $repo;
        $this->userRepo         = $user;
    }

    /***************************  get all  **************************/
    public function index()
    {
        view()->share([
            'rows'       => $this->Repo->acceptedAds(),
            'users'      => $this->userRepo->clients(),
            ]);
        return view('admin.photoads.index');
    }
    public function unaccepted()
    {
        view()->share([
            'rows'       => $this->Repo->unAcceptedAds(),
            'users'      => $this->userRepo->clients(),
            ]);
        return view('admin.photoads.index');
    }

    public function store(Create $request)
    {
        $this->Repo->store(array_filter($request->all()) + (['accepted' => 1]));
        return redirect()->back()->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  update  **************************/
    public function update(Update $request, $id)
    {
        $photoAd = $this->Repo->findOrFail($id);
        $this->Repo->update($request->validated(),$photoAd);
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
        $photoAd = $this->Repo->findOrFail($id);
        $this->Repo->acceptUnAccept($photoAd);
        return redirect()->back()->with('success', 'تمت العمليه بنجاح');
    }
}
