@extends('wl-admin.layouts.app')

@section('content') <div class="container-fluid py-4 ledger-dash">

    @include('wl-admin.layouts.sessionmessage')

    {{-- =========================
        PAGE HEADER
    ========================== --}}
    <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h2 class="mb-1">Blog Management</h2>
            <p class="mb-0 text-secondary">
                Manage blog posts, drafts, categories, and publication status from one dashboard.
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap align-items-center">

            <a href="{{ route('admin.blog.create') }}"
               class="btn btn-brass shadow-sm">
                + Add Blog
            </a>

            <form action="{{ route('admin.logout') }}"
                  method="POST"
                  class="m-0">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-danger shadow-sm">
                    Logout
                </button>
            </form>

        </div>
    </div>


    @php
    // Show all blog counts initially; filter statistics by category when selected.
    $selectedCategory = request('category');
    $statsQuery = \App\Models\Blog::query()
        ->whereDate('created_at', '>=', '2026-09-10');

    if (!empty($selectedCategory)) {
        $statsQuery->where('category_id', $selectedCategory);
    }

    $totalBlogs = (clone $statsQuery)->count();
    $publishedBlogs = (clone $statsQuery)->where('is_draft', 0)->count();
    $draftBlogs = (clone $statsQuery)->where('is_draft', 1)->count();
@endphp

    {{-- =========================
        DASHBOARD STATISTICS
    ========================== --}}
    <div class="row g-3 mb-4">

        {{-- Total Blogs --}}
        <div class="col-sm-6 col-md-3">
            <div class="card ledger-card h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="ledger-icon me-3">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div>
                        <h5 class="mb-1">Total Blogs</h5>
                        <p class="mb-0 ledger-stat">
                            {{ $totalBlogs }}
                        </p>
                    </div>

                </div>
            </div>
        </div>


        {{-- Published --}}
        <div class="col-sm-6 col-md-3">
            <div class="card ledger-card h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="ledger-icon me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div>
                        <h5 class="mb-1">Published</h5>
                        <p class="mb-0 ledger-stat">
                            {{ $publishedBlogs }}
                        </p>
                    </div>

                </div>
            </div>
        </div>


        {{-- Drafts --}}
        <div class="col-sm-6 col-md-3">
            <div class="card ledger-card h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="ledger-icon me-3">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div>
                        <h5 class="mb-1">Drafts</h5>
                        <p class="mb-0 ledger-stat">
                            {{ $draftBlogs }}
                        </p>
                    </div>

                </div>
            </div>
        </div>


        {{-- Categories --}}
        <div class="col-sm-6 col-md-3">
            <div class="card ledger-card h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="ledger-icon me-3">
                        <i class="bi bi-tags"></i>
                    </div>

                    <div>
                        <h5 class="mb-1">Categories</h5>
                        <p class="mb-0 ledger-stat">
                            {{ $totalCategories }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- =========================
        SEARCH & CATEGORY FILTER
    ========================== --}}
    <div class="card mb-4 ledger-card">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.dashboard') }}"
                  id="filterForm">

                <div class="row gx-3 gy-3">

                    {{-- Category --}}
                    <div class="col-md-4">

                        <label for="categoryFilter"
                               class="form-label ledger-label">
                            Category
                        </label>

                        <select name="category"
                                id="categoryFilter"
                                class="form-select ledger-input">

                            <option value="">
                                -- All Categories --
                            </option>

                            @foreach ($categories as $cat)

                                <option value="{{ $cat->id }}"
                                    {{ (string) $category === (string) $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Search --}}
                    <div class="col-md-4">

                        <label for="search"
                               class="form-label ledger-label">
                            Search
                        </label>

                        <input type="text"
                               name="search"
                               id="search"
                               class="form-control ledger-input"
                               placeholder="Enter blog title or keyword"
                               value="{{ $search }}">

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-4 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-brass flex-grow-1">
                            Search
                        </button>

                        <a href="{{ route('admin.dashboard') }}"
                           class="btn btn-outline-ledger flex-grow-1">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- =========================
        BLOG TABLE
    ========================== --}}
    <div class="card ledger-card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table ledger-table align-middle mb-0 text-center">

                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Blog URL</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($blogs as $blog)

                            @php
                                $blogSlug = \Illuminate\Support\Str::slug($blog->blog_heading);
                            @endphp

                            <tr>

                                {{-- S.No --}}
                                <td>
                                    {{ $loop->iteration + (($blogs->currentPage() - 1) * $blogs->perPage()) }}
                                </td>


                                {{-- Date --}}
                                <td>
                                    {{ $blog->created_at?->format('d M Y') }}
                                </td>


                                {{-- Image --}}
                                <td>

                                    @if ($blog->image)

                                        <img src="{{ asset($blog->image) }}"
                                             alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
                                             class="ledger-thumb rounded-3"
                                             width="56"
                                             height="56"
                                             loading="lazy"
                                             style="object-fit: cover;">

                                    @else

                                        <span class="text-secondary small">
                                            No image
                                        </span>

                                    @endif

                                </td>


                                {{-- Title --}}
                                <td class="text-start">

                                    <div class="fw-semibold">
                                        {{ Str::limit($blog->blog_heading, 45) }}
                                    </div>

                                    @if ($blog->meta_title)

                                        <div class="text-secondary small">
                                            {{ Str::limit($blog->meta_title, 60) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Blog URL --}}
