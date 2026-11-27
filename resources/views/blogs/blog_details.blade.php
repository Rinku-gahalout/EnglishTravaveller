@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->blog_heading)

@section('meta_description', $blog->meta_description ?? '')

@section('meta_keywords', $blog->meta_keywords ?? '')

@section('robots')
    @if(isset($blog->category) && $blog->category->slug === 'old-blog')
        noindex, nofollow
    @else
        index, follow
    @endif
@endsection


{{-- =========================================================
     PAGE CSS  (pushed into <head> via @stack('styles') in layouts/app.blade.php)
     The banner background image was removed: it was covered by a 95%
     opaque overlay and was being detected as the LCP resource (3.5s delay).
========================================================= --}}
@push('styles')
<style>

/* =========================================================
   BLOG ACTION BUTTONS
========================================================= */

.blog-action-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding-bottom: 20px;
    border-bottom: 2px solid #ead8c8;
    margin-top: 20px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    box-sizing: border-box;
    text-decoration: none;
    transition:
        background-color 0.25s ease,
        border-color 0.25s ease,
        color 0.25s ease,
        transform 0.25s ease,
        box-shadow 0.25s ease;
}

.call-btn {
    background: #f8f1eb;
    color: #6c3f2a;
    border: 1px solid #d9bca6;
}

.call-btn:hover {
    background: #6c3f2a;
    color: #ffffff;
    border-color: #6c3f2a;
    box-shadow: 0 4px 12px rgba(108, 63, 42, 0.18);
}

.flight-btn {
    background: #fbf3e6;
    color: #9a672e;
    border: 1px solid #d9b47a;
}

.flight-btn:hover {
    background: #b07b38;
    color: #ffffff;
    border-color: #b07b38;
    box-shadow: 0 4px 12px rgba(176, 123, 56, 0.22);
}

.author-btn {
    margin-left: auto;
    background: #f8f1eb;
    color: #6c3f2a;
    border: 1px solid #d9bca6;
}

.author-btn:hover {
    background: #6c3f2a;
    color: #ffffff;
    border-color: #6c3f2a;
    box-shadow: 0 4px 12px rgba(108, 63, 42, 0.18);
}

.action-btn svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    transition: transform 0.25s ease;
}

.action-btn:hover svg {
    transform: translateX(1px);
}

.author-btn:hover svg {
    transform: scale(1.08);
}

.action-btn:hover {
    transform: translateY(-1px);
}

@media (max-width: 576px) {

    .blog-action-buttons {
        gap: 8px;
        padding-bottom: 16px;
    }

    .action-btn {
        font-size: 13px;
        padding: 7px 13px;
    }

}


/* =========================================================
   BLOG IMAGE (LCP element)
   Single definition. The 16/9 wrapper reserves space, so no layout shift.
========================================================= */

.hero-image-wrapper {
    width: 100%;
    aspect-ratio: 16 / 9;
    overflow: hidden;
    position: relative;
    border-radius: 14px;
}

.hero-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 14px;
}

.blog-image-date {
    position: absolute;
    left: 15px;
    bottom: 15px;
    z-index: 5;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 8px;
}

.blog-image-date-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    border-radius: 6px;
    color: #fff;
    font-size: 12px;
    line-height: 1.4;
    white-space: nowrap;
    box-sizing: border-box;
}

.blog-image-date-item.published-date {
    background: rgba(108, 63, 42, 0.95);
}

.blog-image-date-item.updated-date {
    background: rgba(176, 123, 56, 0.95);
}

.blog-image-date-item i {
    font-size: 11px;
    color: #fff;
}

.blog-image-date-item span {
    font-weight: 500;
}

.blog-image-date-item strong {
    font-weight: 700;
    color: #fff;
}


/* =========================================================
   RELATED POST BOX (inside article)
========================================================= */

.article .related-posts {
    margin-top: 30px;
    padding: 18px 18px 30px;
    width: 100%;
    box-sizing: border-box;
    background: #f3f5ff;
    border: 1px solid #d8def5;
    border-radius: 10px;
}

.article .related-posts-title {
    margin: 0 0 13px;
    padding: 0;
    font-size: 14px;
    line-height: 1.4;
    font-weight: 700;
    color: #111827;
}

.article .related-post-list {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
}

