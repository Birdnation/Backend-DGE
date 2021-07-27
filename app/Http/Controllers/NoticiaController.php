<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Noticia;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Registro de nuevo usuario
     */
    public function create(Request $request)
    {

        $request->validate([
            'titulo' => 'required|string',
            'subtitulo' => 'required|string',
            'cuerpo' => 'required',
            'imagen' => 'required|file|mimes:jpg,png,jpeg',
            'descImg' => 'required|string',
            'area_id' => 'exists:App\Models\Area,id',
            'user_id' => 'exists:App\Models\User,id'
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/noticias');
            $newPath = $parameters['imagen'] = substr($path, 16);
            $finalPath = "/storage/noticias/" . $newPath;
        };

        $noticia = Noticia::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'cuerpo' => $request->cuerpo,
            'imagen' => $finalPath,
            'desc-img' => $request->descImg,
            'user_id' => $request->user_id,
            'area_id' => $request->area_id,
        ]);

        if ($request->tag) {
            foreach ($request->tag as $key => $value) {
                $tag = Tag::where('name', $value)->firstOrFail();
                $noticia->tags()->save($tag);
            }
        }

        return response()->json([
            'mensaje' => 'noticia creada'
        ], 201);
    }

    public function edit ( $id ,Request $request) {
        //busca noticia
        $noticia = Noticia::where('id', $id)->firstOrFail();

        //editar titulo
        if ($request->titulo) {
                $request->validate([
                'titulo' => 'required|string',
            ]);
            $noticia->update([
                'titulo' => $request->titulo
            ]);
        }
        //editar cuerpo
         if ($request->cuerpo) {
            $noticia->update([
                'cuerpo' => $request->cuerpo
            ]);
        }
        //editar imagen
        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/noticias');
            $newPath = $parameters['imagen'] = substr($path, 16);
            $finalPath = "/storage/noticias/" . $newPath;
            $noticia->update([
                'imagen' => $finalPath
            ]);
        }
        //editar descripcion imagen
        if ($request->titulo) {
                $request->validate([
                'descImg' => 'required|string',
            ]);
            $noticia->update([
                'desc-img' => $request->descImg
            ]);
        }
        return response()->json([
            'mensaje' => 'noticia actualizada'
        ], 200);

    }

    public function noticias () {
        $noticias = Noticia::with('user')->with('area')->with('tags')->orderBy('id', 'DESC')->simplePaginate(10);
        return response()->json($noticias);
    }

    public function noticia ($id) {
        $noticia = Noticia::where('id', $id)->firstOrFail();
        return response()->json($noticia);
    }

    public function delete ($id) {
        $noticia = Noticia::where('id', $id)->firstOrFail();
        $noticia->delete();
        return response()->json([
            'mensaje' => 'noticia eliminada'
        ], 200);
    }
}
