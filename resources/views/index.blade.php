
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

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        @include('parts.latest-news')
        @include('parts.other-news')
      </div><!-- col-md-9 -->
      <div class="d-none d-md-block d-lg-none col-md-3"></div>
      <div class="col-md-6 col-lg-4">
          <div class="pl-20 pl-md-0">
              @include('parts.poll')
              @include('parts.popular-posts')
              @include('parts.newsletter')
          </div><!--  pl-20 -->
      </div><!-- col-md-3 -->
    </div><!-- row -->
  </div><!-- container -->
</section>


@endsection
@section('custom-js')
  <script type="text/javascript" src="{{asset('js/poll-front.js')}}"></script>
@endsection

@section('footer')
  @include('parts.footer')
@endsection
