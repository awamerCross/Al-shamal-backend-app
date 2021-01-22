<?php

namespace App\Traits;
use Image ;

trait UploadTrait
{


    public function uploadAllTyps($file , $directory = 'unknown' , $resize = null , $resize400 = null  )
    {
        if (is_file($file)){
            $img = Image::make($file);
            $thumbsPath             = 'public/storage/images/' . $directory;
            $name                   = time().'_'. rand(1111,9999).'.'. $file->getClientOriginalExtension();

            $img->save($thumbsPath . '/' . $name);

            if ($resize != null){
                $img->resize($resize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resize/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }
            if ($resize != null){
                $img->resize($resize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resize/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }
            if ($resize400 != null){
                $img->resize(400, 300 , function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resizeMid/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }
            return (string) $name ;
        }else{
            $name = time() . rand(1000000, 9999999) .  '.png';
            file_put_contents(base_path().'/public/storage/images/' . $directory . '/' . $name, base64_decode($file));
            if ($resize != null){
                $img = Image::make(base64_decode($file));
                $img->resize($resize, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resize/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }
            if ($resize != null){
                $img = Image::make(base64_decode($file));
                $img->resize($resize, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resize/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }

            if ($resize400 != null){
                $img = Image::make(base64_decode($file));
                $img->resize(400, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $thumbsPath = 'public/storage/resizeMid/images/' . $directory;
                $img->save($thumbsPath . '/' . $name);
            }
            return (string) $name;
        }

    }
    public function uploadFile($file, $directory = 'unknown'): string
    {
        $name = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('/public/images/' . $directory, $name);
        return $name;
    }

    public  function uploadBase64(String $base64, String $path) : string
    {
        $image     = base64_decode($base64);
        $imgName = time() . rand(1000000, 9999999) .  '.png';
        $p = 'public/storage/images/' . $path .'/'.$imgName;
        file_put_contents($p , $image);
        return (string) $imgName;
    }

    public function deleteFile($file_name, $directory = 'unknown'): void
    {
        if ($file_name && file_exists('public/storage/images/' . $directory . '/' . $file_name)) {
            unlink('public/storage/images/' . $directory . '/' . $file_name);
        }
    }

    public function deleteFileModified($icon): void
    {
        if ($icon && file_exists($icon)) {
            unlink($icon);
        }
    }

     public  function uploadImage ($image,  $path , $resize = null)
     {
         $img = Image::make($image);
         $img->resize(200, null, function ($constraint) {
             $constraint->aspectRatio();
         });
         $thumbsPath             = 'public/storage/images/' . $path;
         $name                   = time().'_'. rand(1111,9999).'.png';
         $img->save($thumbsPath . '/' . $name);
         return (string) $name;
     }


    // public  function uploadImageWaterMark ($image,  $path)
    // {
    //     $watermark = Image::make(public_path('images/site/logo.png'))->resize(80, 80)->opacity(100);
    //     $img = Image::make($image);
    //     $resizePercentage = 80;
    //     $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2);
    //     $watermark->resize($watermarkSize, null, function ($constraint) {
    //         $constraint->aspectRatio();
    //     });
    //     $thumbsPath             = 'images/' . $path;
    //     $name                   = time().'_'. rand(1111,9999).'.png';
    //     $img->insert($watermark, 'bottom-left', 20, 20)->save($thumbsPath . '/' . $name);
    //     return (string) $name;
    // }

  
}
