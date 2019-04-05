@extends('layouts.app')

@section('content')
<div class="container">
  @if(Session::has('error_message'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Инфо!</strong> {{Session::get('error_message')}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <h2>Измени податке администратора <strong>{{$admin->name}}</strong></h2>
  <br>
  
</div>
@endsection
