<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function lifeStyle()
    {

        $directory = public_path('storage/vault-photo/lifestyle');


        $files = File::files($directory);

        $images = [];

        foreach ($files as $file) {
            $images[] = [
                'name' => $file->getFilename(),
                'url'  => asset('storage/vault-photo/lifestyle/' . $file->getFilename()) // URL
            ];
        }

        return view('vault-photo.life-style.index',compact('images'));
    }
    public function productImage()
    {
        $photo = [
            'url' => 'Life Style',
        ];
        return view('vault-photo.product-image.index', $photo);
    }
}
