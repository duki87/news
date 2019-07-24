$(document).ready(function() {
  $(document).on('submit', '#add-comment', function(e) {
    e.preventDefault();
    let route = $('#route').val();
    let formData = new FormData();
    formData.append('reply', $('#reply').val());
    formData.append('news_id', $('#news_id').val());
    if($('#auth').val() == 'guest') {
      let name = $('#name').val();
      let email = $('#email').val();
      if(name == '' || email == '') {
        showMessage('Попуните сва поља са звездицом (*)', 'danger');
        return false;
      }
      formData.append('name', name);
      formData.append('email', email);
    }
    if($('#body').val() == '') {
      showMessage('Попуните сва поља са звездицом (*)', 'danger');
      return false;
    }
    formData.append('body', $('#body').val());
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
     $.ajax({
       url: route+"/add-comment",
       type: "POST",
       data: formData,
       dataType: 'json',
       contentType: false,
       processData: false,
       success: function(res) {
         if(res.response == 'COMMENT_ADD') {
            showMessage('Коментар је успешно додат!', 'success');
         }
       },
       error: function (res, status, error) {
         showMessage('Дошло је до грешке!', 'danger');
      }
     });
  });

  $(document).on('click', '.like-comment', function(e) {
    e.preventDefault();
    let route = $('#route').val();
    let comment_id = $(this).attr('data-comment_id');
    console.log(comment_id);
    let formData = new FormData();
    formData.append('comment_id', comment_id);
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
     $.ajax({
       url: route+"/like-comment",
       type: "POST",
       data: formData,
       dataType: 'json',
       contentType: false,
       processData: false,
       success: function(res) {
         console.log(res.response);
         if(res.response == 'LIKE') {
           $(this).removeClass('btn-brdr-grey');
           $(this).addClass('btn-brdr-grey-active');
         } else {
           $(this).addClass('btn-brdr-grey');
           $(this).removeClass('btn-brdr-grey-active');
         }
       },
       error: function (res, status, error) {
         showMessage('Дошло је до грешке!', 'danger');
      }
     });
  });

  $(document).on('submit', '#reply-comment', function(e) {
    e.preventDefault();

  });

  function submitComment() {

  }

  function showMessage(content, type) {
    let message = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">'+
        '<strong>Инфо!</strong> '+content+''+
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
          '<span aria-hidden="true">&times;</span>'+
        '</button>'+
      '</div>';
      $('#comment_message').html(message);
  }
});
