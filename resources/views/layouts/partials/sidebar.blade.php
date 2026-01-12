<aside class="main-sidebar sidebar-dark-primary elevation-4 border-right-0">
    <a href="{{ auth()->user()->hasRole('super_admin') ? route('super.dashboard') : (auth()->user()->hasRole('member') ? route('member.dashboard') : route('dashboard')) }}" 
       class="brand-link border-bottom-0 py-3 d-flex align-items-center" style="background: rgba(0,0,0,0.2); height: auto; min-height: 60px;">
        
        @if(auth()->user()->hasRole('super_admin'))
            @php $saasLogo = \App\Models\SaasSetting::where('key', 'app_logo')->value('value'); @endphp
            <img src="{{ $saasLogo ? asset('storage/' . $saasLogo) : asset('adminlte3/dist/img/AdminLTELogo.png') }}" 
                 alt="SaaS Logo" class="brand-image img-circle elevation-2 shadow-sm" style="opacity: 1; border: 2px solid rgba(255,255,255,0.2);">
            <span class="brand-text font-weight-bolder ls-1" style="font-size: 1rem;">
                {{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'SaaS Admin' }}
            </span>
        @else
            <img src="{{ isset($koperasi) && $koperasi->logo ? asset('storage/' . $koperasi->logo) : asset('adminlte3/dist/img/AdminLTELogo.png') }}" 
                 alt="Logo" class="brand-image img-circle elevation-2 shadow-sm" style="opacity: 1; border: 2px solid rgba(255,255,255,0.2); float: none; margin-right: 10px;">
            <span class="brand-text font-weight-bolder ls-1" style="font-size: 0.9rem; line-height: 1.2; white-space: normal; display: inline-block; vertical-align: middle;">
                {{ isset($koperasi) ? $koperasi->nama : 'SaaS Koperasi' }}
            </span>
        @endif
    </a>

    <div class="sidebar px-2">
        <div class="user-panel mt-4 pb-4 mb-4 d-flex align-items-center border-bottom-0 shadow-sm rounded-lg" style="background: rgba(255,255,255,0.05); padding: 12px;">
            <div class="image">
                @php
                    $userImage = asset('adminlte3/dist/img/user2-160x160.jpg');
                    if (auth()->user()->hasRole('member') && auth()->user()->nasabah && auth()->user()->nasabah->foto) {
                        $userImage = asset('storage/' . auth()->user()->nasabah->foto);
                    } elseif (auth()->user()->avatar) {
                        $userImage = asset('storage/' . auth()->user()->avatar);
                    }
                @endphp
                <img src="{{ $userImage }}" class="img-circle elevation-2" alt="User Image" 
                     style="object-fit: cover; width: 2.5rem; height: 2.5rem; border: 2px solid #0d6efd;">
            </div>
            <div class="info ml-2">
                @php
                    $profileRoute = match(true) {
                        auth()->user()->hasRole('super_admin') => route('super.profile.edit'),
                        auth()->user()->hasRole('member')      => route('member.profile.edit'),
                        default                               => route('admin.profile.edit')
                    };
                @endphp
                <a href="{{ $profileRoute }}" class="d-block font-weight-bold" style="font-size: 0.9rem; letter-spacing: 0.3px;">
                    {{ Str::limit(Auth::user()->name, 18) }}
                </a>
                <small class="text-primary font-weight-bold text-uppercase" style="font-size: 0.65rem;">
                    <i class="fas fa-circle text-success mr-1" style="font-size: 0.5rem;"></i> Online
                </small>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" 
                data-widget="treeview" role="menu" data-accordion="false">
                
                @if(auth()->user()->hasRole('anggota') || auth()->user()->hasRole('member'))
                    @include('layouts.partials.sidebar_menu_member')
                @else
                    @include('layouts.partials.sidebar_menu')
                @endif

                {{-- Spacing Bottom --}}
                <li class="nav-header mt-4">AKUN</li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-sidebar">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();" class="nav-link text-danger">
                            <i class="nav-icon fas fa-power-off"></i>
                            <p>Keluar Aplikasi</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        </div>
    </aside>