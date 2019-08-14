$(document).ready(function() {
    $(document).on('click', '.poll-option', function(e) {
        e.preventDefault();
        $(this).children('span').removeClass('d-none');
        $(this).siblings().remove();
        $(this).removeClass('poll-option');
        $('#vote-thanks').removeClass('d-none');
        let option_id = $(this).attr('data-option_id');
        let poll_id = $('#poll_id').val();
        let formData = new FormData();
        formData.append('option_id', option_id);
        formData.append('poll_id', poll_id);
        $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });
         $.ajax({
           url: "add-vote",
           type: "POST",
           data: formData,
           dataType: 'json',
           contentType: false,
           processData: false,
           success: function(res) {
             console.log(res.response);
           },
           error: function (res, status, error) {

           }
         });
    });

    //Poll Results Animation
    //var values = ['40', '30', '99', '25'];
    //var values = [];

    $(document).on('click', '#results_btn', function(e) {
      $('#vote-area').addClass('d-none');
      $('#results-area').removeClass('d-none');
      let poll_id = $('#poll_id').val();
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
       $.ajax({
         url: "get-poll-results/"+poll_id,
         type: "GET",
         //data: poll_id,
         dataType: 'json',
         contentType: false,
         processData: false,
         success: function(res) {
           // res.poll_votes.forEach(function(results) {
           //   values.push(results);
           // });
           let values = res.poll_votes;
           console.log(values);
           create_divs(values);
           load_poll(values);
         },
         error: function (res, status, error) {

         }
       });

    });

    function create_divs(values) {
      for(let i=0; i<values.length; i++) {
        $('#results-area').append('<div class="" style="position:relative"><div id="div'+i+'" style="background:#98bf21;height:40px;width:0px;" class="mt-2"></div><p style="position:absolute; top:7px; left:50px">'+values[i].title+':<strong>'+values[i].result+' %</strong></p></div>');
      }
    }

    function load_poll(values) {
      for(let j=0; j<values.length; j++) {
        $('#div'+j).animate({
          width: values[j].result+'%'
        }, 1200);
      }
    }
});
