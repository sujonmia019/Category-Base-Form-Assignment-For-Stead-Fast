<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                @php
                    $user = Auth::user();
                @endphp
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                        id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        {!! user_image(USER_AVATAR_PATH,$user->avatar,$user->name) !!} {{ $user->name }}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right"
                        aria-labelledby="navbarDropdown">
                        <button type="button" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out pull-right"></i>Logout</button>

                        <form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
