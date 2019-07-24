@extends('layouts.front')
@section('header')
  @include('parts.header')
@endsection

@section('content')
<div class="container">
    <div class="h-600x h-sm-auto">
      @include('parts.single-news')
    </div><!-- h-100vh -->
  </div><!-- container -->
@endsection
@section('footer')
  @include('parts.footer')
@endsection

@section('custom-js')
  <script type="text/javascript" src="{{asset('js/comment.js')}}"></script>
@endsection