.article .related-post-link {
    display: inline-flex;
    align-items: center;
    width: fit-content;
    max-width: 100%;
    padding: 9px 14px 9px 15px;
    background: #b07b38;
    color: #fff;
    border-radius: 7px;
    text-decoration: none;
    font-size: 13px;
    line-height: 1.4;
    font-weight: 600;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.article .related-post-text {
    display: block;
}

.article .related-arrow {
    margin-left: 9px;
    color: #fff;
    font-size: 15px;
    line-height: 1;
    flex-shrink: 0;
    transition: transform .2s ease;
}

.article .related-post-link:hover {
    background: #b07b38;
    color: #fff;
}

.article .related-post-link:hover .related-arrow {
    transform: translateX(3px);
}


/* =========================================================
   BLOG BANNER  (solid colour, no background image)
========================================================= */

.blog-banner {
    background: rgb(88, 54, 36);
    height: 260px;
    position: relative;
}

.blog-banner .overlay {
    width: 100%;
    height: 100%;
    background: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
}

.blog-banner .container {
    color: #fff;
}

.blog-banner h1 {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 8px;
}


/* =========================================================
   BREADCRUMB
========================================================= */

.banner-breadcrumb {
    margin-top: 20px;
}

.banner-breadcrumb .breadcrumb {
    background: transparent;
    justify-content: center;
}

.banner-breadcrumb .breadcrumb-item,
.banner-breadcrumb .breadcrumb-item.active {
    color: #fff;
    font-size: 16px;
    font-weight: 500;
}

.banner-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: ">";
    color: #fff;
    padding: 0 10px;
}

.banner-breadcrumb .breadcrumb-item a {
    color: #fff;
    text-decoration: none;
}


/* =========================================================
   FLOATING TITLE CARD
========================================================= */

.banner-card {
    position: absolute;
    left: 50%;
    bottom: -83px;
    transform: translateX(-50%);
    width: 92%;
    max-width: 720px;
    background: #fff;
    border-radius: 10px;
    padding: 18px 25px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
    text-align: center;
    z-index: 5;
}

.banner-card h1 {
    margin: 0;
    color: #5c2f19;
    font-size: 28px;
    font-weight: 600;
    line-height: 1.4;
}


/* =========================================================
   MAIN BLOG CONTAINER
========================================================= */

.blogdetail-container {
    width: 1200px;
    margin: 131px auto 78px;
    display: grid;
    grid-template-columns: 2.7fr 1fr;
    gap: 45px;
    align-items: start;
}

.blogdetail-content {
    border: 1px solid #adb5bd;
    border-radius: 20px;
    padding: 20px;
    background: #adb5bd14;
    min-width: 0;
}


/* =========================================================
   ARTICLE
========================================================= */

.article {
    margin-top: 30px;
    font-size: 17px;
    line-height: 1.8;
}

.article th p {
    font-size: 17px;
    line-height: 1.6;
    margin-bottom: 16px;
    color: #7b3f12;
}

.article h2 {
    margin: 30px 0 12px;
    font-size: 28px;
    line-height: 1.5;
    color: #7b3f12;
    font-weight: 600;
    scroll-margin-top: 100px;
}

.article h3 {
    margin: 25px 0 14px;
    font-size: 21px;
    line-height: 1.4;
    color: #7b3f12;
    font-weight: 600;
    scroll-margin-top: 100px;
}

.article ul {
    margin-left: 25px;
    margin-bottom: 24px;
}

.article li {
    font-size: 17px;
    line-height: 1.6;
}


/* =========================================================
   TABLE OF CONTENT
========================================================= */

.table-of-content {
    border: 1px solid #adb5bd;
    background: #F9FBFF;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
    border-radius: 12px;
    padding: 24px;
    width: 100%;
    box-sizing: border-box;
}

.table-of-content h3 {
    font-size: 22px;
    color: #27014B;
    margin: 0 0 8px;
    padding-bottom: 21px;
    font-weight: 700;
    border-bottom: 2px solid #16161694;
}

.table-of-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.table-of-content li {
    padding: 12px 0;
    border-bottom: 1px solid #1616163d;
}

.table-of-content li:last-child {
    border-bottom: none;
}

.table-of-content a {
    text-decoration: none;
    color: #212529;
    font-size: 14px;
    line-height: 1.6;
    display: block;
    transition: .3s ease;
    font-weight: 500;
}

.table-of-content a.active {
    color: #6C3F2A;
    font-weight: 700;
}

.table-of-content a:hover {
    color: #6C3F2A;
    padding-left: 8px;
}

