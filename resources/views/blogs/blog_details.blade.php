@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->blog_heading)
@section('meta_description', $blog->meta_description ?? '')
@section('meta_keywords', $blog->meta_keywords ?? '')

@section('content')
<section class="blog-banner">
    <div class="overlay">
        <div class="container">

            <!-- Breadcrumb -->
            <ul class="banner-breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>/</li>
                <li><a href="#">Blog</a></li>
                <li>/</li>
                <li>{{ Str::limit($blog->blog_heading, 40) }}</li>
            </ul>

            <h1>Blog-Detail</h1>

        </div>
    </div>

    <!-- Floating Title Card -->
    <div class="banner-card">
        <span class="publish-date">
            <i class="fa-solid fa-calendar-days"></i>
            Published on {{ $blog->created_at->format('F d, Y') }}
        </span>

        <h2>
            {{ $blog->blog_heading }}
        </h2>
    </div>
</section>

<style>
.blog-banner {
    position: relative;
    background: url("{{ asset('images/christmas.png') }}") center center/cover no-repeat;
    height: 240px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    overflow: visible;
}

.blog-banner .overlay {
    width: 100%;
    height: 100%;
    background: rgba(88, 54, 36, 0.65);
    display: flex;
    justify-content: center;
    align-items: center;
}

.blog-banner .container {
    color: #fff;
}

.banner-breadcrumb {
    display: flex;
    justify-content: center;
    gap: 8px;
    list-style: none;
    margin: 0 0 8px;
    padding: 0;
    font-size: 13px;
}

.banner-breadcrumb li,
.banner-breadcrumb a {
    color: #fff;
    text-decoration: none;
}

.blog-banner h1 {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 8px;
}

.blog-banner p {
    font-size: 13px;
    max-width: 550px;
    margin: auto;
    line-height: 1.5;
}

/* Floating White Card */
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
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    text-align: center;
}

.publish-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #8a8a8a;
    margin-bottom: 10px;
}

.publish-date i {
    color: #b67b52;
    font-size: 14px;
}

.banner-card h2 {
    margin: 0;
    color: #5c2f19;
    font-size: 28px;
    font-weight: 600;
    line-height: 1.4;
}

/* Mobile */
@media (max-width: 768px) {

    .blog-banner {
        height: 200px;
    }

    .blog-banner h1 {
        font-size: 26px;
    }

    .blog-banner p {
        font-size: 12px;
        padding: 0 15px;
    }

    .banner-card {
        padding: 15px;
        bottom: -35px;
    }

    .banner-card h2 {
        font-size: 20px;
    }

    .publish-date {
        font-size: 13px;
    }
}
</style>


<div class="blogdetail-container">

    <div class="blogdetail-content">

        <img src="{{ asset($blog->image) }}"
             class="hero-image"
             alt="{{ $blog->alt_tag ?? $blog->blog_heading }}">

        <div class="article">
            {!! $content !!}
        </div>

    </div>

    <aside class="sidebar">

        @if(count($toc))
        <div class="table-of-content sticky-toc">
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

        @if($relatedPosts->count())
        <div class="sidebar-card border-box p-4 rounded-4">

            <h3>Recent Posts</h3>

@foreach($relatedPosts as $post)
    <a href="{{ route('blogdetails', [
        'cate_subcate' => $post->subcategory->slug ?? $post->category->slug,
        'blog_slug' => \Illuminate\Support\Str::slug($post->blog_heading),
    ]) }}" class="sidebar-post-link">

        <div class="sidebar-post">
            <img src="{{ asset($post->image) }}"
                 alt="{{ $post->alt_tag ?? $post->blog_heading }}">

            <p>{{ $post->blog_heading }}</p>
        </div>

    </a>
@endforeach

        </div>
        @endif

    </aside>

</div>


<style>

.blogdetail-container{
    width:1200px;
    margin:40px auto;
    display:grid;
    grid-template-columns:2.7fr 1fr;
    gap:45px;
    margin-top: 131px;
    margin-bottom: 78px;
}

.hero-image{
    width:100%;
    border-radius:14px;
    display:block;
}

.article{
    margin-top:30px;
}

.article p{
    font-size:18px;
    margin-bottom:22px;
    color:#444;
}

.article h2{
    margin:35px 0 15px;
    font-size:30px;
    color:#7b3f12;
    font-weight:500;
    scroll-margin-top: 100px;
}

