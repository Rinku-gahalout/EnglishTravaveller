@extends('wl-admin.layouts.app')
@section('meta')
    <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
    <div class="container-fluid py-4 ledger-dash">

        {{-- =========================
            PREVIEW HEADER
        ========================== --}}
        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">Preview: {{ Str::limit($blog->blog_heading, 60) }}</h2>
                <p class="mb-0 text-secondary">
                    This is how the post will look when published.
                    @if((int) $blog->is_draft === 1)
                        <span class="badge ledger-badge-draft ms-1">Draft</span>
                    @else
                        <span class="badge ledger-badge-published ms-1">Published</span>
                    @endif
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-ledger-edit">Edit</a>
                <a href="{{ url()->previous() }}" class="btn btn-outline-ledger">Back</a>
            </div>
        </div>

        {{-- =========================
            PREVIEW CARD
        ========================== --}}
        <div class="card ledger-card">
            <div class="card-body p-4 p-md-5">

                @if ($blog->image)
                    <img src="{{ asset($blog->image) }}"
                         alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
                         class="w-100 rounded-3 mb-4"
                         style="max-height: 420px; object-fit: cover;">
                @endif

                <div class="d-flex flex-wrap gap-2 mb-3">
                    @if ($blog->category)
                        <span class="badge ledger-badge-published">{{ $blog->category->name }}</span>
                    @endif
                    @if ($blog->subcategory)
                        <span class="badge ledger-badge-draft">{{ $blog->subcategory->name }}</span>
                    @endif
                </div>

                <h1 class="preview-title mb-2">{{ $blog->blog_heading }}</h1>

                <p class="text-secondary mb-4">
                    {{ $blog->created_at?->format('d M Y') }}
                    @if ($blog->language)
                        &middot; {{ strtoupper($blog->language) }}
                    @endif
                </p>

                {{-- Main content --}}
                <div class="preview-body">
                    {!! $blog->blog_description !!}
                </div>

                {{-- FAQs --}}
                @if ($blog->faqs && $blog->faqs->count())
                    <hr class="my-5">

                    <h3 class="preview-faq-title mb-3">Frequently Asked Questions</h3>

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
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- SEO meta preview (admin-only info, not shown to real visitors) --}}
                @if ($blog->meta_title || $blog->meta_description)
                    <hr class="my-5">

                    <div class="seo-preview-box p-3 rounded-3">
                        <div class="text-secondary small mb-2 text-uppercase fw-bold">SEO Preview</div>
                        @if ($blog->meta_title)
                            <div class="seo-title mb-1">{{ $blog->meta_title }}</div>
                        @endif
                        @if ($blog->meta_description)
                            <div class="seo-desc text-secondary small">{{ $blog->meta_description }}</div>
                        @endif
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;800&family=Inter:wght@400;500;600;700&display=swap");

        :root {
            --navy-deep: #0b1d26;
            --navy-soft: #1d3f50;
            --brass: #c9a26a;
            --brass-bright: #e7c68c;
            --paper: #f6f1e4;
            --ink: #16232b;
            --ink-soft: #5b6b74;
            --display-font: 'Big Shoulders Display', sans-serif;
        }

        .ledger-header h2 { font-family: var(--display-font); }

        .ledger-card {
            border-radius: 1rem;
            border: 1px solid rgba(22, 35, 43, .08);
            background: #fffdf8;
            box-shadow: 0 4px 14px rgba(11, 29, 38, .06);
        }

        .btn-ledger-edit {
            background: var(--navy-soft);
            color: var(--paper);
            border: none;
        }
        .btn-ledger-edit:hover { background: var(--navy-deep); color: var(--paper); }

        .btn-outline-ledger {
            background: transparent;
            border: 1px solid var(--navy-soft);
            color: var(--navy-soft);
            font-weight: 600;
            border-radius: .5rem;
        }
        .btn-outline-ledger:hover { background: var(--navy-soft); color: var(--paper); }

        .badge {
            font-size: .78rem;
            padding: .4em .8em;
            border-radius: .5rem;
        }
        .ledger-badge-published {
            background: rgba(31, 110, 79, .12);
            color: #1f6e4f;
            border: 1px solid rgba(31, 110, 79, .3);
        }
        .ledger-badge-draft {
            background: rgba(201, 162, 106, .18);
            color: #8a6a34;
            border: 1px solid rgba(201, 162, 106, .4);
        }

        .preview-title {
            font-family: var(--display-font);
            font-weight: 800;
            color: var(--navy-deep);
            line-height: 1.15;
        }

        .preview-body {
            font-size: 1.05rem;
            line-height: 1.75;
            color: var(--ink);
        }
        .preview-body img { max-width: 100%; height: auto; border-radius: .5rem; }
        .preview-body h2, .preview-body h3 { font-family: var(--display-font); color: var(--navy-deep); margin-top: 1.5rem; }

        .preview-faq-title {
            font-family: var(--display-font);
            color: var(--navy-deep);
        }

        .accordion-button:not(.collapsed) {
            background: rgba(201, 162, 106, .12);
            color: var(--navy-deep);
        }
        .accordion-button:focus {
            box-shadow: 0 0 0 .2rem rgba(201, 162, 106, .2);
        }

        .seo-preview-box {
            background: var(--paper);
            border: 1px dashed rgba(22, 35, 43, .15);
        }
        .seo-title {
            color: #1a0dab;
            font-size: 1.1rem;
        }
    </style>
@endsection