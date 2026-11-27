{{-- @php
    use Illuminate\Support\Facades\DB;

    $trashCount = DB::table('blogs')->whereNotNull('deleted_at')->count();
    $draftCount = DB::table('blogs')->where('is_draft', 1)->whereNull('deleted_at')->count();
@endphp --}}

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
@endphp



<nav class="l-navbar show" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="nav_logo">
                <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">Admin Panel</span>
            </a>
            <div class="nav_list">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav_link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class='bx bx-grid-alt nav_icon'></i>
                    <span class="nav_name">Home</span>
                </a>
                
                
<a href="{{ route('admin.blogs.index') }}"
    class="nav_link {{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">

    <i class='bx bx-plus-circle nav_icon'></i>

    <span class="nav_name">Blog</span>

    @if($blogCount > 0)
        <span class="badge">{{ $blogCount }}</span>
    @endif

</a>



                <a href="{{ route('admin.categories.listCategory') }}"
                    class="nav_link {{ request()->routeIs('admin.categories.listCategory') ? 'active' : '' }}">
                    <i class='bx bx-category nav_icon'></i>
                    <span class="nav_name">Category</span>
                </a>

                <a href="{{ route('admin.subcategories.list') }}"
                    class="nav_link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
                    <i class='bx bx-purchase-tag-alt nav_icon'></i>
                    <span class="nav_name">Subcategory</span>
                </a>

              <a href="{{ route('admin.blogs.drafts') }}"
    class="nav_link {{ request()->routeIs('admin.blogs.drafts') ? 'active' : '' }}">

    <i class='bx bx-pencil nav_icon'></i>

    <span class="nav_name">Draft</span>

    @if($draftCount > 0)
        <span class="badge">{{ $draftCount }}</span>
    @endif

</a>


             @if(auth('admin')->user()?->role === 'admin')

    <a href="{{ route('admin.blogs.trash') }}"
        class="nav_link {{ request()->routeIs('admin.blogs.trash') ? 'active' : '' }}">

        <i class='bx bx-trash nav_icon'></i>

        <span class="nav_name">Trash</span>

        @if($trashCount > 0)
            <span class="badge">{{ $trashCount }}</span>
        @endif

    </a>

@endif

                @if(auth('admin')->user()?->role === 'admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="nav_link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Users</span>
                    </a>
                @endif
                
                @if(auth('admin')->user()?->role === 'admin')
     <a href="{{ route('admin.blogs.old') }}"
        class="nav_link {{ request()->routeIs('admin.blogs.old') ? 'active' : '' }}">
        <i class='bx bx-folder nav_icon'></i>
        <span class="nav_name">Old Blogs</span>
    </a>
@endif


            </div>
        </div>
        <div class="nav_bottom">
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </nav>
</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;800&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap");

    :root {
        --navy-deep: #0b1d26;
        --navy-mid: #142f3d;
        --navy-soft: #1d3f50;
        --brass: #c9a26a;
        --brass-bright: #e7c68c;
        --paper: #f6f1e4;
        --ink: #16232b;
        --ink-soft: #5b6b74;

        --header-height: 3rem;
        --nav-width: 250px;
        --white-color: #f7f6fb;
        --body-font: 'Inter', sans-serif;
        --display-font: 'Big Shoulders Display', sans-serif;
        --mono-font: 'Space Mono', monospace;
        --normal-font-size: 1rem;
        --z-fixed: 100;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        background-color: var(--paper);
    }

    /* ===========================================================
       SIDEBAR
    ============================================================ */
    .l-navbar {
        position: relative;
        width: 100%;
        height: 100vh;
        background: linear-gradient(180deg, var(--navy-mid), var(--navy-deep) 85%);
        background-image:
            linear-gradient(180deg, var(--navy-mid), var(--navy-deep) 85%),
            radial-gradient(1px 1px at 20% 15%, rgba(255, 255, 255, .18) 50%, transparent 51%),
            radial-gradient(1px 1px at 70% 40%, rgba(255, 255, 255, .14) 50%, transparent 51%),
            radial-gradient(1px 1px at 40% 70%, rgba(255, 255, 255, .12) 50%, transparent 51%);
        padding: 1rem 0.5rem;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.35);
        transition: left .3s ease;
    }

    .nav {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    /* ---------- Logo ---------- */
    .nav_logo {
        display: flex;
        align-items: center;
        color: var(--paper);
        font-family: var(--display-font);
        font-weight: 800;
        letter-spacing: .02em;
        text-transform: uppercase;
        font-size: 1.3rem;
        padding: 1rem;
        border-bottom: 1px dashed rgba(246, 241, 228, .18);
        margin-bottom: .5rem;
        transition: transform .3s ease;
    }

    .nav_logo:hover {
        transform: translateX(3px);
    }

    .nav_logo-icon {
        font-size: 1.8rem;
        margin-right: 0.6rem;
        color: var(--brass-bright);
        transition: transform .4s ease;
    }

    .nav_logo:hover .nav_logo-icon {
        transform: rotate(-12deg) scale(1.1);
    }

    /* ---------- Links ---------- */
    .nav_list {
        display: flex;
        flex-direction: column;
        gap: .2rem;
        margin-top: .5rem;
    }

    .nav_link {
        display: flex;
        align-items: center;
        color: rgba(246, 241, 228, .75);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: .95rem;
        position: relative;
        overflow: hidden;
        transition: color .25s ease, background .25s ease, transform .25s ease;
    }

    .nav_link::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0%;
        background: var(--brass-bright);
        border-radius: 0 3px 3px 0;
        transition: height .25s ease;
    }

    .nav_link:hover {
        background: rgba(201, 162, 106, .12);
        color: var(--paper);
        transform: translateX(4px);
    }

    .nav_link:hover::before {
        height: 60%;
    }

    .nav_link.active {
        background: rgba(201, 162, 106, .16);
        color: var(--brass-bright);
        box-shadow: inset 0 0 0 1px rgba(201, 162, 106, .25);
    }

    .nav_link.active::before {
        height: 70%;
    }

    .nav_icon {
        margin-right: 1rem;
        font-size: 1.25rem;
        transition: transform 0.3s ease;
    }

    .nav_link:hover .nav_icon,
    .nav_link.active .nav_icon {
        transform: scale(1.15);
    }

    .nav_name {
        font-size: .95rem;
    }

    .badge {
        margin-left: auto;
        background: var(--brass-bright);
        padding: 0.2rem 0.55rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-family: var(--mono-font);
        color: var(--navy-deep);
        font-weight: 700;
    }

    /* ---------- Bottom / Logout ---------- */
    .nav_bottom {
        margin-top: auto;
        padding: 1rem;
        border-top: 1px dashed rgba(246, 241, 228, .18);
    }

    .nav_bottom .btn-danger {
        background: #c1443b;
        border-color: #c1443b;
        border-radius: 0.5rem;
        padding: 0.6rem;
        font-weight: 600;
        letter-spacing: .01em;
        transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    }

    .nav_bottom .btn-danger:hover {
        background: #a83a32;
        border-color: #a83a32;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(193, 68, 59, .35);
    }

    .nav_bottom .btn-danger:active {
        transform: translateY(0) scale(.98);
    }

    /* ===========================================================
       RESPONSIVE
    ============================================================ */
    @media (max-width: 768px) {
        .l-navbar {
            left: -260px;
        }

        .l-navbar.show {
            left: 0;
        }
    }
</style>