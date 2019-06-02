@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message"></div>
  <h2 class="d-inline">Управљање вестима</h2> <a href="{{route('admin.add-news')}}" type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2">Додај нову вест</a>
  <div class="my-4"></div>
    @if(Session::has('news_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>ИНФО</strong> {{Session::get('news_message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="row">
      <form class="row col-md-4" id="searchNews">
        <div class="form-group col-md-8">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search">
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
    <a href="{{ route('admin.single-news', $singleNews->url.'-'.$singleNews->id) }}" class="list-group-item list-group-item-action flex-column align-items-start {{ $index == 0 ? 'active' : '' }}">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">{{$singleNews->title}}</h5>
        <small>{{$singleNews->created_at}}</small>
      </div>
      <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
      <small>Donec id elit non mi porta.</small><br>
      <small><strong>Аутор: {{$singleNews->author}}</strong></small>
    </a>
    @endforeach
  </div>
  <div class="my-4">
    {{ $news->links() }}
  </div>
</div>

@endsection

@section('custom-js')

@endsection
