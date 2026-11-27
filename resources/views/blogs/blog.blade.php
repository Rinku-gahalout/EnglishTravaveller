@extends('layouts.app')

@section('title', $category->meta_title ?? $category->name ?? 'Blog')

@section('meta_description', $category->meta_description ?? '')

@section('robots')
    @if($category->slug === 'old-blog')
        noindex, nofollow
    @else
        index, follow
    @endif
@endsection

@section('content')

<!-- =========================
     Banner
========================= -->

<section class="contact-banner">
    <div class="overlay">
        <div class="container">

            <h1>{{ $category->name ?? 'Blog' }}</h1>

        </div>
    </div>
</section>

<!-- =========================
     Banner CSS
========================= -->

<style>

.contact-banner {
    background-image: url("/images/et_blog_img_bg.webp");
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    height: 260px;
    position: relative;
}


.contact-banner .overlay {
    position: absolute;
    inset: 0;
    background: rgb(88 54 36 / 95%);
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.contact-banner .container {
    max-width: 1200px;
    width: 100%;
    padding: 0 20px;
}

.contact-banner h1 {
    font-size: 46px;
    color: #fff;
    font-weight: 500;
    margin-bottom: 0;
    line-height: 1;
}

.contact-banner h1 span {
    color: #d39a45;
    font-weight: 600;
}

.contact-banner p {
    color: #fff;
    font-size: 14px;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.6;
    opacity: .95;
}
</style>

<!-- =========================
     Blog Section
========================= -->

<div class="blog-container">

<!-- =========================
     Top Row: Breadcrumb (left) + Search (right)
========================= -->
<div class="blog-top-row">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="page-breadcrumb">
        <ol class="breadcrumb mb-0">

            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Home</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">
                {{ $category->name ?? 'Blog' }}
            </li>

        </ol>
    </nav>

    <!-- Search (filters blogs within this category/subcategory) -->
    <form action="{{ url()->current() }}" method="GET" class="search-box">
        <input
            type="text"
            name="q"
            id="blogSearch"
            placeholder="Search..."
            value="{{ $query ?? request('q') }}"
        >

        <button type="submit" aria-label="Search">
            <img
                src="{{ asset('images/Group 1597884477.png') }}"
                alt="Search"
            >
        </button>
    </form>

</div>


<!-- =========================
     Search Status
========================= -->
@if(!empty($query))
    <div class="search-status">
        Showing results for "<strong>{{ $query }}</strong>"
        <a href="{{ url()->current() }}" class="clear-search">Clear</a>
    </div>
@endif


<!-- =========================
     Category Description
     IMPORTANT:
     This is OUTSIDE #blogGrid
     so it will never duplicate
     during AJAX pagination.
     Hidden while a search filter is active.
========================= -->
@if(empty($query) && $category && $category->description)
    <div class="blog-category-description">
        {!! $category->description !!}
    </div>
@endif


<!-- =========================
     Blog Grid
========================= -->
@if($blogs->isEmpty())

    <p class="no-blogs-found">
        @if(!empty($query))
            No blogs found matching "{{ $query }}" in this category.
        @else
            No blogs found in this category yet.
        @endif
    </p>

@else

<div class="blog-grid" id="blogGrid">

@foreach($blogs as $blog)

    @php
        $categorySlug = $blog->subcategory?->slug ?? $blog->category?->slug;

        // Priority 1: blog_url, Priority 2: slug made from blog_heading
        $blogSlug = !empty($blog->blog_url)
            ? $blog->blog_url
            : \Illuminate\Support\Str::slug($blog->blog_heading);

        // Real publish date (falls back to created_at for old posts)
        $publishedOn = $blog->published_at ?? $blog->created_at;
    @endphp

    {{-- Safety net: skip only if a slug still can't be built --}}
    @continue(empty($categorySlug) || empty($blogSlug))

    <a href="{{ route('blogdetails', [
        'cate_subcate' => $categorySlug,
        'blog_slug'    => $blogSlug,
    ]) }}"
       class="blog-card-link">

        <div class="blog-card">

            <img
                src="{{ asset($blog->image) }}"
                alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
            >

            <div class="blog-content">

                <span class="publish-date">
                    Published on:
                    {{ $publishedOn->format('F d, Y') }}
                </span>

                <h3>{{ $blog->blog_heading }}</h3>

                <span class="read-more">Read More ↗</span>

            </div>

        </div>

    </a>

