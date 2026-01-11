<li class="nav-item">
    <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-header">KEUANGAN</li>

<li class="nav-item">
    <a href="{{ route('member.simpanan.index') }}" class="nav-link {{ request()->routeIs('member.simpanan.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-wallet"></i>
        <p>Simpanan Saya</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('member.pinjaman.index') }}" class="nav-link {{ request()->routeIs('member.pinjaman.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Pinjaman Saya</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('member.shu.index') }}" class="nav-link {{ request()->routeIs('member.shu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>SHU Saya</p>
    </a>
</li>

<li class="nav-header">AKUN</li>

<li class="nav-item">
    <a href="{{ url('/member/profile') }}" class="nav-link {{ request()->is('member/profile*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Profil Saya</p>
    </a>
</li>

<li class="nav-item">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Keluar</p>
        </a>
    </form>
</li>
