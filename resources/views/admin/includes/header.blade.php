 <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <span class="sidebar-heading d-block mr-5">Admin Haposoft</span>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a id="menu-toggle" href="#" class="ml-5 pl-3"><i class="fa fa-bars"></i></a>
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin.dashboard')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Welcome {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        {{ __('Logout') }}
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
