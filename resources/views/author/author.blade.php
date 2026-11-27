@extends('layouts.app')

@section('title', 'Articles by ' . $author)

@section('description', 'Read all travel articles and guides written by ' . $author . '.')

@section('content')

@php
    // Author name comes from $author
    // Example: Gabriel Potter

    // Generate initials dynamically
    $initials = \Illuminate\Support\Str::of($author)
        ->explode(' ')
        ->filter()
        ->map(fn ($word) => \Illuminate\Support\Str::upper(
            \Illuminate\Support\Str::substr($word, 0, 1)
        ))
        ->take(2)
        ->implode('');

    // Generate URL slug dynamically
    $authorSlug = \Illuminate\Support\Str::slug($author);

    // Generate author page URL dynamically
    $authorUrl = route('author.blogs', [
        'authorName' => $authorSlug
    ]);
@endphp

<div class="ap-page">

    {{-- =====================================================
         BANNER
    ====================================================== --}}
    <section class="ap-banner">

        <div class="ap-banner-overlay">

            <div class="container">

                <nav aria-label="breadcrumb" class="ap-breadcrumb">

                    <ol class="breadcrumb justify-content-center mb-0">

                                   <li class="breadcrumb-item">
    <a href="{{ route('home') }}">Home</a>
</li>

<li class="breadcrumb-item">
    Authors
</li>

<li class="breadcrumb-item active" aria-current="page">
    {{ $author }}
</li>

                    </ol>

                </nav>

            </div>

        </div>

    </section>


    {{-- =====================================================
         AUTHOR PROFILE CARD
    ====================================================== --}}
    <section class="ap-profile-wrap">

        <div class="ap-profile">

            {{-- Avatar --}}
            <div class="ap-avatar">

                <span>
                    {{ $initials }}
                </span>

                <i class="fa fa-pencil ap-avatar-badge"></i>

            </div>


            {{-- Author Information --}}
            <div class="ap-profile-info">

                <span class="ap-role">
                    TRAVEL WRITER
                </span>

                <h1>
                    {{ $author }}
                </h1>

                <p>
    {{ $author }} is an aviation and travel content specialist with over 6+ 
    years of industry knowledge and extensive travel experience. He covers 
    airline policies, flight bookings, cancellations, refunds, travel deals,
     airport experiences, and practical air-travel strategies. His clear,
      research-driven guides help travelers understand airline procedures,
     make informed decisions, and navigate every journey with confidence.
</p>


               @php
    // Generate initials dynamically
    $initials = \Illuminate\Support\Str::of($author)
        ->explode(' ')
        ->filter()
        ->map(fn ($word) => \Illuminate\Support\Str::upper(
            \Illuminate\Support\Str::substr($word, 0, 1)
        ))
        ->take(2)
        ->implode('');

    // Generate author slug dynamically
    $authorSlug = \Illuminate\Support\Str::slug($author);

    // Generate author URL dynamically
    $authorUrl = route('author.blogs', [
        'authorName' => $authorSlug
    ]);
