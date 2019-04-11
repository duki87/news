<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class IndexController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function get_parent_category($url)
    {
        $category = Category::where(['url' => $url])->first();
        return view('parent')->with(['category' => $category]);
    }

    public function get_child_category($parent_url, $child_url)
    {
        $child = Category::where(['url' => $child_url])->first();
        return view('parent')->with(['category' => $child]);
    }
}
