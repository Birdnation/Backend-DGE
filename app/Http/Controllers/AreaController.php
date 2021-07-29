<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Noticia;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function areas () {
        $areas = Area::all();
        return response()->json($areas->reverse()->values());
    }

}