@endphp
            </div>


            {{-- Article Count --}}
            <div class="ap-profile-stat">

                <strong>
                    {{ $blogs->total() }}
                </strong>

                <span>
                    {{ \Illuminate\Support\Str::plural('Article', $blogs->total()) }}
                </span>

            </div>

        </div>

    </section>


    {{-- =====================================================
         ARTICLES
    ====================================================== --}}
    <section class="ap-articles">

        <div class="ap-container">


            {{-- TOOLBAR --}}
            <div class="ap-toolbar">

                <h2 class="ap-toolbar-title">
                    Latest Articles
                </h2>


                {{-- SEARCH --}}
                <form
                    action="{{ url()->current() }}"
                    method="GET"
                    class="ap-search"
                >

                    <div class="ap-search-wrap">

                        <i class="fa fa-search ap-search-icon"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search articles..."
                            autocomplete="off"
                        >


                        @if($search)

                            <a
                                href="{{ url()->current() }}"
                                class="ap-clear"
                                title="Clear search"
                            >

                                <i class="fa fa-times"></i>

                            </a>

                        @endif

                    </div>


                    <button type="submit">
                        Search
                    </button>

                </form>

            </div>


            {{-- =================================================
                 SEARCH RESULT
            ================================================== --}}
            @if($search)

                <div class="ap-result">

                    <div>

                        <span class="ap-result-label">
                            Search results for
                        </span>

                        <strong>
                            "{{ $search }}"
                        </strong>

                    </div>


                    <span class="ap-result-count">

                        {{ $blogs->total() }}

                        {{ \Illuminate\Support\Str::plural('article', $blogs->total()) }}

                    </span>

                </div>

            @endif


            {{-- =================================================
                 BLOG GRID
            ================================================== --}}
            @if ($blogs->count())

                <div class="ap-grid">

                    @foreach ($blogs as $blog)

                        {{-- Skip blogs without a slug --}}
                        @continue(empty($blog->blog_url))


                        @php

                            $catSlug = $blog->subcategory->slug
                                ?? $blog->category->slug
                                ?? null;

                            $blogLink = $catSlug
                                ? route('blogdetails', [
                                    'cate_subcate' => $catSlug,
                                    'blog_slug'    => $blog->blog_url,
                                ])
                                : '#';

                        @endphp


                        {{-- =================================================
                             BLOG CARD
                        ================================================== --}}
                        <article class="ap-card">


                            {{-- Blog Image --}}
                            <a
                                href="{{ $blogLink }}"
                                class="ap-card-image"
                            >

                                <img
                                    src="{{ asset($blog->image ?? 'images/blog_blur 3.png') }}"
                                    alt="{{ $blog->alt_tag ?? $blog->title }}"
                                    loading="lazy"
                                >


                                {{-- Date Badge --}}
                                <span class="ap-card-date">

                                    <i class="fa-solid fa-calendar-days"></i>

                                    {{ optional($blog->updated_at)->format('d M Y') }}

                                </span>

                            </a>


                            {{-- Card Body --}}
                            <div class="ap-card-body">


                                {{-- Blog Title --}}
                                <h3 class="ap-card-title">

                                    <a href="{{ $blogLink }}">

                                        {{ $blog->meta_title ?? $blog->title }}

                                    </a>

                                </h3>


                                {{-- Read Article Button --}}
                                <a
                                    href="{{ $blogLink }}"
                                    class="ap-card-btn"
                                >

                                    <span>
                                        Read Article
                                    </span>

                                    <span class="ap-card-arrow">
                                        →
                                    </span>

                                </a>

                            </div>

                        </article>

                    @endforeach

                </div>


                {{-- =================================================
                     PAGINATION
                ================================================== --}}
                <div class="ap-pagination">

                    {{ $blogs->links('pagination::bootstrap-5') }}

                </div>


            @else


                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}
                <div class="ap-empty">

                    <div class="ap-empty-icon">

                        <i class="fa fa-search"></i>

                    </div>


                    <h3>
                        No articles found
                    </h3>


                    @if($search)

                        <p>

                            We couldn't find any articles matching

                            <strong>
                                "{{ $search }}"
                            </strong>.

                        </p>


                        <a
                            href="{{ url()->current() }}"
                            class="ap-empty-btn"
                        >
                            View All Articles
                        </a>


                    @else

                        <p>
                            There are currently no published articles
                            for this author.
                        </p>

                    @endif

                </div>

            @endif

        </div>

    </section>

</div>



<style>

/* =========================================================
   PAGE
========================================================= */

.ap-page {
    background: #fbf7f3;
    padding-bottom: 70px;
}


/* =========================================================
   BANNER
========================================================= */

.ap-banner {
    height: 240px;

    background:
        url("{{ asset('images/christmas.png') }}")
        center center / cover no-repeat;
}


.ap-banner-overlay {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: flex-start;
    justify-content: center;

    padding-top: 55px;

    background: rgb(88 54 36 / 95%);
}


/* Breadcrumb */

.ap-breadcrumb .breadcrumb {
    background: transparent;
    justify-content: center;
}


