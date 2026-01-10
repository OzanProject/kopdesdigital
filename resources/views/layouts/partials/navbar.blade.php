  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Auth::user()->hasRole('super_admin') ? route('super.dashboard') : route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('super.dashboard') ? 'active' : '' }}">Dashboard</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Fullscreen Widget -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            @php
                $smallUserImage = asset('adminlte3/dist/img/user2-160x160.jpg');
                if (auth()->user()->hasRole('member') && auth()->user()->nasabah && auth()->user()->nasabah->foto) {
                    $smallUserImage = asset('storage/' . auth()->user()->nasabah->foto);
                } elseif (auth()->user()->avatar) {
                    $smallUserImage = asset('storage/' . auth()->user()->avatar);
                }
            @endphp
          <img src="{{ $smallUserImage }}" class="user-image img-circle elevation-2" alt="User Image" style="object-fit: cover;">
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            @php
                $userImage = asset('adminlte3/dist/img/user2-160x160.jpg');
                if (auth()->user()->hasRole('member') && auth()->user()->nasabah && auth()->user()->nasabah->foto) {
                    $userImage = asset('storage/' . auth()->user()->nasabah->foto);
                } elseif (auth()->user()->avatar) {
                    $userImage = asset('storage/' . auth()->user()->avatar);
                }
            @endphp
            <img src="{{ $userImage }}" class="img-circle elevation-2" alt="User Image" style="object-fit: cover;">
            <p>
              {{ Auth::user()->name }}
              <small>{{ Auth::user()->roles->pluck('name')->first() ?? 'Staff' }}</small>
            </p>
          </li>
          <!-- Menu Body -->
          <!-- Menu Footer-->
          <li class="user-footer">
            @php
                $profileRoute = route('admin.profile.edit');
                if (auth()->user()->hasRole('super_admin')) {
                    $profileRoute = route('super.profile.edit');
                } elseif (auth()->user()->hasRole('member')) {
                    $profileRoute = route('member.profile.edit');
                }
            @endphp
            <a href="{{ $profileRoute }}" class="btn btn-default btn-flat">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="float-right">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-default btn-flat">Sign out</a>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
