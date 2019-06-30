$(document).ready(function() {
  var cover = '';
  $(document).on('submit', '#add-news', function(e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append('title', $('#title').val());
    formData.append('category', $('#category').val());
    formData.append('author', $('#author').val());
    formData.append('keywords', $('#keywords').val());
    formData.append('body', $('#text').val());
    formData.append('priority', $('#priority').val());

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
       processData: false,
       success: function(res) {
         if(res.success == 'NEWS_ADD') {
           window.location.href = res.url;
         }
       },
       error: function (res, status, error) {
        let list = '<ul>';
        if(res.status == 500) {
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
      }
     });
  });

  // $(document).on('submit', '#update-news', function(e) {
  //   e.preventDefault();
  //   let formData = new FormData();
  //   formData.append('title', $('#title').val());
  //   formData.append('category', $('#category').val());
  //   formData.append('author', $('#author').val());
  //   formData.append('keywords', $('#keywords').val());
  //   formData.append('body', $('#text').val());
  //
  //   $.ajaxSetup({
  //      headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //      }
  //    });
  //    $.ajax({
  //      url: "update-news",
  //      type: "GET",
  //      data: formData,
  //      dataType: 'json',
  //      contentType: false,
  //      processData: false,
  //      success: function(res) {
  //        if(res.success == 'NEWS_UPDATE') {
  //          window.location.href = res.url;
  //        }
  //      },
  //      error: function (res, status, error) {
  //       let list = '<ul>';
  //       if(res.status == 500) {
  //         let errors = JSON.parse(res.responseText);
  //         let errList = errors.errors;
  //         for(let li of errList) {
  //           list += '<li>'+li+'</li>';
  //         }
  //         list += '</ul>';
  //         let message =
  //         '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+
  //           '<strong>ИНФО</strong> Нисте исправно унели вест:'+
  //             list +
  //           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
  //             '<span aria-hidden="true">&times;</span>'+
  //           '</button>'
  //         '</div>';
  //         $('#news_message').html(message);
  //       }
  //     }
  //    });
  // });
});
