<?php

namespace App\Repositories\Classes;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Uploader
{
    public function storeImageFile($file)
    {
        $filePath = "upload";

        return $this->storePublicImage($file, $filePath);
    }

    public function storePublicImage($file, $filePath)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $image = Image::make($file->getRealpath())->orientate();

        $path = public_path('storage/' . $filename);

        $image->save($path);

        return 'upload/' . $filename;
    }

    public function storeImage($folder, $fileName)
    {
        if (!request()->hasFile($fileName)) {
            return null;
        }

        $file = request()->file($fileName);

        return Storage::disk('public')->put($folder, $file);
    }

    public function removeImage($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function copyFolder($currentName, $newName)
    {
        $newFolder = storage_path('app/' . $newName);

        if (!file_exists($newFolder)) {
            File::copyDirectory(storage_path('app/' . $currentName), $newFolder);
        }
    }

    public function uploadImage(array $request, $inputName, $folder)
    {
        if (!$request[$inputName]->isValid()) {
            return null;
        }

        $temp = time() . rand(5, 50);
        $ext = $request[$inputName]->getClientOriginalExtension();
        $ext = strtolower($ext);
        $newFileName = $temp . '.' . $ext;
        $path = "assets/" . $folder;

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request[$inputName]->move($path, $newFileName);

        if (isset($upload)) {
            return $newFileName;
        }

        return null;
    }
}

