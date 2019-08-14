$(document).ready(function() {
  $(document).on('click', '#add_option', function(e) {
    if($('#add_poll_option').val() !== '') {
      add_option($('#add_poll_option').val());
    } else {
      return false;
    }
  });

  $(document).on('keydown', '#add_poll_option', function(e) {
    if(e.key === 'Enter') {
      e.preventDefault();
      if($(this).val() !== '') {
        add_option($(this).val());
      } else {
        return false;
      }
    }
  });

  function add_option(option) {
    let badge =
    '<span style="padding: 10px 20px 10px 20px;font-size:1em" class="text-white ml-2 d-inline badge badge-pill badge-dark">'+option+
    '<a style="cursor:pointer" title="Избаци" class="text-danger ml-2 remove_option">X</a>'+
    '<input type="hidden" name="poll_options[]" value="'+option+'"></span>';
    $('#options_list').append(badge);
    $('#add_poll_option').val('');
  }

  $(document).on('click', '.remove_option', function(e) {
    $(this).parent().remove();
  });

  $(document).on('change', '#category', function(e) {
    $(this).parent().next().removeClass('d-none');
    let category = $(this).val();
    console.log(category);
    let formData = new FormData();
    formData.append('category', category);
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
     $.ajax({
       url: "populate-news",
       type: "POST",
       data: formData,
       dataType: 'json',
       contentType: false,
       processData: false,
       success: function(res) {
         //console.log(res.news);
         $('#news_by_category').html('');
         $('#news_title').val(unescape(decodeURIComponent(escape(res.news[0].title))));
         res.news.forEach(function(news) {
            $('#news_by_category').append('<option value="'+news.id+'">'+unescape(decodeURIComponent(escape(news.title)))+'</option>');
         });
       },
       error: function (res, status, error) {

       }
     });
  });

  // $('#newsModal').on('hidden.bs.modal', function () {
  //     resetModal();
  // });

  $('body').click(function (event) {
     if($(event.target).closest('#newsModal').length && $(event.target).is('#newsModal')) {
       resetModal();
    }
  });

  $(document).on('click', '#save', function () {
      let news_by_category = $('#news_by_category');
      //console.log(news_by_category.text());
      toggleButton();
      $('#news_title').val(news_by_category.text());
      $('#news').val(news_by_category.val());
      $('#category').val('');
      $('#category_news').addClass('d-none');
  });

  $(document).on('click', '#deleteBtn', function () {
      toggleButton();
      $('#news_title').val('');
      $('#news').val('');
  });

  $(document).on('click', '#close', function () {
      resetModal();
  });

  function resetModal() {
    $('#news_title').val('');
    $('#news').val('');
    $('#category').val('');
    $('#category_news').addClass('d-none');
  }

  function toggleButton() {
    $('#deleteBtn').toggleClass('d-none');
    $('#choose').toggleClass('d-none');
  }

});
