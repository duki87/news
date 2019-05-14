@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message">

  </div>
  <h2 class="d-inline">Додај нову вест</h2> <a href="{{route('admin.all-news')}}" type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2">Погледај све вести</a>
  <br>
  <form id="add-news" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-row mt-3">
      <div class="col-md-4 mb-3">
        <label for="validationDefault01">Наслов</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Унесите наслов вести">
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationDefault02">Категорија</label>
        <select class="form-control" name="category" id="category">
            <?php echo($categories);?>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label for="author">Аутор</label>
        <input type="text" class="form-control" id="author" name="author" placeholder="Унесите аутора или ауторе">
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-12 mb-3">
        <label for="keywords">Кључне речи за претрагу</label>
        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Унесите кључне речи за претрагу">
      </div>
    </div>
    <div class="">
      <label for="validationDefault03">Текст вести</label>
      <textarea id="text">Унесите текст вести и обликујте га помоћу доступних опција</textarea>

      <div class="form-row">
        <div class="col-md-12 mb-3 mt-3">
          <label for="keywords">Фотографије</label> <br>
          <button type="button" name="button" class="btn btn-info text-white btn-sm" onclick="triggerFileInput()">Додај фотографијe</button>
          <button type="button" class="btn btn-danger btn-sm text-white d-none" onclick="destroyFolder()" name="clear_photos" id="clear_photos">Обриши све учитане фотографијe</button>
          <input type="file" multiple class="form-control d-none" name="photos" id="photos">
          <input type="hidden" name="folder" id="folder" value="">
          <input type="hidden" name="cover" id="cover" value="">
        </div>
      </div>
    </div>
    <div class="row" id="preview">

    </div>
    <button class="btn btn-primary mt-3" type="submit">Објави вест</button>
  </form>
</div>
@endsection

@section('custom-js')
  <!-- Main Quill library -->
  <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=cfvkot7yk42a8trelrzb513elw32ppzhae0mlfut3liw62mw"></script>
  <script>tinymce.init({selector:'textarea'});</script>
  <script type="text/javascript">
    $(window).on('beforeunload', function() {
      return confirm('Да ли сте сигурни да желите да затворите? Подаци неће бити сачувани.');
      //destroyFolder();
    });
    function triggerFileInput() {
      $('#photos').trigger('click');
    }
    function destroyFolder() {
      const folder = $('#folder').val();
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
         url: "delete-news-photo-folder/"+folder,
         type: "DELETE",
         //data: img,
         contentType: false,
         cache: false,
         processData: false,
         success: function(response) {
            console.log(response);
            $('#clear_photos').addClass('d-none');
            $('#preview').html('');
            $('#folder').val('');
            let message =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
              '<strong>ИНФО</strong> Све учитане фотографије су успешно обрисане!'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                '<span aria-hidden="true">&times;</span>'+
              '</button>'
            '</div>';
            $('#news_message').html(message);
            $('#cover').val('');
            return 'FOLDER_REMOVED';
           },
           error: function(res, status, error) {
             console.log(res);
          }
       });
    }
  </script>
  <script type="text/javascript" src="{{asset('js/add-news.js')}}"></script>
@endsection
