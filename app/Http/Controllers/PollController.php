<?php

namespace App\Http\Controllers;

use App\Poll;
use App\PollOption;
use App\News;
use Illuminate\Http\Request;
use App\Category;
use Validator;
use Illuminate\Support\Facades\Input;

class PollController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.polls');
    }

    public function create()
    {
        $categories = $this->get_categories();
        return view('admin.add-poll')->with(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validatorArr = array();
        $validator = Validator::make($request->all(), [
              'title'     => 'required|max:255',
              'duration'  => 'required',
              'poll_options'    => 'required|array|min:2',
              'poll_options.*'  => 'required|string|distinct|min:2',
        ]);

        if($validator->fails())
        {
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput(Input::all());
        }
        $poll = new Poll();
        $poll->title = $request->title;
        $poll->news = $request->news;
        $poll->description = $request->description;
        $poll->duration = $request->duration;
        $poll->status = 1;
        if($poll->save())
        {
            foreach ($request->poll_options as $option)
            {
                  $pollOptions = new PollOption();
                  $pollOptions->poll = $poll->id;
                  $pollOptions->option = $option;
                  $pollOptions->save();
            }
            return redirect('/admin/polls')->with(['session_message' => ['alert' => 'success', 'content' => ' Успешно креирана анкета.']]);
        }
    }


    public function edit(Poll $poll)
    {
        //
    }

    public function update(Request $request, Poll $poll)
    {
        //
    }

    public function destroy(Poll $poll)
    {
        //
    }

    public function populate_news(Request $request)
    {
        $news = News::where(['category' => $request->category])->get();
        return response()->json(['news' => $news], 200);
    }

    private function get_categories($id = '') {
      $categoriesArr = Array();
      $categories = '<option value="">Изаберите</option>';
      $parentCategories = Category::where(['parent' => 0])->get();
      foreach($parentCategories as $parentCategory) {
        $selected = $parentCategory['id'] == $id ? 'selected' : '';
        $categories .= '<option style="font-weight:bold" value="'.$parentCategory['id'].'" '.$selected.'><strong>'.$parentCategory['title'].'</strong></option>';
        $childCategories = Category::where(['parent' => $parentCategory['id']])->get();
        foreach($childCategories as $childCategory) {
          $selected = $childCategory['id'] == $id ? 'selected' : '';
          $categories .= '<option value="'.$childCategory['id'].'" '.$selected.'>'.$childCategory['title'].'</option>';
        }
      }
      return $categories;
    }
}
