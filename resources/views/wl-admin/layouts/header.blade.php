@php
    $adminUser = auth('admin')->user();
    $roleLabel = $adminUser?->role === 'admin' ? 'Admin' : ($adminUser?->role === 'user' ? 'User' : '');
@endphp

<style>
    .topbar {
        position: fixed; top: 0; left: var(--sidebar-width); right: 0; z-index: 1030;
        height: var(--header-height); padding: 0 1.75rem;
        display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        background: rgba(255, 255, 255, .92);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid var(--line);
        box-shadow: 0 4px 16px rgba(45, 56, 43, .06);
    }
    /* dashed flight-path line along the bottom edge */
    .topbar::after {
        content: ""; position: absolute; left: 0; right: 0; bottom: -1px; height: 2px;
        background: repeating-linear-gradient(90deg, var(--sky) 0 8px, transparent 8px 16px);
        opacity: .55; pointer-events: none;
    }

    .topbar__left { display: flex; align-items: center; gap: .9rem; min-width: 0; }

    .topbar__toggle {
        width: 42px; height: 42px; border: 1px solid var(--line); border-radius: .6rem;
        background: transparent; color: var(--navy-deep); font-size: 1.5rem;
        display: grid; place-items: center;
    }
    .topbar__toggle:hover { background: var(--sky-soft); }

    .topbar__crumbs { min-width: 0; line-height: 1.15; }
    .topbar__app { font-size: .8rem; color: var(--ink-soft); font-weight: 500; }
    .topbar__page {
        font-family: var(--display-font); font-weight: 700; font-size: 1.45rem; color: var(--navy-deep);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .topbar__right { display: flex; align-items: center; gap: .8rem; }

    .site-link {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .45rem .9rem; border-radius: 999px; font-size: .85rem; font-weight: 600;
        color: var(--navy-soft); background: var(--sky-soft); text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }
    .site-link:hover { background: var(--sky); color: #fff; }

    .role-chip {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 700;
        background: var(--navy-deep); color: var(--sky-bright);
    }

    /* Profile */
    .profile-btn { padding: 0; border: 0; background: transparent; }
    .profile-btn::after { display: none; }
    .profile-btn img {
        width: 44px; height: 44px; object-fit: cover; border-radius: 50%;
        border: 2px solid var(--sunset); padding: 2px; background: #ffffff;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .profile-btn:hover img, .profile-btn:focus-visible img {
        transform: scale(1.06); box-shadow: 0 0 0 4px rgba(156, 96, 55, .25);
    }
    .profile-btn:focus-visible { outline: none; }

    .profile-menu {
        min-width: 270px; padding: 0; margin-top: .75rem !important;
        border: 1px solid var(--line); border-radius: .9rem; overflow: hidden;
        background: #ffffff; box-shadow: 0 14px 34px rgba(45, 56, 43, .22);
    }
    .profile-menu__head {
        display: flex; align-items: center; gap: .85rem; padding: 1rem 1.15rem;
        background: linear-gradient(120deg, var(--navy-deep), var(--navy-soft));
        color: #fff;
    }
    .profile-menu__head img { width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid var(--sunset); }
    .profile-menu__name { font-family: var(--display-font); font-weight: 700; font-size: 1.1rem; color: #fff; line-height: 1.1; }
    .profile-menu__email { font-size: .8rem; color: rgba(255, 255, 255, .75); word-break: break-all; }

    .profile-menu .dropdown-item {
        display: flex; align-items: center; gap: .75rem; width: 100%;
        padding: .75rem 1.15rem; font-size: .92rem; font-weight: 500; color: var(--ink);
    }
    .profile-menu .dropdown-item i { font-size: 1.2rem; color: var(--navy-soft); }
    .profile-menu .dropdown-item:hover { background: var(--sky-soft); color: var(--navy-deep); }
    .profile-menu .dropdown-item.is-danger, .profile-menu .dropdown-item.is-danger i { color: var(--red); }
    .profile-menu .dropdown-item.is-danger:hover { background: var(--red); color: #fff; }
    .profile-menu .dropdown-item.is-danger:hover i { color: #fff; }
    .profile-menu .dropdown-divider { margin: 0; border-color: var(--line); }

    @media (max-width: 991.98px) {
        .topbar { left: 0; }
    }

    @media (max-width: 575.98px) {
        .topbar { padding: 0 1rem; }
        .topbar__page { font-size: 1.15rem; }
        .role-chip, .site-link span { display: none; }
        .site-link { padding: .5rem; }
    }
</style>

<header class="topbar">

    <div class="topbar__left">
        <button type="button" class="topbar__toggle d-lg-none" id="sidebarToggle" aria-label="Open menu">
            <i class='bx bx-menu'></i>
        </button>

        <div class="topbar__crumbs">
            <div class="topbar__app">EnglishTraveller</div>
            <div class="topbar__page">@yield('title', 'Dashboard')</div>
        </div>
    </div>

    <div class="topbar__right">

        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="site-link" title="Open the live website">
            <i class='bx bx-link-external'></i> <span>View site</span>
        </a>

        @if($roleLabel)
            <span class="role-chip"><i class='bx bx-shield-quarter'></i> {{ $roleLabel }}</span>
        @endif

        <!-- Profile dropdown -->
        <div class="dropdown">
            <button class="profile-btn dropdown-toggle" type="button" id="profileDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open profile menu">
                <img src="{{ $adminUser->profile_image ?? asset('images/avatar5.png') }}" alt="Profile">
            </button>

            <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                <li class="profile-menu__head">
                    <img src="{{ $adminUser->profile_image ?? asset('images/avatar5.png') }}" alt="">
                    <div>
                        <div class="profile-menu__name">{{ $adminUser->name ?? '' }}</div>
                        <div class="profile-menu__email">{{ $adminUser->email ?? '' }}</div>
                    </div>
                </li>

                <li>
                    <a class="dropdown-item" href="#"><i class='bx bx-key'></i> Change password</a>
                </li>

                {{-- <li><a class="dropdown-item" href="{{ route('forgot.password.form') }}"><i class='bx bx-lock-open'></i> Forgot password</a></li> --}}

                @if($adminUser?->role === 'admin')
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                            <i class='bx bx-user-plus'></i> Add user
                        </a>
                    </li>
                @endif

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf
                        @method('delete')
                        <button class="dropdown-item is-danger border-0 bg-transparent" type="submit">
                            <i class='bx bx-log-out'></i> Log out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</header>