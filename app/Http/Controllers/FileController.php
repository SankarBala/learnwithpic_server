<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    /**
     * Save the file from ckeditor image upload.
     * Default function demands file[] but ckeditor send upload[];
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response>Json
     */

    public function saveCKEditorImage(Request $request) 
    {

        $request->validate([
            'upload' => 'file|required|mimes:png,jpg,jpeg,gif,webp|min:2|max:2000'
        ]);


        if ($request->hasFile('upload')) {
            $file = $request->file('upload')->store('public/photos');
            return response()->json([
                "uploaded" => 1,
                "fileName" => "ddddd.png",
                "url" => url(Storage::url($file))
            ]);
        }

        return response()->json([
            "uploaded" => 1,
            "fileName" => "",
            "url" => ""
        ]);
    }
}
