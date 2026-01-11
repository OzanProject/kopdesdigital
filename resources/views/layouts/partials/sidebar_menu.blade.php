{{-- ==========================================================
     SUPER ADMIN SECTION
     ========================================================== --}}
@role('super_admin')
<li class="nav-header">CORE SYSTEM</li>
<li class="nav-item">
    <a href="{{ route('super.dashboard') }}" class="nav-link {{ request()->routeIs('super.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Main Dashboard</p>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('koperasi*', 'subscription-packages*', 'global-users*', 'discounts*', 'invoices*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('koperasi*', 'subscription-packages*', 'global-users*', 'discounts*', 'invoices*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-layer-group"></i>
        <p>
            SaaS Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('koperasi.index') }}" class="nav-link {{ request()->routeIs('koperasi*') ? 'active' : '' }}">
                <i class="fas fa-university nav-icon"></i>
                <p>Data Koperasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('subscription-packages.index') }}" class="nav-link {{ request()->routeIs('subscription-packages*') ? 'active' : '' }}">
                <i class="fas fa-box-open nav-icon"></i>
                <p>Paket Langganan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('global-users.index') }}" class="nav-link {{ request()->routeIs('global-users*') ? 'active' : '' }}">
                <i class="fas fa-users-cog nav-icon"></i>
                <p>User Global</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('discounts.index') }}" class="nav-link {{ request()->routeIs('discounts*') ? 'active' : '' }}">
                <i class="fas fa-percent nav-icon"></i>
                <p>Kode Promo</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>Billing / Invoice</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">FRONTEND CMS</li>
<li class="nav-item {{ request()->routeIs('landing-*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('landing-*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-window-restore"></i>
        <p>
            Landing Page
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('landing-settings.index') }}" class="nav-link {{ request()->routeIs('landing-settings*') ? 'active' : '' }}">
                <i class="fas fa-sliders-h nav-icon"></i>
                <p>Settings Utama</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-features.index') }}" class="nav-link {{ request()->routeIs('landing-features*') ? 'active' : '' }}">
                <i class="fas fa-star nav-icon"></i>
                <p>List Fitur</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-faqs.index') }}" class="nav-link {{ request()->routeIs('landing-faqs*') ? 'active' : '' }}">
                <i class="fas fa-question-circle nav-icon"></i>
                <p>Data FAQ</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-testimonials.index') }}" class="nav-link {{ request()->routeIs('landing-testimonials*') ? 'active' : '' }}">
                <i class="fas fa-quote-left nav-icon"></i>
                <p>Testimoni User</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">SYSTEM & SUPPORT</li>
<li class="nav-item">
    <a href="{{ route('saas-settings.index') }}" class="nav-link {{ request()->routeIs('saas-settings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tools"></i>
        <p>Config Aplikasi</p>
    </a>
</li>
<li class="nav-item {{ request()->routeIs('support-tickets*', 'admin.article-categories*', 'admin.articles*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('support-tickets*', 'admin.article-categories*', 'admin.articles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-life-ring"></i>
        <p>
            Support Center
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt nav-icon"></i>
                <p>Inbox Tiket</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">
                <i class="fas fa-book nav-icon"></i>
                <p>Knowledge Base</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('backups.index') }}" class="nav-link {{ request()->routeIs('backups*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-database"></i>
        <p>Database Backup</p>
    </a>
</li>
@endrole


{{-- ==========================================================
     ADMIN KOPERASI & PETUGAS SECTION
     ========================================================== --}}
@role('admin_koperasi|petugas')
<li class="nav-header">OVERVIEW</li>
<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<li class="nav-header">CORE OPERATIONS</li>
<li class="nav-item {{ request()->routeIs('nasabah.*', 'simpanan.*', 'penarikan.*', 'pinjaman.*', 'angsuran.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('nasabah.*', 'simpanan.*', 'penarikan.*', 'pinjaman.*', 'angsuran.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-hand-holding-usd"></i>
        <p>
            Transaksi Utama
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('nasabah.index') }}" class="nav-link {{ request()->routeIs('nasabah.*') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Database Anggota</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('simpanan.index') }}" class="nav-link {{ request()->routeIs('simpanan.*') ? 'active' : '' }}">
                <i class="fas fa-piggy-bank nav-icon"></i>
                <p>Setoran Simpanan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penarikan.index') }}" class="nav-link {{ request()->routeIs('penarikan.*') ? 'active' : '' }}">
                <i class="fas fa-money-check-alt nav-icon"></i>
                <p>Penarikan Dana</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pinjaman.index') }}" class="nav-link {{ request()->routeIs('pinjaman.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Kredit / Pinjaman</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('angsuran.index') }}" class="nav-link {{ request()->routeIs('angsuran.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check nav-icon"></i>
                <p>Jadwal Angsuran</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">REPORTING</li>
<li class="nav-item {{ request()->routeIs('laporan.*', 'shu.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('laporan.*', 'shu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>
            Laporan Keuangan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="fas fa-print nav-icon"></i>
                <p>Cetak Laporan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('shu.index') }}" class="nav-link {{ request()->routeIs('shu.*') ? 'active' : '' }}">
                <i class="fas fa-calculator nav-icon"></i>
                <p>Kalkulasi SHU</p>
            </a>
        </li>
    </ul>
</li>

@role('admin_koperasi')
<li class="nav-header">ADMINISTRATION</li>
<li class="nav-item {{ request()->routeIs('subscription.*', 'users.*', 'setting.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('subscription.*', 'users.*', 'setting.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Pengaturan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('subscription.index') }}" class="nav-link {{ request()->routeIs('subscription.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card nav-icon"></i>
                <p>Billing & Paket</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield nav-icon"></i>
                <p>Hak Akses User</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('setting.index') }}" class="nav-link {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                <i class="fas fa-building nav-icon"></i>
                <p>Profil Koperasi</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->routeIs('support*', 'knowledge-base*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('support*', 'knowledge-base*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-life-ring"></i>
        <p>
            Pusat Bantuan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('knowledge-base.index') }}" class="nav-link {{ request()->routeIs('knowledge-base*') ? 'active' : '' }}">
                <i class="fas fa-info-circle nav-icon"></i>
                <p>Panduan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('support.index') }}" class="nav-link {{ request()->routeIs('support.index', 'support.show') ? 'active' : '' }}">
                <i class="fas fa-headset nav-icon"></i>
                <p>Tiket Saya</p>
            </a>
        </li>
    </ul>
</li>
@endrole
@endrole