@endforeach

</div>


<!-- =========================
     View All Button
========================= -->
@if($blogs->hasMorePages())

    <div class="view-all-wrapper">
        <button
            type="button"
            id="viewAllBtn"
            class="view-all-btn"
            data-next="{{ $blogs->nextPageUrl() }}"
        >
            View All
        </button>
    </div>

@endif

@endif

</div>

<!-- =========================
     Blog CSS
========================= -->

<style>

.blog-container {
    max-width: 1200px;
    margin: 47px auto 85px;
    padding: 0 20px;
    position: relative;
    z-index: 2;
}


/* =========================
   Top Row (Breadcrumb + Search)
========================= */

.blog-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.page-breadcrumb .breadcrumb {
    background: transparent;
    margin: 0;
    padding: 0;
}

.page-breadcrumb .breadcrumb-item,
.page-breadcrumb .breadcrumb-item.active {
    color: #6C3F2A;
    font-size: 16px;
    font-weight: 500;
}

.page-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #999;
    padding: 0 10px;
}

.page-breadcrumb .breadcrumb-item a {
    color: #777;
    text-decoration: none;
    transition: color .3s ease;
}

.page-breadcrumb .breadcrumb-item a:hover {
    color: #A37437;
}


/* =========================
   Search
========================= */

.search-box {
    width: 300px;
    margin: 0;
    position: relative;
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 5px 10px;
    background: #2125291c;
}

.search-box input {
    border: none;
    outline: none;
    flex: 1;
    background: transparent;
    padding: 5px;
}

.search-box button {
    border: none;
    background: transparent;
    padding: 0;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.search-box button img {
    width: 20px;
    height: 20px;
}


/* =========================
   Search Status
========================= */

.search-status {
    text-align: center;
    margin-bottom: 30px;
    color: #555;
    font-size: 15px;
}

.search-status .clear-search {
    margin-left: 10px;
    color: #A37437;
    text-decoration: underline;
    font-size: 14px;
}

.no-blogs-found {
    text-align: center;
    padding: 60px 0;
    color: #777;
    font-size: 16px;
}


/* =========================
   Category Description
========================= */

.blog-category-description {
    width: 100%;
    margin-bottom: 35px;
    color: #555;
    font-size: 16px;
    line-height: 1.8;
}


/* =========================
   Blog Grid
========================= */

.blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 45px;
}


/* =========================
   Blog Card
========================= */
.blog-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.blog-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    /*border: 1px solid transparent;*/
    transition: .3s ease;
    padding: 20px;
}

.blog-card:hover {
    transform: translateY(-3px);
    border-color: #6C3F2A;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.blog-card img {
    width: 100%;
    height: 189px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.4s ease;
}

.blog-card:hover img {
    transform: scale(1.08);
}

.read-more {
    display: inline-block;
    color: #6C3F2A;
    text-decoration: none;
    border: 1px solid #C68542;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.read-more span {
    display: inline-block;
    position: relative;
    top: -1px;
    margin-left: 3px;
    transition: transform 0.3s ease;
}

.read-more:hover {
    background: #C68542;
    color: #fff;
    border-color: #C68542;
}

.read-more:hover .arrow {
    transform: translateX(3px);
}





/* =========================
   Blog Content
========================= */

.blog-content {
    padding: 12px 0;
}

.publish-date {
    display: block;
    color: #777;
    font-size: 14px;
    margin-bottom: 5px;
}

