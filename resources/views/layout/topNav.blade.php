<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <a href="{{route('shop.dashBoard')}}" class="brand-logo">
        <img class="logo-abbr" src="../images/logo.png" alt="">
        <img class="logo-compact" src="../images/logo-text.png" alt="">
        <img class="brand-title" src="../images/logo-text.png" alt="">
    </a>
    <div class="nav-control">
        <div class="hamburger" >
            <span class="line" style="background:white"></span>
            <span class="line" style="background:white"></span>
            <span class="line" style="background:white"></span>
        </div>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->
<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content" style="background-color: #343957">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                </div>
                <ul class="navbar-nav header-right" >
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account" style="color:white"></i>
                            <span class="ml-2" style="color:white">{{Auth::user()->user_name}} </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('auth.logout')}}" class="dropdown-item">
                                <i class="icon-key"></i>
                                <span class="ml-2">Logout </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
    Header end ti-comment-alt
***********************************-->