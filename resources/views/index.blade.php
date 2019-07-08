
@extends('layouts.front')
@section('header')
  @include('parts.header')
@endsection

@section('content')
<div class="container">
    <div class="h-600x h-sm-auto">
      @include('parts.featured-news')
    </div><!-- h-100vh -->
  </div><!-- container -->
@include('parts.latest-news')
@endsection
@section('footer')
  @include('parts.footer')
@endsection