.ap-breadcrumb .breadcrumb-item,
.ap-breadcrumb .breadcrumb-item.active {
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}


.ap-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #fff;
    padding: 0 10px;
}


.ap-breadcrumb .breadcrumb-item a {
    color: #fff;
    text-decoration: none;
}


/* =========================================================
   PROFILE CARD
========================================================= */

.ap-profile-wrap {
    position: relative;
    z-index: 5;

    margin-top: -95px;

    padding: 0 15px;
}


.ap-profile {
    width: 100%;
    max-width: 1000px;

    margin: 0 auto;

    display: grid;

    grid-template-columns:
        auto
        1fr
        auto;

    align-items: center;

    gap: 30px;

    padding: 30px 34px;

    background: #fff;

    border: 1px solid #ead8c8;

    border-radius: 16px;

    box-shadow:
        0 10px 30px rgba(92, 47, 25, .14);
}


/* =========================================================
   AVATAR
========================================================= */

.ap-avatar {
    position: relative;

    width: 110px;
    height: 110px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #6c3f2a,
            #b07b38
        );

    border: 5px solid #f8f1eb;

    box-shadow:
        0 6px 18px rgba(108, 63, 42, .3);

    color: #fff;

    font-size: 34px;

    font-weight: 700;

    letter-spacing: 1px;
}


/* Avatar badge */

.ap-avatar-badge {
    position: absolute;

    right: -2px;
    bottom: 4px;

    width: 30px;
    height: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #b07b38;

    border: 3px solid #fff;

    color: #fff;

    font-size: 12px;
}


/* =========================================================
   AUTHOR INFO
========================================================= */

.ap-role {
    display: inline-block;

    margin-bottom: 8px;

    padding: 4px 12px;

    border-radius: 999px;

    background: #fbf3e6;

    border: 1px solid #d9b47a;

    color: #9a672e;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 1.5px;
}


.ap-profile-info h1 {
    margin: 0 0 10px;

    color: #5c2f19;

    font-size: 32px;

    font-weight: 600;

    line-height: 1.3;
}


.ap-profile-info p {
    margin: 0;

    color: #555;

    font-size: 15px;

    line-height: 1.75;
}


/* =========================================================
   ARTICLE STAT
========================================================= */

.ap-profile-stat {
    min-width: 110px;

    padding: 18px 20px;

    text-align: center;

    background: #f8f1eb;

    border: 1px solid #d9bca6;

    border-radius: 14px;
}


.ap-profile-stat strong {
    display: block;

    color: #6c3f2a;

    font-size: 34px;

    font-weight: 700;

    line-height: 1;
}


.ap-profile-stat span {
    display: block;

    margin-top: 6px;

    color: #9a672e;

    font-size: 12px;

    font-weight: 600;

    text-transform: uppercase;

    letter-spacing: 1px;
}


/* =========================================================
   ARTICLES SECTION
========================================================= */

.ap-articles {
    padding: 50px 15px 0;
}


.ap-container {
    width: 100%;
    max-width: 1200px;

    margin: 0 auto;
}


/* =========================================================
   TOOLBAR
========================================================= */

.ap-toolbar {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;

    margin-bottom: 28px;

    padding-bottom: 20px;

    border-bottom: 2px solid #ead8c8;
}


.ap-toolbar-title {
    position: relative;

    margin: 0;

    padding-left: 16px;

    color: #6c3f2a;

    font-size: 26px;

    font-weight: 600;
}


.ap-toolbar-title::before {
    content: "";

    position: absolute;

    left: 0;
    top: 4px;
    bottom: 4px;

    width: 5px;

    border-radius: 4px;

    background: #b07b38;
}


/* =========================================================
   SEARCH
========================================================= */

.ap-search {
    display: flex;

    align-items: center;

    gap: 10px;

    width: min(100%, 460px);
}


.ap-search-wrap {
    position: relative;

    flex: 1;
}


