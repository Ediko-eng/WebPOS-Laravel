<nav class="main-header navbar navbar-light navbar-expand navbar-white">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success mr-3" style="padding-top:10px;">
                <input type="checkbox" class="custom-control-input" id="cekDark">
                <label class="custom-control-label" for="cekDark">Modu Nakukun</label>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle fa-lg"></i>
                <span class="d-none d-sm-inline">{{ auth()->user()->username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <div class="dropdown-item dropdown-header">
                    {{ auth()->user()->fullname }}
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('password') }}" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i> Troka Password
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sai
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
