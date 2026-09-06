<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
trait FileUpload
{
    public function uploadFile($request, $input_name ,$path){
        $file_name = '';

        if($request->hasFile($input_name)){
            $image = $request->file($input_name);
            $file_name = uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path($path),$file_name);
        }

        return $file_name;
    }

    public function updateFile($request, $data, $input_name ,$path){  
        $file_name = $data->{$input_name};

        if($request->hasFile($input_name)){
                
            if($file_name && File::exists(public_path($path.$file_name))){
                File::delete(public_path($path.$file_name));
            }

            $image = $request->file($input_name);
            $file_name = uniqid().".".$image->getClientOriginalExtension();

            $image->move(public_path($path),$file_name);
        }

        return $file_name;
    }

    public function deleteFile($file_name , $path){  

        if($file_name && File::exists(public_path($path.$file_name))){
            File::delete(public_path($path.$file_name));
        }
    }
}