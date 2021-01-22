<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ICountry;
use App\Http\Requests\Admin\Country\Create;

class CountryController extends Controller
{
    protected $countryRepo;
    public function __construct(ICountry $Country)
    {
        $this->countryRepo = $Country;
    }
    /***************************  get all  **************************/
    public function index()
    {
        $countries = $this->countryRepo->get();
        return view('admin.countries.index', compact('countries'));
    }
    /***************************  store  **************************/
    public function store(Create $request)
    {
        $this->countryRepo->store(array_filter($request->validated()));
        return response()->json();
    }
    /***************************  update  **************************/
    public function update(Create $request, $id)
    {
        $country = $this->countryRepo->findOrFail($id);
        $this->countryRepo->update($request->validated(),$country);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
    public function destroy($id)
    {
        $country = $this->countryRepo->findOrFail($id);
        $this->countryRepo->softDelete($country);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
