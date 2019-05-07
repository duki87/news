<?php

namespace App\Http\Controllers;

use App\News;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Validator;
use Storage;
use Illuminate\Support\Facades\File;

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
              'err' => $validatorArr
            ], 500);
        }
        else
        {
            return response()->json(['success' => 'Вест је успешно додата. Овде можете погледати како изгледа.'], 200);
        }
    }

    public function upload(Request $request)
    {
        $validatorErrors = array();
        $images = $request->file('photos');
        foreach($images as $image)
        {
          $validator = Validator::make(
             array('photos' => $image),
             array('photos' => 'required|mimes:jpeg,png,jpg,gif|image|max:2000')
          );
          $tmp_name = $image->getClientOriginalName();
          $extension = $image->getClientOriginalExtension();
          if($validator->fails()) {
            $validatorErrors[] = $tmp_name.'.'.$extension.' => '.$validator->getMessageBag()->first();
            //continue;
          }
        }
        if(count($validatorErrors) > 0) {
          return response()->json(['errors' => $validatorErrors], 500);
        }
        return response()->json(['success' => 'Фотографије су успешно додате.'], 200);
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
    public function destroy(News $news)
    {
        //
    }
}
