<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\News;

class IndexController extends Controller
{

    public function index()
    {
        $latest = News::where(['priority' => 4])->first();
        $categories = Category::where(['parent' => 0])->get();
        return view('index')->with(['categories' => $categories, 'latest' => $latest]);
    }

    public function get_parent_category($url)
    {
        $category = Category::where(['url' => $url])->first();
        return view('parent-category')->with(['category' => $category]);
    }

    public function get_child_category($parent_url, $child_url)
    {
        $child = Category::where(['url' => $child_url])->first();
        return view('child-category')->with(['category' => $child]);
    }

    public static function populate_child_categories($id)
    {
      $parent = Category::where(['id' => $id])->first();
      $children = Category::where(['parent' => $id])->get();
      $childList = '';
      foreach($children as $child) {
        $childList .= '<li><a href="'.route('front.child', [$parent->url, $child->url]).'">'.$child->title.'</a></li>';
      }
      echo $childList;
    }

    // public static function get_single_latest()
    // {
    //     $latest = News::where(['priority' => 4])->first();
    //     return $latest;
    // }
}
