<section class="ptb-0">
  <div class="mb-30 brdr-ash-1 opacty-5"></div>
  <div class="container">
    <a class="mt-10 mr-4" href="{{route('start')}}"><i class="mr-5 ion-ios-home"></i>Почетна </a>

    <a class="mt-10 mr-4" href="archive-page.html">{{App\Http\Controllers\IndexController::get_category_name($news->category)}}</a>

    <a class="mt-10 color-ash" style="color:grey">{{utf8_decode($news->title)}}</a>
  </div><!-- container -->
</section>

<section>
  <div class="container">
    <div class="row">

      <div class="col-md-12 col-lg-8">
        <img src="{{utf8_decode($news->cover)}}" alt="">
        <h3 class="mt-30"><b>{{utf8_decode($news->title)}}</b></h3>
        <ul class="list-li-mr-20 mtb-15">
          <li>Aутор <a href="#"><b>{{ App\Http\Controllers\AdminController::get_author_name($news->author) }} </b></a> {{date_format($news->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
        </ul>

        <p>RSK is launching its bitcoins smart contracts platform in beta today.</p>

        <p class="mtb-15">Formerly known as Rootstock, the startup has long been lauded for Rs potential to pave the way for the
          implementation of ethereum-style smart contracts on broom. something enthusiasts believe vein keep the wodd's
          largest cryptocurrency competitive with the platform t hnl acquably pionverecl
          the idea I hat mote executing code could be rim on a bickchain.</p>

        <p class="mtb-15">But while it would be easy enough for Wan users that want more complex smart contracts oo merely
          some users believe that. as tdcoin is the largest and most secure cryptocumency, more experimental
          features that debut on other networks will eventually make hal in
          doing to, Uxy can r apitalier impressive startup infrastructure and serve different users.</p>

        <p class="mtb-15">Yet.RSK's version of the functionality doesn't quite upgrade the bmcom blockchain itself. I he
          capability will rather be brought to brtcoin via a sidechain. which moves tokens from the main btroin
          blockchaln to a compatible network operated with the help of 25 companies.</p>

        <p class="mtb-15">Still, RSK's CEO Diego Gutierrez 7aldivar believes the advance will effectively provide
          the level of ubuty to potential users. </p>

        <div class="quote-primary mtb-20">
          <h5>"This Is the first time that there's going to be a smart contract platform powered by the bitcoin network."</h5>
          <h5 class="mt-15"><b>Oliver Dale</b></h5>
        </div><!-- quote-primary -->

        <h4><b>How to Buy Powerledger POWR</b></h4>

        <p class="mtb-15">You are not able to purchase POWR with "Fiat" currency so you will need to first purchase another
          currency - the easiest to buy are Bitcoin or Ethereum which you can do at Coinbase using a bank transfer or
          debit / credit card purchase and then swap that for POWR at an exchange such as Binance.</p>

        <p class="mtb-15">You will have to carry out some identity verification when signing up as they have
          to adhere to strict financial guidelines. Make sure you use our link to signup you will be
          credited with $10 in free bitcoin when you make your first purchase of $100 </p>

        <div class="float-left-right text-center mt-40 mt-sm-20">

          <ul class="mb-30 list-li-mt-10 list-li-mr-5 list-a-plr-15 list-a-ptb-7 list-a-bg-grey list-a-br-2 list-a-hvr-primary ">
            <li><a href="#">MULTIPURPOSE</a></li>
            <li><a href="#">FASHION</a></li>
            <li class="mr-0"><a href="#">BLOGS</a></li>
          </ul>
          <ul class="mb-30 list-a-bg-grey list-a-hw-radial-35 list-a-hvr-primary list-li-ml-5">
            <li class="mr-10 ml-0">Share</li>
            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
            <li><a href="#"><i class="ion-social-google"></i></a></li>
            <li><a href="#"><i class="ion-social-instagram"></i></a></li>
          </ul>

        </div><!-- float-left-right -->

        <div class="brdr-ash-1 opacty-5"></div>



        <h4 class="p-title mt-20"><b>Kоментари на вест</b></h4>

        @include('parts.comments')

      <div class="d-none d-md-block d-lg-none col-md-3"></div>
      <div class="col-md-6 col-lg-4">
        <div class="pl-20 pl-md-0">
          <ul class="list-block list-li-ptb-15 list-btm-border-white bg-primary text-center">
            <li><b>1 BTC = $13,2323</b></li>
            <li><b>1 BCH = $13,2323</b></li>
            <li><b>1 ETH = $13,2323</b></li>
            <li><b>1 LTC = $13,2323</b></li>
            <li><b>1 DAS = $13,2323</b></li>
            <li><b>1 BCC = $13,2323</b></li>
          </ul>

          <div class="mtb-50">
            <h4 class="p-title"><b>POPULAR POSTS</b></h4>
            <a class="oflow-hidden pos-relative mb-20 dplay-block" href="#">
              <div class="wh-100x abs-tlr"><img src="images/polular-1-100x100.jpg" alt=""></div>
              <div class="ml-120 min-h-100x">
                <h5><b>Bitcoin Billionares Hidding in Plain Sight</b></h5>
                <h6 class="color-lite-black pt-10">by <span class="color-black"><b>Danile Palmer,</b></span> Jan 25, 2018</h6>
              </div>
            </a><!-- oflow-hidden -->

            <a class="oflow-hidden pos-relative mb-20 dplay-block" href="#">
              <div class="wh-100x abs-tlr"><img src="images/polular-2-100x100.jpg" alt=""></div>
              <div class="ml-120 min-h-100x">
                <h5><b>Bitcoin Billionares Hidding in Plain Sight</b></h5>
                <h6 class="color-lite-black pt-10">by <span class="color-black"><b>Danile Palmer,</b></span> Jan 25, 2018</h6>
              </div>
            </a><!-- oflow-hidden -->

            <a class="oflow-hidden pos-relative mb-20 dplay-block" href="#">
              <div class="wh-100x abs-tlr"><img src="images/polular-3-100x100.jpg" alt=""></div>
              <div class="ml-120 min-h-100x">
                <h5><b>Bitcoin Billionares Hidding in Plain Sight</b></h5>
                <h6 class="color-lite-black pt-10">by <span class="color-black"><b>Danile Palmer,</b></span> Jan 25, 2018</h6>
              </div>
            </a><!-- oflow-hidden -->

            <a class="oflow-hidden pos-relative mb-20 dplay-block" href="#">
              <div class="wh-100x abs-tlr"><img src="images/polular-4-100x100.jpg" alt=""></div>
              <div class="ml-120 min-h-100x">
                <h5><b>Bitcoin Billionares Hidding in Plain Sight</b></h5>
                <h6 class="color-lite-black pt-10">by <span class="color-black"><b>Danile Palmer,</b></span> Jan 25, 2018</h6>
              </div>
            </a><!-- oflow-hidden -->

          </div><!-- mtb-50 -->

          <div class="mtb-50 pos-relative">
            <img src="images/banner-1-600x450.jpg" alt="">
            <div class="abs-tblr bg-layer-7 text-center color-white">
              <div class="dplay-tbl">
                <div class="dplay-tbl-cell">
                  <h4><b>Available for mobile & desktop</b></h4>
                  <a class="mt-15 color-primary link-brdr-btm-primary" href="#"><b>Download for free</b></a>
                </div><!-- dplay-tbl-cell -->
              </div><!-- dplay-tbl -->
            </div><!-- abs-tblr -->
          </div><!-- mtb-50 -->

          <div class="mtb-50 mb-md-0">
            <h4 class="p-title"><b>NEWSLETTER</b></h4>
            <p class="mb-20">Subscribe to our newsletter to get notification about new updates,
              information, discount, etc..</p>
            <form class="nwsltr-primary-1">
              <input type="text" placeholder="Your email"/>
              <button type="submit"><i class="ion-ios-paperplane"></i></button>
            </form>
          </div><!-- mtb-50 -->

        </div><!--  pl-20 -->
      </div><!-- col-md-3 -->

    </div><!-- row -->

    <h4 class="p-title mt-50"><b>Препоручујемо за вас</b></h4>
    <div class="row">
      @foreach($suggested_news as $suggestion)
      <div class="col-sm-4">
        <a href="{!! url(App\Http\Controllers\IndexController::generate_news_url($suggestion->id)) !!}">
          <img src="{{utf8_decode($news->cover)}}" alt="">
        </a>
        <h4 class="pt-20"><a href="{!! url(App\Http\Controllers\IndexController::generate_news_url($suggestion->id)) !!}">{{utf8_decode($suggestion->title)}}</a></h4>
        <ul class="list-li-mr-20 pt-10 mb-30">
          <li class="color-lite-black">Аутор <a href="#" class="color-black"><b>{{ App\Http\Controllers\AdminController::get_author_name($news->author) }}</b></a>
          {{date_format($news->created_at,"d. m. Y H:i")}}</li>
          <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
          <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>47</li>
        </ul>
      </div><!-- col-sm-6 -->
      @endforeach

    </div><!-- row -->
  </div><!-- container -->
</section>
