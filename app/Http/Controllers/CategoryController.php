<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = Category::paginate(5);
        $parents = Category::where(['parent' => 0])->get();
        return view('admin.categories')->with(['categories' => $categories, 'parents' => $parents]);
    }

    public function store(Request $request)
    {
        $category = new Category();
        $category->title = $request->title;
        $category->parent = $request->parent == null ? 0 : $request->parent;
        $category->url = $request->url;
        $save = $category->save();
        if($save) {
          return response()->json(['success'=>'CAT_ADD', 'cat_title' => $category->title]);
        }
    }

    public function edit($id)
    {
        $category = Category::where(['id' => $id])->first();
        if($category) {
          return response()->json(['data' => $category]);
        }
    }

    public function update(Request $request)
    {
        $update = Category::where(['id' => $request->id])->update([
          'title' => $request->edit_title,
          'parent' => $request->edit_parent == null ? 0 : $request->edit_parent,
          'url' => $request->edit_url
        ]);
        if($update) {
          return redirect()->back()->with(['cat_message' => 'Категорија је успешно измењена!']);
        }
    }

    public function destroy($id)
    {
        $category = Category::where(['id' => $id])->delete();
        return redirect()->back()->with(['cat_message' => 'Категорија је успешно обрисана!']);
    }

    public static function parent_name($id)
    {
        $category = Category::where(['id' => $id])->first();
        return $category->title;
    }
}