.article h3{
    margin:28px 0 12px;
    font-size:22px;
    color:#7b3f12;
    font-weight:500;
    scroll-margin-top: 100px;
}

.article ul{
    margin-left:25px;
}

.article li{
    margin:12px 0;
    font-size:18px;
}

/* Sidebar */

.blogdetail-card{
    background:#fff;
    border:1px solid #ddd;
    border-radius:12px;
    padding:25px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    position:sticky;
    top:20px;
}

.blogdetail-card h3{
    font-size:32px;
    margin-bottom:25px;
    color:#7b3f12;
}

.blogdetail-post{
    display:flex;
    gap:15px;
    align-items:center;
    padding:18px 0;
    border-top:1px solid #eee;
}

.blogdetail-post:first-of-type{
    border-top:none;
}

.blogdetail-post img{
    width:78px;
    height:60px;
    object-fit:cover;
    border-radius:8px;
}

.blogdetail-post p{
    font-size:16px;
    font-weight:500;
    color:#444;
}

.sidebar-post-link{
    text-decoration:none;
    display:block;
}

.sidebar-post {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
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
    line-height: 1.5;
    color: #333;
    font-weight: 500;
}

.sidebar-card {
    border:2px solid #eee;
    background: #F9FBFF;
}

.sidebar-card h3{
   color: #6C3F2A;
   border-bottom:2px solid #49505742;
}

.sidebar-card p{
   color: #6C3F2A;
}

.table-of-content{
    margin:30px 0;
    background:#F9FBFF;
    border:1px solid #E4EAF4;
    border-radius:12px;
    padding:24px;
}

.table-of-content h3{
    font-size:24px;
    color:#27014B;
    margin-bottom:18px;
    font-weight:700;
    border-bottom:2px solid #49505742;
}

.table-of-content ul{
    list-style:none;
    padding:0;
    margin:0;
}

.table-of-content li{
    padding:12px 0;
    border-bottom:1px solid #ECECEC;
}

.table-of-content li:last-child{
    border-bottom:none;
}

.table-of-content a{
    text-decoration: none;
    color: #6C3F2A;
    font-size: 14px;
    display: block;
    transition: .3s;
    font-weight: 500;
}

.table-of-content a:hover{
    color:#6C3F2A;
    padding-left:8px;
}

.toc-h3 a{
    padding-left:14px;
    font-size:13px;
}

@media(max-width:992px){

.blogdetail-container{
    width:95%;
    grid-template-columns:1fr;
}

.blogdetail-card{
    position:relative;
}

}
</style>


@if($blog->faqs->count())
<section class="faq-section">
    <div class="faq-box">

        <h3 class="faq-title">Frequently Asked Questions (FAQ)</h3>

        @foreach($blog->faqs as $index => $faq)
            <div class="faq-item @if($index === 0) active @endif">
                <button class="faq-question">
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

<style>
.faq-section{
    display:flex;
    justify-content:center;
    padding:40px 20px;
}

.faq-box{
    width:1200px;
    background:#f4f4f4;
    border-radius:12px;
    padding:18px 20px;
    margin: 44px;
    margin-top: -93px;
}

.faq-title{
    text-align:center;
    font-size:30px;
    font-weight:500;
    color:#6C3F2A;
    margin-bottom:15px;
}

.faq-item{
    border-bottom:1px solid #d8d8d8;
}

.faq-item:last-child{
    border-bottom:none;
}

.faq-question{
    width:100%;
    background:none;
    border:none;
    outline:none;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    cursor:pointer;
    font-size:20px;
    font-weight:600;
    color:#333;
    text-align:left;
}

.faq-question span:first-child{
    flex:1;
}

.icon{
    font-size:24px;
    color:#555;
    line-height:1;
    transition:.3s;
}

.faq-answer{
    max-height:0;
    overflow:hidden;
    transition:max-height .35s ease;
}

.faq-answer p{
    margin:0;
    padding:0 0 18px;
    font-size:16px;
    color:#2E3A2E;
    line-height:1.7;
}

.faq-item.active .faq-answer{
    max-height:200px;
}

.faq-item.active .icon{
    transform:rotate(45deg);
}
</style>


<script>
document.querySelectorAll('.faq-question').forEach(button => {

    button.addEventListener('click', function(){

        const item = this.parentElement;

        document.querySelectorAll('.faq-item').forEach(faq => {
            if(faq !== item){
                faq.classList.remove('active');
            }
        });

        item.classList.toggle('active');

    });

});
</script>

@endsection