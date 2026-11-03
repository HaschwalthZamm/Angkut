<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    public function store(UploadedFile $file, string $directory = 'reports'): string
    {
        $filename = Str::uuid()->toString().'.jpg';
        $path = trim($directory, '/').'/'.$filename;
        $fullPath = Storage::disk('public')->path($path);

        Storage::disk('public')->makeDirectory($directory);

        $manager = new ImageManager(new Driver);
        $image = $manager->read($file->getRealPath())->scaleDown(1600);

        $image->toJpeg(80)->save($fullPath);

        return $path;
    }
}