<td class="text-start">
    @php
        $categorySlug = $blog->subcategory?->slug ?? $blog->category?->slug;
    @endphp

    @if($categorySlug && $blog->blog_url)
        <a href="{{ route('blogdetails', [
            'cate_subcate' => $categorySlug,
            'blog_slug' => $blog->blog_url,
        ]) }}"
           target="_blank"
           rel="noopener noreferrer"
           class="ledger-link">

            /{{ $categorySlug }}/{{ $blog->blog_url }}

        </a>
    @else
        <span class="text-muted">No URL</span>
    @endif
</td>


                                {{-- Category --}}
                                <td>
                                    {{ $blog->category->name ?? '—' }}
                                </td>


                                {{-- Subcategory --}}
                                <td>
                                    {{ $blog->subcategory->name ?? '—' }}
                                </td>


                                {{-- Status --}}
                                <td>

                                    @if ((int) $blog->is_draft === 0)

                                        <span class="badge ledger-badge-published">
                                            Published
                                        </span>

                                    @else

                                        <span class="badge ledger-badge-draft">
                                            Draft
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2 flex-wrap">


{{-- Preview --}}
{{-- Preview --}}
{{-- Preview --}}
@php
    $categorySlug = $blog->subcategory?->slug ?? $blog->category?->slug;
@endphp

@if($categorySlug && $blog->blog_url)

    <a href="{{ route('blogdetails', [
            'cate_subcate' => $categorySlug,
            'blog_slug' => $blog->blog_url,
        ]) }}"
       target="_blank"
       rel="noopener noreferrer"
       class="btn btn-sm btn-ledger-preview">
        Preview
    </a>

@else

    <button type="button"
            class="btn btn-sm btn-secondary"
            disabled>
        No URL
    </button>

