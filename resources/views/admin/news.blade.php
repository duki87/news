@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message"></div>
  <h2 class="d-inline">Управљање вестима</h2> <a href="{{route('admin.add-news')}}" type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2">Додај нову вест</a>
  <div class="my-4"></div>
    @if(Session::has('news_message'))
      <div class="alert alert-{{Session::get('news_message.alert')}} alert-dismissible fade show" role="alert">
        <strong>ИНФО</strong> {{Session::get('news_message.content')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row">
      <form class="row col-md-4" id="searchNews">
        <div class="form-group col-md-8">
          <input class="form-control" type="search" placeholder="Претражи вести" aria-label="Search">
        </div>
        <div class="col-md-4">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Претражи</button>
        </div>
      </form>
      <div class="col-md-4">
        <div class="btn-group">
          <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Сортирај
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">По времену - најновије прво</a>
            <a class="dropdown-item" href="#">По времену - најстарије прво</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">По аутору (А - Ш)</a>
            <a class="dropdown-item" href="#">По аутору (Ш - А)</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </div>
      </div>
    </div>
  <br>

  <div class="list-group">
    @foreach($news as $index => $singleNews)
    <div class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="row">
        <div class="col-md-3">
          <a href="{{ route('admin.single-news', $singleNews->url.'-'.$singleNews->id) }}" class="text-primary">
            <img src="{{$singleNews->cover}}" style="width:100%; height:120px; object-fit: cover" alt="">
          </a>
        </div>
        <div class="col-md-6">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">
              <a href="{{ route('admin.single-news', utf8_decode($singleNews->url).'-'.$singleNews->id) }}" class="text-primary">{{utf8_decode($singleNews->title)}}</a>
            </h5>
          </div>
          <p class="mb-1">{{utf8_decode(strip_tags(substr($singleNews->body,0,150)))}}</p>
          <p>
            <a href="#" class="text-primary">
              <strong>Аутор: {{ App\Http\Controllers\AdminController::get_author_name($singleNews->author) }}</strong>
            </a>
          </p>
          @if(Auth::id() == $singleNews->author)
            <a href="{{ route('admin.edit-news', $singleNews->url.'-'.$singleNews->id) }}" class="btn btn-outline-info btn-sm" type="button" name="edit_news">Измени <br> вест</a>
            <a href="{{ route('admin.edit-news-photos', $singleNews->url.'-'.$singleNews->id) }}" class="btn btn-outline-info btn-sm ml-2" type="button" name="edit_photos">Измени <br> фотографије</a>
            <form class="d-inline" action="{{route('admin.delete-news', $singleNews->id)}}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" name="button" onclick="return confirm('Да ли сте сигурни да желите да обришете ову вест?')" class="btn btn-outline-danger btn-sm ml-2">Обриши <br> вест</button>
            </form>
          @endif
        </div>
        <div class="col-md-3">
          <small class="float-right">Објављено: {{utf8_decode($singleNews->created_at)}}</small> <br>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="my-4">
    {{ $news->links() }}
  </div>
</div>

@endsection

@section('custom-js')

@endsection
