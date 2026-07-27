@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">
        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header">
            <div>
                <h2 class="mb-1">Subcategory List</h2>
                <p class="mb-0 text-secondary">Manage your subcategories and link them to parent categories.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.add.subcategory') }}" class="btn btn-brass shadow-sm">Add Subcategory</a>
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
                                <th>Name</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subcategories as $subcategory)
                                <tr>
                                    <td>{{ $subcategory->id }}</td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ $subcategory->category->name ?? '—' }}</td>
                                    <td>{{ $subcategory->slug }}</td>
                                    <td>
                                        <span class="badge {{ $subcategory->status === 'active' ? 'ledger-badge-published' : 'ledger-badge-draft' }}">
                                            {{ ucfirst($subcategory->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $subcategory->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                                            <a href="{{ route('admin.subcategory.edit', $subcategory->id) }}" class="btn btn-sm btn-ledger-edit">Edit</a>
                                            <form action="{{ route('admin.subcategory.destroy', $subcategory->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-4">No subcategories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $subcategories->links('pagination::bootstrap-5') }}
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
            border: 1px solid rgba(22, 35, 43, .08);
            border-radius: .75rem;
            background: #fffdf8;
            box-shadow: 0 4px 14px rgba(11, 29, 38, .06);
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
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    var form = this.closest('form');
                    var nameCell = form.closest('tr')?.querySelector('td:nth-child(2)');
                    var itemName = nameCell?.textContent?.trim() || 'this subcategory';

                    Swal.fire({
                        title: `Delete ${itemName}?`,
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#c1443b',
                        cancelButtonColor: '#1d3f50',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (result) {
                        if (result.isConfirmed && form) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