@endif






                                        {{-- Edit --}}
                                        <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                           class="btn btn-sm btn-ledger-edit">
                                            Edit
                                        </a>


                                        {{-- Delete --}}
                                        @if (auth('admin')->user()?->role === 'admin')

                                            <form action="{{ route('admin.blog.destroy', $blog->id) }}"
                                                  method="POST"
                                                  data-title="{{ $blog->blog_heading }}"
                                                  class="d-inline m-0">

                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                        class="btn btn-sm btn-danger delete-btn">
                                                    Delete
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9"
                                    class="py-5 text-secondary">

                                    <div class="mb-2">
                                        <i class="bi bi-search fs-3"></i>
                                    </div>

                                    <div>
                                        No blogs found
                                        @if ($search || $category)
                                            for the selected filters.
                                        @endif
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =========================
                PAGINATION
            ========================== --}}
            <div class="d-flex justify-content-between align-items-center px-3 py-3 ledger-pagination flex-wrap gap-3">

                {{-- Result Count --}}
                <div>

                    @if ($blogs->total() > 0)

                        Showing
                        <strong>{{ $blogs->firstItem() }}</strong>
                        to
                        <strong>{{ $blogs->lastItem() }}</strong>
                        of
                        <strong>{{ $blogs->total() }}</strong>
                        results

                    @else

                        No results

                    @endif

                </div>


                {{-- Pagination --}}
                @if ($blogs->hasPages())

                    <div class="pagination-wrapper">

                        {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}

                    </div>

                @endif

            </div>

        </div>
    </div>

</div>

@endsection

