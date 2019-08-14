@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message">

  </div>
  @if(Session::has('session_message'))
    <div class="alert alert-{{Session::get('session_message.alert')}} alert-dismissible fade show" role="alert">
      <strong>ИНФО</strong>{{Session::get('session_message.content')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
</div>
@endsection