.toc-h3 a {
    padding-left: 14px;
    font-size: 13px;
}


/* =========================================================
   SIDEBAR (DESKTOP)
   One sticky column holds TOC + Recent Posts (two separate cards),
   so they move together and never overlap.
========================================================= */

.sidebar {
    position: relative;
    align-self: stretch;
    min-width: 0;
}

.desktop-toc-space {
    height: 0;
}

.sidebar-sticky {
    position: sticky;
    top: 100px;
    z-index: 10;
}

.desktop-recent-posts {
    margin-top: 24px;
}


/* =========================================================
   SIDEBAR CARD
========================================================= */

.sidebar-card {
    border: 1px solid #adb5bd;
    background: #F9FBFF;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
    border-radius: 12px;
    padding: 24px;
}

.sidebar-card h3 {
    color: #6C3F2A;
    margin: 0;
    padding-bottom: 21px;
    border-bottom: 2px solid #16161694;
    font-size: 22px;
}


/* =========================================================
   RECENT POSTS
========================================================= */

.sidebar-post-link {
    text-decoration: none;
    display: block;
}

.sidebar-post {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 28px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #1616163d;
}

.sidebar-post img {
    width: 70px;
    height: 70px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
}

.sidebar-post p {
    margin: 0;
    font-size: 14px;
    line-height: 1.55;
    color: #333;
    font-weight: 500;
    transition: color .25s ease;
}

.sidebar-post-link:hover .sidebar-post p {
    color: #6C3F2A;
}


/* =========================================================
   READ MORE RELATED POSTS (generic)
========================================================= */

.related-posts {
    margin-top: 45px;
    padding: 20px 18px 30px;
    background: #F4F7FF;
    border: 1px solid #D5DEEF;
    border-radius: 12px;
}

.related-posts-title {
    margin: 0 0 15px;
    font-size: 14px;
    font-weight: 700;
    color: #161616;
}

.related-post-list {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
}

.related-post-link {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    width: fit-content;
    max-width: 100%;
    padding: 9px 15px;
    background: #b07b38;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.4;
    transition: all .3s ease;
}

.related-post-link:hover {
    background: #b07b38;
    color: #fff;
    transform: translateX(3px);
}

.related-arrow {
    font-size: 16px;
    line-height: 1;
    position: relative;
    top: -1px;
    transition: transform .3s ease;
}

.related-post-link:hover .related-arrow {
    transform: translateX(4px);
}


/* =========================================================
   BLOG TABLE
========================================================= */


/* =========================================================
   LUXURY EDITORIAL BLOG TABLE
   Premium Brown + Champagne Gold Design
========================================================= */

.article table {
    width: 100%;
    margin: 38px 0;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    border: 1px solid #e6d8c9;
    border-radius: 14px;
    overflow: hidden;
    box-shadow:
        0 8px 28px rgba(55, 35, 22, 0.08),
        0 2px 5px rgba(55, 35, 22, 0.03);
    font-size: 16px;
    line-height: 1.7;
}

/* PREMIUM HEADER */

.article table thead th,
.article table th {
    background: #503020;
    color: #ffffff !important;
    padding: 19px 20px;
    text-align: left;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.6;
    letter-spacing: 0.35px;
    border: none;
    border-bottom: 3px solid #c69a5b;
    vertical-align: middle;
}

/* TABLE BODY */

.article table td {
    padding: 17px 20px;
    color: #332b26 !important;
    background: #ffffff;
    border-bottom: 1px solid #eee7df;
    border-right: 1px solid #eee7df;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.75;
    vertical-align: middle;
}

/* REMOVE UNNECESSARY BORDERS */

.article table td:last-child,
.article table th:last-child {
    border-right: none;
}

.article table tr:last-child td {
    border-bottom: none;
}

/* ALTERNATE ROW BACKGROUND */

.article table tbody tr:nth-child(even) td {
    background: #faf6f1;
}

/* PREMIUM HOVER */

.article table tbody tr {
    transition: background-color 0.25s ease;
}

.article table tbody tr:hover td {
    background: #f2e8dc;
}

/* EMPHASIZED CONTENT */

.article table td strong,
.article table td b {
    color: #603b25 !important;
    font-weight: 700;
}

/* LINKS */

.article table td a {
    color: #986526;
    font-weight: 700;
    text-decoration: underline;
    text-decoration-color: #d7bd98;
    text-underline-offset: 3px;
}

