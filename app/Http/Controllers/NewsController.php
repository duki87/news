<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsImage;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Validator;
use Storage;
use Illuminate\Support\Facades\File;
use Image;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Traits\ImagesTrait;

class NewsController extends Controller
{
    use ImagesTrait;

    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.news')->with(['news' => $news]);
    }

    public function single_news($unique)
    {
        $arr = explode('-', $unique);
        $id = $arr[count($arr)-1];
        $news = News::where(['id' => $id])->first();
        return view('admin.single-news')->with(['news' => $news]);
    }

    public function create()
    {
        $categories = $this->get_categories();
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
            $url = utf8_encode(strtolower($this->convert_characters($request->title)));
            $url = preg_replace('/[[:space:]]+/', '-', $url);
            $news = new News();
            $news->category = $request->category;
            $news->title = utf8_encode($request->title);
            $news->body = utf8_encode($request->body);
            $news->keywords = utf8_encode($request->keywords);
            $news->author = utf8_encode($request->author);
            $news->cover = 'default.jpg';
            $news->image_folder = 'folder';
            $news->url = $url;
            $news->priority = $request->priority;
            $save = $news->save();
            if($save) {
              $id = $news->id;
              $redirect_url = route('admin.add-images-to-news', $news->id);
              return response()->json(['success' => 'NEWS_ADD', 'id' => $id, 'url' => $redirect_url], 200);
            }
        }
    }

    public function edit($unique)
    {
        $arr = explode('-', $unique);
        $id = $arr[count($arr)-1];
        $news = News::where(['id' => $id])->with('images')->first();
        if(Auth::id() == $news->author) {
          $categories = $this->get_categories($news->category);
          return view('admin.edit-news')->with(['news' => $news, 'categories' => $categories]);
        }
        return redirect('/admin/news')->with(['news_message' => ['alert' => 'danger', 'content' => 'Нисте овлашћени да мењате садржај ове вести!']]);
    }

    public function update(Request $request, $id)
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
        $url = utf8_encode(strtolower($this->convert_characters($request->title)));
        $url = preg_replace('/[[:space:]]+/', '-', $url);
        $update = News::where(['id' => $id])->update([
          'category' => $request->category,
          'title' => utf8_encode($request->title),
          'body' => utf8_encode($request->body),
          'keywords' => utf8_encode($request->keywords),
          'author' => utf8_encode($request->author),
          'url' => $url,
          'priority' => $request->priority
        ]);
        if($update) {
          return redirect()->route('admin.single-news', $url.'-'.$id);
        }
    }


    public function update_cover(Request $request)
    {
        $update = News::where(['id' => $request->id])->update([
          'cover' => $request->cover
        ]);
        if($update) {
          return response()->json(['success' => 'UPDATE_COVER'], 200);
        }
    }

    public function destroy($id)
    {
        $news = News::where(['id' => $id])->first();
        $images = NewsImage::where(['news_id' => $id])->count();
        if(Auth::id() == $news->author) {
          if($images > 0) {
            $delete_images = $this->destroyImageFolder($news->image_folder, $news->id);
          }
          $delete = News::where(['id' => $id])->delete();
          if($delete) {
            return redirect()->route('admin.all-news')->with(['news_message' => ['alert' => 'success', 'content' => 'Вест је успешно обрисана!']]);
          } else {
            return redirect()->route('admin.all-news')->with(['news_message' => ['alert' => 'danger', 'content' => 'Дошло је до грешке!']]);
          }
        }
        return redirect('/admin/news')->with(['news_message' => ['alert' => 'danger', 'content' => 'Нисте овлашћени обришете ову вест!']]);
    }

    private function convert_characters($string) {
        $cyr = [
            'а','б','в','г','д', 'ђ', 'е','ж','з','и','ј','к','л', 'љ', 'м','н','њ', 'о','п',
            'р','с','т','ћ','у','ф','х','ц','ч', 'џ', 'ш',
            'А','Б','В','Г','Д','Ђ','Е','Ж','З','И','Ј','К','Л','Љ','М','Н','Њ','О','П',
            'Р','С','Т','Ћ','У','Ф','Х','Ц','Ч', 'Џ','Ш'
        ];
        $lat = [
            'a','b','v','g','d','dj','e','z','z','i','j','k','l', 'lj', 'm','n','nj','o','p',
            'r','s','t','c','u','f','h','c','c','dz','s',
            'a','b','v','g','d','dj','e','z','z','i','j','k','l','lj','m','n','nj','o','p',
            'r','s','t','c','u','f','h','c','c','dz','s'
        ];
        $textcyr = str_replace($cyr, $lat, $string);
        return $textcyr;
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


    public function show(News $news)
    {
        //
    }


}
