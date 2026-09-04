<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
trait FileUpload
{
    public function uploadImage($request, $input_name ,$path){
        $image_name = '';

        if($request->hasFile($input_name)){
            $image = $request->file($input_name);
            $image_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path),$image_name);
        }

        return $image_name;
    }

    public function updateImage($request, $data, $input_name ,$path){  
        $image_name = $data->{$input_name};

        if($request->hasFile($input_name)){
                
            if($image_name && File::exists(public_path($path.$image_name))){
                File::delete(public_path($path.$image_name));
            }

            $image = $request->file($input_name);
            $image_name = uniqid().".".$image->getClientOriginalExtension();

            $image->move(public_path($path),$image_name);
        }

        return $image_name;
    }

    public function deleteImage($image_name , $path){  

        if($image_name && File::exists(public_path($path.$image_name))){
            File::delete(public_path($path.$image_name));
        }
    }
}