<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CommonController extends Controller
{
    public static function fileUploaded($slug = true, $image_name = false, $image, $directory, $size = ['width' => null, 'height' => null], $old_image = null)
    {

        $currentDate = Carbon::now()->toDateString();
        if ($slug){
            $image_name = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
        }
        // check is exits directory
        if (!Storage::disk('public')->exists($directory)){

            Storage::disk('public')->makeDirectory($directory);
        }

        // resize image for upload
        $resized_image = Image::make($image)->resize($size['width'], $size['height'])->stream();
        Storage::disk('public')->put($directory.'/'.$image_name, $resized_image);

        if ($old_image){
            self::deleteImage($directory, $old_image);
        }

        return $image_name;
    }

    public static function deleteImage($directory, $image_name){

        if (Storage::disk('public')->exists($directory.'/'.$image_name)){

            Storage::disk('public')->delete($directory.'/'.$image_name);
        }
    }

    public static function PdfFileUpload($file, $slug, $oldFile = null){

        $currentDate = Carbon::now()->toDateString();
        $directory = public_path().'/storage/Uploaded_files/';


            $file_name = $slug.'-'.$currentDate.'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move($directory, $file_name);

            if ($oldFile){
                self::deleteFile($oldFile, $directory);
            }

            return $file_name;
    }

    public static function deleteFile($oldFile, $directory){
        if($directory->exists($oldFile)){
            $directory->delete($oldFile);
        }
    }
}
