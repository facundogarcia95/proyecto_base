<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}"><i class="fa text-light fa-bar-chart"></i> Home</a>
                    </li>
                    <li class="nav-title">
                        Menú
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('usuarios')}}" onclick="event.preventDefault(); document.getElementById('usuarios-form').submit();"><i class="fa text-light fa-user"></i> Usuarios</a>
                         <form id="usuarios-form" action="{{url('usuarios')}}" method="GET" style="display: none;">
                         @csrf
                         </form>
                    </li>

                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
