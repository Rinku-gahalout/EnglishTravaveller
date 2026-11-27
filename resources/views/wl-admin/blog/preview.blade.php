@extends('wl-admin.layouts.app')

@section('title', 'Blog preview')

{{-- Needs @yield('meta') inside <head> of layouts/app.blade.php for this tag to be printed --}}
@section('meta')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
<div class="container-fluid py-4 flight">

    <header class="page-head mb-4">
        <div class="page-head__main">
            <span class="page-head__icon"><i class='bx bx-show'></i></span>
            <div>
                <h1>Preview</h1>
                <p>
                    This is how the post will look when published.
                    @if((int) $blog->is_draft === 1)
                        <span class="status status--draft ms-1">Draft</span>
                    @else
                        <span class="status status--published ms-1">Published</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="page-head__actions">
            <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sunset"><i class='bx bx-edit'></i> Edit</a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-sky"><i class='bx bx-arrow-back'></i> Back</a>
        </div>
    </header>

    <article class="panel article">

        @if ($blog->image)
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->alt_tag ?? $blog->blog_heading }}" class="article__cover">
        @endif

        <div class="article__chips">
            @if ($blog->category)
                <span class="chip chip--category">{{ $blog->category->name }}</span>
            @endif
            @if ($blog->subcategory)
                <span class="chip chip--sub">{{ $blog->subcategory->name }}</span>
            @endif
        </div>

        <h2 class="article__title">{{ $blog->blog_heading }}</h2>

        <p class="article__meta">
            {{ $blog->created_at?->format('d M Y') }}
            @if ($blog->language)
                &middot; {{ strtoupper($blog->language) }}
            @endif
        </p>

        {{-- Main content --}}
        <div class="article__body">
            {!! $blog->blog_description !!}
        </div>

        {{-- FAQs --}}
        @if ($blog->faqs && $blog->faqs->count())
            <hr class="article-rule">

            <h3 class="article__faq-title">Frequently asked questions</h3>

            <div class="accordion" id="previewFaqAccordion">
                @foreach ($blog->faqs as $index => $faq)
                    <div class="accordion-item">
                        <h4 class="accordion-header">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h4>
                        <div id="faq{{ $faq->id }}"
                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                             data-bs-parent="#previewFaqAccordion">
                            <div class="accordion-body">{{ $faq->answer }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- SEO preview (admin-only, never shown to visitors) --}}
        @if ($blog->meta_title || $blog->meta_description)
            <hr class="article-rule">

            <div class="seo-box">
                <div class="seo-box__label">How it may appear in search results</div>
                @if ($blog->meta_title)
                    <div class="seo-box__title">{{ $blog->meta_title }}</div>
                @endif
                @if ($blog->meta_description)
                    <div class="seo-box__desc">{{ $blog->meta_description }}</div>
                @endif
            </div>
        @endif

    </article>

</div>
@endsection


