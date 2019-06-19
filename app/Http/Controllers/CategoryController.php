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

    public function reset_table()
    {
        $categoryData = array();
        $categories = Category::paginate(5);
        $parents = Category::where(['parent' => 0])->get();
        foreach ($categories as $category) {
          $cat_name = $category->parent == 0 ? 'Главна категорија' : self::parent_name($category->parent);
          $data = '<tr>';
            $data .= '<td>'.$category->title.'</td>';
            $data .= '<td class="text-center">'.$cat_name.'</td>';
            $data .= '<td class="text-center">'.$category->url.'</td>';
            $data .= '<td class="text-center">';
              $data .= '<a type="button" class="btn btn-primary edit text-white" id="'.$category->id.'" name="button" data-toggle="modal" data-target="#editCatModal"><i class="fas fa-edit"></i></a>';
              $data .= '<a type="button" class="btn btn-danger" name="button" onclick="return confirm(Да ли сте сигурни да желите да обришете ову категорију?)" href="'.route('admin.remove-category', $category->id).'"><i class="fas fa-trash"></i></a>';
          $data .= '</tr>';
          $categoryData[] = $data;
        }
        return response()->json(['success'=>'RESET', 'categories' => $categories->links(), 'parents' => $parents, 'categoryData' => $categoryData]);
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
