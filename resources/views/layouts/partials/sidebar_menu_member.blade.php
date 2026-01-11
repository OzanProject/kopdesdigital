{{-- Section: Dashboard Utama --}}
<li class="nav-item">
    <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-th-large"></i>
        <p>Ringkasan Akun</p>
    </a>
</li>

<li class="nav-header ls-1 small font-weight-bold opacity-75">MANAJEMEN KEUANGAN</li>

{{-- Simpanan --}}
<li class="nav-item">
    <a href="{{ route('member.simpanan.index') }}" class="nav-link {{ request()->routeIs('member.simpanan.*') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-piggy-bank"></i>
        <p>Tabungan & Simpanan</p>
    </a>
</li>

{{-- Pinjaman --}}
<li class="nav-item">
    <a href="{{ route('member.pinjaman.index') }}" class="nav-link {{ request()->routeIs('member.pinjaman.*') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>Kredit & Pinjaman</p>
    </a>
</li>

{{-- SHU --}}
<li class="nav-item">
    <a href="{{ route('member.shu.index') }}" class="nav-link {{ request()->routeIs('member.shu.*') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Dividen SHU</p>
    </a>
</li>

<li class="nav-header ls-1 small font-weight-bold opacity-75">BANTUAN & PENGATURAN</li>

{{-- Knowledge Base --}}
<li class="nav-item">
    <a href="{{ route('knowledge-base.index') }}" class="nav-link {{ request()->routeIs('knowledge-base.*') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-info-circle"></i>
        <p>Panduan Layanan</p>
    </a>
</li>

{{-- Profil --}}
<li class="nav-item">
    <a href="{{ route('member.profile.edit') }}" class="nav-link {{ request()->routeIs('member.profile.*') ? 'active shadow-sm' : '' }}">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Keamanan Profil</p>
    </a>
</li>