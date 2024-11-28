<div class="sidebar">
  <nav class="sidebar-nav">
      <ul class="nav">
          <li class="nav-item">
              <a class="nav-link" href="{{route('home')}}"><i class="fa text-light fa-bar-chart"></i> @lang('generic.home')</a>
          </li>
          <li class="nav-title">
              @lang('generic.menu')
          </li>
          @if(Auth::user()->rol->is_admin)
              <li class="nav-item">
                  <a class="nav-link" href="{{route('users.index')}}"><i class="fa text-light fa-user"></i> @lang('menu.users')</a>
              </li>
          @endif
          @if(Auth::user()->rol->is_super)
            <li class="nav-item">
                <a class="nav-link" href="{{route('roles.index')}}"><i class="fa text-light fa-user"></i> @lang('menu.roles')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('permissions.index')}}"><i class="fa text-light fa-user"></i> @lang('menu.permissions')</a>
            </li>
          @endif
      </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
