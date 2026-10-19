<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('asset/image/isa.jpg') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SI POS Kasir</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('asset/image/' . auth()->user()->foto) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->username }}</a>
            </div>
        </div>

        @php
            $currentPath = request()->path();
        @endphp

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ $currentPath === 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt text-sm"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->level != 3)
                <li class="nav-item {{ in_array(explode('/', $currentPath)[0] ?? '', ['supplier', 'customer', 'barang']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder text-sm"></i>
                        <p>Dadu Baze
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-sm"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-sm"></i>
                                <p>Kliente</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-sm"></i>
                                <p>Sasan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-header">Transaksaun</li>
                <li class="nav-item">
                    <a href="{{ route('pembelian.index') }}" class="nav-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart text-sm"></i>
                        <p>Maksosak</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice text-sm"></i>
                        <p>Makfa'an</p>
                    </a>
                </li>

                <li class="nav-header">Relatoriu</li>
                <li class="nav-item">
                    <a href="{{ route('relatoriu.maksosak') }}" class="nav-link {{ request()->routeIs('relatoriu.maksosak*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie text-sm"></i>
                        <p>Relatoriu Maksosak</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('relatoriu.makfaan') }}" class="nav-link {{ request()->routeIs('relatoriu.makfaan*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line text-sm"></i>
                        <p>Relatoriu Makfa'an</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stock') }}" class="nav-link {{ request()->routeIs('stock') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse text-sm"></i>
                        <p>Relatoriu Stock</p>
                    </a>
                </li>

                @if (auth()->user()->level == 1)
                <li class="nav-header">Konfigurasaun</li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog text-sm"></i>
                        <p>Utilizadores</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
