<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\News;
use App\Comment;
use App\Reads;
use DB;
use Auth;
use Session;

class IndexController extends Controller
{

    public function index()
    {
        $latest = News::where(['priority' => 4])->first();
        $featured = News::where('priority', '>=', '3')
                          //->orderBy('created_at', 'desc')
                          ->orderBy('priority', 'desc')
                          ->limit(6)->get();

        $categories = Category::where(['parent' => 0])->get();
        return view('index')->with(['categories' => $categories, 'latest' => $latest, 'featured' => $featured]);
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

    public function show_news($parent_url, $child_url, $unique)
    {
      // $parent = Category::where(['id' => $id])->first();
      // $children = Category::where(['parent' => $id])->get();
      $arr = explode('-', $unique);
      $id = $arr[count($arr)-1];
      $news = News::where(['id' => $id])->with('images')->first();
      $comments = Comment::where(['news_id' => $news->id,'reply' => 0])->orderBy('created_at', 'desc')->with('user')->with('likes')->get();
      $commentsArray = array();
      foreach ($comments as $comment) {
          $replies = Comment::where(['reply' => $comment->id])->orderBy('created_at', 'desc')->with('user')->get();
          $commentsArray[] = $comment;
          foreach ($replies as $reply) {
              $commentsArray[] = $reply;
          }
      }
      $this->add_read($news->id);
      $categories = Category::where(['parent' => 0])->get();
      $suggested = News::where(['category' => $news->category])
                          ->orderBy('priority', 'desc')
                          ->limit(3)->get();
      return view('show-news')->with(['news' => $news, 'categories' => $categories, 'suggested_news' => $suggested, 'comments' => $commentsArray]);
    }

    private function add_read($news)
    {

        if(!Auth::id()) {
          $exist = Reads::where(['news' => $news, 'session' => Session::getId()])->first();
          if($exist) {
            return false;
          }
          $read = new Reads();
          $read->news = $news;
          $read->session = Session::getId();
          $read->read = true;
          $read->save();
        }
        $exist = Reads::where(['news' => $news, 'user' => Auth::id()])->first();
        $read = new Reads();
        $read->news = $news;
        $read->user = Auth::id();
        $read->read = true;
        $read->save();
    }

    public static function generate_news_url($id)
    {
      $news = News::where(['id' => $id])->first();
      $category = Category::where(['id' => $news->category])->first();
      if($category->parent === 0) {
        return '/'.$category->url.'/'.$news->url.'-'.$news->id;
      } else {
        $parent = Category::where(['id' => $category->parent])->first();
        return '/'.$parent->url.'/'.$category->url.'/'.$news->url.'-'.$news->id;
      }
    }

    public static function get_category_name($id)
    {
      $category = Category::where(['id' => $id])->first();
      return $category->title;
    }

    // public static function get_single_latest()
    // {
    //     $latest = News::where(['priority' => 4])->first();
    //     return $latest;
    // }
}