.article table td a:hover {
    color: #503020;
}

/* TABLE PARAGRAPHS */

.article table td p,
.article table th p {
    color: inherit;
    font-size: inherit;
    line-height: 1.7;
    margin: 0;
}

/* MOBILE RESPONSIVE */

@media (max-width: 768px) {

    .article table {
        display: block;
        width: 100%;
        overflow-x: auto;
        white-space: normal;
        border-radius: 10px;
        margin: 28px 0;
        font-size: 14px;
        -webkit-overflow-scrolling: touch;
    }

    .article table th {
        min-width: 125px;
        padding: 14px 16px;
        font-size: 14px;
    }

    .article table td {
        min-width: 125px;
        padding: 14px 16px;
        font-size: 14px;
        line-height: 1.65;
    }
}


/* =========================================================
   FAQ
========================================================= */

.faq-section {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
}

.faq-box {
    width: 1200px;
    background: #f4f4f4;
    border-radius: 12px;
    padding: 18px 20px;
    margin: 20px 44px 44px;
    border: 1px solid #2E3A2E;
}

.faq-title {
    text-align: center;
    font-size: 28px;
    font-weight: 600;
    color: #6C3F2A;
    margin-bottom: 15px;
}

.faq-item {
    border-bottom: 1px solid #2E3A2E;
}

.faq-item:last-child {
    border-bottom: none;
}

.faq-question {
    width: 100%;
    background: none;
    border: none;
    outline: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    cursor: pointer;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    text-align: left;
}

.faq-question span:first-child {
    flex: 1;
}

.icon {
    font-size: 24px;
    color: #555;
    line-height: 1;
    transition: .3s;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s ease;
}

.faq-answer p {
    margin: 0;
    padding: 0 0 18px;
    font-size: 16px;
    line-height: 1.8;
    color: #2E3A2E;
}

.faq-item.active .faq-answer {
    max-height: 500px;
}

.faq-item.active .icon {
    transform: rotate(45deg);
}


/* =========================================================
   MOBILE RECENT POSTS
========================================================= */

.mobile-recent-posts {
    display: none;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 992px) {

    .blogdetail-container {
        width: 95%;
        display: block;
        margin-top: 90px;
        margin-bottom: 30px;
    }

    .sidebar {
        display: none;
    }

    .table-of-content {
        position: sticky;
        top: 15px;
        margin-top: 25px;
        margin-bottom: 30px;
        z-index: 10;
    }

    .mobile-recent-posts {
        display: block;
        width: 95%;
        margin: 0 auto 50px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .blog-banner {
        height: 200px;
    }

    .blog-banner h1 {
        font-size: 24px;
    }

    .banner-breadcrumb .breadcrumb-item,
    .banner-breadcrumb .breadcrumb-item.active {
        font-size: 12px;
    }

    .banner-card {
        padding: 15px;
        bottom: -35px;
    }

    .banner-card h1 {
        font-size: 20px;
    }

    .blogdetail-container {
        width: 95%;
        margin-top: 75px;
    }

    .blogdetail-content {
        padding: 15px;
        border-radius: 15px;
    }

    .hero-image-wrapper,
    .hero-image {
        border-radius: 10px;
    }

    .blog-image-date {
        left: 8px;
        bottom: 8px;
        gap: 5px;
        max-width: calc(100% - 16px);
    }

    .blog-image-date-item {
        padding: 6px 8px;
        gap: 4px;
        font-size: 14px;
        border-radius: 5px;
    }

    .blog-image-date-item i {
        font-size: 9px;
    }

    .table-of-content {
        margin-top: 20px;
        margin-bottom: 25px;
        padding: 18px;
    }

    .table-of-content h3 {
        font-size: 19px;
        padding-bottom: 15px;
    }

    .table-of-content li {
        padding: 10px 0;
    }

    .table-of-content a {
        font-size: 13px;
    }

    .article {
        margin-top: 20px;
        font-size: 16px;
    }

    .article p {
        font-size: 16px;
        line-height: 1.75;
    }

    .article h2 {
        font-size: 23px;
    }

    .article h3 {
        font-size: 19px;
    }

    .related-posts {
        margin-top: 30px;
        padding: 18px 14px 25px;
    }

    .related-posts-title {
        font-size: 14px;
    }

    .related-post-list {
        gap: 12px;
    }

    .related-post-link {
        width: auto;
        max-width: 100%;
        font-size: 12px;
        padding: 9px 12px;
    }

    .faq-section {
        padding: 20px 10px;
    }

    .faq-box {
        width: 100%;
        margin: 20px 0;
        padding: 15px;
    }

    .faq-title {
        font-size: 22px;
    }

    .faq-question {
        font-size: 16px;
    }

    .mobile-recent-posts {
        width: 95%;
        margin: 0 auto 40px;
    }

    .mobile-recent-posts .sidebar-card {
        padding: 18px;
    }

    .mobile-recent-posts .sidebar-card h3 {
        font-size: 19px;
    }

 

}

</style>
@endpush


@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | Recent Post URL builder (same logic as the blog listing page)
    |--------------------------------------------------------------------------
    | Priority 1: blog_url
    | Priority 2: slug generated from blog_heading
    | Returns null when a link cannot be built, so the post is skipped.
    */
    $recentPostUrl = function ($post) {

        $categorySlug = $post->subcategory?->slug ?? $post->category?->slug;

        $blogSlug = !empty($post->blog_url)
            ? $post->blog_url
            : \Illuminate\Support\Str::slug($post->blog_heading);

        if (empty($categorySlug) || empty($blogSlug)) {
            return null;
        }

        return route('blogdetails', [
            'cate_subcate' => $categorySlug,
            'blog_slug'    => $blogSlug,
        ]);
    };
@endphp


<!-- =========================================================
     BLOG BANNER
========================================================= -->

<section class="blog-banner">

    <div class="overlay">
        <div class="container">

            <nav aria-label="breadcrumb" class="banner-breadcrumb">

                <ol class="breadcrumb justify-content-center mb-0">

                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('categoryblogs', ['cate_subcate' => $cate_subcate]) }}">
                            {{ $blog->subcategory->name ?? $blog->category->name }}
                        </a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $blog->blog_heading }}
                    </li>

                </ol>

            </nav>

        </div>
    </div>


    <!-- FLOATING BLOG TITLE -->
    <div class="banner-card">
        <h1>{{ $blog->blog_heading }}</h1>
    </div>

