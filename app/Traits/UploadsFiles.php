<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Faker\Factory as Faker;

trait UploadsFiles
{
    public function uploadFile(Request $request, $fieldName, $directory = 'uploads')
    {
        $path = '';
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $path = $file->store($directory, 'public');
        } else {
            $faker = Faker::create();
            $path = $faker->imageUrl(640, 480, $directory); // Generates a random image URL
        }
        return $path;
    }
}
