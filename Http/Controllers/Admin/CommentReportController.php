<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IComment;
use App\Repositories\Interfaces\ICommentReport;

class CommentReportController extends Controller
{
     protected $Repo;
     protected $CommentRepo;

    public function __construct(ICommentReport $Repo ,IComment $CommentRepo)
    {
        $this->Repo = $Repo;
        $this->CommentRepo = $CommentRepo;
    }


    /***************************  get all  **************************/
    public function index()
    {
        $rows = $this->Repo->get();
        return view('admin.commentreports.index', compact('rows'));
    }


    public function destroy($id)
    {
        $reason = $this->Repo->findOrFail($id);
        $this->Repo->softDelete($reason);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }

    public function destroyComment($id)
    {
        $comment = $this->CommentRepo->findOrFail($id);
        $this->CommentRepo->softDelete($comment);
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}