/*
class Uploader
{
    public function storeImageFile($file)
    {
        $filePath = "upload";

        return Storage::disk('public')->put($filePath, $file);
    }

    public function storeImagePublic()
    {
        $filename = time() . '.' . request()->file('thumbnail')->getClientOriginalExtension();

        $file = Image::make(request()->file('thumbnail')->getRealpath());

        $file->orientate();

        $path = base_path('storage/app/public/upload/' . $filename);

        $file->save($path);

        return 'upload/' . $filename;
    }

    public function storeImage($folder, $fileName)
    {
        if (!request()->hasFile($fileName)) {
            return null;
        }

        $file = request()->file($fileName);

        return Storage::disk('s3')->put($folder, $file);
    }

    public function removeImage($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function removeFileS3($path)
    {
        Storage::disk('s3')->delete($path);
    }

    public function storeListImage($folder, $file_name)
    {
        return Storage::disk('s3')->put($folder, $file_name);
    }

    function copyFolder($currentName, $newName)
    {
        $newFolder = base_path('storage/app/' . $newName);

        if (!file_exists($newFolder)) {
            File::copyDirectory(base_path('storage/app/' . $currentName), base_path('storage/app/' . $newName));
        }
    }

    public function uploadImage(array $request, $inputName, $folder)
    {
        $temp = time() . rand(5, 50);
        $ext = $request[$inputName]->getClientOriginalExtension();
        $ext = strtolower($ext);
        $new_file_name = $temp . '.' . $ext;
        $path = "assets/" . $folder;

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request[$inputName]->move($path, $new_file_name);

        if (isset($upload)) {
            return $new_file_name;
        }

        return null;
    }

    public function storeFile($file_name)
    {
        $file = request()->file($file_name);

        $filePath = "upload";

        return Storage::disk('s3')->put($filePath, $file);
    }
}
*/
/*
<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class Uploader
{
    public function storeImageFile($file)
    {
        $filePath = "upload";

        return Storage::disk('public')->put($filePath, $file);
    }

    public function storeImagePublic()
    {
        $filename = time() . '.' . request()->file('thumbnail')->getClientOriginalExtension();

        $file = Image::make(request()->file('thumbnail')->getRealpath());

        $file->orientate();

        $path = base_path('storage/app/public/upload/' . $filename);

        $file->save($path);

        return 'upload/' . $filename;
    }

    public function storeImage($folder, $fileName, $isFile = null)
    {
        if ($isFile) {
            $file = $fileName;
        } else {
            if (!request()->hasFile($fileName)) {
                return null;
            }

            $file = request()->file($fileName);
        }

        $filePath = "$folder";

        return Storage::disk('public')->put($filePath, $file);
    }

    public function storeVideo($folder, $fileName, $id)
    {
        $md5Name = md5_file(request()->file($fileName)->getRealPath());
        $guessExtension = request()->file($fileName)->guessExtension();

        $filePath = "assets01";
        if (isset($folder) && !empty($folder)) {
            $filePath = "assets01/$folder";
        }
        return request()->file($fileName)->storeAs($filePath, 'meal_' . $id . '_' . $md5Name . '.' . $guessExtension, 's3');
    }

    public function storeVideoAsVideo($folder, $fileName, $id)
    {
        $md5Name = md5_file(request()->file($fileName)->getRealPath());

        $guessExtension = request()->file($fileName)->guessExtension();

        $filePath = "assets01";

        if (isset($folder) && !empty($folder)) {
            $filePath = "assets01/$folder";
        }

        return request()->file($fileName)->storeAs($filePath, 'video_' . $id . '_' . $md5Name . '.' . $guessExtension, 's3');
    }

    public function storeVideoPublic($folder, $fileName, $isFile = null)
    {
        if ($isFile) {
            $file = $fileName;
        } else {
            if (!request()->hasFile($fileName)) {
                return null;
            }

            $file = request()->file($fileName);
        }

        $filePath = "assets01";

        if (isset($folder)) {
            $filePath = "assets01/$folder";
        }

        return Storage::disk('public')->put($filePath, $file);
    }

    public function storeAudioPublic($folder, $fileName, $isFile = null)
    {
        if ($isFile) {
            $file = $fileName;
        } else {
            if (!request()->hasFile($fileName)) return null;

            $file = request()->file($fileName);
        }

        $filePath = "assets01";

        if (isset($folder)) {
            $filePath = "assets01/$folder";
        }

        return Storage::disk('public')->put($filePath, $file);
    }

    public function removeImage($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function removeFileS3($path)
    {
        Storage::disk()->delete($path);
    }

    public function storeListImage($folder, $fileName)
    {
        return Storage::disk()->put($folder, $fileName);
    }

    public function copyFolder($currentName, $newName)
    {
        $newFolder = base_path('storage/app/' . $newName);

        if (!file_exists($newFolder)) {
            File::copyDirectory(base_path('storage/app/' . $currentName), base_path('storage/app/' . $newName));
        }
    }

    public function uploadImage(array $request, $inputName, $folder)
    {
        $temp = time() . rand(5, 50);
        $ext = $request[$inputName]->getClientOriginalExtension();
        $ext = strtolower($ext);
        $new_file_name = $temp . '.' . $ext;
        $path = "assets/" . $folder;

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $upload = $request[$inputName]->move($path, $new_file_name);

        if (isset($upload)) {
            return $new_file_name;
        }

        return null;
    }

    public function storeFile($fileName)
    {
        $file = request()->file($fileName);

        $filePath = "upload";

        return Storage::disk('public')->put($filePath, $file);
    }

    public function storeImageCustom($folder, $fileName, $index = 0, $h = 512, $w = 512, $isSmall = 0)
    {
        if ($index) {
            $file = $fileName;
        } else {
            $file = request()->file($fileName);
        }

        if (!$file) {
            return null;
        }

        $pathCheck = "storage/$folder";
        $fileExtension = $file->getClientOriginalExtension();
        $filename = generateString(10) . "." . $fileExtension;

        if (!file_exists($pathCheck)) {
            File::makeDirectory($pathCheck, 0777, true, true);
        }

        if ($isSmall) {
            Image::make($file->getRealPath())->resize($h, $w)->save($pathCheck . "/" . $filename, 60);
        } else {
            Image::make($file->getRealPath())->resize($h, $w)->save($pathCheck . "/" . $filename);
        }

        return $folder . '/' . $filename;
    }
}
*/
