$(document).ready(function() {
  var cover = '';
  $(document).on('submit', '#add-news', function(e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append('title', $('#title').val());
    formData.append('category', $('#category').val());
    formData.append('author', $('#author').val());
    formData.append('keywords', $('#keywords').val());
    formData.append('body', $('#text').html());

    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
     $.ajax({
       url: "add-news",
       type: "POST",
       data: formData,
       dataType: 'json',
       contentType: false,
       cache: false,
       processData: false,
       success: function(res) {
         console.log(res.success);
       },
       error: function (res, status, error) {
        let list = '<ul>';
        let errors = JSON.parse(res.responseText);
        let errList = errors.errors;
        for(let li of errList) {
          list += '<li>'+li+'</li>';
        }
        list += '</ul>';
        let message =
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
          '<strong>ИНФО</strong> Нисте исправно унели вест:'+
            list +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
          '</button>'
        '</div>';
        $('#news_message').html(message);
      }
     });
  });

  $(document).on('change', '#photos', function(e) {
    e.preventDefault();
    const files = $(this)[0].files;
    let formData = new FormData();
    for(let index in files) {
      formData.append('photos[]', files[index]);
    }
    formData.append('folder', $('#folder').val());
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
       url: "upload-news-photo",
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
     });
   });

   $(document).on('click', '.remove_img', function(e) {
     e.preventDefault();
     let arr = $(this).attr('data-img').split('/');
     const img = $('#folder').val() +'/'+ arr[arr.length-1];
     var elem = $(this);
     $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
     $.ajax({
        url: "delete-news-photo/"+img,
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

    function destroyFolder() {
      e.preventDefault();
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
           },
           error: function(res, status, error) {
             console.log(res);
          }
       });
    }

   function previewPhotos(folder, images) {
     for(let image of images) {
       let card = '<div class="col-md-3 mt-2 cards"><div class="card">'+
                      '<img class="card-img-top" style="object-fit:cover" width="100%" height="150px" src="'+image+'" alt="">'+
                      '<ul class="list-group list-group-flush">'+
                        '<li class="list-group-item"><input type="text" name="" class="form-control img-title" value="" placeholder="Унесите назив фотографијe"></li>'+
                        '<li class="list-group-item"><input type="text" name="" class="form-control img-author" value="" placeholder="Унесите аутора фотографијe"></li>'+
                        '<li class="list-group-item"><input type="text" name="" class="form-control img-description" value="" placeholder="Унесите опис фотографијe"></li>'+
                        '<li class="list-group-item">Постави као насловну<a href="#" class="btn btn-secondary add-cover text-white float-right" data-img="'+image+'"><i class="fas fa-check"></i></a></li>'+
                        '<li class="list-group-item">Обриши<a href="#" class="btn btn-danger text-white float-right remove_img" data-img="'+image+'"><i class="fas fa-trash"></i></a></li>'+
                      '</ul>'+
                  '</div></div>';
         $('#preview').append(card);
       }
   }
});
