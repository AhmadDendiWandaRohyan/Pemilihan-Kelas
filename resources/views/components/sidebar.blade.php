<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand justify-content-center mt-3">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('logo-black.png') }}" alt="{{ config('app.name') }}" width="150">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div>
        <div class="app-brand justify-content-center mt-3 brand-texttt">
            SMA Negeri 1 Tayu
        </div>
    </div>
    
    <hr>
    <style>
        .brand-texttt {
            font-size: 1.15em; /* Ukuran teks lebih besar */
            font-weight: bold; /* Teks tebal */
            color: rgb(46, 46, 124); /* Warna teks biru */
        }
        
    </style>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Home -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('menu.home') }}">{{ __('menu.home') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('menu.header.main_menu') }}</span>
        </li>

        @if (auth()->user()->role == 'siswa')
            <!-- Paket Management User -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('paket.*') ? 'active' : '' }}">
                <a href="{{ route('paket.paket-pelajaran.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="{{ __('menu.paket.menu_user') }}">{{ __('menu.paket.menu_user') }}</div>
                </a>
            </li>

            <!-- Supporting Management -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('supporting.*') ? 'active' : '' }}">
                <a href="{{ route('supporting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div data-i18n="{{ __('menu.supporting.menu') }}">{{ __('menu.supporting.menu') }}</div>
                </a>
            </li>

            <!-- Download -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('report.*') ? 'active' : '' }}">
                <a href="{{ route('report.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-download"></i>
                    <div data-i18n="{{ __('menu.download.menu') }}">{{ __('menu.download.menu') }}</div>
                </a>
            </li>
        @endif

        @if (auth()->user()->role == 'admin')
            <!-- Paket Pelajaran Management admin -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('paket.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div data-i18n="{{ __('menu.paket.menu') }}">{{ __('menu.paket.menu') }}</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('paket.pelajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('paket.pelajaran.index') }}" class="menu-link">
                            <div data-i18n="{{ __('menu.paket.pelajaran') }}">
                                {{ __('menu.paket.pelajaran') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('paket.paket-pelajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('paket.paket-pelajaran.index') }}" class="menu-link">
                            <div data-i18n="{{ __('menu.paket.paket_pelajaran') }}">
                                {{ __('menu.paket.paket_pelajaran') }}</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- grade siswa -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('grade.*') ? 'active' : '' }}">
                <a href="{{ route('grade.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-clipboard"></i>
                    <div data-i18n="{{ __('menu.grade.menu') }}">{{ __('menu.grade.menu') }}</div>
                </a>
            </li>

            <!-- Supporting Management -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('supporting.*') ? 'active' : '' }}">
                <a href="{{ route('supporting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div data-i18n="{{ __('menu.supporting.menu') }}">{{ __('menu.supporting.menu') }}</div>
                </a>
            </li>

            <!-- Report Management -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('report.*') ? 'active' : '' }}">
                <a href="{{ route('report.admin') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bar-chart-square"></i>
                    <div data-i18n="{{ __('menu.report.menu') }}">{{ __('menu.report.menu') }}</div>
                </a>
            </li>
        @endif

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('menu.header.other_menu') }}</span>
        </li>

        @if (auth()->user()->role == 'admin')
            <!-- User Management -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('user.*') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin"></i>
                    <div data-i18n="{{ __('menu.users') }}">{{ __('menu.users') }}</div>
                </a>
            </li>

            <!-- Announcement Management -->
            <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('announcement.*') ? 'active' : '' }}">
                <a href="{{ route('announcement.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-error"></i>
                    <div data-i18n="{{ __('menu.announcement.menu') }}">{{ __('menu.announcement.menu') }}</div>
                </a>
            </li>
        @endif
        <!-- Setting -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('profile.show') ? 'active' : '' }}">
            <a href="{{ route('profile.show') }}" class="menu-link">
                <i class="bx bx-user me-2"></i>
                <div data-i18n="{{ __('navbar.profile.profile') }}">{{ __('navbar.profile.profile') }}</div>
            </a>
        </li>
        <!-- Logout -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('logout') ? 'active' : '' }}">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="menu-link cursor-pointer border-0 bg-light">
                    <i class="bx bx-power-off me-2"></i>
                    <div data-i18n="{{ __('navbar.profile.logout') }}">{{ __('navbar.profile.logout') }}</div>
                </button>
            </form>
        </li>
    </ul>
</aside>
