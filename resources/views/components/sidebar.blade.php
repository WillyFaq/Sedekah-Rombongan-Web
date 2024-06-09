<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
            <img src="{{ asset('assets/imgs/icon-32.png') }}" alt="icon">
        </div>
        <div class="sidebar-brand-text mx-3">Sedekah Rombongan</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <x-navlink href="/" :active="request()->is('/')">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a></x-navlink>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Master
    </div>
    <x-navlink href="/category" :active="request()->is('category*')">
        <i class="fas fa-fw fa-cog"></i>
        <span>Kategori</span></a>
    </x-navlink>
    <x-navlink href="/user" :active="request()->is('user*')">
        <i class="fas fa-fw fa-users"></i>
        <span>Pengguna</span></a>
    </x-navlink>
    <x-navlink href="/project" :active="request()->is('project*')">
        <i class="fas fa-hand-holding-usd"></i>
        <span>Project</span></a>
    </x-navlink>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>
    <x-navlink href="/donation" :active="request()->is('donation*')">
        <i class="fas fa-donate"></i>
        <span>Donasi</span></a>
    </x-navlink>
    <x-navlink href="/comment" :active="request()->is('comment*')">
        <i class="fas fa-comments"></i>
        <span>Komentar</span></a>
    </x-navlink>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Laporan
    </div>
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Laporan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
