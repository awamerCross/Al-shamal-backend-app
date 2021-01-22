<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\AddEditClientRequest;
use App\Repositories\Interfaces\IRole;
use App\Repositories\Interfaces\IUser;
use App\Jobs\BlockUser;
use App\Jobs\AcceptAd;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $userRepo;

    public function __construct(IUser $user)
    {
        $this->userRepo = $user;
    }

    /***************************  get all clients  **************************/
    public function index()
    {
        $clients = $this->userRepo->clients();
        return view('admin.clients.index', compact('clients'));
    }


    /***************************  store client **************************/
    public function store(AddEditClientRequest $request)
    {
        $this->userRepo->storeClient($request->all());
        return response()->json();
        // return redirect()->back()->with('success', 'added successfully');
    }

    /***************************  update client  **************************/
    public function update(AddEditClientRequest $request, $id)
    {
        $admin = $this->userRepo->findOrFail($id);
//        dd($admin);
        $this->userRepo->update($request->all(),$admin);
        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    /***************************  delete client **************************/
    public function destroy($id)
    {
        $client = $this->userRepo->findOrFail($id);
        $this->userRepo->softDelete($client);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function blockUser($id)
    {
        $client = $this->userRepo->findOrFail($id);
        $this->userRepo->block($client);
        $data = [
            'sender'        => auth()->id(),
            'title_ar'      => 'حظر',
            'title_en'      => 'Block',
            'message_ar'    => 'تم حظرك من قبل الادراه ',
            'message_en'    => 'You have been banned by admin',
            'data'          => [
                'type'       => 4 ,
            ],
        ];
        dispatch(new BlockUser($client, $data));
        return redirect()->back()->with('success', 'تم حظر المستخدم بنجاح');
    }
    public function notify(Request $request)
    {
        $data = [
            'sender'        => auth()->id(),
            'title_ar'      => 'تنبيه اداري',
            'title_en'      => 'Administrative Notify',
            'message_ar'    => $request->message_ar ? $request->message_ar : $request->message_en ,
            'message_en'    => $request->message_en ? $request->message_en : $request->message_ar,
            'data'          => [
                'type'       => 0 ,
            ],
        ];

        if ($request->id == 'all'){
            $clients =  $this-> userRepo->clients();
            foreach ($clients as $client){
                dispatch(new AcceptAd($client, $data));
            }
        }else{
            $client = $this-> userRepo->findOrFail($request->id);
            dispatch(new AcceptAd($client, $data));
        }
        return redirect()->back()->with('success', 'تم ارسال الاشعار بنجاح');
    }
}
