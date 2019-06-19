<?php

namespace App\Http\Controllers;

use App\NewsImage;
use App\News;
use Illuminate\Http\Request;
use Validator;
use Storage;
use Illuminate\Support\Facades\File;
use Image;
use App\Traits\ImagesTrait;

class NewsImageController extends Controller
{
    use ImagesTrait;

    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function add_images_page($id) {
        $news = News::where(['id' => $id])->first();
        $url = route('admin.index');
        return view('admin.add-images')->with(['news' => $news, 'url' => $url]);
    }

    public function create(Request $request)
    {
        $validatorErrors = array();
        $watermark = ('images/watermark.png');
        $imagesArray = array();
        $images = $request->file('photos');
        $directory = '';
        if($request->folder != '') {
          $directory = $request->folder;
        } else {
          $directory = sha1(time());
          Storage::disk('news_images_uploads')->makeDirectory($directory);
        }
        foreach($images as $image)
        {
          $validator = Validator::make(
             array('photos' => $image),
             array('photos' => 'mimes:jpeg,png,jpg,gif|image|max:5000')
          );
          $tmp_name = $image->getClientOriginalName();
          $extension = $image->getClientOriginalExtension();
          if($validator->fails()) {
            $validatorErrors[] = $tmp_name.'.'.$extension.' => '.$validator->getMessageBag()->first();
            continue;
          }
          $name = sha1($tmp_name).'.'.$extension;
          Image::make($image)
                    ->resize(1024, null, function($constraint) {
                      $constraint->aspectRatio();
                    })
                    ->insert($watermark, 'bottom-left', 10, 10)
                    ->save('news_images/'.$directory.'/'.$name);

            $record = new NewsImage();
            $record->news_id = $request->news_id;
            $record->destination = url('/').'/news_images/'.$directory.'/'.$name;
            $record->save();
        }
        $imagesArray = NewsImage::where(['news_id' => $request->news_id])->orderBy('id','DESC')->take(count($images))->get();
        if(count($validatorErrors) > 0)
        {
          if(count($imagesArray) > 0)
          {
            return response()->json(['uploadedWithErrors' => true, 'errors' => $validatorErrors, 'folder' => $directory, 'images' => $imagesArray], 500);
          }
          return response()->json(['uploadedWithErrors' => false, 'errors' => $validatorErrors, 'folder' => $directory], 500);
        }
        return response()->json(['success' => 'Фотографије су успешно додате.', 'folder' => $directory, 'images' => $imagesArray], 201);
    }

    public function destroy($folder, $image, $id)
    {
        $remove = Storage::disk('news_images_uploads')->delete($folder.'/'.$image);
        $delete = NewsImage::where(['id' => $id])->delete();
        if($delete && $remove) {
          $files = Storage::disk('news_images_uploads')->files($folder);
          if(count($files) < 1) {
            Storage::disk('news_images_uploads')->deleteDirectory($folder);
          }
          return response()->json(['success' => 'Фотографија је успешно oбрисана.'], 200);
        }
        return response()->json(['error' => 'Дошло је до грешке.'], 500);
    }

    public function store(Request $request)
    {
        if(count($request->img_path) > 0) {
          $cover = '';
          if($request->cover == '') {
            $cover = $request->img_path[0];
          } else {
            $cover = $request->cover;
          }

          foreach($request->img_id as $key => $value) {
              $image = NewsImage::where(['id' => $request->img_id[$key]])->update([
                'title' => $request->img_title[$key],
                'author' => $request->img_author[$key],
                'description' => $request->img_description[$key]
              ]);
          }

          $update = $this->updateNews($request->news_id, $cover, $request->folder);
          if($update) {
            return redirect('/admin/news')->with(['news_message' => ['content' => 'Фотографије су успешно додате!', 'alert' => 'success']]);
          }
        } else {
          return redirect('/admin/news')->with(['news_message' => ['content' => 'Вест је успешно додата!', 'alert' => 'success']]);
        }
    }

    public function edit($unique) {
        $arr = explode('-', $unique);
        $id = $arr[count($arr)-1];
        $news = News::where(['id' => $id])->first();
        if(Auth::id() == $news->author) {
          $url = route('admin.index');
          $images = NewsImage::where(['news_id' => $id])->get();
          return view('admin.edit-news-images')->with(['images' => $images, 'title' => $news->title, 'folder' => $news->image_folder, 'cover' => $news->cover, 'url' => $url, 'id' => $news->id]);
        }
        return redirect('/admin/news')->with(['news_message' => ['alert' => 'danger', 'content' => 'Нисте овлашћени да мењате садржај ове вести!']]);
    }

    public function update(Request $request, $news_id) {
      foreach($request->img_id as $key => $value) {
          $image = NewsImage::where(['id' => $request->img_id[$key]])->update([
            'title' => $request->img_title[$key],
            'author' => $request->img_author[$key],
            'description' => $request->img_description[$key]
          ]);
        }
        return redirect('/admin/news')->with(['news_message' => ['content' => 'Фотографије су успешно измењене!', 'alert' => 'success']]);
    }

    public function destroyFolder($folder, $news_id)
    {
        $this->destroyImageFolder($folder, $news_id);
    }

}
