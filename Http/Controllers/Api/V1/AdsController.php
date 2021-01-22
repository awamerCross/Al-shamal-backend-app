<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IAd;
use App\Http\Requests\Api\favUnFavAd;
use App\Http\Resources\SingleAdResource;
use App\Http\Resources\CommentResource;
use App\Repositories\Interfaces\IComment;
use App\Repositories\Interfaces\IFavorite;
use App\Repositories\Interfaces\ILastSeen;
use App\Http\Requests\Api\addCommentRequest;
use App\Http\Requests\Api\AdDetailesRequest;
use App\Http\Requests\Api\deleteCommentRequest;
use App\Http\Requests\Api\addAdRequest;
use App\Http\Requests\Api\deleteAdRequest;
use  App\Jobs\NewComment ;

class AdsController extends Controller
{
    use     Responses;

    private $Repo;
    private $lastSeenRepo;
    private $FavoriteRepo;
    private $CommentRepo;

    public function __construct(IAd $Repo ,ILastSeen $lastSeenRepo,IFavorite $FavoriteRepo,IComment $CommentRepo)
    {
        $this->Repo          =   $Repo;
        $this->lastSeenRepo  = $lastSeenRepo;
        $this->FavoriteRepo  = $FavoriteRepo;
        $this->CommentRepo   = $CommentRepo;
    }



    public function filterAds(Request $request)
    {
        $ads = AdResource::collection($this->Repo->filterAds($request->all() , $request->page));
        $this->sendResponse($ads ,'' , $this->paginationModel($ads));
    }

    public function LastSeen()
    {
        $ids = $this->lastSeenRepo->lastseen(auth()->id());
        $ads = AdResource::collection($this->Repo->lastSeenAds($ids));
        $this->sendResponse($ads); 
    }

    public function Favorite()
    {
        $ids = $this->FavoriteRepo->favoriets(auth()->id());
        $ads = AdResource::collection($this->Repo->lastSeenAds($ids));
        $this->sendResponse($ads); 
    }

    public function AdDetailes(AdDetailesRequest $request)
    {
        $this->lastSeenRepo->plusLastSeen(['user_id' => auth()->id() , 'ad_id' => $request->ad_id]);
        $ad = new SingleAdResource($this->Repo->find($request->ad_id));
        $data = [
            'ad'         => $ad ,
            'similerAds' => AdResource::collection($this->Repo->similerAds($request->ad_id)) 
        ];
        $this->sendResponse($data); 
    }

    public function favUnFavAd(favUnFavAd $request)
    {
        $msg =  $this->FavoriteRepo->favUnFav(auth()->id() , $request->ad_id) == 1 ? __('apis.fav') : __('apis.unFav') ;
        $this->sendResponse('' , $msg);
    }

    public function addComment(addCommentRequest $request)
    {
        $comment =  $this->CommentRepo->store($request->validated()+(['user_id'=>auth()->id()]));
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
        $this->sendResponse(new CommentResource($comment) , __('apis.commentAdded'));
    }
    
    public function deleteComment(deleteCommentRequest $request)
    {
        $comment = $this->CommentRepo->find($request->comment_id);
        if (auth() ->id() != $comment->user_id) {
            $this->sendResponse('' , __('apis.unauthorize'));
        }
        $this->CommentRepo->delete($request->comment_id);
        $this->sendResponse('' , __('apis.commentDeleted'));
    }

    public function addAd(addAdRequest $request)
    {
        $ad = $this->Repo->addAd($request->all() , auth()->id());
        $this->sendResponse('' , __('apis.addAdded'));
    }

    public function deleteAd(deleteAdRequest $request)
    {
        $ad = $this->Repo->find($request->ad_id);
        if (auth()->id() == $ad->user_id){
            $this->Repo->softDelete($ad);
            $this->sendResponse('' , __('apis.adDeleted'));
        }else{
            $this->errorResponse([],trans('apis.unauthorize'));
        }
    }

    public function transferAds(Request $request){
        $ads = $this->Repo->get();
        $ads=  AdResource::collection($ads);
        $this->sendResponse($ads);
    }

    public function refreshAd(Request $request)
    {
        $ad =  $this->Repo->find($request->ad_id);
        $ad->update(['created_at' => \Carbon\Carbon::now()]);
        $this->sendResponse('',__('apis.refreshed'));
    }

    public function deleteImageAd(Request $request)
    {
        $this->Repo->deleteImage($request->id);
        $this->sendResponse('','');

    }

    public function updateAd(Request $request)
    {
        $ad = $this->Repo->find($request->ad_id);
        $ad = $this->Repo->updateAd($request->all() , $ad);
        $this->sendResponse('' , __('apis.updated'));
    }
}
