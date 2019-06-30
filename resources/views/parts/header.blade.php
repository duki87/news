<header>
  <div class="bg-191">
    <div class="container">
      <div class="oflow-hidden color-ash font-9 text-sm-center ptb-sm-5">

        <ul class="float-left float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-10">
          <li><a class="pl-0 pl-sm-10" href="#">About</a></li>
          <li><a href="#">Advertise</a></li>
          <li><a href="#">Submit Press Release</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <ul class="float-right float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-10">
          <li><a class="pl-0 pl-sm-10" href="#"><i class="ion-social-facebook"></i></a></li>
          <li><a href="#"><i class="ion-social-twitter"></i></a></li>
          <li><a href="#"><i class="ion-social-google"></i></a></li>
          <li><a href="#"><i class="ion-social-instagram"></i></a></li>
          <?php if(!Auth::check()) { ?>
          <li>
            <a class="pl-0 pl-sm-10" href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i> Пријави се</a>
          </li>
        <?php } else { ?>
          <li>
            <a class="pl-0 pl-sm-10" href=""
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                Одајави се
            </a>
            <form id="logout-form" action="{{ route('user.logout') }}" method="GET" style="display: none;">
                @csrf
            </form>
          </li>
        <?php } ?>
        </ul>

      </div><!-- top-menu -->
    </div><!-- container -->
  </div><!-- bg-191 -->

  <div class="container">
    <a class="logo" href="index.html"><img src="images/logo-black.png" alt="Logo"></a>

    <a class="right-area src-btn" href="#" >
      <i class="active src-icn ion-search"></i>
      <i class="close-icn ion-close"></i>
    </a>
    <div class="src-form">
      <form action="" method="POST">
        <input type="text" placeholder="Унесите кључне речи за претрагу">
        <button type="submit"><i class="ion-search"></i></a></button>
      </form>
    </div><!-- src-form -->

    <a class="menu-nav-icon" data-menu="#main-menu" href="#"><i class="ion-navicon"></i></a>

    <ul class="main-menu" id="main-menu">
      @foreach($categories as $category)
        <li class="drop-down"><a href="{{route('front.parent', $category->url)}}">{{$category->title}}<i class="ion-arrow-down-b"></i></a>
          <ul class="drop-down-menu drop-down-inner">
            {{App\Http\Controllers\IndexController::populate_child_categories($category->id)}}
          </ul>
        </li>
      @endforeach
      <!-- <li class="drop-down"><a href="03_single-post.html">GUIDES & ANALYTICS<i class="ion-arrow-down-b"></i></a>
        <ul class="drop-down-menu drop-down-inner">
          <li><a href="#">PAGE 1</a></li>
          <li><a href="#">PAGE 2</a></li>
        </ul>
      </li> -->
    </ul>
    <div class="clearfix"></div>
  </div><!-- container -->
</header>
