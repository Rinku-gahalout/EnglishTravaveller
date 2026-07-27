@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">

        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">Blog Management</h2>
                <p class="mb-0 text-secondary">Manage blog posts, drafts, categories, and publication status from one dashboard.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <a href="{{ route('admin.blog.create') }}" class="btn btn-brass shadow-sm">+ Add Blog</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger shadow-sm">Logout</button>
                </form>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card ledger-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="ledger-icon me-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Total Blogs</h5>
                            <p class="mb-0 ledger-stat">{{ $totalBlogs }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card ledger-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="ledger-icon me-3">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Published</h5>
                            <p class="mb-0 ledger-stat">{{ $publishedBlogs }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card ledger-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="ledger-icon me-3">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Drafts</h5>
                            <p class="mb-0 ledger-stat">{{ $draftBlogs }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card ledger-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="ledger-icon me-3">
                            <i class="bi bi-tags"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Categories</h5>
                            <p class="mb-0 ledger-stat">{{ $totalCategories }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 ledger-card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                    <div class="row gx-3 gy-3">
                        <div class="col-md-4">
                            <label class="form-label ledger-label">Category</label>
                            <select name="category" class="form-select ledger-input" id="categoryFilter">
                                <option value="">-- All Categories --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ (string) $category === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label ledger-label">Search</label>
                            <input type="text" name="search" class="form-control ledger-input"
                                placeholder="Enter blog title or keyword" value="{{ $search }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-brass flex-grow-1">Search</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-ledger flex-grow-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                                <tr>
                                    <td>{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
                                    <td>{{ $blog->created_at?->format('d M Y') }}</td>
<td>
    @if ($blog->image)
        <img src="{{ asset($blog->image) }}"
             alt="{{ $blog->alt_tag ?? $blog->blog_heading }}"
             class="ledger-thumb rounded-3"
             width="56"
             height="56"
             style="object-fit: cover;">
    @else
        <span class="text-secondary small">No image</span>
    @endif
</td>
                                    <td class="text-start">
                                        <div class="fw-semibold">{{ Str::limit($blog->blog_heading, 45) }}</div>
                                        @if ($blog->meta_title)
                                            <div class="text-secondary small">{{ Str::limit($blog->meta_title, 60) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/blog/' . $blog->id) }}" target="_blank" class="ledger-link">
                                            /blog/{{ $blog->id }}
                                        </a>
                                    </td>
                                    <td>{{ $blog->category->name ?? '—' }}</td>
                                    <td>{{ $blog->subcategory->name ?? '—' }}</td>
                                    <td>
                                        @if ((int) $blog->is_draft === 0)
                                            <span class="badge ledger-badge-published">Published</span>
                                        @else
                                            <span class="badge ledger-badge-draft">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ url('/blog/' . $blog->id) }}" target="_blank"
                                                class="btn btn-sm btn-ledger-preview">Preview</a>
                                            <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                                class="btn btn-sm btn-ledger-edit">Edit</a>
                                            @if(auth('admin')->user()?->role === 'admin')
                                                <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST"
                                                    data-title="{{ $blog->blog_heading }}" class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-5 text-secondary">
                                        No blogs found
                                        @if ($search || $category)
                                            for the selected filters
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center px-3 py-3 ledger-pagination flex-wrap gap-2">
                    <div>
                        @if ($blogs->total() > 0)
                            Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} results
                        @else
                            No results
                        @endif
                    </div>
                    <div>
                        {{ $blogs->links() }}
                    </div>
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

        /* ---------- Page heading ---------- */
        .ledger-heading {
            padding-bottom: 1rem;
            border-bottom: 1px dashed rgba(22, 35, 43, .18);
        }

        .ledger-heading h2 {
            font-weight: 800;
            letter-spacing: .02em;
            text-transform: uppercase;
            font-size: 1.6rem;
            color: var(--navy-deep);
            position: relative;
            padding-left: .85rem;
        }

        .ledger-heading h2::before {
            content: "";
            position: absolute;
            left: 0;
            top: .15em;
            bottom: .15em;
            width: 4px;
            background: var(--brass);
            border-radius: 2px;
        }

        /* ---------- Buttons ---------- */
        .btn-brass {
            background: var(--brass);
            border: 1px solid var(--brass);
            color: var(--navy-deep);
            font-weight: 700;
            letter-spacing: .01em;
            border-radius: .5rem;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
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

        /* ---------- Cards ---------- */
        .ledger-card {
            border: 1px solid rgba(22, 35, 43, .08);
            border-radius: .75rem;
            background: #fffdf8;
            box-shadow: 0 4px 14px rgba(11, 29, 38, .06);
        }

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

        /* ---------- Filter form ---------- */
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
        }

        .ledger-input:focus {
            border-color: var(--brass);
            box-shadow: 0 0 0 .2rem rgba(201, 162, 106, .2);
        }

        /* ---------- Table ---------- */
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

        .ledger-thumb {
            border: 1px solid rgba(22, 35, 43, .12);
        }

        .ledger-link {
            color: var(--navy-soft);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed var(--brass);
        }

        .ledger-link:hover {
            color: var(--navy-deep);
        }

        .ledger-pagination {
            border-top: 1px dashed rgba(22, 35, 43, .12);
            color: var(--ink-soft);
            font-size: .85rem;
        }

        /* ---------- Badges ---------- */
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

        /* ---------- Row action buttons ---------- */
        .btn-sm {
            min-width: 80px;
            height: 36px;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .82rem;
        }

        .btn-ledger-view {
            background: #1f6e4f;
            color: #fff;
            border: none;
        }

        .btn-ledger-view:hover {
            background: #175a40;
            color: #fff;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .d-flex.flex-md-row {
                flex-direction: column !important;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function() {
                    const form = this.closest("form");
                    const main_headline = form.getAttribute("data-title");

                    Swal.fire({
                        title: `Are you sure to delete "${main_headline}"?`,
                        text: "This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#c1443b",
                        cancelButtonColor: "#1d3f50",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Auto-submit the filter form when the category dropdown changes,
            // so users don't have to also click "Search" for category filtering.
            const categoryFilter = document.getElementById('categoryFilter');
            const filterForm = document.getElementById('filterForm');
            if (categoryFilter && filterForm) {
                categoryFilter.addEventListener('change', function () {
                    filterForm.submit();
                });
            }
        });
    </script>
@endsection