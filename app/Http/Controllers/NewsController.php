<?php

namespace App\Http\Controllers;

use App\News;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Validator;
use Storage;
use Illuminate\Support\Facades\File;
use Image;

class NewsController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.news');
    }

    public function create()
    {
        $categoriesArr = Array();
        $categories = '<option value="">Изаберите</option>';
        $parentCategories = Category::where(['parent' => 0])->get();
        foreach($parentCategories as $parentCategory) {
          $categories .= '<option value="'.$parentCategory['id'].'">'.$parentCategory['title'].'</option>';
          $childCategories = Category::where(['parent' => $parentCategory['id']])->get();
          foreach($childCategories as $childCategory) {
            $categories .= '<option value="'.$childCategory['id'].'">'.$childCategory['title'].'</option>';
          }
        }
        return view('admin.add-news')->with(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatorArr = array();
        $validator = Validator::make($request->all(), [
              'title'     => 'required|max:255',
              'category'  => 'required',
              'author'    => 'required|max:255',
              'keywords'  => 'required|max:255',
              'body'      => 'required'
        ]);

        if($validator->fails())
        {
            foreach ($validator->getMessageBag()->toArray() as $err) {
              $validatorArr[] = $err[0];
            }
            return response()->json([
              'errors' => $validatorArr
            ], 500);
        }
        else
        {
            $cover = '';
            if($request->cover == '') {
              //$cover = $request->cover[0]['image'];
              $cover = 'cover';
            } else {
              $cover = $request->cover;
            }
            $url = strtolower($request->title);
            $url = preg_replace('/[[:space:]]+/', '-', $url);
            $news = new News();
            $news->category = $request->category;
            $news->title = $request->title;
            $news->body = $request->body;
            $news->keywords = $request->keywords;
            $news->author = $request->author;
            $news->cover = $cover;
            $news->image_folder = 'folder'; //EDIT DB TABLE AND DELETE THIS COLUMN
            $news->url = $url;
            $save = $news->save();
            if($save) {
              return response()->json(['success' => 'Вест је успешно додата. Овде можете погледати како изгледа.'], 200);
            }
        }
    }

    public function destroy(News $news)
    {
        //
    }

    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */

}
