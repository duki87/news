$(document).ready(function() {
  var cover = '';
  $(document).on('submit', '#add-news', function(e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append('title', $('#title').val());
    formData.append('category', $('#category').val());
    formData.append('author', $('#author').val());
    formData.append('keywords', $('#keywords').val());
    formData.append('cover', $('#cover').val());
    formData.append('body', $('#text').html());
    // var img_title = document.querySelectorAll('input[name*=img_title]');
    // var img_path = document.querySelectorAll('input[name*=img_path]');
    // var img_author = document.querySelectorAll('input[name*=img_author]');
    // var img_description = document.querySelectorAll('input[name*=img_description]');

    var img_title = $('.img-title');
    var img_path = $('.img-path');
    var img_author = $('.img-author');
    var img_description = $('.img-description');
    for(let i = 0; i < img_path.length; i++) {
      //formData.append(img_title[i].name, img_title[i].value);
      // console.log(img_title[i] + ' - ' + img_title[i].value);
      // console.log(img_author[i] + ' - ' + img_author[i].value);
      // console.log(img_description[i] + ' - ' + img_description[i].value);
      console.log(img_path[i].value);
      formData.append('img_title[]', img_title[i].value == undefined ? '' : img_title[i].value);
      formData.append('img_path[]', img_path[i].value);
      formData.append('img_author[]', img_author[i].value == undefined ? '' : img_author[i].value);
      formData.append('img_description[]', img_description[i].value == undefined ? '' : img_description[i].value);
    }

    // let images = []; //DELETE AFTER TESTING
    // let files = $('.add-cover');
    //
    // for(let x=0; x<files.length; x++) {
    //   let img = files.eq(x).attr('data-img');
    //   let img_title = $('.img-title').eq(x).val();
    //   let img_author = $('.img-author').eq(x).val();
    //   let img_description = $('.img-description').eq(x).val();
    //   let img_data = {
    //     image: img,
    //     title: img_title,
    //     author: img_author,
    //     description: img_description
    //   }
    //   images.push(img_data); //DELETE AFTER TESTING
    //   //formData.append('images[]', img_data);
    //   formData.append('images[]', img_data);
    // }
    // console.log(images); //DELETE AFTER TESTING

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
                      '<img class="card-img-top" style="object-fit:cover" width="100%" height="150px" src="'+image+'" alt="">'+
                      '<input type="hidden" name="img_path[]" value="'+image+'" class="img-path">'+
                      '<ul class="list-group list-group-flush">'+
                        '<li class="list-group-item"><input type="text" name="img_title[]" class="form-control img-title" value="" placeholder="Унесите назив фотографијe"></li>'+
                        '<li class="list-group-item"><input type="text" name="img_author[]" class="form-control img-author" value="" placeholder="Унесите аутора фотографијe"></li>'+
                        '<li class="list-group-item"><input type="text" name="img_description[]" class="form-control img-description" value="" placeholder="Унесите опис фотографијe"></li>'+
                        '<li class="list-group-item">Постави као насловну<a href="#" class="btn btn-secondary add-cover text-white float-right" data-img="'+image+'"><i class="fas fa-check"></i></a></li>'+
                        '<li class="list-group-item">Обриши<a href="#" class="btn btn-danger text-white float-right remove_img" data-img="'+image+'"><i class="fas fa-trash"></i></a></li>'+
                      '</ul>'+
                  '</div></div>';
         $('#preview').append(card);
         $('#clear_photos').removeClass('d-none');
       }
   }
});