</section>



<!-- =========================================================
     MAIN BLOG CONTAINER
========================================================= -->

<div class="blogdetail-container" id="blogdetailContainer">


    <!-- BLOG CONTENT -->
    <div class="blogdetail-content" id="blogdetailContent">


        <!-- BLOG IMAGE + DATES (LCP element) -->
        <div class="hero-image-wrapper">

            <img
                src="{{ asset($blog->image) }}"
                class="hero-image"
                alt="{{ $blog->alt_tag }}"
                width="1200"
                height="675"
                fetchpriority="high"
                decoding="async"
            >

            <div class="blog-image-date">

                @if($blog->updated_at && $blog->updated_at->gt($blog->created_at))

                    <div class="blog-image-date-item updated-date">

                        <i class="fa-solid fa-rotate"></i>

                        <strong>{{ $blog->updated_at->format('d M Y') }}</strong>

                    </div>

                @endif

            </div>

        </div>


        <!-- ACTION BUTTONS -->
        <div class="blog-action-buttons">

            <!-- Request a Call -->
            <a href="tel:+18444263868" class="action-btn call-btn">

                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path>
                </svg>

                <span>Request a Call</span>

            </a>


            <!-- Book Flight -->
            <a href="{{ route('contact') }}" class="action-btn flight-btn">

                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2l-.5-.2z"></path>
                </svg>

                <span>Book Flight</span>

            </a>


            <!-- Author -->
            @php
                $author     = 'Gabriel Potter';
                $authorSlug = \Illuminate\Support\Str::slug($author);
                $authorUrl  = route('author.blogs', ['authorName' => $authorSlug]);
            @endphp

            <a href="{{ $authorUrl }}" class="action-btn author-btn">

                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4 21a8 8 0 0 1 16 0"></path>
                </svg>

                <span>{{ $author }}</span>

            </a>

        </div>



        <!-- TABLE OF CONTENT -->
        @if(count($toc))

            <div class="table-of-content" id="tableOfContent">

                <h3>Table of Contents</h3>

                <ul>
                    @foreach($toc as $item)
                        <li class="toc-{{ $item['level'] }}">
                            <a href="#{{ $item['slug'] }}">{{ $item['text'] }}</a>
                        </li>
                    @endforeach
                </ul>

            </div>

        @endif



        <!-- EXTRACT "Read Related Post" BLOCK -->
        @php

            $relatedPostLinks = [];

            // MARKDOWN FORMAT
            if (
                preg_match(
                    '/\*\*\s*Read\s+Related\s+Post\s*:?\s*\*\*\s*((?:\R*\s*\[[^\]]+\]\([^)]+\)\s*)+)/i',
                    $content,
                    $blockMatch
                )
            ) {

                preg_match_all(
                    '/\[([^\]]+)\]\(([^)]+)\)/',
                    $blockMatch[1],
                    $linkMatches,
                    PREG_SET_ORDER
                );

                foreach ($linkMatches as $link) {
                    $relatedPostLinks[] = [
                        'title' => trim($link[1]),
                        'url'   => trim($link[2]),
                    ];
                }

                $content = str_replace($blockMatch[0], '', $content);
            }


            // HTML FORMAT
            if (
                empty($relatedPostLinks) &&
                preg_match(
                    '/<p>\s*<strong>\s*Read\s+Related\s+Post\s*:?\s*<\/strong>\s*<\/p>\s*((?:<p>\s*<a[^>]*href=["\']([^"\']+)["\'][^>]*>([^<]+)<\/a>\s*<\/p>\s*)+)/i',
                    $content,
                    $blockMatch
                )
            ) {

                preg_match_all(
                    '/<a[^>]*href=["\']([^"\']+)["\'][^>]*>([^<]+)<\/a>/i',
                    $blockMatch[1],
                    $linkMatches,
                    PREG_SET_ORDER
                );

                foreach ($linkMatches as $link) {
                    $relatedPostLinks[] = [
                        'url'   => trim($link[1]),
                        'title' => trim(html_entity_decode($link[2])),
                    ];
                }

                $content = str_replace($blockMatch[0], '', $content);
            }

        @endphp



        <!-- ARTICLE -->
        <div class="article">

            {!! $content !!}


            <!-- RELATED POSTS -->
            @if(!empty($relatedPostLinks))

                <div class="related-posts">

                    <h3 class="related-posts-title">Read More Related Post:</h3>

                    <div class="related-post-list">

                        @foreach($relatedPostLinks as $related)

                            <a href="{{ $related['url'] }}" class="related-post-link">

                                <span class="related-post-text">{{ $related['title'] }}</span>

                                <span class="related-arrow">→</span>

                            </a>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>



    <!-- =====================================================
         DESKTOP SIDEBAR
         One sticky wrapper holds: TOC (moved here by JS)
         followed by Recent Posts, so both scroll together.
    ====================================================== -->

    <aside class="sidebar" id="desktopSidebar">

        <div class="sidebar-sticky" id="sidebarSticky">

        {{-- Empty anchor: JS inserts the TOC right after this, directly inside the aside --}}
        @if(count($toc))
            <div id="desktopTocSpace" class="desktop-toc-space"></div>
        @endif


        @if($relatedPosts->count())

            <div class="sidebar-card desktop-recent-posts" id="desktopRecentPosts">

                <h3>Recent Posts</h3>

                @foreach($relatedPosts as $post)

                    @php $postUrl = $recentPostUrl($post); @endphp

                    @continue(empty($postUrl))

                    <a href="{{ $postUrl }}" class="sidebar-post-link">

                        <div class="sidebar-post">

                            <img
                                src="{{ asset($post->image) }}"
                                alt="{{ $post->alt_tag ?? $post->blog_heading }}"
                                width="70"
                                height="70"
                                loading="lazy"
                                decoding="async"
                            >

                            <p>{{ $post->blog_heading }}</p>

                        </div>

                    </a>

                @endforeach

            </div>

        @endif

        </div>

    </aside>

