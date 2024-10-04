<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            @if (Gate::allows('admin_access'))
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('app.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li class="{{ request()->is('categories') ? 'active' : '' }}">
                    <a href="{{ route('app.categories.index') }}"><i class="fa fa-tags"></i> Categories</a>
                </li>
                <li>
                    <a>
                        <i class="fa fa-home"></i> Form Builder <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('app.forms.index') }}">Form List</a></li>
                        <li><a href="{{ route('app.forms.create') }}">Add Form</a></li>
                    </ul>
                </li>
            @endif

            @if (Gate::allows('user_access'))
                <li class="{{ request()->is('panel') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a>
                </li>
            @endif
        </ul>
    </div>
</div>










