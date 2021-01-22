<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IComment;
use App\Http\Requests\Site\AddComment;
use  App\Jobs\NewComment ;
class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(IComment $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function addComment(AddComment $request)
    {
        $comment = $this->commentRepo->store(['ad_id' => $request->ad_id, 'comment' => strip_tags($request->comment) , 'user_id' => auth()->id()]);
        $receiver = $comment->ad->user ;
        if ($receiver->is_notify == 1)
        {
            $data = [
                'sender'        => auth()->id(),
                'title_ar'      => 'تعليق جديد',
                'title_en'      => 'New Comment',
                'message_ar'    => 'لديك تعليق جديد علي اعلانك ل ' .auth()->user()->name,
                'message_en'    => 'New Comment On Your Ad By ' .auth()->user()->name,
                'data'          => [
                    'type'       => 2 ,
                    'comment_id' => $comment->id ,
                    'ad_id'      => $request->ad_id ,
                ],
            ];
            dispatch(new NewComment($receiver, $data));
        }
        $comment = view('site.ad.shared.comment', compact('comment'))->render();
        return response()->json(['comment' => $comment]);
    }

    public function deleteComment(Request $request)
    {
        $this->commentRepo->delete($request->id);
        return response()->json();
    }

}
