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
  <h2 class="d-inline">Измени вест: <strong>{{utf8_decode($news->title)}}</strong></h2>
  <br>
  <form id="update-news" method="POST" action="{{route('admin.update-news', $news->id)}}">
    @method('PUT')
    @csrf
    <div class="form-row mt-3">
      <div class="col-md-4 mb-3">
        <label for="validationDefault01">Наслов</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Унесите наслов вести" value="{{utf8_decode($news->title)}}">
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationDefault02">Категорија</label>
        <select class="form-control" name="category" id="category">
            <?php echo($categories);?>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label for="author">Аутор</label>
        <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Унесите аутора или ауторе" value="{{ App\Http\Controllers\AdminController::get_author_name($news->author) }}">
        <input type="hidden" class="form-control" id="author" name="author" value="{{ $news->author }}">
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-12 mb-3">
        <label for="keywords">Кључне речи за претрагу</label>
        <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Унесите кључне речи за претрагу" value="{{utf8_decode($news->keywords)}}">
      </div>
    </div>
    <div class="">
      <label for="validationDefault03">Текст вести</label>
      <textarea id="text" name="body">{{utf8_decode($news->body)}}</textarea>
    </div>

    <div class="mt-2">
      <label for="images">Фотографије</label>
      <div class="container">
        @foreach($news->images as $image)
          <img src="{{$image['destination']}}" class="img-thumbnail" alt="Responsive image" style="width:200px">
        @endforeach
      </div>
      <a href="{{ route('admin.edit-news-photos', utf8_decode($news->url).'-'.$news->id) }}" type="button" name="edit-photos" class="btn btn-primary">Измени фотографије</a>
    </div>
    <button class="btn btn-warning mt-3" type="submit">Сачувај измене</button>
  </form>
</div>
@endsection

@section('custom-js')
  <!-- Main Quill library -->
  <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=cfvkot7yk42a8trelrzb513elw32ppzhae0mlfut3liw62mw"></script>
  <script>tinymce.init({
      selector: 'textarea',
      //entity_encoding : "raw",
      height: 400,
      toolbar: "image",
      plugins: "image imagetools"
  });</script>
  <script type="text/javascript">
    // $(window).on('beforeunload', function(e) {
    //   return confirm('Да ли сте сигурни да желите да затворите? Подаци неће бити сачувани.');
    // });
  </script>
  <script type="text/javascript" src="{{asset('js/add-news.js')}}"></script>
@endsection