.ap-search-wrap input {
    width: 100%;

    height: 46px;

    padding:
        0
        42px
        0
        42px;

    border: 1px solid #d9bca6;

    border-radius: 999px;

    background: #fff;

    color: #333;

    font-size: 14px;

    outline: none;

    transition: .2s;
}


.ap-search-wrap input:focus {
    border-color: #b07b38;

    box-shadow:
        0 0 0 4px
        rgba(176, 123, 56, .15);
}


.ap-search-icon {
    position: absolute;

    left: 16px;
    top: 50%;

    transform: translateY(-50%);

    color: #9a672e;

    font-size: 14px;
}


.ap-clear {
    position: absolute;

    right: 15px;
    top: 50%;

    transform: translateY(-50%);

    color: #a58b7a;

    text-decoration: none;
}


.ap-clear:hover {
    color: #c0392b;
}


.ap-search button {
    height: 46px;

    padding: 0 24px;

    border: 1px solid #6c3f2a;

    border-radius: 999px;

    background: #6c3f2a;

    color: #fff;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: .25s;
}


.ap-search button:hover {
    background: #b07b38;

    border-color: #b07b38;

    transform: translateY(-1px);
}


/* =========================================================
   SEARCH RESULT
========================================================= */

.ap-result {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 25px;

    padding: 14px 18px;

    background: #f3f5ff;

    border: 1px solid #d8def5;

    border-radius: 10px;

    color: #333;

    font-size: 14px;
}


.ap-result-label {
    margin-right: 4px;

    color: #777;
}


.ap-result strong {
    color: #6c3f2a;
}


.ap-result-count {
    font-weight: 700;

    color: #9a672e;
}


/* =========================================================
   GRID
========================================================= */

.ap-grid {
    display: grid;

    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );

    gap: 28px;
}


/* =========================================================
   CARD
========================================================= */

.ap-card {
    display: flex;

    flex-direction: column;

    min-width: 0;

    overflow: hidden;

    background: #fff;

    border: 1px solid #ead8c8;

    border-radius: 14px;

    box-shadow:
        0 2px 8px rgba(0, 0, 0, .08);

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;
}


.ap-card:hover {
    transform: translateY(-6px);

    border-color: #d9b47a;

    box-shadow:
        0 14px 30px
        rgba(92, 47, 25, .16);
}


/* =========================================================
   CARD IMAGE
========================================================= */

.ap-card-image {
    position: relative;

    display: block;

    height: 220px;

    overflow: hidden;

    background: #f1e6dc;
}


.ap-card-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform .6s ease;
}


.ap-card:hover .ap-card-image img {
    transform: scale(1.07);
}


/* =========================================================
   DATE BADGE
========================================================= */

.ap-card-date {
    position: absolute;

    left: 14px;
    bottom: 14px;

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 6px 11px;

    border-radius: 6px;

    background:
        rgba(108, 63, 42, .95);

    color: #fff;

    font-size: 12px;

    font-weight: 600;

    line-height: 1.4;
}


.ap-card-date i {
    font-size: 11px;
}


/* =========================================================
   CARD BODY
========================================================= */

.ap-card-body {
    display: flex;

    flex: 1;

    flex-direction: column;

    padding:
        20px
        20px
        22px;
}


/* Card title */

.ap-card-title {
    margin: 0 0 18px;

    font-size: 19px;

    font-weight: 600;

    line-height: 1.45;
}


.ap-card-title a {
    display: -webkit-box;

    overflow: hidden;

    color: #5c2f19;

    text-decoration: none;

    -webkit-line-clamp: 3;

    -webkit-box-orient: vertical;

    transition: color .2s;
}


.ap-card-title a:hover {
    color: #b07b38;
}


/* =========================================================
   READ ARTICLE BUTTON
========================================================= */

.ap-card-btn {
    display: inline-flex;

    align-items: center;

    width: fit-content;

    margin-top: auto;

    padding: 9px 15px;

    border-radius: 7px;

    background: #b07b38;

    color: #fff;

    font-size: 13px;

    font-weight: 600;

    line-height: 1.4;

    text-decoration: none;

    transition: all .25s ease;
}


