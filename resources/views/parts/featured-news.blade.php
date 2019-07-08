<div class="h-2-3 h-sm-auto oflow-hidden">

  <div class="pb-5 pr-5 pr-sm-0 float-left float-sm-none w-2-3 w-sm-100 h-100 h-sm-300x">
    <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[0]->id)) !!}">

      <div class="img-bg bg-grad-layer-6">
        <img src="{{utf8_decode($featured[0]->cover)}}" alt="{{utf8_decode($featured[0]->title)}}">
      </div>

      <div class="abs-blr color-white p-20 bg-sm-color-7">
        <h3 class="mb-15 mb-sm-5 font-sm-13"><b>{{utf8_decode($featured[0]->title)}}</b></h3>
        <ul class="list-li-mr-20">
          <li>by <span class="color-primary"><b>{{ App\Http\Controllers\AdminController::get_author_name($featured[0]->author) }}</b></span> {{date_format($featured[0]->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
        </ul>
      </div><!--abs-blr -->
    </a><!-- pos-relative -->
  </div><!-- w-1-3 -->

  <div class="float-left float-sm-none w-1-3 w-sm-100 h-100 h-sm-600x">

    <div class="pl-5 pb-5 pl-sm-0 ptb-sm-5 pos-relative h-50">
      <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[1]->id)) !!}">

        <div class="img-bg bg-grad-layer-6">
          <img src="{{utf8_decode($featured[1]->cover)}}" style="height:100%; object-fit:cover" alt="{{utf8_decode($featured[1]->title)}}">
        </div>

        <div class="abs-blr color-white p-20 bg-sm-color-7">
          <h4 class="mb-10 mb-sm-5"><b>{{utf8_decode($featured[1]->title)}}</b></h4>
          <ul class="list-li-mr-20">
            <li>{{date_format($featured[1]->created_at,"d. m. Y H:i")}}</li>
            <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
            <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
          </ul>
        </div><!--abs-blr -->
      </a><!-- pos-relative -->
    </div><!-- w-1-3 -->

    <div class="pl-5 ptb-5 pl-sm-0 pos-relative h-50">
      <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[2]->id)) !!}">

        <div class="img-bg bg-grad-layer-6">
          <img src="{{utf8_decode($featured[2]->cover)}}" style="height:100%; object-fit:cover" alt="{{utf8_decode($featured[2]->title)}}">
        </div>

        <div class="abs-blr color-white p-20 bg-sm-color-7">
          <h4 class="mb-10 mb-sm-5"><b>{{utf8_decode($featured[2]->title)}}</b></h4>
          <ul class="list-li-mr-20">
            <li>{{date_format($featured[2]->created_at,"d. m. Y H:i")}}</li>
            <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
            <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
          </ul>
        </div><!--abs-blr -->
      </a><!-- pos-relative -->
    </div><!-- w-1-3 -->

  </div><!-- float-left -->

</div><!-- h-2-3 -->

<div class="h-1-3 oflow-hidden">

  <div class="pr-5 pr-sm-0 pt-5 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
    <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[3]->id)) !!}">

      <div class="img-bg bg-grad-layer-6">
        <img src="{{utf8_decode($featured[3]->cover)}}" style="height:100%; object-fit:cover" alt="{{utf8_decode($featured[3]->title)}}">
      </div>

      <div class="abs-blr color-white p-20 bg-sm-color-7">
        <h4 class="mb-10 mb-sm-5"><b>{{utf8_decode($featured[3]->title)}}</b></h4>
        <ul class="list-li-mr-20">
          <li>{{date_format($featured[3]->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
        </ul>
      </div><!--abs-blr -->
    </a><!-- pos-relative -->
  </div><!-- w-1-3 -->

  <div class="plr-5 plr-sm-0 pt-5 pt-sm-10 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
    <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[4]->id)) !!}">

      <div class="img-bg bg-grad-layer-6">
        <img src="{{utf8_decode($featured[4]->cover)}}" style="height:100%; object-fit:cover" alt="{{utf8_decode($featured[4]->title)}}">
      </div>

      <div class="abs-blr color-white p-20 bg-sm-color-7">
        <h4 class="mb-10 mb-sm-5"><b>{{utf8_decode($featured[4]->title)}}</b></h4>
        <ul class="list-li-mr-20">
          <li>{{date_format($featured[4]->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
        </ul>
      </div><!--abs-blr -->
    </a><!-- pos-relative -->
  </div><!-- w-1-3 -->

  <div class="pl-5 pl-sm-0 pt-5 pt-sm-10 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x">
    <a class="pos-relative h-100 dplay-block" href="{!! url(App\Http\Controllers\IndexController::generate_news_url($featured[5]->id)) !!}">

      <div class="img-bg bg-grad-layer-6">
        <img src="{{utf8_decode($featured[5]->cover)}}" style="height:100%; object-fit:cover" alt="{{utf8_decode($featured[5]->title)}}">
      </div>

      <div class="abs-blr color-white p-20 bg-sm-color-7">
        <h4 class="mb-10 mb-sm-5"><b>{{utf8_decode($featured[5]->title)}}</b></h4>
        <ul class="list-li-mr-20">
          <li>{{date_format($featured[5]->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
        </ul>
      </div><!--abs-blr -->
    </a><!-- pos-relative -->
  </div><!-- w-1-3 -->

</div><!-- h-2-3 -->
