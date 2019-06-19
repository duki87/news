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
  <div class="container mt-4">
    <h2 class="d-inline">{{utf8_decode($news->title)}}</h2>
    @if(Auth::id() == $news->author)
      <a href="{{ route('admin.edit-news', utf8_decode($news->url).'-'.$news->id) }}" type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2 ml-2">Измени вест</a>
      <form class="d-inline" action="{{route('admin.delete-news', $news->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" name="button" class="btn btn-danger text-white d-inline float-right mb-2">Обриши вест</button>
      </form>
    @endif
    <p style="font-weight:bold">Aутор: {{utf8_decode($news->author)}}</p>
    <?=utf8_decode($news->body);?>
  </div>
  <br>

  @endsection

  @section('custom-js')

  @endsection
