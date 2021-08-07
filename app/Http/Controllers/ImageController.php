<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'imagen' => "required|file|mimes:jpg,png,jpeg",
            'user_id' => 'exists:App\Models\User,id',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/noticias');
            $newPath = $parameters['imagen'] = substr($path, 16);
            $finalPath = "/storage/noticias/" . $newPath;
        };

        Image::create([
            'user_id' => $request->user_id,
            'url' => $finalPath

        ]);

        return response()->json([
            'mensaje' => 'Imagen agregada'
        ], 201);
    }

    public function imagesByUser (Request $request){

        return response()->json(Image::where('user_id', $request->user_id)->orderBy('id', 'DESC')->take(6)->get());
    }
}
