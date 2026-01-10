  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ auth()->user()->hasRole('super_admin') ? route('super.dashboard') : (auth()->user()->hasRole('member') ? route('member.dashboard') : route('dashboard')) }}" class="brand-link" style="height: auto; min-height: 57px;">
      @if(auth()->user()->hasRole('super_admin'))
          @php $saasLogo = \App\Models\SaasSetting::where('key', 'app_logo')->value('value'); @endphp
          <img src="{{ $saasLogo ? asset('storage/' . $saasLogo) : asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="SaaS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light" style="white-space: normal; font-size: 0.9rem; display: inline-block; vertical-align: middle;">{{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'SaaS Super Admin' }}</span>
      @else
          <img src="{{ isset($koperasi) && $koperasi->logo ? asset('storage/' . $koperasi->logo) : asset('adminlte3/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light" style="white-space: normal; font-size: 0.85rem; line-height: 1.2; display: inline-block; vertical-align: middle;">{{ isset($koperasi) ? $koperasi->nama : 'SaaS Koperasi' }}</span>
      @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @php
                $userImage = asset('adminlte3/dist/img/user2-160x160.jpg');
                if (auth()->user()->hasRole('member') && auth()->user()->nasabah && auth()->user()->nasabah->foto) {
                    $userImage = asset('storage/' . auth()->user()->nasabah->foto);
                } elseif (auth()->user()->avatar) {
                    $userImage = asset('storage/' . auth()->user()->avatar);
                }
            @endphp
          <img src="{{ $userImage }}" class="img-circle elevation-2" alt="User Image" style="object-fit: cover; width: 2.1rem; height: 2.1rem;">
        </div>
        <div class="info">
          <a href="{{ auth()->user()->hasRole('member') ? route('member.profile.edit') : '#' }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           @include('layouts.partials.sidebar_menu')
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
