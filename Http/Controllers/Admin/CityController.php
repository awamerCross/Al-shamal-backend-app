<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ICity;
use App\Http\Requests\Admin\City\Create;
use App\Repositories\Interfaces\ICountry;

class CityController extends Controller
{
     protected $Repo;
     protected $countryRepo;

    public function __construct(ICity $repo,ICountry $country)
    {
        $this->Repo = $repo;
        $this->countryRepo = $country;
    }

    /***************************  get all  **************************/
    public function index()
    {
        view()->share([
            'singleName' => 'مدينه',
            'rows'       =>  $this->Repo->get(),
            'countries'  => $this->countryRepo->get(),
            ]);
        return view('admin.cities.index');
    }

    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->Repo->store(array_filter($request->validated()));
        return response()->json();

        // return redirect()->back()->with('success', 'added successfully');
    }

    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $city = $this->Repo->findOrFail($id);
        $this->Repo->update($request->validated(),$city);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function getCities(Request $request)
    {
        $cities  = $this->Repo->citiesByCountry($request->id);
        return response()->json(['cities' => $cities]);
    }
}
