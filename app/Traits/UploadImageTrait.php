<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait UploadImageTrait
{
    private function uploadImage($file, $path)
    {
        $fileName = md5($file->getClientOriginalName() . time()) . '.' . File::extension($file->getClientOriginalName());
        $file->move(storage_path("app/public/$path/"), $fileName);

        return "/storage/$path/" . $fileName;
    }
}
