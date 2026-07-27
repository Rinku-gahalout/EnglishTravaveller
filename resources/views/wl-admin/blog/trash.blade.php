@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">
        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">Trash</h2>
                <p class="mb-0 text-secondary">Manage blogs that were deleted and restore or permanently remove them.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-ledger">Blog List</a>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-brass shadow-sm">Add Blog</a>
            </div>
        </div>

        <div class="card ledger-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table ledger-table align-middle mb-0 text-center">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Deleted At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
                                    <td class="text-start">{{ \Illuminate\Support\Str::limit($blog->blog_heading, 55) }}</td>
                                    <td>{{ $blog->category->name ?? '—' }}</td>
                                    <td>{{ $blog->subcategory->name ?? '—' }}</td>
                                    <td>{{ $blog->deleted_at?->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <form action="{{ route('admin.blog.restore', $blog->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-ledger-edit">Restore</button>
                                            </form>
                                            <form action="{{ route('admin.blog.forceDelete', $blog->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete Permanently</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-5 text-secondary">No trashed blogs found.</td>
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
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--paper);
            color: var(--ink);
        }

        .ledger-header h2,
        .ledger-header h5 {
            font-family: 'Big Shoulders Display', cursive;
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

        .btn-ledger-edit {
            background: var(--navy-soft);
            color: var(--paper);
            border: none;
        }

        .btn-ledger-edit:hover {
            background: var(--navy-deep);
            color: var(--paper);
        }
    </style>
@endsection