</div>



<!-- =========================================================
     FAQ
========================================================= -->

@if($blog->faqs->count())

<section class="faq-section">

    <div class="faq-box">

        <h3 class="faq-title">Frequently Asked Questions (FAQ)</h3>

        @foreach($blog->faqs as $index => $faq)

            <div class="faq-item @if($index === 0) active @endif">

                <button type="button" class="faq-question">

                    <span>Q. {{ $faq->question }}</span>

                    <span class="icon">+</span>

                </button>

                <div class="faq-answer">
                    <p>{{ $faq->answer }}</p>
                </div>

            </div>

        @endforeach

    </div>

</section>

@endif



<!-- =========================================================
     MOBILE RECENT POSTS
========================================================= -->

@if($relatedPosts->count())

<section class="mobile-recent-posts">

    <div class="sidebar-card">

        <h3>Recent Posts</h3>

        @foreach($relatedPosts as $post)

            @php $postUrl = $recentPostUrl($post); @endphp

            @continue(empty($postUrl))

            <a href="{{ $postUrl }}" class="sidebar-post-link">

                <div class="sidebar-post">

                    <img
                        src="{{ asset($post->image) }}"
                        alt="{{ $post->alt_tag ?? $post->blog_heading }}"
                        width="70"
                        height="70"
                        loading="lazy"
                        decoding="async"
                    >

                    <p>{{ $post->blog_heading }}</p>

                </div>

            </a>

        @endforeach

    </div>

