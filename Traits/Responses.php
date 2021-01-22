<?php

namespace App\Traits;
use Illuminate\Http\Exceptions\HttpResponseException;

trait  Responses
{

    public  function validationResponse($validator){
        $response = [
            'success'   => false,
            'message'   => $validator->errors()->first(),
            'data'      => null,
            'extra'     => [],
        ];
        throw new HttpResponseException(response()->json( $response , 200));
    }

    public  function  sendResponse($result, $message = '', $extraData = null){
        $response = [
            'success'  => true,
            'message'  => $message,
            'data'     => $result,
            'extra'    => auth()->user() != null ? auth()-> user()->block : 0,
            'pages'    => $extraData,
        ];
        throw new HttpResponseException(response()->json( $response , 200));
    }

    public  function  errorResponse($result, $message = '', $extraData = null){
        $response = [
            'success'  => false,
            'message'  => $message,
            'data'     => $result,
            'extra'    => auth()->user() != null ? auth()-> user()->block : '',
        ];
        throw new HttpResponseException(response()->json( $response , 200));
    }

    public function paginationModel( $col ){
            $data = [
                'total'         => $col -> total()              ??'',
                'count'         => $col -> count()              ??'',
                'per_page'      => $col -> perPage()            ??'',
                'next_page_url' => $col -> nextPageUrl()        ??'',
                'perv_page_url' => $col -> previousPageUrl()    ??'',
                'current_page'  => $col -> currentPage()        ??'',
                'total_pages'   => $col -> lastPage()           ??'',
            ];
            return $data;
    }
}

