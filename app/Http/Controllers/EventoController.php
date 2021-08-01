<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Evento;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventoController extends Controller
{

    public function create(Request $request) {


        if ($request->inicio) {
            $request->validate([
            'titulo' => 'required|string',
            'imagen' => 'nullable|mimes:jpg,png,jpeg',
            'descImg' => 'string|nullable',
            'area_id' => 'required|exists:App\Models\Area,id',
            'user_id' => 'exists:App\Models\User,id',
            'inicio' => 'required|date|after:today',
            'fin' => 'required|date|after:inicio'
        ]);
        }else {
            $request->validate([
            'titulo' => 'required|string',
            'imagen' => 'nullable|mimes:jpg,png,jpeg',
            'descImg' => 'nullable|string',
            'area_id' => 'required|exists:App\Models\Area,id',
            'user_id' => 'exists:App\Models\User,id',
            'fin' => 'required|date|after:today'
        ]);
        }

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/eventos');
            $newPath = $parameters['imagen'] = substr($path, 15);
            $finalPath = "/storage/eventos/" . $newPath;
        } else {
            $finalPath = null;
        }



        $color = $this->getColor($request->area_id);

        $evento = Evento::create([
            'titulo' => $request->titulo,
            'cuerpo' => $request->cuerpo,
            'imagen' => $finalPath,
            'desc_imagen' => $request->descImg,
            'user_id' => $request->user_id,
            'area_id' => $request->area_id,
            'inicio' => Carbon::parse($request->inicio)->toDateTimeString(),
            'fin' => Carbon::parse($request->fin)->toDateTimeString(),
            'color' => $color,
        ]);

        if ($request->tag) {
            foreach ($request->tag as $key => $value) {
                $tag = Tag::where('name', $value)->get()->first();
                if (!$tag) {
                    $newTag = Tag::create([
                        'name' => $value
                    ]);
                    $evento->tags()->save($newTag);
                }else {
                    $evento->tags()->save($tag);
                }
            }
        }

        return response()->json([
            'mensaje' => 'Evento Creado'
        ]);

    }

    public function getColor ($area){
        $a = Area::where('id', $area)->firstOrFail();
        switch ($a->name) {
            case 'Salud':
                return 'red';
            case 'Deportes':
                return 'blue';
            case 'Beneficios':
                return 'yellow';
            case 'Arte y Cultura':
                return 'green';
            case 'Jardin Infantil':
                return 'pink';
            case 'Inclusión':
                return 'gold';
            default:
                break;
        }
    }

    public function eventos (Request $request) {
        if ($request->area) {
            $area = Area::where('name', $request->area)->firstOrFail();
            $eventos = Evento::where('area_id', $area->id)->with("area")->orderBy('id', 'DESC')->simplePaginate(10);
            return response()->json($eventos);
        }else if ($request->tag) {
            $tag = Tag::where('name', $request->tag)->firstOrFail();
            $eventos = $tag->eventos()->with("area")->with('tags')->orderBy('id', 'DESC')->simplePaginate(10);
            return response()->json($eventos);
        }
        $eventos = Evento::with('user')->with('area')->with('tags')->orderBy('id', 'DESC')->simplePaginate(10);
        return response()->json($eventos);
    }

    public function edit ( $id ,Request $request) {
        //busca evento
        $evento = Evento::where('id', $id)->firstOrFail();

        //editar titulo
        if ($request->titulo) {
                $request->validate([
                'titulo' => 'required|string',
            ]);
            $evento->update([
                'titulo' => $request->titulo
            ]);
        }



        //editar imagen
        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('public/eventos');
            $newPath = $parameters['imagen'] = substr($path, 15);
            $finalPath = "/storage/eventos/" . $newPath;
            $evento->update([
                'imagen' => $finalPath
            ]);
        }

        //editar descripcion imagen
        if ($request->descImg) {
                $request->validate([
                'descImg' => 'required|string',
            ]);
            $evento->update([
                'desc_imagen' => $request->descImg
            ]);
        }

        if ($request->inicio){
            $evento->update([
                'inicio' => Carbon::parse($request->inicio)->toDateTimeString()
            ]);
        }

        if ($request->fin){
            $evento->update([
                'fin' => Carbon::parse($request->fin)->toDateTimeString()
            ]);
        }

        //editar area
        if ($request->area_id) {
            $request->validate([
                'area' => 'exists:App\Models\Area,id',
            ]);
            $evento->update([
                'area_id' => $request->area_id
            ]);
        }

        //editar cuerpo
         if ($request->cuerpo) {
            $evento->update([
                'cuerpo' => $request->cuerpo
            ]);
        }

        if ($request->tag) {
            foreach ($evento->tags()->get() as $key => $value) {
                $evento->tags()->detach($value);
            }
            foreach ($request->tag as $key => $value) {
                $tag = Tag::where('name', $value)->get()->first();
                if (!$tag) {
                    $newTag = Tag::create([
                        'name' => $value
                    ]);
                    $evento->tags()->save($newTag);
                }else {
                    $evento->tags()->save($tag);
                }
            }
        }else{
            foreach ($evento->tags()->get() as $key => $value) {
                $evento->tags()->detach($value);
            }
        }


        return response()->json([
            'mensaje' => 'evento actualizada'
        ], 200);

    }

    public function evento ($id) {
        $evento = Evento::where('id', $id)->with("area")->with('tags')->firstOrFail();
        return response()->json($evento);
    }

    public function delete ($id) {
        $evento = Evento::where('id', $id)->firstOrFail();
        $evento->delete();
        return response()->json([
            'mensaje' => 'evento eliminado'
        ], 200);
    }


}
