$(document).ready(function() {
    // let route = $('#route').val();
    // console.log(route);
    // function add_read() {
    //   $.ajaxSetup({
    //      headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //      }
    //    });
    //    $.ajax({
    //      url: route+'/add-read',
    //      type: "POST",
    //      data: formData,
    //      dataType: 'json',
    //      contentType: false,
    //      processData: false,
    //      success: function(res) {
    //        if(res.success == 'NEWS_ADD') {
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
    // }
});