@section('styles')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
        background-color: var(--paper);
        color: var(--ink);
    }


    .ledger-dash h2,
    .ledger-dash h5 {
        font-family: var(--display-font);
    }


    /* =========================
       PAGE HEADER
    ========================== */

    .ledger-header {
        background: #fffdf8 !important;
    }


    .ledger-header h2 {
        font-weight: 800;
        letter-spacing: .02em;
        text-transform: uppercase;
        color: var(--navy-deep);
    }


    /* =========================
       BUTTONS
    ========================== */

    .btn-brass {
        background: var(--brass);
        border: 1px solid var(--brass);
        color: var(--navy-deep);
        font-weight: 700;
        letter-spacing: .01em;
        border-radius: .5rem;
        transition: all .2s ease;
    }


    .btn-brass:hover {
        background: var(--brass-bright);
        border-color: var(--brass-bright);
        color: var(--navy-deep);
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(201, 162, 106, .35);
    }


    .btn-outline-ledger {
        background: transparent;
        border: 1px solid var(--navy-soft);
        color: var(--navy-soft);
        font-weight: 600;
        border-radius: .5rem;
    }


    .btn-outline-ledger:hover {
        background: var(--navy-soft);
        color: var(--paper);
    }


    .btn-danger {
        background: #c1443b;
        border-color: #c1443b;
        border-radius: .5rem;
        font-weight: 600;
    }


    .btn-danger:hover {
        background: #a83a32;
        border-color: #a83a32;
    }


    /* =========================
       CARDS
    ========================== */

    .ledger-card {
        border: 1px solid rgba(22, 35, 43, .08);
        border-radius: .75rem;
        background: #fffdf8;
        box-shadow: 0 4px 14px rgba(11, 29, 38, .06);
    }


    /* =========================
       STAT ICON
    ========================== */

    .ledger-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--navy-deep);
        color: var(--brass-bright);
        font-size: 1.3rem;
        flex-shrink: 0;
    }


    .ledger-card h5 {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--navy-deep);
        text-transform: uppercase;
        letter-spacing: .03em;
    }


    .ledger-stat {
        font-family: var(--mono-font);
        font-size: 1.3rem;
        color: var(--ink-soft);
    }


    /* =========================
       FILTER
    ========================== */

    .ledger-label {
        font-family: var(--display-font);
        font-weight: 700;
        letter-spacing: .02em;
        text-transform: uppercase;
        font-size: .85rem;
        color: var(--navy-soft);
    }


    .ledger-input {
        border: 1px solid rgba(22, 35, 43, .18);
        border-radius: .5rem;
        background: var(--paper);
        min-height: 42px;
    }


    .ledger-input:focus {
        border-color: var(--brass);
        box-shadow: 0 0 0 .2rem rgba(201, 162, 106, .2);
    }


    /* =========================
       TABLE
    ========================== */

    .ledger-table {
        margin-bottom: 0;
    }


    .ledger-table thead {
        background: var(--navy-deep);
    }


    .ledger-table thead th {
        color: var(--brass-bright);
        text-transform: uppercase;
        font-size: .78rem;
        letter-spacing: .06em;
        font-weight: 700;
        border: none;
        padding: .85rem .6rem;
        white-space: nowrap;
    }


    .ledger-table tbody tr {
        transition: background .2s ease;
    }


    .ledger-table tbody tr:hover {
        background: rgba(201, 162, 106, .1);
    }


    .ledger-table td {
        font-size: .92rem;
        color: var(--ink);
        border-color: rgba(22, 35, 43, .08);
    }


    /* =========================
       IMAGE
    ========================== */

    .ledger-thumb {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border: 1px solid rgba(22, 35, 43, .12);
    }


    /* =========================
       BLOG URL
    ========================== */

    .ledger-link {
        display: inline-block;
        max-width: 260px;
        color: var(--navy-soft);
        font-family: var(--mono-font);
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px dashed var(--brass);
        word-break: break-word;
    }


    .ledger-link:hover {
        color: var(--navy-deep);
    }


    /* =========================
       PAGINATION
    ========================== */

    .ledger-pagination {
        border-top: 1px dashed rgba(22, 35, 43, .12);
        color: var(--ink-soft);
        font-size: .85rem;
    }


    .pagination {
        margin-bottom: 0;
    }


    .pagination .page-link {
        color: var(--navy-soft);
        border-color: rgba(22, 35, 43, .12);
    }


    .pagination .page-link:hover {
        color: var(--navy-deep);
        background: rgba(201, 162, 106, .12);
        border-color: var(--brass);
    }


    .pagination .page-item.active .page-link {
        background-color: var(--navy-soft);
        border-color: var(--navy-soft);
        color: #fff;
    }


    .pagination .page-item.disabled .page-link {
        color: #9aa3a8;
    }


    /* =========================
       BADGES
    ========================== */

    .badge {
        font-family: var(--mono-font);
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


    /* =========================
       ACTION BUTTONS
    ========================== */

    .btn-sm {
        min-width: 80px;
        height: 36px;
        border-radius: .5rem;
        font-weight: 600;
        font-size: .82rem;
    }


    .btn-ledger-preview {
        background: var(--brass);
        color: var(--navy-deep);
        border: none;
    }


    .btn-ledger-preview:hover {
        background: var(--brass-bright);
        color: var(--navy-deep);
    }


    .btn-ledger-edit {
        background: var(--navy-soft);
        color: var(--paper);
        border: none;
    }


    .btn-ledger-edit:hover {
        background: var(--navy-deep);
        color: var(--paper);
    }


    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 768px) {

        .ledger-header {
            align-items: flex-start !important;
        }


        .ledger-pagination {
            align-items: flex-start !important;
            flex-direction: column;
        }


        .pagination-wrapper {
            width: 100%;
            overflow-x: auto;
        }


        .pagination {
            flex-wrap: nowrap;
        }


        .ledger-link {
            max-width: 180px;
        }

    }

</style>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        /* =========================
           DELETE CONFIRMATION
        ========================== */

        document.querySelectorAll(".delete-btn").forEach(function (button) {

            button.addEventListener("click", function () {

                const form = this.closest("form");

                const mainHeadline =
                    form.getAttribute("data-title") || "this blog";


                Swal.fire({

                    title: `Are you sure to delete "${mainHeadline}"?`,

                    text: "This action cannot be undone.",

                    icon: "warning",

                    showCancelButton: true,

                    confirmButtonColor: "#c1443b",

                    cancelButtonColor: "#1d3f50",

                    confirmButtonText: "Yes, delete it!",

                    cancelButtonText: "Cancel"

                }).then(function (result) {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });


        /* =========================
           CATEGORY AUTO FILTER
        ========================== */

        const categoryFilter =
            document.getElementById("categoryFilter");

        const filterForm =
            document.getElementById("filterForm");


        if (categoryFilter && filterForm) {

            categoryFilter.addEventListener("change", function () {

                filterForm.submit();

            });

        }

    });

</script>

@endsection
