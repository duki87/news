<?php

namespace App\Http\Controllers;

use App\NewsImage;
use App\News;
use Illuminate\Http\Request;
use Validator;
use Storage;
use Illuminate\Support\Facades\File;
use Image;

class NewsImageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function add_images_page($id) {
        $news = News::where(['id' => $id])->first();
        return view('admin.add-images')->with(['news' => $news]);
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

            $imagesArray[] = url('/').'/news_images/'.$directory.'/'.$name;

        }
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

    public function destroy($folder, $image)
    {
        $remove = Storage::disk('news_images_uploads')->delete($folder.'/'.$image);
        if($remove) {
          $files = Storage::disk('news_images_uploads')->files($folder);
          if(count($files) < 1) {
            Storage::disk('news_images_uploads')->deleteDirectory($folder);
          }
          return response()->json(['success' => 'Фотографија је успешно oбрисана.'], 200);
        } else {
          return response()->json(['error' => 'Дошло је до грешке.'], 500);
        }
    }

    public function store(Request $request)
    {
        $cover = '';
        if($request->cover == '') {
          $cover = $request->img_path[0];
        } else {
          $cover = $request->cover;
        }

        foreach($request->img_path as $key => $value) {
            $image = new NewsImage();
            $image->news_id = $request->news_id;
            $image->destination = $request->img_path[$key];
            $image->title = $request->img_title[$key];
            $image->author = $request->img_author[$key];
            $image->description = $request->img_description[$key];
            $save_info = $image->save();
        }
        $update = News::where(['id' => $request->news_id])->update(['cover' => $cover]);
        if($update) {
          return redirect('/admin/news')->with(['news_message' => 'Фотографије су успешно додате!']);
        }
    }

    public function destroyFolder($folder)
    {
        Storage::disk('news_images_uploads')->deleteDirectory($folder);
    }
}
