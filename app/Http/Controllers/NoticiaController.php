<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Noticia;
use App\Models\Tag;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Registro de nueva noticia
     * POST con datos de la noticia
     */
    public function create(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'subtitulo' => 'required|string',
            'cuerpo' => 'required|max:1800000',
            'imagen' => 'required|file|mimes:jpg,png,jpeg',
            'descImg' => 'required|string',
            'area_id' => 'exists:App\Models\Area,id',
            'user_id' => 'exists:App\Models\User,id',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/noticias');
            $newPath = $parameters['imagen'] = substr($path, 16);
            $finalPath = "/storage/noticias/" . $newPath;
        };


        if ($request->links) {
            $noticia = Noticia::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'cuerpo' => $request->cuerpo,
            'imagen' => $finalPath,
            'desc_img' => $request->descImg,
            'user_id' => $request->user_id,
            'area_id' => $request->area_id,
            'links' => $request->links
        ]);
        }else {
            $noticia = Noticia::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'cuerpo' => $request->cuerpo,
            'imagen' => $finalPath,
            'desc_img' => $request->descImg,
            'user_id' => $request->user_id,
            'area_id' => $request->area_id,
        ]);
        }

        if ($request->tag) {
            foreach ($request->tag as $key => $value) {
                $tag = Tag::where('name', $value)->get()->first();
                if (!$tag) {
                    $newTag = Tag::create([
                        'name' => $value
                    ]);
                    $noticia->tags()->save($newTag);
                }else {
                    $noticia->tags()->save($tag);
                }
            }
        }

        return response()->json([
            'mensaje' => 'noticia creada'
        ], 201);
    }
    /**
     * Editar una noticia
     * POST con los datos de la noticia
     * id por por parametro
     */

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

        //editar subtitulo
        if ($request->subtitulo) {
                $request->validate([
                'subtitulo' => 'string',
            ]);
            $noticia->update([
                'subtitulo' => $request->subtitulo
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
        if ($request->descImg) {
                $request->validate([
                'descImg' => 'required|string',
            ]);
            $noticia->update([
                'desc_img' => $request->descImg
            ]);
        }

        //editar area
        if ($request->area_id) {
            $request->validate([
                'area' => 'exists:App\Models\Area,id',
            ]);
            $noticia->update([
                'area_id' => $request->area_id
            ]);
        }

        //editar cuerpo
         if ($request->cuerpo) {
            $noticia->update([
                'cuerpo' => $request->cuerpo
            ]);
        }

        if ($request->links) {
            $noticia->update([
                'links' => $request->links
            ]);
        }

        if ($request->tag) {
            foreach ($noticia->tags()->get() as $key => $value) {
                $noticia->tags()->detach($value);
            }
            foreach ($request->tag as $key => $value) {
                $tag = Tag::where('name', $value)->get()->first();
                if (!$tag) {
                    $newTag = Tag::create([
                        'name' => $value
                    ]);
                    $noticia->tags()->save($newTag);
                }else {
                    $noticia->tags()->save($tag);
                }
            }
        }else{
            foreach ($noticia->tags()->get() as $key => $value) {
                $noticia->tags()->detach($value);
            }
        }


        return response()->json([
            'mensaje' => 'noticia actualizada'
        ], 200);

    }

    public function noticias (Request $request) {
        if ($request->area) {
            $area = Area::where('name', ucfirst($request->area))->firstOrFail();
            $noticias = Noticia::where('area_id', $area->id)->with("area")->with('tags')->orderBy('id', 'DESC')->Paginate(10);
            return response()->json($noticias);
        }else if ($request->tag) {
            $tag = Tag::where('name', $request->tag)->firstOrFail();
            $noticias = $tag->noticias()->with("area")->with('tags')->orderBy('id', 'DESC')->Paginate(10);
            return response()->json($noticias);
        }
        $noticias = Noticia::with('user')->with('area')->with('tags')->orderBy('id', 'DESC')->Paginate(10);
        return response()->json($noticias);
    }

    public function noticia ($id) {
        $noticia = Noticia::where('id', $id)->with("area")->with('tags')->firstOrFail();
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
