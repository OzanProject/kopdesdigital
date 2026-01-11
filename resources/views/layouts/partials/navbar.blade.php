<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-secondary" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          @php
              // Menentukan Route berdasarkan Role
              $dashboardRoute = 'dashboard'; // default untuk admin_koperasi & petugas
              
              if (auth()->user()->hasRole('super_admin')) {
                  $dashboardRoute = 'super.dashboard';
              } elseif (auth()->user()->hasRole('member')) {
                  $dashboardRoute = 'member.dashboard';
              }

              // Mengecek apakah halaman saat ini adalah dashboard manapun
              $isActive = request()->routeIs('dashboard') || 
                          request()->routeIs('super.dashboard') || 
                          request()->routeIs('member.dashboard');
          @endphp

          <a href="{{ route($dashboardRoute) }}" 
            class="nav-link font-weight-bold {{ $isActive ? 'text-primary' : 'text-secondary' }}">
              <i class="fas fa-home mr-1"></i> Dashboard
          </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link text-secondary" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                @php
                    $userImage = asset('adminlte3/dist/img/user2-160x160.jpg');
                    if (auth()->user()->hasRole('member') && auth()->user()->nasabah && auth()->user()->nasabah->foto) {
                        $userImage = asset('storage/' . auth()->user()->nasabah->foto);
                    } elseif (auth()->user()->avatar) {
                        $userImage = asset('storage/' . auth()->user()->avatar);
                    }
                @endphp
                <img src="{{ $userImage }}" class="user-image img-circle elevation-1 border" alt="User Image" style="object-fit: cover; width: 32px; height: 32px;">
                <span class="d-none d-md-inline font-weight-bold ml-1">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <li class="user-header bg-gradient-primary">
                    <img src="{{ $userImage }}" class="img-circle elevation-2 border-white" alt="User Image" style="object-fit: cover; border-width: 3px;">
                    <p class="text-white">
                        <span class="d-block font-weight-bold">{{ Auth::user()->name }}</span>
                        <small class="opacity-75">
                            @php
                                $roleName = Auth::user()->roles->pluck('name')->first() ?? 'Staff';
                                $roleLabel = match($roleName) {
                                    'super_admin'   => 'Administrator Utama',
                                    'admin_koperasi' => 'Admin Koperasi',
                                    'member'        => 'Anggota Koperasi',
                                    'petugas'       => 'Petugas Lapangan',
                                    default         => ucfirst($roleName)
                                };
                            @endphp
                            {{ $roleLabel }}
                        </small>
                    </p>
                </li>
                
                <li class="user-footer bg-white py-3">
                    @php
                        $profileRoute = match(true) {
                            auth()->user()->hasRole('super_admin') => route('super.profile.edit'),
                            auth()->user()->hasRole('member')      => route('member.profile.edit'),
                            default                               => route('admin.profile.edit')
                        };
                    @endphp
                    <div class="row px-2">
                        <div class="col-6">
                            <a href="{{ $profileRoute }}" class="btn btn-light btn-block rounded-pill btn-sm font-weight-bold border shadow-xs">
                                <i class="fas fa-user-cog mr-1"></i> Profil
                            </a>
                        </div>
                        <div class="col-6">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-block rounded-pill btn-sm font-weight-bold shadow-xs">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>