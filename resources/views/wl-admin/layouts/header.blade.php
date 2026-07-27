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
    --body-font: 'Inter', sans-serif;
    --display-font: 'Big Shoulders Display', sans-serif;
    --mono-font: 'Space Mono', monospace;
}

body {
    font-family: var(--body-font);
}

/* Navbar */
.navbar {
    height: 70px;
    padding: 0 2rem;
    background: linear-gradient(90deg, var(--navy-mid), var(--navy-deep) 85%);
    background-image:
        linear-gradient(90deg, var(--navy-mid), var(--navy-deep) 85%),
        radial-gradient(1px 1px at 15% 30%, rgba(255, 255, 255, .16) 50%, transparent 51%),
        radial-gradient(1px 1px at 60% 60%, rgba(255, 255, 255, .12) 50%, transparent 51%),
        radial-gradient(1px 1px at 85% 20%, rgba(255, 255, 255, .1) 50%, transparent 51%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, .3);
    border-bottom: 1px dashed rgba(246, 241, 228, .18);
}

/* Navbar brand */
.navbar-brand {
    font-family: var(--display-font);
    font-weight: 800;
    letter-spacing: .02em;
    text-transform: uppercase;
    font-size: 1.4rem;
    color: var(--paper) !important;
}

/* Profile button */
.profile-btn img {
    width: 46px;
    height: 46px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid var(--brass);
    transition: all .3s ease;
}

.profile-btn img:hover {
    transform: scale(1.08);
    box-shadow: 0 0 12px rgba(201, 162, 106, .6);
    border-color: var(--brass-bright);
}

/* Dropdown menu */
.dropdown-menu {
    min-width: 250px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(22, 35, 43, .1);
    box-shadow: 0 10px 28px rgba(11, 29, 38, .22);
    padding: 0;
    animation: fadeIn .25s ease;
    background: #fffdf8;
}

/* Fade-in animation for dropdown */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-8px);}
    to {opacity: 1; transform: translateY(0);}
}

/* Admin info */
.dropdown-menu .admin-info {
    background-color: var(--navy-deep);
    padding: 16px 20px;
    font-size: .92rem;
    color: var(--paper);
    text-align: left;
    border-bottom: 1px dashed rgba(246, 241, 228, .2);
}

.dropdown-menu .admin-info b {
    color: var(--brass-bright);
    font-family: var(--display-font);
    letter-spacing: .01em;
}

/* Dropdown items */
.dropdown-menu .dropdown-item {
    padding: 12px 20px;
    transition: all .2s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .92rem;
    font-weight: 500;
    color: var(--ink);
}

.dropdown-menu .dropdown-item i {
    font-size: 1.05rem;
    color: var(--navy-soft);
    width: 18px;
    text-align: center;
}

/* Hover effect */
.dropdown-menu .dropdown-item:hover {
    background: var(--brass);
    color: var(--navy-deep);
    border-radius: 8px;
}

.dropdown-menu .dropdown-item:hover i {
    color: var(--navy-deep);
}

/* Divider spacing */
.dropdown-divider {
    margin: 0;
    border-color: rgba(22, 35, 43, .1);
}

/* Logout button */
.dropdown-menu .text-danger {
    color: #c1443b !important;
}

.dropdown-menu .text-danger i {
    color: #c1443b !important;
}

.dropdown-menu .text-danger:hover {
    background-color: #c1443b !important;
    color: #fff !important;
    border-radius: 8px;
}

.dropdown-menu .text-danger:hover i {
    color: #fff !important;
}

</style>

<!-- Icons (optional, for dropdown icons) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<nav class="navbar d-flex justify-content-between align-items-center">
    <span class="navbar-brand">
    @if(auth('admin')->check() && auth('admin')->user()->role === 'admin')
        Admin EnglishTraveller Dashboard
    @elseif(auth('admin')->check() && auth('admin')->user()->role === 'user')
        User EnglishTraveller Dashboard
    @else
        EnglishTraveller Dashboard
    @endif
    </span>

    <!-- Profile dropdown -->
    <div class="dropdown">
        <button class="btn p-0 border-0 bg-transparent dropdown-toggle profile-btn" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ auth('admin')->user()->profile_image ?? asset('images/avatar5.png') }}" alt="Profile">
        </button>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <!-- Admin info -->
            <li class="admin-info">
                <b>{{ auth('admin')->user()->name ?? '' }}</b><br>
                {{ auth('admin')->user()->email ?? '' }}
            </li>

            <!-- Actions -->
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-key"></i> Change Password</a></li>
            {{-- <li><a class="dropdown-item" href="{{ route('forgot.password.form') }}"><i class="fa-solid fa-lock-open"></i> Forgot Password</a></li> --}}
            @if(auth('admin')->user()?->role === 'admin')
                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-user-plus"></i> Add User</a></li>
                <li><hr class="dropdown-divider"></li>
            @endif

            <!-- Logout -->
            <li>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="dropdown-item text-danger w-100 border-0 bg-transparent" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>