</section>

@endif



<!-- =========================================================
     JAVASCRIPT (single script block)
========================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       RELATED POST ANIMATION
    ===================================================== */

    const relatedPosts = document.querySelector('.related-posts');

    if (relatedPosts && 'IntersectionObserver' in window) {

        const observer = new IntersectionObserver(
            function (entries, obs) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        obs.unobserve(entry.target);
                    }
                });
            },
            {
                root: null,
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            }
        );

        observer.observe(relatedPosts);
    }


    /* =====================================================
       FAQ ACCORDION (runs even when there is no TOC)
    ===================================================== */

    document.querySelectorAll('.faq-question').forEach(function (button) {

        button.addEventListener('click', function () {

            const item = this.closest('.faq-item');

            document.querySelectorAll('.faq-item').forEach(function (faq) {
                if (faq !== item) {
                    faq.classList.remove('active');
                }
            });

            item.classList.toggle('active');

        });

    });


    /* =====================================================
       TABLE OF CONTENT
    ===================================================== */

    const toc             = document.getElementById('tableOfContent');
    const desktopTocSpace = document.getElementById('desktopTocSpace');
    const blogContent     = document.getElementById('blogdetailContent');

    if (!toc) {
        return;
    }

    const headings = document.querySelectorAll(
        '.article h2[id], .article h3[id]'
    );


    /* MOVE TOC
       Desktop (>992px): TOC goes into #desktopTocSpace, inside the sticky
       sidebar wrapper, directly above Recent Posts.
       Mobile/Tablet (<=992px): Image -> Buttons -> TOC -> Article */

    function updateTocPosition() {

        if (window.innerWidth > 992) {

            if (desktopTocSpace && toc.previousElementSibling !== desktopTocSpace) {
                desktopTocSpace.insertAdjacentElement('afterend', toc);
            }

        } else {

            const actionButtons = blogContent.querySelector('.blog-action-buttons');
            const imageWrapper  = blogContent.querySelector('.hero-image-wrapper');
            const anchorElement = actionButtons || imageWrapper;

            if (anchorElement && toc.parentNode !== blogContent) {
                anchorElement.insertAdjacentElement('afterend', toc);
            }

        }

    }

    updateTocPosition();

    window.addEventListener('resize', updateTocPosition);


    /* TOC LINKS */

    function getTocLinks() {
        return document.querySelectorAll('#tableOfContent a');
    }


    /* ACTIVE TOC ON SCROLL */

    if (headings.length) {

        function setActiveHeading() {

            let currentHeading = null;

            const offset = 130;

            headings.forEach(function (heading) {

                if (heading.getBoundingClientRect().top <= offset) {
                    currentHeading = heading;
                }

            });

            if (!currentHeading) {
                return;
            }

            getTocLinks().forEach(function (link) {
                link.classList.remove('active');
            });

            const activeLink = document.querySelector(
                '#tableOfContent a[href="#' + CSS.escape(currentHeading.id) + '"]'
            );

            if (activeLink) {
                activeLink.classList.add('active');
            }

        }

        window.addEventListener('scroll', setActiveHeading, { passive: true });

        setActiveHeading();

    }


    /* TOC CLICK (smooth scroll) */

    document.addEventListener('click', function (event) {

        const link = event.target.closest('#tableOfContent a');

        if (!link) {
            return;
        }

        const href = link.getAttribute('href');

        if (!href || href === '#') {
            return;
        }

        const target = document.querySelector(href);

        if (!target) {
            return;
        }

        event.preventDefault();

        getTocLinks().forEach(function (item) {
            item.classList.remove('active');
        });

        link.classList.add('active');

        const headerOffset    = 100;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition  = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });

    });

});
</script>


@endsection