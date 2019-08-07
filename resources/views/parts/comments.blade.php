@foreach($comments as $comment)
  <div class="sided-70 mb-50 {{$comment->reply != 0 ? 'ml-100 ml-xs-20':''}}">

    <div class="s-left rounded">
      <img src="{{asset('images/default-user.png')}}" alt="">
    </div><!-- s-left -->

    <div class="s-right ml-100 ml-xs-85">
      <h5><b>{{$comment->name}} </b> <span class="font-8 color-ash">{{date_format($news->created_at,"d. m. Y H:i")}}</span></h5>
      <p class="mt-10 mb-15">{{$comment->body}}</p>
      @if(Auth::id() !== null)
        @if($comment->user !== null && $comment->user == Auth::id())
          <a class="btn btn-outline-info btn-sm" href="#"><i class="far fa-comment-dots"></i><b> Одговори</b></a>
          <a class="btn btn-outline-danger btn-sm" href="#"><i class="far fa-trash-alt"></i> <b>Обриши</b></a>
        @else
          <a id="comment{{$comment->id}}" class="btn btn-{{ App\Http\Controllers\LikeController::isLiked($comment->id, Auth::id(), 0) ? 'success' : 'outline-success' }}success btn-sm" data-comment_id="{{$comment->id}}" href="#"><b> Свиђа ми се</b></a>
          <a class="btn btn-outline-info btn-sm" href="#"><i class="far fa-comment-dots"></i><b> Одговори</b></a>
        @endif
      @else
        <a id="comment{{$comment->id}}" class="btn btn-{{ App\Http\Controllers\LikeController::isLiked($comment->id, 0, Session::getId()) ? 'success' : 'outline-success' }} btn-sm like-comment" data-comment_id="{{$comment->id}}" href="#"><i class="far fa-thumbs-up"></i><b> Свиђа ми се</b></a>
        <a class="btn btn-outline-info btn-sm" href="#"><i class="far fa-comment-dots"></i><b> Одговори</b></a>
      @endif
    </div><!-- s-right -->

  </div><!-- sided-70 -->
@endforeach

<h4 class="p-title mt-20"><b>Остави коментар</b></h4>
@if(!Auth::check())
  <div id="comment_message"></div>
    <form class="form-block form-plr-15 form-h-45 form-mb-20 form-brdr-lite-white mb-md-50" id="add-comment">
      @csrf
      <input type="text" id="name" name="name" placeholder="Ваше име*:">
      <input type="text" id="email" name="email" placeholder="Ваш е-маил*:">
      <input type="hidden" id="route" name="route" value="{{route('start')}}">
      <input type="hidden" id="reply" name="reply" value="0">
      <input type="hidden" id="auth" value="guest">
      <input type="hidden" id="news_id" name="news_id" value="{{$news->id}}">
      <textarea id="body" name="body" class="ptb-10" placeholder="Унесите коментар"></textarea>
      <button class="btn-fill-primary plr-30" rows="4" cols="50" type="submit"><b>Додај коментар</b></button>
    </form>
    @else
    <form class="form-block form-plr-15 form-h-45 form-mb-20 form-brdr-lite-white mb-md-50" id="add-comment">
      @csrf
      <textarea id="body" name="body" class="ptb-10" placeholder="Унесите коментар"></textarea>
      <input type="hidden" id="route" name="route" value="{{route('start')}}">
      <input type="hidden" id="reply" name="reply" value="0">
      <input type="hidden" id="auth" value="user">
      <input type="hidden" id="news_id" name="news_id" value="{{$news->id}}">
      <button class="btn-fill-primary plr-30" rows="4" cols="50" type="submit"><b>Додај коментар</b></button>
    </form>
  @endif
</div><!-- col-md-9 -->
