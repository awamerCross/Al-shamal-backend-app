<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\Create;
use App\Repositories\Interfaces\IRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    protected $roleRepo;

    public function __construct(IRole $role)
    {
        $this->roleRepo = $role;
    }

    /***************************  get all roles  **************************/
    public function index()
    {
        $roles = $this->roleRepo->get();
        return view('admin.roles.index', compact('roles'));
    }

    /***************************  get all roles  **************************/
    public function create()
    {
        return view('admin.roles.create');
    }

    /***************************  get all roles  **************************/
    public function store(Create $request)
    {
        if(!$request->permissions){
            return back()->with('danger', 'يجب اختيار صلاحيه واحده علي الاقل ');
        }
        $role = $this->roleRepo->store($request->all());

        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);

        return redirect(route('admin.roles.index'))->with('success', 'تم الاضافه بنجاح');
    }

    /***************************  get all roles  **************************/
    public function edit($id)
    {
        $role = $this->roleRepo->findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    /***************************  get all roles  **************************/
    public function update(Request $request, $id)
    {
        $role = $this->roleRepo->findOrFail($id);
        $role->permissions()->delete();
        $permissions = [];
        foreach ($request->permissions ?? [] as $permission)
            $permissions[]['permission'] = $permission;

        $role->permissions()->createMany($permissions);

        return redirect(route('admin.roles.index'))->with('success', 'تم التعديل بنجاح');
    }

    /***************************  destroy  **************************/
    public function destroy($id)
    {
         $role = $this->roleRepo->findOrFail($id);
         $this->roleRepo->softDelete($role);
        return redirect(route('admin.roles.index'))->with('success', 'تم الحذف بنجاح');
    }
}
