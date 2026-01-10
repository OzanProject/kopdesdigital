@role('super_admin')
<li class="nav-item">
    <a href="{{ route('super.dashboard') }}" class="nav-link {{ request()->routeIs('super.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<!-- SaaS Management Group -->
<!-- SaaS Management Group -->
<li class="nav-item {{ request()->routeIs('koperasi*', 'subscription-packages*', 'global-users*', 'discounts*', 'invoices*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('koperasi*', 'subscription-packages*', 'global-users*', 'discounts*', 'invoices*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-server"></i>
        <p>
            SaaS Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('koperasi.index') }}" class="nav-link {{ request()->routeIs('koperasi*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Koperasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('subscription-packages.index') }}" class="nav-link {{ request()->routeIs('subscription-packages*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Paket</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('global-users.index') }}" class="nav-link {{ request()->routeIs('global-users*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data User (Global)</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('discounts.index') }}" class="nav-link {{ request()->routeIs('discounts*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Diskon</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Invoice</p>
            </a>
        </li>
    </ul>
</li>

<!-- CMS Landing Page Group -->
<li class="nav-item {{ request()->routeIs('landing-*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('landing-*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-globe"></i>
        <p>
            CMS Landing Page
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('landing-settings.index') }}" class="nav-link {{ request()->routeIs('landing-settings*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengaturan Utama</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-features.index') }}" class="nav-link {{ request()->routeIs('landing-features*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Fitur Unggulan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-faqs.index') }}" class="nav-link {{ request()->routeIs('landing-faqs*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ / Tanya Jawab</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('landing-testimonials.index') }}" class="nav-link {{ request()->routeIs('landing-testimonials*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Testimoni</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('saas-settings.index') }}" class="nav-link {{ request()->routeIs('saas-settings*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Aplikasi (SaaS)</p>
    </a>
</li>
<li class="nav-item {{ request()->routeIs('support-tickets*', 'admin.article-categories*', 'admin.articles*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('support-tickets*', 'admin.article-categories*', 'admin.articles*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-headset"></i>
        <p>
            Support Center
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('support-tickets.index') }}" class="nav-link {{ request()->routeIs('support-tickets*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tiket Masuk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.article-categories.index') }}" class="nav-link {{ request()->routeIs('admin.article-categories*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori Bantuan</p>
            </a>
        </li>
        <li class="nav-item">
             <a href="{{ route('admin.articles.index') }}" class="nav-link {{ request()->routeIs('admin.articles*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Artikel Bantuan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('backups.index') }}" class="nav-link {{ request()->routeIs('backups*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-database"></i>
        <p>Backup Database</p>
    </a>
</li>
@endrole

@role('admin_koperasi|petugas')
<li class="nav-item">
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<!-- Menu Operasional -->
<li class="nav-item {{ request()->routeIs('nasabah.*', 'simpanan.*', 'penarikan.*', 'pinjaman.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('nasabah.*', 'simpanan.*', 'penarikan.*', 'pinjaman.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            Operasional
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('nasabah.index') }}" class="nav-link {{ request()->routeIs('nasabah.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Nasabah</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('simpanan.index') }}" class="nav-link {{ request()->routeIs('simpanan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Simpanan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penarikan.index') }}" class="nav-link {{ request()->routeIs('penarikan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Penarikan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pinjaman.index') }}" class="nav-link {{ request()->routeIs('pinjaman.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pinjaman</p>
            </a>
        </li>
    </ul>
</li>

<!-- Menu Laporan -->
<li class="nav-item {{ request()->routeIs('laporan.*', 'shu.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('laporan.*', 'shu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>
            Laporan & SHU
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Laporan Keuangan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('shu.index') }}" class="nav-link {{ request()->routeIs('shu.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pembagian SHU</p>
            </a>
        </li>
    </ul>
</li>
@endrole

@role('admin_koperasi')
<!-- Menu Pengaturan -->
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
                <i class="far fa-circle nav-icon"></i>
                <p>Billing & Paket</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Manajemen User</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('setting.index') }}" class="nav-link {{ request()->routeIs('setting.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengaturan Umum</p>
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
                <i class="far fa-circle nav-icon"></i>
                <p>Panduan Aplikasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('support.index') }}" class="nav-link {{ request()->routeIs('support.index', 'support.show') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tiket Saya</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('support.create') }}" class="nav-link {{ request()->routeIs('support.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Buat Tiket Baru</p>
            </a>
        </li>
    </ul>
</li>
@endrole

@role('member')
<li class="nav-item">
    <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard Anggota</p>
    </a>
</li>
<li class="nav-item {{ request()->routeIs('member.simpanan.*', 'member.pinjaman.*', 'member.shu.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('member.simpanan.*', 'member.pinjaman.*', 'member.shu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-wallet"></i>
        <p>
            Keuangan Saya
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('member.simpanan.index') }}" class="nav-link {{ request()->routeIs('member.simpanan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Simpanan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('member.pinjaman.index') }}" class="nav-link {{ request()->routeIs('member.pinjaman.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Pinjaman</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('member.shu.index') }}" class="nav-link {{ request()->routeIs('member.shu.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>SHU Saya</p>
            </a>
        </li>
    </ul>
</li>
@endrole
