@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message">

  </div>
  @if(Session::has('news_message'))
    <div class="alert alert-{{Session::get('news_message.alert')}} alert-dismissible fade show" role="alert">
      <strong>ИНФО</strong> {{Session::get('news_message.content')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  <h2 class="d-inline">Додај фотографије за вест: <strong>{{utf8_decode($news->title)}}</strong> </h2>
  <br>

  <form id="" method="POST" enctype="multipart/form-data" action="{{route('admin.add-news-images')}}">
    @csrf
    <input type="hidden" name="news_id" id="news_id" value="{{$news->id}}">
    <input type="hidden" id="url" value="{{$url}}">
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
      <div class="row" id="preview">

      </div>
      <button class="btn btn-primary mt-3" type="submit">Додај фотографијe</button>
  </form>
</div>
@endsection

@section('custom-js')
<script type="text/javascript">
    function triggerFileInput() {
      $('#photos').trigger('click');
    }
    function destroyFolder() {
      const folder = $('#folder').val();
      let url = $('#url').val();
      let news_id = $('#news_id').val();
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
         url: url+'/delete-news-photo-folder/'+folder+'/'+news_id,
         type: "DELETE",
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

    $(document).on('change', '#photos', function(e) {
      e.preventDefault();
      const files = $(this)[0].files;
      let formData = new FormData();
      for(let index in files) {
        formData.append('photos[]', files[index]);
      }
      formData.append('folder', $('#folder').val());
      formData.append('news_id', $('#news_id').val());
      var originUrl = (window.location.href).split('/').splice();
      console.log(originUrl);
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
         url: "{{url('/admin/upload-news-photo')}}",
         type: "POST",
         data: formData,
         dataType: 'json',
         contentType: false,
         cache: false,
         processData: false,
         success: function(response) {
           $('#folder').val(response.folder);
           let message =
             '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
               '<strong>ИНФО</strong> Фотографије су успешно учитане!'+
               '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                 '<span aria-hidden="true">&times;</span>'+
               '</button>'
             '</div>';
             $('#news_message').html(message);
             previewPhotos(response.folder, response.images);
           },
           error: function(res, status, error) {
             if(res.status == 500) {
              let list = '<ul>';
              let errors = JSON.parse(res.responseText);
              let errList = errors.errors;
              if(errors.uploadedWithErrors) {
                previewPhotos(errors.folder, errors.images);
              }
              for(let li of errList) {
                list += '<li>'+li+'</li>';
              }
              list += '</ul>';
              let message =
              '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
                '<strong>ИНФО</strong> Дошло је до грешке приликом учитавања фотографија:'+
                  list +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                  '<span aria-hidden="true">&times;</span>'+
                '</button>'
              '</div>';
              $('#news_message').html(message);
            }
          }
       });
     });

     $(document).on('click', '.remove_img', function(e) {
       e.preventDefault();
       let arr = $(this).attr('data-img').split('/');
       const img = $('#folder').val() +'/'+ arr[arr.length-1];
       let id = $(this).attr('data-id');
       var elem = $(this);
       let url = $('#url').val();
       $.ajaxSetup({
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       $.ajax({
          url: url+'/delete-news-photo/'+img+'/'+id,
          type: "DELETE",
          //data: img,
          contentType: false,
          cache: false,
          processData: false,
          success: function(response) {
            let message =
              '<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                '<strong>ИНФО</strong> Фотографијa je успешно обрисана!'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                  '<span aria-hidden="true">&times;</span>'+
                '</button>'
              '</div>';
              $('#news_message').html(message);
              elem.closest('.card').parent().remove();
              if($('.cards').length < 1) {
                $('#folder').val('');
                $('#cover').val('');
                $('#clear_photos').addClass('d-none');
              }
            },
            error: function(res, status, error) {
             let message =
             '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
               '<strong>ИНФО</strong> Дошло је до грешке приликом брисања фотографије!'+
               '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                 '<span aria-hidden="true">&times;</span>'+
               '</button>'
             '</div>';
             $('#news_message').html(message);
           }
        });
      });

      $(document).on('click', '.add-cover', function(e) {
        e.preventDefault();
        if($('.news-cover-photo').length >= 1) {
          $('.add-cover').removeClass('news-cover-photo');
          $('.add-cover').removeClass('btn-success');
          $('.add-cover').addClass('btn-secondary');
          $('#cover').val('');
        }
        $(this).removeClass('btn-secondary');
        $(this).addClass('news-cover-photo');
        $(this).addClass('btn-success');
        let cover = $(this).attr('data-img');
        $('#cover').val(cover);
      });

     function previewPhotos(folder, images) {
       for(let image of images) {
         let card = '<div class="col-md-3 mt-2 cards"><div class="card">'+
                        '<img class="card-img-top" style="object-fit:cover" width="100%" height="150px" src="'+image.destination+'" alt="">'+
                        '<input type="hidden" name="img_path[]" value="'+image.destination+'" class="img-path">'+
                        '<input type="hidden" name="img_id[]" value="'+image.id+'" class="img-id">'+
                        '<ul class="list-group list-group-flush">'+
                          '<li class="list-group-item"><input type="text" name="img_title[]" class="form-control img-title" value="" placeholder="Унесите назив фотографијe"></li>'+
                          '<li class="list-group-item"><input type="text" name="img_author[]" class="form-control img-author" value="" placeholder="Унесите аутора фотографијe"></li>'+
                          '<li class="list-group-item"><input type="text" name="img_description[]" class="form-control img-description" value="" placeholder="Унесите опис фотографијe"></li>'+
                          '<li class="list-group-item">Постави као насловну<a href="#" class="btn btn-secondary add-cover text-white float-right" data-img="'+image.destination+'"><i class="fas fa-check"></i></a></li>'+
                          '<li class="list-group-item">Обриши<a href="#" class="btn btn-danger text-white float-right remove_img" data-id="'+image.id+'" data-img="'+image.destination+'"><i class="fas fa-trash"></i></a></li>'+
                        '</ul>'+
                    '</div></div>';
           $('#preview').append(card);
           $('#clear_photos').removeClass('d-none');
       }
     }
</script>
<script type="text/javascript" src="{{asset('js/add-news.js')}}"></script>
@endsection