.blog-content h3 {
    font-size: 20px;
    line-height: 28px;
    font-weight: 700;
    margin: 6px 0 18px;
    color: #6C3F2A;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.blog-content p {
    color: #666;
    font-size: 15px;
    line-height: 24px;
    margin-bottom: 18px;

    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}


/* =========================
   Read More
========================= */

.blog-content a {
    display: inline-block;
    padding: 8px 18px;
    border: 1px solid #6c3f2a96;
    border-radius: 20px;
    color: #A37437;
    text-decoration: none;
    font-size: 16px;
    transition: .3s;
    font-weight: 700;
}

.blog-content a:hover {
    background: #b96d33;
    color: #fff;
}


/* =========================
   View All Button
========================= */

.view-all-wrapper {
    display: flex;
    justify-content: center;
    margin: 40px 0;
}

.view-all-btn {
    background: #6C3F2A;
    color: #fff;
    border: none;
    padding: 12px 35px;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    transition: .3s ease;
    min-width: 150px;
}

.view-all-btn:hover {
    background: #A37437;
}

.view-all-btn:disabled {
    opacity: .7;
    cursor: not-allowed;
}


/* =========================
   Mobile
========================= */

@media (max-width: 768px) {

    .blog-container {
        padding: 0 15px;
        margin-top: 30px;
        margin-bottom: 50px;
    }

    .blog-top-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-box {
        width: 100%;
    }

    .blog-category-description {
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .blog-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }

    .blog-card img {
        height: 220px;
    }

    .blog-content {
        padding: 15px 0;
    }

    .blog-content h3 {
        font-size: 18px;
        line-height: 26px;
        margin-bottom: 15px;
    }

    .publish-date {
        font-size: 13px;
    }

    .blog-content a {
        font-size: 15px;
        padding: 10px 20px;
    }

    .view-all-wrapper {
        margin: 30px 0;
    }

    .view-all-btn {
        width: 180px;
        padding: 12px 25px;
    }
}

</style>

<!-- =========================
     AJAX Pagination
========================= -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("viewAllBtn");
    const blogGrid = document.getElementById("blogGrid");

    if (!btn || !blogGrid) {
        return;
    }


    btn.addEventListener("click", function () {

        let url = btn.getAttribute("data-next");

        if (!url) {
            return;
        }


        /* Disable button while loading */
        btn.disabled = true;
        btn.textContent = "Loading...";


        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "text/html"
            }
        })

        .then(response => {

            if (!response.ok) {
                throw new Error("Failed to load blogs.");
            }

            return response.text();
        })


        .then(html => {

            const parser = new DOMParser();

            const doc = parser.parseFromString(
                html,
                "text/html"
            );


            /*
             * IMPORTANT:
             * Only take the blog cards from #blogGrid.
             * We take the whole <a class="blog-card-link"> wrapper
             * so the loaded cards stay clickable.
             *
             * Category description is outside #blogGrid,
             * therefore it will NOT be duplicated.
             */
            const newCards = doc.querySelectorAll(
                "#blogGrid .blog-card-link"
            );


            if (newCards.length > 0) {

                newCards.forEach(card => {

                    blogGrid.appendChild(
                        document.importNode(card, true)
                    );

                });

            }


            /*
             * Get next pagination URL
             */
            const nextButton = doc.querySelector(
                "#viewAllBtn"
            );


            if (nextButton) {

                const nextUrl = nextButton.getAttribute(
                    "data-next"
                );

                if (nextUrl) {

                    btn.setAttribute(
                        "data-next",
                        nextUrl
                    );

                    btn.disabled = false;
                    btn.textContent = "View All";

                } else {

                    btn.remove();

                }

            } else {

                /*
                 * No more pages
                 */
                btn.remove();

            }

        })

        .catch(error => {

            console.error(error);

            btn.disabled = false;
            btn.textContent = "View All";

            alert(
                "Unable to load more blogs. Please try again."
            );

        });

    });

});

</script>

@endsection