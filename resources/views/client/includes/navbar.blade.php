<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Haposoft</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(getGuardName() == 'customer')
            <li class="nav-item active">
                <a class="nav-link" href="{{route('client.customers.index')}}">Home <span class="sr-only">(current)</span></a>
            </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('client.customers.project.index') }}">Projects <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('client.customers.staffs.index')}}">Staffs <span class="sr-only">(current)</span></a>
                </li>
            @else
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('client.staffs.index')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('list-project.index') }}">Projects Join<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('reports.index')}}">Reports <span class="sr-only">(current)</span></a>
                </li>
            @endif

            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Welcome {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>