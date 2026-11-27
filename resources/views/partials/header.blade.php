<header class="main-header">
    <div class="container">

        <!-- ==============================
             TOP NAVBAR
        =============================== -->
        <nav class="navbar navbar-expand-lg">

            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/Group (1).png') }}"
                     alt="English Traveller Logo">
            </a>


            <!-- ==============================
                 MOBILE ACTIONS
            =============================== -->
            <div class="mobile-header-actions">

                <!-- Mobile Search Icon -->
                <button type="button"
                        class="mobile-search-toggle"
                        id="mobileSearchToggle"
                        aria-label="Search"
                        aria-expanded="false"
                        aria-controls="mobileSearchWrapper">

                    <!-- Lightweight SVG Search Icon -->
                    <svg width="22"
                         height="22"
                         viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">

                        <circle cx="11"
                                cy="11"
                                r="7"
                                stroke="currentColor"
                                stroke-width="2"/>

                        <path d="M20 20L16.65 16.65"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"/>
                    </svg>

                </button>


                <!-- Hamburger -->
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav"
                        aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation">

                    <span class="navbar-toggler-icon"></span>

                </button>

            </div>


            <!-- ==============================
                 NAVIGATION
            =============================== -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mx-auto">

                    @foreach ($categories as $category)

                        @if ($category->subcategories->count())

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle"
                                   href="{{ route('categoryblogs', ['cate_subcate' => $category->subcategories->first()->slug]) }}"
                                   id="dropdown-{{ $category->slug }}"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">

                                    {{ $category->name }}

                                </a>


                                <ul class="dropdown-menu"
                                    aria-labelledby="dropdown-{{ $category->slug }}">

                                    @foreach ($category->subcategories as $subcategory)

                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('categoryblogs', ['cate_subcate' => $subcategory->slug]) }}">

                                                {{ $subcategory->name }}

                                            </a>
                                        </li>

                                    @endforeach

                                </ul>

                            </li>

                        @else

                            <li class="nav-item">

                                <a class="nav-link"
                                   href="{{ route('categoryblogs', ['cate_subcate' => $category->slug]) }}">

                                    {{ $category->name }}

                                </a>

                            </li>

                        @endif

                    @endforeach

                </ul>


                <!-- ==============================
                     DESKTOP SEARCH
                =============================== -->
                <form action="{{ route('search') }}"
                      method="GET"
                      class="header-search desktop-search"
                      autocomplete="off">

                    <input type="text"
                           name="q"
                           id="desktopSearchInput"
                           placeholder="Search..."
                           value="{{ request('q') }}"
                           aria-label="Search">

                    <button type="submit"
                            aria-label="Search">

                        <!-- Lightweight SVG Search Icon -->
                        <svg width="20"
                             height="20"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg"
                             aria-hidden="true">

                            <circle cx="11"
                                    cy="11"
                                    r="7"
                                    stroke="currentColor"
                                    stroke-width="2"/>

                            <path d="M20 20L16.65 16.65"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"/>

                        </svg>

                    </button>


                    <!-- Live Search Results -->
                    <div class="search-dropdown"
                         id="desktopSearchDropdown">
                    </div>

                </form>


                <!-- ==============================
                     PHONE
                =============================== -->
                <a href="tel:+18444263868"
                   class="phone-btn">

                    <img src="{{ asset('images/call-calling.png') }}"
                         alt=""
                         class="phone-icon"
                         width="20"
                         height="20">

                    +1-844-426-3868

                </a>

            </div>

        </nav>


        <!-- ==============================
             MOBILE SEARCH
        =============================== -->
        <div class="mobile-search-wrapper"
             id="mobileSearchWrapper">

            <form action="{{ route('search') }}"
                  method="GET"
                  class="mobile-search-form"
                  autocomplete="off">

                <input type="text"
                       name="q"
                       id="mobileSearchInput"
                       placeholder="Search..."
                       value="{{ request('q') }}"
                       aria-label="Search">

                <button type="submit"
                        aria-label="Search">

                    <!-- Lightweight SVG Search Icon -->
                    <svg width="20"
                         height="20"
                         viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">

                        <circle cx="11"
                                cy="11"
                                r="7"
                                stroke="currentColor"
                                stroke-width="2"/>

                        <path d="M20 20L16.65 16.65"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"/>

                    </svg>

                </button>


                <!-- Live Search Results -->
                <div class="search-dropdown"
                     id="mobileSearchDropdown">
                </div>

            </form>

        </div>

    </div>
</header>


<!-- =====================================================
     HEADER CSS
