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
      <form>
        <input type="text" placeholder="Search here">
        <button type="submit"><i class="ion-search"></i></a></button>
      </form>
    </div><!-- src-form -->

    <a class="menu-nav-icon" data-menu="#main-menu" href="#"><i class="ion-navicon"></i></a>

    <ul class="main-menu" id="main-menu">
      <li><a href="02_archive-page.html">NEWS</a></li>
      <li class="drop-down"><a href="03_single-post.html">GUIDES & ANALYTICS<i class="ion-arrow-down-b"></i></a>
        <ul class="drop-down-menu drop-down-inner">
          <li><a href="#">PAGE 1</a></li>
          <li><a href="#">PAGE 2</a></li>
        </ul>
      </li>
      <li><a href="04_FAQS.html">EVENTS</a></li>
      <li><a href="05_FAQS-single.html">EXPLAINED</a></li>
      <li><a href="06_contact-us.html">ICON CLAENDER</a></li>
    </ul>
    <div class="clearfix"></div>
  </div><!-- container -->
</header>
