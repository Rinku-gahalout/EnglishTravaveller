@extends('wl-admin.layouts.app')

@section('title', 'Blog management')

@section('content')
@php
    // Stats: all blogs initially; filtered by category when one is selected.
    $selectedCategory = request('category');
    $statsQuery = \App\Models\Blog::query()->whereDate('created_at', '>=', '2026-09-10');

    if (!empty($selectedCategory)) {
        $statsQuery->where('category_id', $selectedCategory);
    }

    $totalBlogs     = (clone $statsQuery)->count();
    $publishedBlogs = (clone $statsQuery)->where('is_draft', 0)->count();
    $draftBlogs     = (clone $statsQuery)->where('is_draft', 1)->count();

    $adminName = auth('admin')->user()->name ?? 'there';
@endphp

<div class="container-fluid py-4 flight">

    @include('wl-admin.layouts.sessionmessage')

    {{-- ===================== HERO: SKY + FLIGHT PATH ===================== --}}
    <section class="sky-hero mb-4">
        <svg class="sky-hero__art" viewBox="0 0 640 200" preserveAspectRatio="xMaxYMid slice" aria-hidden="true">
            {{-- clouds --}}
            <g fill="#ffffff" fill-opacity=".1">
                <ellipse cx="120" cy="170" rx="90" ry="22"/>
                <ellipse cx="180" cy="158" rx="60" ry="24"/>
                <ellipse cx="470" cy="182" rx="110" ry="24"/>
                <ellipse cx="540" cy="166" rx="64" ry="26"/>
            </g>
            {{-- flight path with a plane at the end --}}
            <path d="M20 170 C 180 150, 300 40, 560 40" fill="none" stroke="#ffffff" stroke-opacity=".6"
                  stroke-width="2" stroke-dasharray="2 9" stroke-linecap="round"/>
            <circle cx="20" cy="170" r="5" fill="#b5c9ad"/>
            <g transform="translate(572 38) rotate(-4)" fill="#ffffff">
                <path d="M0 0 L-30 -10 L-22 0 L-30 10 Z"/>
                <path d="M-8 0 L-24 -22 L-18 0 L-24 22 Z" fill-opacity=".75"/>
            </g>
        </svg>

        <div class="sky-hero__text">
            <h1>Welcome back, {{ $adminName }}</h1>
            <p>Write, review and publish blog posts for englishtraveller.us. Drafts stay private until you publish them.</p>
        </div>

        <div class="sky-hero__actions">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-sunset">
                <i class='bx bx-plus'></i> Add blog
            </a>
            <a href="{{ route('admin.blogs.drafts') }}" class="btn btn-ghost">
                <i class='bx bx-edit-alt'></i> View drafts
            </a>
        </div>
    </section>

    {{-- ===================== BOARDING-PASS STATS ===================== --}}
    <div class="row g-3 mb-4">
        @php
            $passes = [
                ['label' => 'Total blogs', 'value' => $totalBlogs,      'icon' => 'bx-book-content', 'tone' => 'sky'],
                ['label' => 'Published',   'value' => $publishedBlogs,  'icon' => 'bx-check-circle', 'tone' => 'green'],
                ['label' => 'Drafts',      'value' => $draftBlogs,      'icon' => 'bx-edit-alt',     'tone' => 'sunset'],
                ['label' => 'Categories',  'value' => $totalCategories, 'icon' => 'bx-purchase-tag', 'tone' => 'navy'],
            ];
        @endphp

        @foreach ($passes as $pass)
            <div class="col-sm-6 col-xl-3">
                <div class="pass-shell">
                    <div class="pass pass--{{ $pass['tone'] }}">
                        <div class="pass__main">
                            <div class="pass__value">{{ $pass['value'] }}</div>
                            <div class="pass__label">{{ $pass['label'] }}</div>
                        </div>
                        <div class="pass__stub">
                            <span class="pass__icon"><i class='bx {{ $pass['icon'] }}'></i></span>
                            <span class="pass__barcode"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===================== FILTERS ===================== --}}
    <section class="panel mb-4">
        <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label for="categoryFilter" class="field-label">Category</label>
                    <div class="field-icon">
                        <i class='bx bx-category'></i>
                        <select name="category" id="categoryFilter" class="form-select field">
                            <option value="">All categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ (string) $category === (string) $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="search" class="field-label">Search</label>
                    <div class="field-icon">
                        <i class='bx bx-search'></i>
                        <input type="text" name="search" id="search" class="form-control field"
                               placeholder="Blog title or keyword" value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sunset flex-grow-1">Search</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-sky flex-grow-1">Reset</a>
                </div>

            </div>
        </form>
    </section>

    {{-- ===================== BLOG TABLE ===================== --}}
    <section class="panel panel--flush">

        <div class="table-responsive">
            <table class="table board-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Blog URL</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($blogs as $blog)
                    @php
                        $categorySlug = $blog->subcategory?->slug ?? $blog->category?->slug;
                        $hasUrl = $categorySlug && $blog->blog_url;
                        $isPublished = (int) $blog->is_draft === 0;
                    @endphp

                    <tr class="{{ $isPublished ? 'is-published' : 'is-draft' }}">

                        <td class="text-center serial">
                            {{ $loop->iteration + (($blogs->currentPage() - 1) * $blogs->perPage()) }}
                        </td>

                        <td class="text-nowrap">{{ $blog->created_at?->format('d M Y') }}</td>

                        <td>
                            @if ($blog->image)
                                <img src="{{ asset($blog->image) }}"
                                     alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
                                     class="thumb" width="56" height="56" loading="lazy">
                            @else
                                <span class="thumb thumb--empty"><i class='bx bx-image'></i></span>
                            @endif
                        </td>

                        <td class="title-cell">
                            <div class="title-cell__main">{{ Str::limit($blog->blog_heading, 45) }}</div>
                            @if ($blog->meta_title)
                                <div class="title-cell__sub">{{ Str::limit($blog->meta_title, 60) }}</div>
                            @endif
                        </td>

                        <td>
                            @if ($hasUrl)
                                <a href="{{ route('blogdetails', ['cate_subcate' => $categorySlug, 'blog_slug' => $blog->blog_url]) }}"
                                   target="_blank" rel="noopener noreferrer" class="route-link">
                                    /{{ $categorySlug }}/{{ $blog->blog_url }}
                                </a>
                            @else
                                <span class="text-muted small">No URL</span>
                            @endif
                        </td>

                        <td>{{ $blog->category->name ?? '—' }}</td>
                        <td>{{ $blog->subcategory->name ?? '—' }}</td>

                        <td>
                            @if ($isPublished)
                                <span class="status status--published">Published</span>
                            @else
                                <span class="status status--draft">Draft</span>
                            @endif
                        </td>

                        <td class="pe-4">
                            <div class="d-flex justify-content-end gap-2">

                                @if ($hasUrl)
                                    <a href="{{ route('blogdetails', ['cate_subcate' => $categorySlug, 'blog_slug' => $blog->blog_url]) }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="icon-btn icon-btn--preview" title="Preview" aria-label="Preview">
                                        <i class='bx bx-show'></i>
                                    </a>
                                @else
                                    <span class="icon-btn icon-btn--disabled" title="No URL yet" aria-label="No URL yet">
                                        <i class='bx bx-hide'></i>
                                    </span>
                                @endif

                                <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                   class="icon-btn icon-btn--edit" title="Edit" aria-label="Edit">
                                    <i class='bx bx-edit'></i>
                                </a>

                                @if (auth('admin')->user()?->role === 'admin')
                                    <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST"
                                          data-title="{{ $blog->blog_heading }}" class="d-inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-btn icon-btn--delete js-delete"
                                                title="Delete" aria-label="Delete">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <i class='bx bx-map-alt'></i>
                            <div class="empty-state__title">
                                No blogs found
                                @if ($search || $category)
                                    for these filters
                                @endif
                            </div>
                            <div class="empty-state__hint">
                                @if ($search || $category)
                                    Try a different keyword or reset the filters.
                                @else
                                    Add your first blog to get started.
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel__footer">
            <div>
                @if ($blogs->total() > 0)
                    Showing <strong>{{ $blogs->firstItem() }}</strong>–<strong>{{ $blogs->lastItem() }}</strong>
                    of <strong>{{ $blogs->total() }}</strong> blogs
                @else
                    No results
                @endif
            </div>

            @if ($blogs->hasPages())
                <div class="pagination-wrapper">
                    {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

</div>
@endsection


@section('styles')
<style>
    .flight { color: var(--ink); }

    /* ---------- Buttons ---------- */
    .flight .btn { border-radius: .6rem; font-weight: 600; padding: .6rem 1.1rem; display: inline-flex; align-items: center; justify-content: center; gap: .4rem; }
    .flight .btn i { font-size: 1.15rem; }

    .flight .btn-sunset { background: var(--sunset); border: 1px solid var(--sunset); color: #fff; }
    .flight .btn-sunset:hover { background: var(--sunset-bright); border-color: var(--sunset-bright); color: var(--navy-deep); box-shadow: 0 8px 18px rgba(156, 96, 55, .35); }

    .flight .btn-ghost { background: rgba(255, 255, 255, .08); border: 1px solid rgba(255, 255, 255, .45); color: #fff; }
    .flight .btn-ghost:hover { background: rgba(255, 255, 255, .2); color: #fff; border-color: #fff; }

    .flight .btn-outline-sky { background: transparent; border: 1px solid var(--navy-soft); color: var(--navy-soft); }
    .flight .btn-outline-sky:hover { background: var(--navy-soft); color: #fff; }

    .flight .btn:focus-visible, .flight .icon-btn:focus-visible, .flight .route-link:focus-visible {
        outline: 3px solid var(--sky-bright); outline-offset: 2px;
    }

    /* ---------- Hero ---------- */
    .sky-hero {
        position: relative; overflow: hidden;
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem;
        padding: 2.1rem 2.25rem; border-radius: 1rem; color: #fff;
        background:
            radial-gradient(60% 120% at 95% 110%, rgba(156, 96, 55, .75), transparent 60%),
            linear-gradient(130deg, #1f281e, var(--navy-deep) 55%, var(--navy-soft));
        box-shadow: 0 14px 34px rgba(45, 56, 43, .25);
    }
    .sky-hero__art { position: absolute; right: 0; top: 0; height: 100%; width: 62%; pointer-events: none; }
    .sky-hero__text, .sky-hero__actions { position: relative; z-index: 1; }
    .sky-hero h1 { font-family: var(--display-font); font-weight: 700; font-size: clamp(1.6rem, 3vw, 2.3rem); margin: 0 0 .35rem; color: #fff; }
    .sky-hero p { margin: 0; max-width: 48ch; color: rgba(255, 255, 255, .85); }
    .sky-hero__actions { display: flex; gap: .6rem; flex-wrap: wrap; }

    /* ---------- Boarding-pass stats ---------- */
    .pass-shell { height: 100%; filter: drop-shadow(0 6px 10px rgba(45, 56, 43, .12)); }

    .pass {
        --stub: 92px;
        --pass-accent: var(--sky);
        height: 100%; display: flex; align-items: stretch;
        background: #ffffff;
        border-radius: .9rem;
        /* half-circle notches where the stub tears off */
        -webkit-mask:
            radial-gradient(circle 10px at calc(100% - var(--stub)) 0, #0000 97%, #000) top / 100% 51% no-repeat,
            radial-gradient(circle 10px at calc(100% - var(--stub)) 100%, #0000 97%, #000) bottom / 100% 51% no-repeat;
        mask:
            radial-gradient(circle 10px at calc(100% - var(--stub)) 0, #0000 97%, #000) top / 100% 51% no-repeat,
            radial-gradient(circle 10px at calc(100% - var(--stub)) 100%, #0000 97%, #000) bottom / 100% 51% no-repeat;
    }

    .pass__main { flex: 1; padding: 1.1rem 1.2rem; border-left: 5px solid var(--pass-accent); border-radius: .9rem 0 0 .9rem; }
    .pass__value { font-family: var(--display-font); font-weight: 800; font-size: 2.6rem; line-height: 1; color: var(--navy-deep); }
    .pass__label { margin-top: .35rem; font-weight: 600; font-size: .9rem; color: var(--ink-soft); }

    .pass__stub {
        width: var(--stub); flex-shrink: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .6rem;
        border-left: 2px dashed rgba(45, 56, 43, .18);
        background: linear-gradient(180deg, color-mix(in srgb, var(--pass-accent) 10%, #fff), #fff);
    }
    .pass__icon {
        width: 40px; height: 40px; display: grid; place-items: center; border-radius: 50%;
        font-size: 1.3rem; color: #fff; background: var(--pass-accent);
    }
    .pass__barcode {
        width: 52px; height: 18px; opacity: .55;
        background: repeating-linear-gradient(90deg, var(--navy-deep) 0 2px, transparent 2px 4px, var(--navy-deep) 4px 5px, transparent 5px 8px);
    }

    .pass--sky    { --pass-accent: var(--sky); }
    .pass--green  { --pass-accent: var(--green); }
    .pass--sunset { --pass-accent: var(--sunset); }
    .pass--navy   { --pass-accent: var(--navy-soft); }

    /* ---------- Panels ---------- */
    .panel {
        position: relative; background: #ffffff; border: 1px solid var(--line);
        border-radius: .9rem; padding: 1.25rem 1.4rem;
        box-shadow: 0 6px 18px rgba(45, 56, 43, .07);
    }
    .panel--flush { padding: 0; overflow: hidden; }

    /* ---------- Fields ---------- */
    .field-label { font-weight: 700; font-size: .85rem; color: var(--navy-soft); margin-bottom: .35rem; }
    .field-icon { position: relative; }
    .field-icon > i { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--ink-soft); font-size: 1.15rem; pointer-events: none; z-index: 2; }
    .flight .field { min-height: 44px; padding-left: 2.5rem; border: 1px solid rgba(45, 56, 43, .18); border-radius: .6rem; background-color: var(--cloud); }
    .flight .field:focus { border-color: var(--sky); box-shadow: 0 0 0 .22rem rgba(93, 120, 86, .22); }

    /* ---------- Table (departure board) ---------- */
    .board-table { --bs-table-bg: transparent; }
    .board-table thead th {
        background: var(--navy-deep); color: var(--sky-bright);
        font-family: var(--display-font); font-weight: 600; font-size: .95rem; letter-spacing: .03em;
        padding: .95rem .75rem; border: 0; white-space: nowrap;
    }
    .board-table tbody td { padding: .85rem .75rem; border-color: var(--line); font-size: .92rem; }
    .board-table tbody tr { transition: background .2s ease; }
    .board-table tbody tr:hover { background: var(--sky-soft); }

    /* left edge stripe shows status at a glance */
    .board-table tbody tr.is-published td:first-child { box-shadow: inset 4px 0 0 var(--green); }
    .board-table tbody tr.is-draft td:first-child { box-shadow: inset 4px 0 0 var(--sunset); }

    .serial { font-family: var(--mono-font); color: var(--ink-soft); font-size: .82rem !important; }

    .thumb { width: 56px; height: 56px; object-fit: cover; border-radius: .6rem; border: 1px solid var(--line); display: block; }
    .thumb--empty { display: grid; place-items: center; background: var(--cloud); color: var(--ink-soft); font-size: 1.4rem; }

    .title-cell { min-width: 220px; }
    .title-cell__main { font-weight: 600; color: var(--navy-deep); }
    .title-cell__sub { font-size: .8rem; color: var(--ink-soft); margin-top: .15rem; }

    .route-link {
        display: inline-block; max-width: 260px; word-break: break-word;
        font-family: var(--mono-font); font-size: .76rem; font-weight: 700;
        color: var(--sky); text-decoration: none; border-bottom: 1px dashed var(--sky);
    }
    .route-link:hover { color: var(--navy-deep); border-bottom-style: solid; }

    /* status pills (own class so they don't clash with Bootstrap .badge) */
    .status { display: inline-flex; align-items: center; gap: .45rem; padding: .3rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 700; }
    .status::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
    .status--published { background: rgba(61, 122, 74, .12); color: #2f6a3d; }
    .status--draft { background: var(--sunset-soft); color: #8a4f27; }

    /* icon action buttons */
    .icon-btn {
        width: 38px; height: 38px; display: inline-grid; place-items: center;
        border: 0; border-radius: .6rem; font-size: 1.2rem; text-decoration: none; cursor: pointer;
        transition: transform .15s ease, background .2s ease, color .2s ease;
    }
    .icon-btn:hover { transform: translateY(-2px); }
    .icon-btn--preview { background: var(--sky-soft); color: var(--sky); }
    .icon-btn--preview:hover { background: var(--sky); color: #fff; }
    .icon-btn--edit { background: var(--sunset-soft); color: #8a4f27; }
    .icon-btn--edit:hover { background: var(--sunset); color: #fff; }
    .icon-btn--delete { background: rgba(214, 69, 69, .12); color: var(--red); }
    .icon-btn--delete:hover { background: var(--red); color: #fff; }
    .icon-btn--disabled { background: #eceff3; color: #aab3bd; cursor: not-allowed; }
    .icon-btn--disabled:hover { transform: none; }

    /* empty state */
    .empty-state { text-align: center; padding: 3.5rem 1rem !important; color: var(--ink-soft); }
    .empty-state i { font-size: 2.6rem; color: var(--sky); }
    .empty-state__title { font-family: var(--display-font); font-weight: 700; font-size: 1.3rem; color: var(--navy-deep); margin-top: .4rem; }
    .empty-state__hint { font-size: .9rem; }

    /* footer + pagination */
    .panel__footer {
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
        padding: .9rem 1.25rem; border-top: 1px dashed rgba(45, 56, 43, .18);
        color: var(--ink-soft); font-size: .85rem; background: var(--cloud);
    }
    /* Laravel's bootstrap-5 view prints its own "Showing x to y" text; we already show that on the left */
    .pagination-wrapper p.small { display: none; }
    .flight .pagination { margin: 0; }
    .flight .pagination .page-link { color: var(--navy-soft); border-color: var(--line); border-radius: .5rem; margin: 0 2px; }
    .flight .pagination .page-link:hover { background: var(--sky-soft); border-color: var(--sky); color: var(--navy-deep); }
    .flight .pagination .page-item.active .page-link { background: var(--navy-soft); border-color: var(--navy-soft); color: #fff; }
    .flight .pagination .page-item.disabled .page-link { color: #9aa3a8; }

    @media (max-width: 768px) {
        .sky-hero { padding: 1.5rem 1.25rem; }
        .sky-hero__art { width: 100%; opacity: .6; }
        .route-link { max-width: 180px; }
        .panel__footer { flex-direction: column; align-items: flex-start; }
        .pagination-wrapper { width: 100%; overflow-x: auto; }
        .flight .pagination { flex-wrap: nowrap; }
    }

    @media (prefers-reduced-motion: reduce) {
        .flight * { transition: none !important; }
    }
</style>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Delete confirmation (.js-delete so the layout's .delete-btn handler doesn't fire a second dialog)
    document.querySelectorAll(".js-delete").forEach(function (button) {
        button.addEventListener("click", function () {
            const form = this.closest("form");
            const title = form.getAttribute("data-title") || "this blog";

            Swal.fire({
                title: `Delete "${title}"?`,
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d64545",
                cancelButtonColor: "#4f6149",
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel"
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // Auto-submit when the category changes
    const categoryFilter = document.getElementById("categoryFilter");
    const filterForm = document.getElementById("filterForm");
    if (categoryFilter && filterForm) {
        categoryFilter.addEventListener("change", function () { filterForm.submit(); });
    }
});
</script>
@endsection