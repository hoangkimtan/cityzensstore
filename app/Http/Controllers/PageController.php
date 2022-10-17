<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    
    public function detail($slug, $id)
    {
        $page = Page::where([['slug', '=', $slug],['id','=',$id],['status','=','publish']])->first();
        return view('page.page', compact('page'));
    }
}
