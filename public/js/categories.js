$(document).ready(function() {
  var previousSelect;
  $(document).on('submit','#addCat', function(e) {
    e.preventDefault();
    console.log('fgdfg');
    var fd = new FormData();
    let title = $('#title').val();
    let parent = $('#parent').val();
    let url = $('#url').val();
    fd.append('title', title);
    fd.append('parent', parent);
    fd.append('url', url);
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $.ajax({
       url: "create-category",
       type: "post",
       data: fd,
       contentType: false,
       cache: false,
       processData: false,
       success: function(result) {
         if(result.success == 'CAT_ADD') {
           $('#addCatModal').modal('hide');
           let message = '<div class="alert alert-success alert-dismissible" role="alert">'+
               '<strong>Инфо!</strong> <span id="ajax_message_text">Категорија <strong>'+result.cat_title+'</strong> је успешно додата!</span>'+
               '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                 '<span aria-hidden="true">&times;</span>'+
               '</button>'+
             '</div>';
           $('#ajax_message').append(message);
         }
       }
     });
  });

  $(document).on('click', '.edit', function(e) {
    e.preventDefault();
    const id = $(this).attr('id');
    $.ajaxSetup({
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });
    $.ajax({
       url: "edit-category/"+id,
       type: "get",
       contentType: false,
       cache: false,
       processData: false,
       success: function(result) {
         //console.log(result.data);
         let data = result.data;
         $('#cat_ttl').html(data.title);
         $('#edit_title').val(data.title);
         $('#edit_url').val(data.url);
         $('#cat_id').val(data.id);
         $('#selectParent > select > option[value="'+data.parent+'"]').attr("selected", "selected");
         previousSelect = data.parent;
       }
     });
  });

  $('#editCatModal').on('hidden.bs.modal', function () {
    $('#cat_ttl').html('');
    $('#edit_title').val('');
    $('#edit_url').val('');
    $('#selectParent > select > option[value="'+previousSelect+'"]').attr("selected", false);
  });
});