====================================================== -->
<style>

    /* =========================================
       DESKTOP SEARCH
    ========================================= */

    .header-search {
        display: flex;
        align-items: center;
        position: relative;

        width: 170px;
        height: 40px;

        margin-right: 20px;

        border: 1px solid #ddd;
        border-radius: 30px;

        overflow: visible;
        background: #fff;
    }


    .header-search input {
        flex: 1;
        min-width: 0;

        width: 100%;
        height: 40px;

        border: none;
        outline: none;

        padding: 0 15px;

        font-size: 14px;

        background: transparent;
    }


    .header-search button {
        width: 42px;
        height: 40px;

        flex-shrink: 0;

        padding: 0;

        border: none;
        background: transparent;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #8B4513;
    }


    .header-search button svg {
        display: block;
        flex-shrink: 0;
    }


    /* =========================================
       MOBILE ACTIONS
    ========================================= */

    .mobile-header-actions {
        display: none;
    }


    /* =========================================
       MOBILE SEARCH
       HIDDEN BY DEFAULT
    ========================================= */

    .mobile-search-wrapper {
        display: none;

        opacity: 0;

        transform: translateY(-6px);

        transition:
            opacity 0.2s ease,
            transform 0.2s ease;
    }


    .mobile-search-wrapper.active {
        display: block;

        opacity: 1;

        transform: translateY(0);
    }


    /* =========================================
       LIVE SEARCH DROPDOWN
    ========================================= */

    .search-dropdown {
        display: none;

        position: absolute;

        top: calc(100% + 5px);

        left: 0;
        right: 0;

        width: 100%;

        background: #fff;

        border: 1px solid #eee;

        border-radius: 10px;

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.08);

        max-height: 320px;

        overflow-y: auto;

        z-index: 9999;

        text-align: left;
    }


    .search-dropdown.active {
        display: block;
    }


    .search-dropdown-item {
        display: flex;

        align-items: center;

        gap: 10px;

        padding: 10px 14px;

        text-decoration: none;

        color: #333;

        font-size: 14px;

        border-bottom: 1px solid #f2f2f2;
    }


    .search-dropdown-item:last-child {
        border-bottom: none;
    }


    .search-dropdown-item:hover {
        background: #f9f9f9;
    }


    .search-dropdown-item img {
        width: 36px;
        height: 36px;

        object-fit: cover;

        border-radius: 6px;

        flex-shrink: 0;
    }


    .search-dropdown-empty,
    .search-dropdown-loading {
        padding: 12px 14px;

        font-size: 14px;

        color: #999;
    }


    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 991px) {

        /* Navbar */

        .navbar {
            width: 100%;

            display: flex;

            align-items: center;
        }


        /* Mobile Logo + Search + Hamburger */

        .mobile-header-actions {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-left: auto;
        }


        /* =====================================
           MOBILE SEARCH BUTTON
        ===================================== */

        .mobile-search-toggle {
            display: flex;

            align-items: center;

            justify-content: center;

            width: 42px;
            height: 42px;

            padding: 0;

            border: none;

            background: transparent;

            color: #fff;

            font-size: 24px;

            cursor: pointer;
        }


        .mobile-search-toggle svg {
            display: block;

            flex-shrink: 0;
        }


        /* =====================================
           HAMBURGER
        ===================================== */

        .navbar-toggler {
            width: 42px;
            height: 42px;

            padding: 5px;

            border: 1px solid #ddd;

            border-radius: 6px;
        }


        /* =====================================
           HIDE DESKTOP SEARCH
        ===================================== */

        .desktop-search {
            display: none !important;
        }


        /* =====================================
           MOBILE SEARCH WRAPPER
        ===================================== */

        .mobile-search-wrapper {
            width: 100%;

            padding: 10px 0 12px;
        }


        /* =====================================
           MOBILE SEARCH FORM
        ===================================== */

        .mobile-search-form {
            position: relative;

            display: flex;

            align-items: center;

            width: 100%;
            height: 44px;

            border: 1px solid #ddd;

            border-radius: 25px;

            overflow: visible;

            background: #fff;
        }


        /* Input */

        .mobile-search-form input {
            flex: 1;

            width: 100%;
            height: 44px;

            padding: 0 15px;

            border: none;

            outline: none;

            font-size: 15px;

            background: #fff;
            
                    border-radius: 20px;
        }


        .mobile-search-form input::placeholder {
            color: #999;
        }


        /* Search Button */

        .mobile-search-form button {
            width: 45px;
            height: 44px;

            flex-shrink: 0;

            padding: 0;

            border: none;

            background: transparent;

            color: #8B4513;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .mobile-search-form button svg {
            display: block;

            flex-shrink: 0;
        }


        /* Navbar Menu */

        .navbar-collapse {
            width: 100%;

            flex-basis: 100%;
        }

    }


    /* =========================================
       HOVER REVEAL
       MOUSE / TRACKPAD ONLY
    ========================================= */

    @media (max-width: 991px)
    and (hover: hover)
    and (pointer: fine) {

        .container:has(.mobile-search-toggle:hover)
        .mobile-search-wrapper,

        .container:has(.mobile-search-wrapper:hover)
        .mobile-search-wrapper {

            display: block;

            opacity: 1;

            transform: translateY(0);
        }

    }


    /* =========================================
       SMALL MOBILE
    ========================================= */

    @media (max-width: 576px) {

        .mobile-header-actions {
            gap: 4px;
        }


        .mobile-search-toggle {
            width: 40px;
            height: 40px;

            font-size: 22px;
        }


        .navbar-toggler {
            width: 40px;
            height: 40px;
        }


        .mobile-search-wrapper {
            padding-top: 8px;
        }

    }

