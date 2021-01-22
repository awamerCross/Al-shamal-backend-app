<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\Create;
use App\Http\Requests\Admin\Admin\UpdateProfile;
use App\Repositories\Interfaces\IRole;
use App\Repositories\Interfaces\IUser;
use Illuminate\Http\Request;


class AdminController extends Controller
{

    protected $userRepo, $roleRepo;

    public function __construct(IUser $user,IRole $role)
    {
        $this->userRepo = $user;
        $this->roleRepo = $role;
    }

    /***************************  get all admins  **************************/
    public function index()
    {
        $admins = $this->userRepo->admins();
        $roles  = $this->roleRepo->get();
        return view('admin.admins.index', compact('admins','roles'));
    }


    /***************************  store admin **************************/
    public function store(Create $request)
    {
        $this->userRepo->storeAdmin(array_filter($request->all()));
        return response()->json();
        // return redirect()->back()->with('success', 'added successfully');
    }

    /***************************  edit admin  **************************/
    public function edit($id)
    {
        $admin = $this->userRepo->findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /***************************  update admin  **************************/
    public function update(Request $request, $id)
    {
        $admin = $this->userRepo->findOrFail($id);
        $this->userRepo->update(array_filter($request->all()),$admin);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    /***************************  delete admin  **************************/
    public function destroy($id)
    {
         $role = $this->userRepo->findOrFail($id);
         $this->userRepo->softDelete($role);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    /***************************  update profile  **************************/
    public function updateProfile(UpdateProfile $request,$id)
    {
        $admin = $this->userRepo->findOrFail($id);
        $this->userRepo->update(array_filter($request->all()),$admin);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }
}