.ap-card-btn:hover {
    background: #6c3f2a;

    color: #fff;
}


.ap-card-arrow {
    margin-left: 9px;

    font-size: 15px;

    line-height: 1;

    transition:
        transform .25s ease;
}


.ap-card-btn:hover .ap-card-arrow {
    transform: translateX(4px);
}


/* =========================================================
   PAGINATION
========================================================= */

.ap-pagination {
    display: flex;

    justify-content: center;

    margin-top: 45px;
}


.ap-pagination .pagination {
    gap: 6px;

    margin: 0;
}


.ap-pagination .page-link {
    min-width: 40px;

    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 1px solid #d9bca6;

    border-radius: 8px !important;

    background: #fff;

    color: #6c3f2a;

    font-weight: 600;
}


.ap-pagination .page-link:hover {
    background: #f8f1eb;

    border-color: #b07b38;

    color: #6c3f2a;
}


.ap-pagination .page-item.active .page-link {
    background: #6c3f2a;

    border-color: #6c3f2a;

    color: #fff;
}


.ap-pagination .page-item.disabled .page-link {
    background: #f6f1ec;

    color: #b9a898;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.ap-empty {
    padding: 65px 25px;

    text-align: center;

    background: #fff;

    border: 1px solid #ead8c8;

    border-radius: 14px;

    box-shadow:
        0 2px 8px rgba(0, 0, 0, .08);
}


.ap-empty-icon {
    width: 70px;
    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: 0 auto 18px;

    border-radius: 50%;

    background: #f8f1eb;

    border: 1px solid #d9bca6;

    color: #6c3f2a;

    font-size: 24px;
}


.ap-empty h3 {
    margin: 0 0 8px;

    color: #5c2f19;

    font-size: 22px;

    font-weight: 600;
}


.ap-empty p {
    margin: 0 0 20px;

    color: #777;

    font-size: 14px;
}


.ap-empty-btn {
    display: inline-flex;

    padding: 10px 20px;

    border-radius: 7px;

    background: #b07b38;

    color: #fff;

    font-size: 13px;

    font-weight: 600;

    text-decoration: none;

    transition: .25s;
}


.ap-empty-btn:hover {
    background: #6c3f2a;

    color: #fff;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 992px) {

    .ap-grid {
        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 22px;
    }


    .ap-profile {
        grid-template-columns:
            auto
            1fr;
    }


    .ap-profile-stat {
        grid-column: 1 / -1;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 12px;
    }


    .ap-profile-stat span {
        margin-top: 0;
    }


    .ap-toolbar {
        flex-direction: column;

        align-items: stretch;
    }


    .ap-search {
        width: 100%;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .ap-banner {
        height: 200px;
    }


    .ap-banner-overlay {
        padding-top: 40px;
    }


    .ap-breadcrumb .breadcrumb-item,
    .ap-breadcrumb .breadcrumb-item.active {
        font-size: 12px;
    }


    .ap-profile-wrap {
        margin-top: -75px;
    }


    .ap-profile {
        grid-template-columns: 1fr;

        justify-items: center;

        gap: 18px;

        padding: 26px 20px;

        text-align: center;
    }


    .ap-avatar {
        width: 90px;
        height: 90px;

        font-size: 28px;
    }


    .ap-profile-info h1 {
        font-size: 25px;
    }


    .ap-profile-info p {
        font-size: 14px;
    }


    .ap-profile-stat {
        grid-column: auto;

        width: 100%;
    }


    .ap-articles {
        padding-top: 35px;
    }


    .ap-toolbar-title {
        font-size: 22px;
    }


    .ap-search {
        flex-direction: column;

        align-items: stretch;
    }


    .ap-search button {
        width: 100%;
    }


    .ap-result {
        flex-direction: column;

        align-items: flex-start;
    }


    .ap-grid {
        grid-template-columns: 1fr;

        gap: 20px;
    }


    .ap-card-image {
        height: 210px;
    }


    .ap-card-title {
        font-size: 18px;
    }

}

</style>




@endsection