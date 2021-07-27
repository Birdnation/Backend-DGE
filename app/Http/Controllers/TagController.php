<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function tags () {
        $tags = Tag::all();
        return response()->json($tags->reverse()->values());

    }
}
