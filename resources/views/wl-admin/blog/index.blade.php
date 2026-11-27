@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">
        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header">
            <div>
                <h2 class="mb-1">Blog List</h2>
                <p class="mb-0 text-secondary">Manage blog posts, drafts, and FAQ entries.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.blog.create') }}" class="btn btn-brass shadow-sm">Add Blog</a>
                <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-ledger">Category List</a>
            </div>
        </div>

        <div class="card ledger-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table ledger-table align-middle mb-0 text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td>{{ $blogs->firstItem() + $loop->index }}</td>
                                    <td>{{ $blog->blog_heading }}</td>
                                    <td>{{ $blog->category->name ?? '—' }}</td>
                                    <td>{{ $blog->subcategory->name ?? '—' }}</td>
                                    <td>{{ $blog->is_draft ? 'Draft' : 'Published' }}</td>
                                    <td>{{ $blog->created_at->format('d M Y') }}</td>
                                    <td>{{ $blog->updated_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                            
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
                                            <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sm btn-ledger-edit">Edit</a>
                                            @if(auth('admin')->user()?->role === 'admin')
                                                <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-4">No blogs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $blogs->links('pagination::bootstrap-5') }}
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

        .ledger-header h2,
        .ledger-header h5 {
            font-family: var(--display-font);
        }

        .ledger-card {
            border-radius: 1rem;
            border: 1px solid rgba(22, 35, 43, .08);
            background: #fffdf8;
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
        }

        .ledger-table th,
        .ledger-table td {
            vertical-align: middle;
            border-color: rgba(22, 35, 43, .08);
        }

        .ledger-table tbody tr:hover {
            background: rgba(201, 162, 106, .08);
        }

        .btn-brass {
            background: var(--brass);
            border: 1px solid var(--brass);
            color: var(--navy-deep);
            font-weight: 700;
            letter-spacing: .01em;
            border-radius: .5rem;
        }

        .btn-outline-ledger {
            background: transparent;
            border: 1px solid var(--navy-soft);
            color: var(--navy-soft);
            font-weight: 600;
            border-radius: .5rem;
        }

        .btn-sm {
            min-width: 80px;
            height: 36px;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .82rem;
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

        .ledger-link {
            color: var(--navy-soft);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed var(--brass);
        }

        .ledger-link:hover {
            color: var(--navy-deep);
        }
        
        
        .btn-ledger-preview {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 500;
    color: #ffffff;
    background-color: var(--brass);
    border: 1px solid var(--brass);
    border-radius: 4px;
    text-decoration: none;
    line-height: 1.5;
    transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.1s ease;
    cursor: pointer;
}

.btn-ledger-preview:hover {
    background-color: #138496;
    border-color: #117a8b;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-ledger-preview:active {
    background-color: #117a8b;
    border-color: #10707f;
    transform: translateY(0);
}

.btn-ledger-preview:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.35);
}

/* Optional: add an eye icon before text if you use one */
.btn-ledger-preview::before {
    content: "";
}
        
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = this.closest('form');
                    const title = form.closest('tr')?.querySelector('td:nth-child(2)')?.textContent?.trim() || 'this blog';

                    Swal.fire({
                        title: `Delete ${title}?`,
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#c1443b',
                        cancelButtonColor: '#1d3f50',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
