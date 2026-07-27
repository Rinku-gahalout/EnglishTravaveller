@extends('layouts.app')

@section('title', 'blog')

@section('content')

<section class="contact-banner">
    <div class="overlay">
        <div class="container">
            <h1>{{ $category->name ?? 'Blog' }}</h1>

            <p>
                We welcome to the English Traveller. We are an independent travel-related
                information provider site.
            </p>
        </div>
    </div>
</section>

<style>
.contact-banner{
    background: url("{{ asset('images/christmas.png') }}") center center/cover no-repeat;
    height: 260px;
    position: relative;
}

.contact-banner .overlay{
    position: absolute;
    inset: 0;
    background: rgba(88, 54, 36, 0.65); /* Brown transparent overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.contact-banner .container{
    max-width: 1200px;
    width: 100%;
    padding: 0 20px;
}

.contact-banner h1{
    font-size: 46px;
    color: #fff;
    font-weight: 500;
    margin-bottom: 12px;
    line-height: 1;
}

.contact-banner h1 span{
    color: #d39a45;
    font-weight: 600;
}

.contact-banner p{
    color: #fff;
    font-size: 14px;
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.6;
    opacity: .95;
}
    </style>


<div class="blog-container">

<div class="search-box">
    <input type="text" placeholder="Search...">
    <span>
        <img src="{{ asset('images/Group 1597884477.png') }}" alt="Search">
    </span>
</div>

<div class="blog-grid" id="blogGrid">

    @foreach($blogs as $blog)
        <div class="blog-card active">

            <img src="{{ asset($blog->image) }}" alt="{{ $blog->alt_tag }}">

            <div class="blog-content">
                <span class="publish-date">
                    Published on: {{ $blog->created_at->format('F d, Y') }}
                </span>

                <h3>{{ $blog->blog_heading }}</h3>

                <a href="{{ route('blogdetails',[
                    'cate_subcate'=>$blog->subcategory->slug ?? $blog->category->slug,
                    'blog_slug'=>\Illuminate\Support\Str::slug($blog->blog_heading)
                ]) }}">
                    Read more →
                </a>
            </div>

        </div>
    @endforeach

</div>
@if($blogs->hasMorePages())
<div class="view-all-wrapper">
    <button id="viewAllBtn"
            class="view-all-btn"
            data-next="{{ $blogs->nextPageUrl() }}">
        View All
    </button>
</div>
@endif
</div>


<style>


.blog-container{
    max-width:1200px;
    margin:auto;
    padding:0 20px;
    position:relative;
    z-index:2;
    margin-top: 47px;
    margin-bottom: 85px;
}

.search-box {
    width:300px;
    margin:0 auto 40px;
    position:relative;
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
    background: #21252900;
}

.search-box span img {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.blog-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:45px;
}

.blog-card{
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    transition:.3s;
    border:none;
}

.blog-card img{
    width:100%;
    height:170px;
    object-fit:cover;
    border-radius:10px;
}

.blog-content{
    padding:12px 0;
}

.blog-content h3{
   font-size: 20px;
    line-height: 28px;
    font-weight: 700;
    margin-bottom:18px;
    color:#6C3F2A;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    margin-top: 6px;
}

.blog-content p{
    color:#666;
    font-size:15px;
    line-height:24px;
    margin-bottom:18px;

    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.blog-content a{
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

.blog-content a:hover{
    background:#b96d33;
    color:#fff;
}

.blog-card.hidden {
    display: none;
}

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
    transition: 0.3s;
    display:block!important;
}

.view-all-btn:hover {
    background: #A37437;
}

/* Mobile View */
@media (max-width: 768px) {

    .blog-container {
        padding: 0 15px;
        margin-top: 30px;
        margin-bottom: 50px;
    }

    .search-box {
        width: 100%;
        margin-bottom: 30px;
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".blog-card");
    const btn = document.getElementById("viewAllBtn");

    // If there are 9 or fewer cards, hide the button
    if (cards.length <= 9) {
        btn.style.display = "none";
        return;
    }

    let expanded = false;

    // Initially hide cards after the first 9
    function hideExtraCards() {
        cards.forEach((card, index) => {
            if (index >= 9) {
                card.classList.add("hidden");
            }
        });
        btn.textContent = "View All";
        expanded = false;
    }

    hideExtraCards();

    btn.addEventListener("click", function () {
        if (!expanded) {
            // Show all cards
            cards.forEach(card => card.classList.remove("hidden"));
            btn.textContent = "View Less";
            expanded = true;
        } else {
            // Hide cards after the first 9
            hideExtraCards();

            // Scroll back to the blog section (optional)
            document.querySelector(".blog-container").scrollIntoView({
                behavior: "smooth"
            });
        }
    });
});
</script>

<script>
document.getElementById('viewAllBtn')?.addEventListener('click', function () {

    let btn = this;
    let url = btn.dataset.next;

    if (!url) return;

    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {

        let parser = new DOMParser();
        let doc = parser.parseFromString(html, 'text/html');

        let newBlogs = doc.querySelector('#blogGrid').innerHTML;
        document.querySelector('#blogGrid').insertAdjacentHTML('beforeend', newBlogs);

        let nextBtn = doc.querySelector('#viewAllBtn');

        if (nextBtn) {
            btn.dataset.next = nextBtn.dataset.next;
        } else {
            btn.remove();
        }

    });

});
</script>

@endsection