@section('styles')
<style>
.flight { color: var(--ink); }
/* Buttons */
        .flight .btn { border-radius: .6rem; font-weight: 600; padding: .55rem 1.1rem; display: inline-flex; align-items: center; justify-content: center; gap: .4rem; }
        .flight .btn i { font-size: 1.15rem; }
        .flight .btn-sm { padding: .35rem .8rem; font-size: .85rem; }
        .flight .btn-sunset { background: var(--sunset); border: 1px solid var(--sunset); color: #fff; }
        .flight .btn-sunset:hover { background: var(--sunset-bright); border-color: var(--sunset-bright); color: var(--navy-deep); box-shadow: 0 8px 18px rgba(156, 96, 55, .3); }
        .flight .btn-outline-sky { background: transparent; border: 1px solid var(--navy-soft); color: var(--navy-soft); }
        .flight .btn-outline-sky:hover { background: var(--navy-soft); color: #fff; }
        .flight .btn-remove { background: transparent; border: 1px solid rgba(214, 69, 69, .5); color: var(--red); }
        .flight .btn-remove:hover { background: var(--red); border-color: var(--red); color: #fff; }
        .flight .btn:focus-visible, .flight .icon-btn:focus-visible, .flight .route-link:focus-visible { outline: 3px solid var(--sky-bright); outline-offset: 2px; }

        /* Page header (inner pages) */
        .page-head {
            position: relative; overflow: hidden;
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 1.25rem 1.5rem 1.25rem 1.75rem; background: #fff;
            border: 1px solid var(--line); border-radius: .9rem;
            box-shadow: 0 6px 18px rgba(45, 56, 43, .07);
        }
        .page-head::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 5px; background: var(--sunset); }
        .page-head__main { display: flex; align-items: center; gap: 1rem; min-width: 0; }
        .page-head__icon {
            width: 52px; height: 52px; flex-shrink: 0; display: grid; place-items: center; border-radius: 50%;
            font-size: 1.6rem; color: var(--sunset-bright); background: var(--navy-deep);
            box-shadow: 0 0 0 4px rgba(156, 96, 55, .18);
        }
        .page-head h1 { font-family: var(--display-font); font-weight: 700; font-size: 1.6rem; margin: 0; color: var(--navy-deep); }
        .page-head p { margin: .15rem 0 0; color: var(--ink-soft); font-size: .92rem; }
        .page-head__actions { display: flex; gap: .6rem; flex-wrap: wrap; }

        /* Panels */
        .panel { position: relative; background: #fff; border: 1px solid var(--line); border-radius: .9rem; padding: 1.25rem 1.4rem; box-shadow: 0 6px 18px rgba(45, 56, 43, .07); }
        .panel--flush { padding: 0; overflow: hidden; }
        .panel__footer {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
            padding: .9rem 1.25rem; border-top: 1px dashed rgba(45, 56, 43, .18); color: var(--ink-soft); font-size: .85rem; background: #fff;
        }

        
        .status { display: inline-flex; align-items: center; gap: .45rem; padding: .3rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 700; }
        .status::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
        .status--published { background: rgba(61, 122, 74, .12); color: #2f6a3d; }
        .status--draft { background: var(--sunset-soft); color: #8a4f27; }

        /* ---------- Article preview ---------- */
        .article { max-width: 860px; margin: 0 auto; padding: 2rem 2.25rem; }
        .article__cover { width: 100%; max-height: 420px; object-fit: cover; border-radius: .8rem; margin-bottom: 1.5rem; }
        .article__chips { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; }
        .chip { display: inline-flex; align-items: center; padding: .25rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 700; }
        .chip--category { background: var(--sky-soft); color: var(--navy-soft); }
        .chip--sub { background: var(--sunset-soft); color: #8a4f27; }
        .article__title { font-family: var(--display-font); font-weight: 800; font-size: clamp(1.8rem, 3.2vw, 2.6rem); line-height: 1.15; color: var(--navy-deep); margin: 0 0 .6rem; }
        .article__meta { color: var(--ink-soft); font-size: .9rem; margin-bottom: 1.75rem; }

        .article__body { font-size: 1.05rem; line-height: 1.8; color: var(--ink); overflow-wrap: anywhere; }
        .article__body img { max-width: 100%; height: auto; border-radius: .5rem; }
        .article__body h2, .article__body h3, .article__body h4 { font-family: var(--display-font); color: var(--navy-deep); margin-top: 1.75rem; }
        .article__body a { color: var(--sunset); }
        .article__body table { max-width: 100%; }

        .article__faq-title { font-family: var(--display-font); font-weight: 700; font-size: 1.6rem; color: var(--navy-deep); margin-bottom: 1rem; }
        .article-rule { border: 0; border-top: 1px dashed rgba(45, 56, 43, .25); margin: 2.5rem 0; opacity: 1; }
        .flight .accordion-item { border-color: var(--line); }
        .flight .accordion-button { font-weight: 600; color: var(--navy-deep); }
        .flight .accordion-button:not(.collapsed) { background: var(--sunset-soft); color: var(--navy-deep); box-shadow: none; }
        .flight .accordion-button:focus { box-shadow: 0 0 0 .2rem rgba(156, 96, 55, .2); }

        .seo-box { background: var(--sky-soft); border: 1px dashed rgba(45, 56, 43, .25); border-radius: .8rem; padding: 1rem 1.25rem; }
        .seo-box__label { font-size: .8rem; font-weight: 700; color: var(--navy-soft); margin-bottom: .5rem; }
        .seo-box__title { color: #1a0dab; font-size: 1.1rem; margin-bottom: .2rem; }
        .seo-box__desc { color: var(--ink-soft); font-size: .88rem; }

        @media (max-width: 768px) { .article { padding: 1.25rem; } }
</style>
@endsection