<?php
namespace App\Traits;

use App\NewsImage;
use App\News;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\File;
use Image;

    trait ImagesTrait
    {

      public function destroyImageFolder($folder, $news_id = 0)
      {
          if($news_id > 0) {
            $records = NewsImage::where(['news_id' => $news_id])->get();
            foreach ($records as $record) {
              NewsImage::where(['id' => $record->id])->delete();
            }
          }
          $remove = Storage::disk('news_images_uploads')->deleteDirectory($folder);
          if($remove) {
            return true;
          }
      }

      public function destroyRecords($news_id)
      {
          $records = NewsImage::where(['news_id' => $news_id])->get();
          foreach ($records as $record) {
            NewsImage::where(['id' => $record->id])->delete();
          }
      }

      public function updateNews($id, $cover, $folder)
      {
          $update = News::where(['id' => $id])->update(['cover' => $cover, 'image_folder' => $folder]);
          if($update) {
            return true;
          }
      }
    }

?>
