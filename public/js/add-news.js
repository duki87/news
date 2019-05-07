$(document).ready(function() {
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
        //let err = JSON.parse(res.responseText);
        let list = '<ul>';
        console.log(res.responseText);
        // for(let li of JSON.parse(res.responseText)) {
        //   list += '<li>'+li+'</li>';
        // }
        list += '</ul>';
        // console.log(err);
        // console.log(status);
        let message =
        '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
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
    console.log(files);
    let formData = new FormData();
    for (let index in files) {
      // console.log(`Index of ${files[index]}: ${index}`);
      //let size = files[index].size;
      formData.append('photos[]', files[index]);
    }
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
         success: function(res) {
           console.log(res.success);
         },
         error: function (res, status, error) {
          //let err = JSON.parse(res.responseText);
          let list = '<ul>';
          console.log(res.responseText);
          // for(let li of JSON.parse(res.responseText)) {
          //   list += '<li>'+li+'</li>';
          // }
          list += '</ul>';
          // console.log(err);
          // console.log(status);
          // let message =
          // '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
          //   '<strong>ИНФО</strong> Нисте исправно унели вест:'+
          //     list +
          //   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          //     '<span aria-hidden="true">&times;</span>'+
          //   '</button>'
          // '</div>';
          // $('#news_message').html(message);
        }
     });
   });
});