</style>


<!-- =====================================================
     HEADER JAVASCRIPT
====================================================== -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================
       MOBILE SEARCH TOGGLE
    ========================================= */

    var toggleBtn =
        document.getElementById('mobileSearchToggle');

    var searchWrapper =
        document.getElementById('mobileSearchWrapper');


    if (toggleBtn && searchWrapper) {

        toggleBtn.addEventListener('click', function () {

            var isActive =
                searchWrapper.classList.toggle('active');

            toggleBtn.setAttribute(
                'aria-expanded',
                isActive ? 'true' : 'false'
            );

        });


        /* Close mobile search when clicking outside */

        document.addEventListener('click', function (e) {

            if (
                !searchWrapper.contains(e.target) &&
                !toggleBtn.contains(e.target)
            ) {

                searchWrapper.classList.remove('active');

                toggleBtn.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        });

    }


    /* =========================================
       LIVE SEARCH
    ========================================= */

    var ajaxSearchUrl =
        '{{ route('search.ajax') }}';


    /* =========================================
       ESCAPE HTML
    ========================================= */

    function escapeHtml(str) {

        var div =
            document.createElement('div');

        div.textContent = str;

        return div.innerHTML;
    }


    /* =========================================
       RENDER SEARCH RESULTS
    ========================================= */

    function renderDropdown(blogs, dropdown) {

        if (!blogs || !blogs.length) {

            dropdown.innerHTML =
                '<div class="search-dropdown-empty">' +
                'No results found' +
                '</div>';

            dropdown.classList.add('active');

            return;
        }


        dropdown.innerHTML =
            blogs.map(function (blog) {

                return '' +

    '<a href="' +
    escapeHtml(blog.url) +
    '" class="search-dropdown-item">' +

    '<span>' +
    escapeHtml(blog.title) +
    '</span>' +

    '</a>';

            }).join('');


        dropdown.classList.add('active');
    }


    /* =========================================
       INITIALIZE LIVE SEARCH
    ========================================= */

    function initLiveSearch(inputId, dropdownId) {

        var input =
            document.getElementById(inputId);

        var dropdown =
            document.getElementById(dropdownId);


        if (!input || !dropdown) {
            return;
        }


        var debounceTimer = null;

        var currentController = null;


        /* =====================================
           INPUT EVENT
        ===================================== */

        input.addEventListener('input', function () {

            clearTimeout(debounceTimer);


            var q =
                this.value.trim();


            /* Don't search for less than 2 characters */

            if (q.length < 2) {

                dropdown.innerHTML = '';

                dropdown.classList.remove('active');

                return;
            }


            /* Loading */

            dropdown.innerHTML =
                '<div class="search-dropdown-loading">' +
                'Searching...' +
                '</div>';

            dropdown.classList.add('active');


            /* Debounce */

            debounceTimer = setTimeout(function () {


                /* Cancel previous request */

                if (currentController) {

                    currentController.abort();

                }


                currentController =
                    new AbortController();


                /* AJAX Request */

                fetch(
                    ajaxSearchUrl +
                    '?q=' +
                    encodeURIComponent(q),
                    {
                        signal:
                            currentController.signal,

                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json'
                        }
                    }
                )

                .then(function (res) {

                    if (!res.ok) {

                        throw new Error(
                            'Request failed with status ' +
                            res.status
                        );

                    }

                    return res.json();

                })

                .then(function (data) {

                    renderDropdown(
                        data,
                        dropdown
                    );

                })

                .catch(function (err) {

                    /* Ignore cancelled requests */

                    if (
                        err.name ===
                        'AbortError'
                    ) {
                        return;
                    }


                    console.error(
                        'Live search error:',
                        err
                    );


                    dropdown.innerHTML =
                        '<div class="search-dropdown-empty">' +
                        'Something went wrong' +
                        '</div>';


                    dropdown.classList.add(
                        'active'
                    );

                });

            }, 300);

        });


        /* =====================================
           FOCUS
        ===================================== */

        input.addEventListener('focus', function () {

            if (
                dropdown.innerHTML.trim() !== '' &&
                this.value.trim().length >= 2
            ) {

                dropdown.classList.add('active');

            }

        });


        /* =====================================
           CLOSE DROPDOWN
        ===================================== */

        document.addEventListener('click', function (e) {

            if (
                !input.contains(e.target) &&
                !dropdown.contains(e.target)
            ) {

                dropdown.classList.remove('active');

            }

        });

    }


    /* =========================================
       INITIALIZE DESKTOP SEARCH
    ========================================= */

    initLiveSearch(
        'desktopSearchInput',
        'desktopSearchDropdown'
    );


    /* =========================================
       INITIALIZE MOBILE SEARCH
    ========================================= */

    initLiveSearch(
        'mobileSearchInput',
        'mobileSearchDropdown'
    );

});

</script>
