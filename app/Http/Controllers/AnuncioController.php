<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Area;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnuncioController extends Controller
{
    public function create(Request $request) {

        $request->validate([
            'texto' => 'required|max:1800000',
            'area_id' => 'exists:App\Models\Area,id',
            'descripcion' => 'required|string'
        ]);

        Anuncio::create([
            'texto' => $request->texto,
            'area_id' => $request->area_id,
            'descripcion' => $request->descripcion,
            'activo' => false
        ]);

         return response()->json([
            'mensaje' => 'Anuncio creado'
        ], 201);
    }

    public function edit ( $id ,Request $request) {
        //busca anuncio
        $anuncio = Anuncio::where('id', $id)->firstOrFail();

        //editar texto
        if ($request->texto) {
                $request->validate([
                'texto' => 'required|string',
            ]);
            $anuncio->update([
                'texto' => $request->texto
            ]);
        }

        //editar descripcion
        if ($request->descripcion) {
                $request->validate([
                'descripcion' => 'required|string',
            ]);
            $anuncio->update([
                'descripcion' => $request->descripcion
            ]);
        }

        if ($request->activo) {
            $anuncio->update([
                'activo' => $request->activo
            ]);
        }

        //editar area
        if ($request->area_id) {
            $request->validate([
                'area' => 'exists:App\Models\Area,id',
            ]);
            $anuncio->update([
                'area_id' => $request->area_id
            ]);
        }

        return response()->json([
            'mensaje' => 'anuncio actualizado'
        ], 200);
    }

    public function anuncios (Request $request) {
        if ($request->area) {
            $area = Area::where('name', $request->area)->firstOrFail();
            $anuncio = Anuncio::where('area_id', $area->id)->with("area")->orderBy('id', 'DESC')->simplePaginate(10);
            return response()->json($anuncio);
        } else {
            $anuncio = Anuncio::with('area')->orderBy('id', 'DESC')->simplePaginate(10);
            return response()->json($anuncio);
        }
    }

    public function delete ($id) {
        $evento = Anuncio::where('id', $id)->firstOrFail();
        $evento->delete();
        return response()->json([
            'mensaje' => 'Anuncio eliminado'
        ], 200);
    }
}
