@php
    use Illuminate\Support\Facades\DB;

    // Active NEW blogs only
    $blogCount = DB::table('blogs')
        ->join('categories', 'blogs.category_id', '=', 'categories.id')
        ->where('blogs.is_draft', 0)
        ->whereNull('blogs.deleted_at')
        ->where('categories.slug', '!=', 'old-blog')
        ->count();

    // Draft blogs
    $draftCount = DB::table('blogs')
        ->where('is_draft', 1)
        ->whereNull('deleted_at')
        ->count();

    // Trash blogs
    $trashCount = DB::table('blogs')
        ->whereNotNull('deleted_at')
        ->count();

    $isAdmin = auth('admin')->user()?->role === 'admin';
@endphp

<nav class="side" id="nav-bar" aria-label="Main navigation">

    <a href="{{ route('admin.dashboard') }}" class="side__brand">
        <span class="side__brand-mark"><i class='bx bxs-plane-alt'></i></span>
        <span class="side__brand-text">
            <span class="side__brand-name">EnglishTraveller</span>
            <span class="side__brand-sub">Admin panel</span>
        </span>
    </a>

    {{-- The menu is drawn as a flight route: each page is a stop on the dashed line --}}
    <div class="side__scroll">

        <a href="{{ route('admin.dashboard') }}"
           class="nav_link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav_stop"><i class='bx bx-home-alt'></i></span>
            <span class="nav_name">Home</span>
        </a>

        <a href="{{ route('admin.blogs.index') }}"
           class="nav_link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
            <span class="nav_stop"><i class='bx bx-news'></i></span>
            <span class="nav_name">Blog</span>
            @if($blogCount > 0)
                <span class="nav_count">{{ $blogCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.categories.listCategory') }}"
           class="nav_link {{ request()->routeIs('admin.categories.listCategory') ? 'active' : '' }}">
            <span class="nav_stop"><i class='bx bx-category'></i></span>
            <span class="nav_name">Category</span>
        </a>

        <a href="{{ route('admin.subcategories.list') }}"
           class="nav_link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
            <span class="nav_stop"><i class='bx bx-purchase-tag-alt'></i></span>
            <span class="nav_name">Subcategory</span>
        </a>

        <a href="{{ route('admin.blogs.drafts') }}"
           class="nav_link {{ request()->routeIs('admin.blogs.drafts') ? 'active' : '' }}">
            <span class="nav_stop"><i class='bx bx-edit-alt'></i></span>
            <span class="nav_name">Draft</span>
            @if($draftCount > 0)
                <span class="nav_count">{{ $draftCount }}</span>
            @endif
        </a>

        @if($isAdmin)
            <div class="side__group">Administration</div>

            <a href="{{ route('admin.blogs.trash') }}"
               class="nav_link {{ request()->routeIs('admin.blogs.trash') ? 'active' : '' }}">
                <span class="nav_stop"><i class='bx bx-trash'></i></span>
                <span class="nav_name">Trash</span>
                @if($trashCount > 0)
                    <span class="nav_count nav_count--alert">{{ $trashCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav_link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="nav_stop"><i class='bx bx-user'></i></span>
                <span class="nav_name">Users</span>
            </a>

            <a href="{{ route('admin.blogs.old') }}"
               class="nav_link {{ request()->routeIs('admin.blogs.old') ? 'active' : '' }}">
                <span class="nav_stop"><i class='bx bx-archive'></i></span>
                <span class="nav_name">Old blogs</span>
            </a>
        @endif

    </div>

    <div class="side__foot">
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="m-0">
            @csrf
            @method('delete')
            <button type="submit" class="side__logout">
                <i class='bx bx-log-out'></i> Log out
            </button>
        </form>
    </div>

</nav>

<style>
    .side {
        --stop: 36px;                         /* diameter of each stop on the route */
        --pad: 1rem;                          /* left padding of the route */
        position: relative;
        height: 100%;
        display: flex; flex-direction: column;
        color: #fff;
        overflow: hidden;
        background:
            radial-gradient(1.2px 1.2px at 18% 12%, rgba(255, 255, 255, .55) 50%, transparent 51%),
            radial-gradient(1px 1px at 72% 24%, rgba(255, 255, 255, .4) 50%, transparent 51%),
            radial-gradient(1px 1px at 38% 58%, rgba(255, 255, 255, .35) 50%, transparent 51%),
            radial-gradient(1.2px 1.2px at 84% 74%, rgba(255, 255, 255, .45) 50%, transparent 51%),
            radial-gradient(120% 60% at 100% 100%, rgba(156, 96, 55, .35), transparent 60%),
            linear-gradient(180deg, var(--navy-mid), var(--navy-deep) 55%, #1f281e);
        box-shadow: 4px 0 22px rgba(0, 0, 0, .3);
    }

    /* ---------- Brand ---------- */
    .side__brand {
        display: flex; align-items: center; gap: .75rem;
        padding: 1.1rem var(--pad) 1.1rem var(--pad);
        border-bottom: 1px dashed rgba(181, 201, 173, .3);
        text-decoration: none; color: #fff;
    }
    .side__brand-mark {
        width: 44px; height: 44px; flex-shrink: 0; display: grid; place-items: center;
        border-radius: 50%; font-size: 1.6rem; color: #fff;
        background: linear-gradient(135deg, var(--sunset), #c98a5c);
        box-shadow: 0 0 0 4px rgba(156, 96, 55, .22);
    }
    .side__brand-mark i { transform: rotate(45deg); transition: transform .5s ease; }
    .side__brand:hover .side__brand-mark i { transform: rotate(90deg); }
    .side__brand-text { display: flex; flex-direction: column; line-height: 1.1; }
    .side__brand-name { font-family: var(--display-font); font-weight: 700; font-size: 1.25rem; }
    .side__brand-sub { font-size: .78rem; color: rgba(255, 255, 255, .6); margin-top: .2rem; }

    /* ---------- Route ---------- */
    .side__scroll {
        position: relative;
        flex: 1; overflow-y: auto; overflow-x: hidden;
        padding: 1.1rem .7rem 1rem var(--pad);
        display: flex; flex-direction: column; gap: .35rem;
        scrollbar-width: thin; scrollbar-color: rgba(255, 255, 255, .2) transparent;
    }
    /* the dashed flight path that every stop sits on */
    .side__scroll::before {
        content: ""; position: absolute;
        left: calc(var(--pad) + var(--stop) / 2 - 1px);
        top: 1.6rem; bottom: 1rem;
        border-left: 2px dashed rgba(181, 201, 173, .4);
    }

    .side__group {
        position: relative;
        margin: .9rem 0 .2rem calc(var(--stop) + .8rem);
        font-size: .78rem; font-weight: 600; color: var(--sky-bright);
    }

    .side .nav_link {
        position: relative;
        display: flex; align-items: center; gap: .8rem;
        padding: .2rem .8rem .2rem 0;
        border-radius: 999px;
        color: rgba(255, 255, 255, .78);
        font-weight: 500; font-size: .95rem; text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }
    .side .nav_link:hover { color: #fff; background: rgba(181, 201, 173, .1); }
    .side .nav_link:focus-visible { outline: 2px solid var(--sky-bright); outline-offset: 2px; }

    .side .nav_stop {
        width: var(--stop); height: var(--stop); flex-shrink: 0;
        display: grid; place-items: center; border-radius: 50%;
        font-size: 1.2rem; color: var(--sky-bright);
        background: var(--navy-mid);
        border: 2px solid rgba(181, 201, 173, .45);
        transition: background .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease;
    }
    .side .nav_link:hover .nav_stop { border-color: var(--sky-bright); color: #fff; }

    /* active stop = where the plane currently is */
    .side .nav_link.active { color: #fff; font-weight: 600; background: rgba(156, 96, 55, .14); }
    .side .nav_link.active .nav_stop {
        background: var(--sunset); border-color: var(--sunset-bright); color: #fff;
        box-shadow: 0 0 0 5px rgba(156, 96, 55, .22);
    }

    .nav_count {
        margin-left: auto;
        min-width: 26px; padding: .15rem .5rem; text-align: center;
        border-radius: 999px; background: var(--sky); color: #fff;
        font-family: var(--mono-font); font-size: .72rem; font-weight: 700;
    }
    .nav_count--alert { background: var(--red); }

    /* ---------- Footer ---------- */
    .side__foot { padding: 1rem var(--pad); border-top: 1px dashed rgba(181, 201, 173, .3); }
    .side__logout {
        width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem;
        padding: .65rem; border: 1px solid rgba(255, 138, 128, .5); border-radius: .6rem;
        background: transparent; color: #ffb0a8; font-weight: 600;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }
    .side__logout i { font-size: 1.2rem; }
    .side__logout:hover { background: var(--red); border-color: var(--red); color: #fff; }
    .side__logout:focus-visible { outline: 2px solid var(--sky-bright); outline-offset: 2px; }

    @media (prefers-reduced-motion: reduce) {
        .side *, .side *::after { transition: none !important; }
    }
</style>