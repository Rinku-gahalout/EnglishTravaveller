@extends('wl-admin.layouts.app')

@section('title', 'Trash')

@section('content')
<div class="container-fluid py-4 flight">

    @include('wl-admin.layouts.sessionmessage')

    <header class="page-head mb-4">
        <div class="page-head__main">
            <span class="page-head__icon"><i class='bx bx-trash'></i></span>
            <div>
                <h1>Trash</h1>
                <p>Restore deleted blogs, or remove them permanently.</p>
            </div>
        </div>
        <div class="page-head__actions">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-sunset"><i class='bx bx-plus'></i> Add blog</a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-sky"><i class='bx bx-list-ul'></i> Blog list</a>
        </div>
    </header>

    <section class="panel panel--flush">

        <div class="table-responsive">
            <table class="table board-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Deleted on</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($blogs as $blog)
                    <tr class="is-trashed">

                        <td class="text-center serial">
                            {{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}
                        </td>

                        <td class="title-cell">
                            <div class="title-cell__main">{{ \Illuminate\Support\Str::limit($blog->blog_heading, 55) }}</div>
                        </td>

                        <td>{{ $blog->category->name ?? '—' }}</td>
                        <td>{{ $blog->subcategory->name ?? '—' }}</td>
                        <td class="text-nowrap deleted-at">{{ $blog->deleted_at?->format('d M Y') }}</td>

                        <td class="pe-4">
                            <div class="d-flex justify-content-end gap-2 flex-wrap">

                                <form action="{{ route('admin.blog.restore', $blog->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-restore">
                                        <i class='bx bx-undo'></i> Restore
                                    </button>
                                </form>

                                <form action="{{ route('admin.blog.forceDelete', $blog->id) }}" method="POST"
                                      data-title="{{ $blog->blog_heading }}"
                                      data-text="This will permanently remove the blog. You can't get it back." class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-remove js-delete">
                                        <i class='bx bx-x-circle'></i> Delete permanently
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class='bx bx-trash'></i>
                            <div class="empty-state__title">The trash is empty</div>
                            <div class="empty-state__hint">Deleted blogs will show up here.</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel__footer">
            <div>
                @if($blogs->total() > 0)
                    Showing <strong>{{ $blogs->firstItem() }}</strong>–<strong>{{ $blogs->lastItem() }}</strong>
                    of <strong>{{ $blogs->total() }}</strong> trashed blogs
                @else
                    No results
                @endif
            </div>

            @if($blogs->hasPages())
                <div class="pagination-wrapper">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

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

        /* Table (departure board) */
        .board-table { --bs-table-bg: transparent; }
        .board-table thead th { background: var(--navy-deep); color: var(--sky-bright); font-family: var(--display-font); font-weight: 600; font-size: .95rem; letter-spacing: .03em; padding: .95rem .75rem; border: 0; white-space: nowrap; }
        .board-table tbody td { padding: .85rem .75rem; border-color: var(--line); font-size: .92rem; }
        .board-table tbody tr { transition: background .2s ease; }
        .board-table tbody tr:hover { background: var(--sky-soft); }
        .board-table tbody tr.is-published td:first-child { box-shadow: inset 4px 0 0 var(--green); }
        .board-table tbody tr.is-draft td:first-child { box-shadow: inset 4px 0 0 var(--sunset); }
        .serial { font-family: var(--mono-font); color: var(--ink-soft); font-size: .82rem !important; }
        .title-cell { min-width: 220px; }
        .title-cell__main { font-weight: 600; color: var(--navy-deep); }
        .title-cell__sub { font-size: .8rem; color: var(--ink-soft); margin-top: .15rem; }

        .status { display: inline-flex; align-items: center; gap: .45rem; padding: .3rem .75rem; border-radius: 999px; font-size: .8rem; font-weight: 700; }
        .status::before { content: ""; width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
        .status--published { background: rgba(61, 122, 74, .12); color: #2f6a3d; }
        .status--draft { background: var(--sunset-soft); color: #8a4f27; }

        .icon-btn { width: 38px; height: 38px; display: inline-grid; place-items: center; border: 0; border-radius: .6rem; font-size: 1.2rem; text-decoration: none; cursor: pointer; transition: transform .15s ease, background .2s ease, color .2s ease; }
        .icon-btn:hover { transform: translateY(-2px); }
        .icon-btn--preview { background: var(--sky-soft); color: var(--sky); }
        .icon-btn--preview:hover { background: var(--sky); color: #fff; }
        .icon-btn--edit { background: var(--sunset-soft); color: #8a4f27; }
        .icon-btn--edit:hover { background: var(--sunset); color: #fff; }
        .icon-btn--delete { background: rgba(214, 69, 69, .12); color: var(--red); }
        .icon-btn--delete:hover { background: var(--red); color: #fff; }
        .icon-btn--disabled { background: #eceff3; color: #aab3bd; cursor: not-allowed; }
        .icon-btn--disabled:hover { transform: none; }

        .empty-state { text-align: center; padding: 3.5rem 1rem !important; color: var(--ink-soft); }
        .empty-state i { font-size: 2.6rem; color: var(--sky); }
        .empty-state__title { font-family: var(--display-font); font-weight: 700; font-size: 1.3rem; color: var(--navy-deep); margin-top: .4rem; }
        .empty-state__hint { font-size: .9rem; }

        /* Pagination (Laravel's bootstrap-5 view prints its own "Showing x to y" text; hide it) */
        .pagination-wrapper p.small { display: none; }
        .flight .pagination { margin: 0; }
        .flight .pagination .page-link { color: var(--navy-soft); border-color: var(--line); border-radius: .5rem; margin: 0 2px; }
        .flight .pagination .page-link:hover { background: var(--sky-soft); border-color: var(--sky); color: var(--navy-deep); }
        .flight .pagination .page-item.active .page-link { background: var(--navy-soft); border-color: var(--navy-soft); color: #fff; }
        .flight .pagination .page-item.disabled .page-link { color: #9aa3a8; }

        @media (max-width: 768px) {
            .pagination-wrapper { width: 100%; overflow-x: auto; }
            .flight .pagination { flex-wrap: nowrap; }
            .panel__footer { flex-direction: column; align-items: flex-start; }
        }

        .board-table tbody tr.is-trashed td:first-child { box-shadow: inset 4px 0 0 var(--red); }
        .flight .btn-restore { background: var(--sky-soft); border: 1px solid transparent; color: var(--navy-soft); }
        .flight .btn-restore:hover { background: var(--sky); color: #fff; }
        .flight .btn-remove { background: transparent; border: 1px solid rgba(214, 69, 69, .5); color: var(--red); }
        .flight .btn-remove:hover { background: var(--red); border-color: var(--red); color: #fff; }
        .deleted-at { color: var(--red); font-weight: 600; }
</style>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Confirmation dialog (SweetAlert is loaded by the layout). Using .js-delete avoids the layout's generic handler,
    // which does not stop a submit button from submitting the form straight away.
    document.querySelectorAll('.js-delete').forEach(function (button) {
        button.addEventListener('click', function () {
            const form  = this.closest('form');
            const title = form.getAttribute('data-title') || 'this blog';
            const text  = form.getAttribute('data-text') || 'This action cannot be undone.';

            Swal.fire({
                title: `Delete "${title}"?`,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d64545',
                cancelButtonColor: '#4f6149',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection