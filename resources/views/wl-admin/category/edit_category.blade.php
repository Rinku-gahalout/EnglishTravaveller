@extends('wl-admin.layouts.app')

@section('title', 'Edit category')

@section('content')
<div class="container-fluid py-4 flight">

    @include('wl-admin.layouts.sessionmessage')

    <header class="page-head mb-4">
        <div class="page-head__main">
            <span class="page-head__icon"><i class='bx bx-edit-alt'></i></span>
            <div>
                <h1>Edit category</h1>
                <p>Update the category details.</p>
            </div>
        </div>
        <div class="page-head__actions">
            <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-sky"><i class='bx bx-list-ul'></i> Category list</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-sky"><i class='bx bx-home-alt'></i> Dashboard</a>
        </div>
    </header>

    <form method="POST" action="{{ route('admin.category.update', $category->id) }}" novalidate>
        @csrf
        @method('PUT')

        {{-- ===================== BASIC INFO ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-info-circle'></i></span>
                <h2>Basic info</h2>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="field-label">Category name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                           class="form-control form-field @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="slug" class="field-label">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                           class="form-control form-field @error('slug') is-invalid @enderror">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Leave blank to auto-generate from the name.</div>
                </div>
            </div>
        </section>

        {{-- ===================== SEO ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-search-alt'></i></span>
                <h2>SEO and meta</h2>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="meta_title" class="field-label">Meta title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}"
                           maxlength="255" placeholder="Enter SEO meta title..."
                           class="form-control form-field @error('meta_title') is-invalid @enderror">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="meta_keywords" class="field-label">Meta keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $category->meta_keywords) }}"
                           class="form-control form-field @error('meta_keywords') is-invalid @enderror">
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label for="meta_description" class="field-label d-flex justify-content-between">
                        <span>Meta description</span>
                        <span id="meta-description-count" class="counter">0 / 160</span>
                    </label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                              placeholder="Write a short description for search engines..."
                              class="form-control form-field @error('meta_description') is-invalid @enderror">{{ old('meta_description', $category->meta_description) }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Recommended length: 150–160 characters.</div>
                </div>
            </div>
        </section>

        {{-- ===================== CONTENT ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-edit-alt'></i></span>
                <h2>Content</h2>
            </div>

            <textarea id="description" name="description" rows="4"
                      class="form-control form-field @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </section>

        {{-- ===================== STATUS + SAVE ===================== --}}
        <section class="panel">
            <div class="form-actions">
                <div class="form-actions__status">
                    <label for="status" class="field-label mb-0">Status</label>
                    <select id="status" name="status" class="form-select form-field @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $category->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $category->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-sky">Cancel</a>
                    <button type="submit" class="btn btn-sunset px-4"><i class='bx bx-save'></i> Update category</button>
                </div>
            </div>
            @error('status')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </section>

    </form>

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

        /* Forms */
        .form-section { display: flex; align-items: center; gap: .7rem; margin: 0 0 1.1rem; }
        .form-section__icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 50%; font-size: 1.15rem; color: var(--navy-soft); background: var(--sky-soft); }
        .form-section h2 { font-family: var(--display-font); font-size: 1.2rem; font-weight: 700; margin: 0; color: var(--navy-deep); }
        .form-section__hint { margin-left: auto; font-size: .82rem; color: var(--ink-soft); }

        .field-label { font-weight: 700; font-size: .85rem; color: var(--navy-soft); margin-bottom: .35rem; }
        .flight .form-field { min-height: 44px; border: 1px solid rgba(45, 56, 43, .22); border-radius: .6rem; background-color: #fff; }
        .flight textarea.form-field { min-height: 0; }
        .flight input[type="file"].form-field { padding: .55rem .75rem; }
        .flight .form-field:focus { border-color: var(--sunset); box-shadow: 0 0 0 .22rem rgba(156, 96, 55, .2); }
        .flight .form-field.is-invalid { border-color: var(--red); background-image: none; }
        .form-hint { font-size: .8rem; color: var(--ink-soft); margin-top: .3rem; }
        .form-hint strong { font-family: var(--mono-font); font-size: .78rem; color: var(--navy-soft); }

        .counter { font-weight: 600; font-size: .78rem; color: var(--ink-soft); font-family: var(--mono-font); }
        .counter--warning { color: #b0701f; }
        .counter--danger { color: var(--red); }
        .invalid-feedback-live { display: block; font-size: .8rem; color: var(--red); margin-top: .25rem; min-height: 1.1rem; }


        .form-actions { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; }
        .form-actions__status { display: flex; align-items: center; gap: .75rem; }
        .form-actions__status .form-field { width: 190px; }

        
        @media (max-width: 768px) {
            .form-actions__status .form-field { width: 100%; }
        }
</style>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---------- Content editor (jQuery + Summernote are loaded by the layout) ---------- */
    try {
        if (window.jQuery && window.jQuery.fn.summernote) {
            window.jQuery('#description').summernote({
                placeholder: 'Write category content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        } else {
            console.error('jQuery or Summernote is not loaded.');
        }
    } catch (err) {
        console.error('Summernote failed to mount:', err);
    }

    /* ---------- Meta description counter (limit 160) ---------- */
    const area    = document.getElementById('meta_description');
    const counter = document.getElementById('meta-description-count');

    if (area && counter) {
        const LIMIT = 160;

        function updateCount() {
            const n = area.value.length;
            counter.textContent = n + ' / ' + LIMIT;
            counter.classList.toggle('counter--warning', n >= 150 && n < LIMIT);
            counter.classList.toggle('counter--danger', n >= LIMIT);
        }

        area.addEventListener('input', updateCount);
        updateCount();
    }
});
</script>
@endsection