@extends('wl-admin.layouts.app')

@section('title', 'Edit blog')

@section('content')
<div class="container-fluid py-4 flight">

    @include('wl-admin.layouts.sessionmessage')

    <header class="page-head mb-4">
        <div class="page-head__main">
            <span class="page-head__icon"><i class='bx bx-edit-alt'></i></span>
            <div>
                <h1>Edit blog</h1>
                <p>Update the blog post and its FAQ entries.</p>
            </div>
        </div>
        <div class="page-head__actions">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-sky"><i class='bx bx-list-ul'></i> Blog list</a>
            <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-sky"><i class='bx bx-category'></i> Category list</a>
        </div>
    </header>

    <form method="POST" action="{{ route('admin.blog.update', $blog->id) }}" id="blog-form" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        @php
            $b = $blog;  // editing an existing blog

            // FAQ rows: re-populate from validation errors first, otherwise from the blog being edited
            $faqRows = old('faqs');
            if (!$faqRows) {
                $faqRows = ($b && $b->faqs)
                    ? $b->faqs->map(fn ($f) => ['id' => $f->id, 'question' => $f->question, 'answer' => $f->answer])->values()->all()
                    : [];
            }

            $currentImage = ($b && $b->image) ? asset($b->image) : '';
        @endphp

        {{-- ===================== BASIC INFO ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-info-circle'></i></span>
                <h2>Basic info</h2>
            </div>

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="field-label" for="language">Language</label>
                    <select name="language" id="language" class="form-select form-field @error('language') is-invalid @enderror">
                        <option value="en" {{ old('language', $b?->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $b?->language ?? 'en') == 'es' ? 'selected' : '' }}>Spanish</option>
                    </select>
                    @error('language')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="field-label" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-select form-field @error('category_id') is-invalid @enderror">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $b?->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label class="field-label" for="subcategory_id">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-select form-field @error('subcategory_id') is-invalid @enderror">
                        <option value="">Select subcategory</option>
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}"
                                    data-category-id="{{ $subcategory->category_id }}"
                                {{ old('subcategory_id', $b?->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="field-label" for="blog_heading">Blog heading</label>
                    <input type="text" name="blog_heading" id="blog_heading"
                           value="{{ old('blog_heading', $b?->blog_heading) }}"
                           class="form-control form-field @error('blog_heading') is-invalid @enderror">
                    @error('blog_heading')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="field-label" for="blog_url">Blog URL</label>
                    <input type="text" name="blog_url" id="blog_url"
                           value="{{ old('blog_url', $b?->blog_url) }}"
                           class="form-control form-field @error('blog_url') is-invalid @enderror"
                           placeholder="e.g. how-to-learn-laravel">
                    @error('blog_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-hint">Use a URL-friendly slug, for example: <strong>how-to-learn-laravel</strong></div>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="field-label" for="image">Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="form-control form-field @error('image') is-invalid @enderror">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <img id="image-preview" class="image-preview" alt="Preview"
                         data-original="{{ $currentImage }}"
                         src="{{ $currentImage ?: '#' }}"
                         style="{{ $currentImage ? 'display:block;' : '' }}">
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
                    <label class="field-label d-flex justify-content-between" for="meta_title">
                        <span>Meta title</span>
                        <span id="meta-title-counter" class="counter">0 / 60</span>
                    </label>
                    <input type="text" id="meta_title" name="meta_title"
                           value="{{ old('meta_title', $b?->meta_title) }}"
                           class="form-control form-field @error('meta_title') is-invalid @enderror">
                    <div id="meta-title-error" class="invalid-feedback-live"></div>
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="field-label" for="meta_keywords">Meta keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords"
                           value="{{ old('meta_keywords', $b?->meta_keywords) }}"
                           class="form-control form-field @error('meta_keywords') is-invalid @enderror"
                           placeholder="Enter meta keywords">
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="field-label" for="meta_description">Meta description</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                              class="form-control form-field @error('meta_description') is-invalid @enderror">{{ old('meta_description', $b?->meta_description) }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </section>

        {{-- ===================== DESCRIPTION ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-edit-alt'></i></span>
                <h2>Blog description</h2>
            </div>

            <textarea id="summernote" name="blog_description"
                      class="form-control form-field @error('blog_description') is-invalid @enderror">{{ old('blog_description', $b?->blog_description) }}</textarea>
            @error('blog_description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </section>

        {{-- ===================== FAQS ===================== --}}
        <section class="panel mb-4">
            <div class="form-section">
                <span class="form-section__icon"><i class='bx bx-help-circle'></i></span>
                <h2>Blog FAQs</h2>
                <button type="button" id="add-faq" class="btn btn-sunset btn-sm ms-auto">
                    <i class='bx bx-plus'></i> Add FAQ
                </button>
            </div>

            <div id="faq-items">
                @foreach($faqRows as $index => $faq)
                    <div class="faq-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="faq-badge">FAQ {{ $loop->iteration }}</span>
                            <button type="button" class="btn btn-remove btn-sm remove-faq">
                                <i class='bx bx-trash'></i> Remove
                            </button>
                        </div>

                        <input type="hidden" name="faqs[{{ $index }}][id]" value="{{ $faq['id'] ?? '' }}">

                        <div class="mb-3">
                            <label class="field-label">Question</label>
                            <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq['question'] ?? '' }}"
                                   class="form-control form-field @error('faqs.' . $index . '.question') is-invalid @enderror">
                            @error('faqs.' . $index . '.question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="field-label">Answer</label>
                            <textarea name="faqs[{{ $index }}][answer]" rows="3"
                                      class="form-control form-field @error('faqs.' . $index . '.answer') is-invalid @enderror">{{ $faq['answer'] ?? '' }}</textarea>
                            @error('faqs.' . $index . '.answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <p id="faq-empty-msg" class="text-secondary small mb-0 {{ count($faqRows) ? 'd-none' : '' }}">
                No FAQs added yet. Click "Add FAQ" to create one.
            </p>
        </section>

        {{-- ===================== STATUS + SAVE ===================== --}}
        <section class="panel">
            <div class="form-actions">
                <div class="form-actions__status">
                    <label class="field-label mb-0" for="is_draft">Status</label>
                    <select name="is_draft" id="is_draft" class="form-select form-field @error('is_draft') is-invalid @enderror">
                        <option value="0" {{ (int) old('is_draft', $b?->is_draft ?? 0) === 0 ? 'selected' : '' }}>Published</option>
                        <option value="1" {{ (int) old('is_draft', $b?->is_draft ?? 0) === 1 ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-sky">Cancel</a>
                    <button type="submit" class="btn btn-sunset px-4">
                        <i class='bx bx-save'></i> Update blog
                    </button>
                </div>
            </div>
            @error('is_draft')
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
        .image-preview { display: none; max-width: 250px; margin-top: .9rem; padding: 5px; background: #fff; border: 1px solid var(--line); border-radius: .7rem; }

        .counter { font-weight: 600; font-size: .78rem; color: var(--ink-soft); font-family: var(--mono-font); }
        .counter--warning { color: #b0701f; }
        .counter--danger { color: var(--red); }
        .invalid-feedback-live { display: block; font-size: .8rem; color: var(--red); margin-top: .25rem; min-height: 1.1rem; }

        .faq-item { background: #fff; border: 1px solid var(--line); border-left: 4px solid var(--sunset); border-radius: .7rem; padding: 1rem 1.1rem; margin-bottom: 1rem; transition: box-shadow .15s ease; }
        .faq-item:hover { box-shadow: 0 .25rem .75rem rgba(45, 56, 43, .08); }
        .faq-badge { font-weight: 700; font-size: .8rem; color: #8a4f27; background: var(--sunset-soft); padding: .25rem .7rem; border-radius: 999px; }

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
/* Each feature is isolated in its own try/catch so one failure never blocks the others.
   If something doesn't work, open the browser console (F12) and look for console.error. */
document.addEventListener('DOMContentLoaded', function () {
    initMetaTitleCounter();
    initFaqCrud();
    initSummernoteEditor();
    initImagePreview();
    initCategorySubcategoryFilter();
});

/* ---------- 1. Meta title: live 60-character check ---------- */
function initMetaTitleCounter() {
    try {
        const input   = document.getElementById('meta_title');
        const counter = document.getElementById('meta-title-counter');
        const error   = document.getElementById('meta-title-error');
        const form    = document.getElementById('blog-form');
        const LIMIT   = 60;

        if (!input || !counter) return;

        function validate() {
            const len = input.value.length;
            counter.textContent = len + ' / ' + LIMIT;
            counter.classList.remove('counter--danger', 'counter--warning');
            input.classList.remove('is-invalid');
            error.textContent = '';

            if (len > LIMIT) {
                counter.classList.add('counter--danger');
                input.classList.add('is-invalid');
                error.textContent = 'Meta title cannot exceed ' + LIMIT + ' characters.';
            } else if (len >= LIMIT - 10) {
                counter.classList.add('counter--warning');
            }
        }

        input.addEventListener('input', validate);
        validate();

        if (form) {
            form.addEventListener('submit', function (e) {
                validate();
                if (input.value.length > LIMIT) {
                    e.preventDefault();
                    input.focus();
                }
            });
        }
    } catch (err) {
        console.error('Meta title counter failed to initialize:', err);
    }
}

/* ---------- 2. FAQ add / remove ---------- */
function initFaqCrud() {
    try {
        const container = document.getElementById('faq-items');
        const emptyMsg  = document.getElementById('faq-empty-msg');
        const addBtn    = document.getElementById('add-faq');

        if (!container || !addBtn) return;

        function template(index) {
            return `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="faq-badge">FAQ ${index + 1}</span>
                    <button type="button" class="btn btn-remove btn-sm remove-faq"><i class='bx bx-trash'></i> Remove</button>
                </div>
                <input type="hidden" name="faqs[${index}][id]" value="">
                <div class="mb-3">
                    <label class="field-label">Question</label>
                    <input type="text" name="faqs[${index}][question]" class="form-control form-field">
                </div>
                <div class="mb-0">
                    <label class="field-label">Answer</label>
                    <textarea name="faqs[${index}][answer]" rows="3" class="form-control form-field"></textarea>
                </div>`;
        }

        function refresh() {
            const items = container.querySelectorAll('.faq-item');

            items.forEach(function (item, index) {
                item.querySelectorAll('input, textarea').forEach(function (field) {
                    const name = field.getAttribute('name');
                    if (name) field.setAttribute('name', name.replace(/faqs\[\d+\]/, 'faqs[' + index + ']'));
                });
                const badge = item.querySelector('.faq-badge');
                if (badge) badge.textContent = 'FAQ ' + (index + 1);
            });

            if (emptyMsg) emptyMsg.classList.toggle('d-none', items.length > 0);
        }

        addBtn.addEventListener('click', function () {
            const wrapper = document.createElement('div');
            wrapper.className = 'faq-item';
            // New FAQs get an empty id so the controller INSERTs instead of UPDATEs.
            wrapper.innerHTML = template(container.querySelectorAll('.faq-item').length);
            container.appendChild(wrapper);
            refresh();
            const first = wrapper.querySelector('input[type="text"]');
            if (first) first.focus();
        });

        container.addEventListener('click', function (event) {
            const btn = event.target.closest('.remove-faq');
            if (!btn) return;
            // Dropping the row from the form is enough: on update the controller deletes any FAQ id that wasn't submitted.
            btn.closest('.faq-item').remove();
            refresh();
        });

        refresh();
    } catch (err) {
        console.error('FAQ add/remove failed to initialize:', err);
    }
}

/* ---------- 3. Summernote editor (jQuery + Summernote come from the layout; CDN fallback if missing) ---------- */
function initSummernoteEditor() {
    try {
        if (!document.getElementById('summernote')) return;

        if (typeof window.jQuery === 'undefined') {
            loadScript('https://code.jquery.com/jquery-3.7.1.min.js', loadSummernoteAssets);
        } else {
            loadSummernoteAssets();
        }
    } catch (err) {
        console.error('Summernote setup failed:', err);
    }
}

function loadScript(src, onload) {
    const s = document.createElement('script');
    s.src = src;
    s.onload = onload;
    s.onerror = function () { console.error('Failed to load ' + src); };
    document.head.appendChild(s);
}

function loadSummernoteAssets() {
    try {
        if (typeof window.jQuery.fn.summernote === 'undefined') {
            if (!document.getElementById('summernote-css')) {
                const css = document.createElement('link');
                css.id = 'summernote-css';
                css.rel = 'stylesheet';
                css.href = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css';
                document.head.appendChild(css);
            }
            loadScript('https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js', mountSummernote);
        } else {
            mountSummernote();
        }
    } catch (err) {
        console.error('Loading Summernote assets failed:', err);
    }
}

function mountSummernote() {
    try {
        window.jQuery('#summernote').summernote({
            placeholder: 'Write your blog description here...',
            tabsize: 2,
            height: 320
        });
    } catch (err) {
        console.error('Summernote failed to mount on #summernote:', err);
    }
}

/* ---------- 4. Image preview (clearing the file input restores the saved image, if any) ---------- */
function initImagePreview() {
    try {
        const input   = document.getElementById('image');
        const preview = document.getElementById('image-preview');
        if (!input || !preview) return;

        const original = preview.getAttribute('data-original') || '';

        input.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                if (original) {
                    preview.src = original;
                    preview.style.display = 'block';
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    } catch (err) {
        console.error('Image preview failed to initialize:', err);
    }
}

/* ---------- 5. Subcategory list follows the selected category ---------- */
function initCategorySubcategoryFilter() {
    try {
        const categorySelect    = document.querySelector('select[name="category_id"]');
        const subcategorySelect = document.querySelector('select[name="subcategory_id"]');
        if (!categorySelect || !subcategorySelect) return;

        const options = Array.from(subcategorySelect.querySelectorAll('option[value]'));

        function update() {
            const categoryId = categorySelect.value;
            const current    = subcategorySelect.value;
            let hasVisible   = false;

            options.forEach(function (option) {
                if (!option.value) return; // keep the placeholder
                const show = !categoryId || option.getAttribute('data-category-id') === categoryId;
                option.hidden = !show;
                option.disabled = !show;
                if (show) hasVisible = true;
            });

            if (!categoryId) {
                subcategorySelect.value = '';
                return;
            }

            const currentStillValid = options.some(function (o) {
                return o.value === current && o.value !== '' && !o.hidden;
            });

            if (currentStillValid) {
                subcategorySelect.value = current;
            } else if (hasVisible) {
                subcategorySelect.value = '';
            }
        }

        categorySelect.addEventListener('change', update);
        update();
    } catch (err) {
        console.error('Category/subcategory filter failed to initialize:', err);
    }
}
</script>
@endsection