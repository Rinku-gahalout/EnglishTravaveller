@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">
        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="mb-1">Edit Blog</h2>
                <p class="mb-0 text-secondary">Update the blog post and FAQ entries.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-ledger">Blog List</a>
                <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-ledger">Category List</a>
            </div>
        </div>

        <div class="card ledger-card mb-4">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.blog.update', $blog->id) }}" id="blog-form"  enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <h6 class="ledger-section-title">Basic Info</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label ledger-label">Language</label>
                            <select name="language" class="form-select ledger-input @error('language') is-invalid @enderror">
                                <option value="en" {{ old('language', $blog->language) == 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ old('language', $blog->language) == 'es' ? 'selected' : '' }}>Spanish</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label ledger-label">Category</label>
                            <select name="category_id" class="form-select ledger-input @error('category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label class="form-label ledger-label">Subcategory</label>
                            <select name="subcategory_id" class="form-select ledger-input @error('subcategory_id') is-invalid @enderror">
                                <option value="">Select Subcategory</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category-id="{{ $subcategory->category_id }}" {{ old('subcategory_id', $blog->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label ledger-label">Blog Heading</label>
        <input
            type="text"
            name="blog_heading"
            value="{{ old('blog_heading', $blog->blog_heading) }}"
            class="form-control ledger-input @error('blog_heading') is-invalid @enderror"
        >

        @error('blog_heading')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label ledger-label">Blog URL</label>
        <input
            type="text"
            name="blog_url"
            value="{{ old('blog_url', $blog->blog_url) }}"
            class="form-control ledger-input @error('blog_url') is-invalid @enderror"
            placeholder="e.g. how-to-learn-laravel"
        >

        @error('blog_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <small class="text-secondary">
            Use a URL-friendly slug, for example:
            <strong>how-to-learn-laravel</strong>
        </small>
    </div>
</div>

<div class="row g-3 mt-1">

    <!-- Image -->
    <div class="col-md-6">
        <label class="form-label ledger-label">Image</label>

        <input 
            type="file" 
            id="image" 
            name="image" 
            accept="image/*" 
            class="form-control ledger-input @error('image') is-invalid @enderror"
        >

        @error('image') 
            <div class="invalid-feedback">{{ $message }}</div> 
        @enderror

        <div class="mt-3">
            <img 
                id="image-preview" 
                src="{{ $blog->image ? asset($blog->image) : '#' }}" 
                alt="Preview"
                style="{{ $blog->image ? '' : 'display:none;' }}max-width:250px;border-radius:10px;border:1px solid #ddd;padding:5px;"
            >
        </div>
    </div>

    <!-- Meta Keywords -->
    <div class="col-md-6">
        <label class="form-label ledger-label">Meta Keywords</label>

        <input 
            type="text" 
            name="meta_keywords" 
            value="{{ old('meta_keywords', $blog->meta_keywords) }}" 
            class="form-control ledger-input @error('meta_keywords') is-invalid @enderror"
            placeholder="Enter meta keywords"
        >

        @error('meta_keywords') 
            <div class="invalid-feedback">{{ $message }}</div> 
        @enderror
    </div>

</div>
                    <hr class="ledger-divider">

                    <h6 class="ledger-section-title">SEO / Meta</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label ledger-label d-flex justify-content-between">
                                <span>Meta Title</span>
                                <span id="meta-title-counter" class="ledger-counter">0 / 60</span>
                            </label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                                   maxlength="60"
                                   class="form-control ledger-input @error('meta_title') is-invalid @enderror">
                            <div id="meta-title-error" class="invalid-feedback-live"></div>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <label class="form-label ledger-label">Alt Tag</label>-->
                        <!--    <input type="text" name="alt_tag" value="{{ old('alt_tag', $blog->alt_tag) }}" class="form-control ledger-input @error('alt_tag') is-invalid @enderror">-->
                        <!--    @error('alt_tag')-->
                        <!--        <div class="invalid-feedback">{{ $message }}</div>-->
                        <!--    @enderror-->
                        <!--</div>-->
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-12">
                            <label class="form-label ledger-label">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control ledger-input @error('meta_description') is-invalid @enderror">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!--<div class="row g-3 mt-1">-->
                    <!--    <div class="col-md-12">-->
                    <!--        <label class="form-label ledger-label">Meta Keywords</label>-->
                    <!--        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}" class="form-control ledger-input @error('meta_keywords') is-invalid @enderror">-->
                    <!--        @error('meta_keywords')-->
                    <!--            <div class="invalid-feedback">{{ $message }}</div>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--</div>-->

                    <hr class="ledger-divider">

                    <h6 class="ledger-section-title">Blog Description</h6>
                    <div>
                        <textarea id="summernote" name="blog_description" class="form-control ledger-input @error('blog_description') is-invalid @enderror">{{ old('blog_description', $blog->blog_description) }}</textarea>
                        @error('blog_description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label ledger-label">Status</label>
                            <select name="is_draft" class="form-select ledger-input @error('is_draft') is-invalid @enderror">
                                <option value="0" {{ (int) old('is_draft', $blog->is_draft) === 0 ? 'selected' : '' }}>Published</option>
                                <option value="1" {{ (int) old('is_draft', $blog->is_draft) === 1 ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('is_draft')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="ledger-divider">

                 <div class="mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="ledger-section-title mb-0">Blog FAQs</h6>
        <button type="button" id="add-faq" class="btn btn-sm btn-brass">+ Add FAQ</button>
    </div>

    <div id="faq-items">
        @if(old('faqs'))
            @foreach(old('faqs') as $index => $faq)
                <div class="faq-item mb-3 p-3 rounded-3 bg-white border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="faq-badge">FAQ #{{ $index + 1 }}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-faq">Remove</button>
                    </div>
                    <input type="hidden" name="faqs[{{ $index }}][id]" value="{{ $faq['id'] ?? '' }}">
                    <div class="mb-3">
                        <label class="form-label ledger-label">Question</label>
                        <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq['question'] }}" class="form-control ledger-input @error('faqs.' . $index . '.question') is-invalid @enderror">
                        @error('faqs.' . $index . '.question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-0">
                        <label class="form-label ledger-label">Answer</label>
                        <textarea name="faqs[{{ $index }}][answer]" rows="3" class="form-control ledger-input @error('faqs.' . $index . '.answer') is-invalid @enderror">{{ $faq['answer'] }}</textarea>
                        @error('faqs.' . $index . '.answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach
        @elseif(isset($blog) && $blog->faqs && $blog->faqs->count())
            @foreach($blog->faqs as $index => $faq)
                <div class="faq-item mb-3 p-3 rounded-3 bg-white border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="faq-badge">FAQ #{{ $index + 1 }}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-faq">Remove</button>
                    </div>
                    <input type="hidden" name="faqs[{{ $index }}][id]" value="{{ $faq->id }}">
                    <div class="mb-3">
                        <label class="form-label ledger-label">Question</label>
                        <input type="text" name="faqs[{{ $index }}][question]" value="{{ $faq->question }}" class="form-control ledger-input">
                    </div>
                    <div class="mb-0">
                        <label class="form-label ledger-label">Answer</label>
                        <textarea name="faqs[{{ $index }}][answer]" rows="3" class="form-control ledger-input">{{ $faq->answer }}</textarea>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <p id="faq-empty-msg" class="text-secondary small {{ (old('faqs') || (isset($blog) && $blog->faqs && $blog->faqs->count())) ? 'd-none' : '' }}">
        No FAQs added yet. Click "Add FAQ" to create one.
    </p>
</div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-brass px-4">Update Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        /* ==========================================================
           Each feature below is fully isolated in its own try/catch.
           If one fails (e.g. Summernote), the others still run.
           Open the browser console (F12) if something still doesn't
           work — the console.error() calls will tell you exactly why.
        ========================================================== */

        document.addEventListener('DOMContentLoaded', function () {
            initMetaTitleCounter();
            initFaqCrud();
            initSummernoteEditor();
            initImagePreview();
            initCategorySubcategoryFilter();
        });

        /* ---------- 1. Meta title live 60-char validation ---------- */
        function initMetaTitleCounter() {
            try {
                const metaTitleInput = document.getElementById('meta_title');
                const metaTitleCounter = document.getElementById('meta-title-counter');
                const metaTitleError = document.getElementById('meta-title-error');
                const blogForm = document.getElementById('blog-form');
                const META_TITLE_LIMIT = 60;

                if (!metaTitleInput || !metaTitleCounter) return;

                function validateMetaTitle() {
                    const len = metaTitleInput.value.length;
                    metaTitleCounter.textContent = len + ' / ' + META_TITLE_LIMIT;

                    metaTitleCounter.classList.remove('ledger-counter-danger', 'ledger-counter-warning');
                    metaTitleInput.classList.remove('is-invalid');
                    metaTitleError.textContent = '';

                    if (len >= META_TITLE_LIMIT) {
                        metaTitleCounter.classList.add('ledger-counter-danger');
                        metaTitleInput.classList.add('is-invalid');
                        metaTitleError.textContent = 'Meta title cannot exceed ' + META_TITLE_LIMIT + ' characters.';
                    } else if (len >= META_TITLE_LIMIT - 10) {
                        metaTitleCounter.classList.add('ledger-counter-warning');
                    }
                }

                metaTitleInput.addEventListener('input', validateMetaTitle);
                metaTitleInput.addEventListener('keyup', validateMetaTitle);
                validateMetaTitle(); // run once on load (covers existing / old() value)

                if (blogForm) {
                    blogForm.addEventListener('submit', function (e) {
                        validateMetaTitle();
                        if (metaTitleInput.value.length > META_TITLE_LIMIT) {
                            e.preventDefault();
                            metaTitleInput.focus();
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
                const faqContainer = document.getElementById('faq-items');
                const faqEmptyMsg = document.getElementById('faq-empty-msg');
                const addFaqBtn = document.getElementById('add-faq');

                if (!faqContainer || !addFaqBtn) return;

                function faqTemplate(index) {
                    return `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="faq-badge">FAQ #${index + 1}</span>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-faq">Remove</button>
                        </div>
                        <input type="hidden" name="faqs[${index}][id]" value="">
                        <div class="mb-3">
                            <label class="form-label ledger-label">Question</label>
                            <input type="text" name="faqs[${index}][question]" class="form-control ledger-input">
                        </div>
                        <div class="mb-0">
                            <label class="form-label ledger-label">Answer</label>
                            <textarea name="faqs[${index}][answer]" rows="3" class="form-control ledger-input"></textarea>
                        </div>
                    `;
                }

                function refreshFaqIndicesAndBadges() {
                    const items = faqContainer.querySelectorAll('.faq-item');

                    items.forEach(function (item, index) {
                        item.querySelectorAll('input, textarea').forEach(function (field) {
                            const name = field.getAttribute('name');
                            if (!name) return;
                            field.setAttribute('name', name.replace(/faqs\[\d+\]/, 'faqs[' + index + ']'));
                        });

                        const badge = item.querySelector('.faq-badge');
                        if (badge) badge.textContent = 'FAQ #' + (index + 1);
                    });

                    if (faqEmptyMsg) faqEmptyMsg.classList.toggle('d-none', items.length > 0);
                }

                addFaqBtn.addEventListener('click', function () {
                    // New FAQs always get an empty "id" field so the controller
                    // knows to INSERT rather than UPDATE this row.
                    const index = faqContainer.querySelectorAll('.faq-item').length;
                    const wrapper = document.createElement('div');
                    wrapper.className = 'faq-item mb-3 p-3 rounded-3 bg-white border';
                    wrapper.innerHTML = faqTemplate(index);
                    faqContainer.appendChild(wrapper);
                    refreshFaqIndicesAndBadges();
                    const firstInput = wrapper.querySelector('input[type="text"]');
                    if (firstInput) firstInput.focus();
                });

                faqContainer.addEventListener('click', function (event) {
                    if (event.target.matches('.remove-faq')) {
                        // Removing here just drops the field from the submitted
                        // form. The controller diffs submitted IDs against the
                        // blog's existing FAQ IDs and deletes whatever's missing,
                        // so this correctly deletes the row on Update.
                        event.target.closest('.faq-item').remove();
                        refreshFaqIndicesAndBadges();
                    }
                });

                refreshFaqIndicesAndBadges();
            } catch (err) {
                console.error('FAQ add/remove failed to initialize:', err);
            }
        }

        /* ---------- 3. Summernote editor ---------- */
        function initSummernoteEditor() {
            try {
                const target = document.getElementById('summernote');
                if (!target) return;

                // Summernote needs jQuery. Only load it if it isn't already
                // provided by the admin layout, to avoid loading it twice.
                if (typeof window.jQuery === 'undefined') {
                    const jq = document.createElement('script');
                    jq.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
                    jq.onload = loadSummernoteAssets;
                    jq.onerror = function () {
                        console.error('Failed to load jQuery from CDN — check your internet connection / CSP.');
                    };
                    document.head.appendChild(jq);
                } else {
                    loadSummernoteAssets();
                }
            } catch (err) {
                console.error('Summernote setup failed:', err);
            }
        }

        function loadSummernoteAssets() {
            try {
                if (!document.getElementById('summernote-css')) {
                    const css = document.createElement('link');
                    css.id = 'summernote-css';
                    css.rel = 'stylesheet';
                    css.href = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css';
                    document.head.appendChild(css);
                }

                if (typeof window.jQuery.fn.summernote === 'undefined') {
                    const js = document.createElement('script');
                    js.src = 'https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js';
                    js.onload = mountSummernote;
                    js.onerror = function () {
                        console.error('Failed to load Summernote JS from CDN.');
                    };
                    document.head.appendChild(js);
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

        function initCategorySubcategoryFilter() {
            try {
                const categorySelect = document.querySelector('select[name="category_id"]');
                const subcategorySelect = document.querySelector('select[name="subcategory_id"]');

                if (!categorySelect || !subcategorySelect) return;

                const subcategoryOptions = Array.from(subcategorySelect.querySelectorAll('option[value]'));
                const placeholderOption = subcategorySelect.querySelector('option[value=""]');

                function updateSubcategories() {
                    const selectedCategoryId = categorySelect.value;
                    const currentValue = subcategorySelect.value;
                    let hasVisibleOption = false;

                    subcategoryOptions.forEach(function (option) {
                        if (!option.value) return;

                        const matchesCategory = !selectedCategoryId || option.getAttribute('data-category-id') === selectedCategoryId;
                        const shouldShow = matchesCategory;
                        option.hidden = !shouldShow;
                        option.disabled = !shouldShow;

                        if (shouldShow) {
                            hasVisibleOption = true;
                        }
                    });

                    if (placeholderOption) {
                        placeholderOption.hidden = false;
                        placeholderOption.disabled = false;
                    }

                    if (!selectedCategoryId) {
                        subcategorySelect.value = '';
                        return;
                    }

                    if (currentValue && Array.from(subcategorySelect.querySelectorAll('option[value]')).some(function (option) {
                        return option.value === currentValue && !option.hidden;
                    })) {
                        subcategorySelect.value = currentValue;
                    } else if (hasVisibleOption) {
                        subcategorySelect.value = '';
                    }
                }

                categorySelect.addEventListener('change', updateSubcategories);
                updateSubcategories();
            } catch (err) {
                console.error('Category/subcategory filter failed to initialize:', err);
            }
        }

        function initImagePreview() {

    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');

    if (!input || !preview) return;

    input.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };

        reader.readAsDataURL(file);

    });

}
    </script>
@endsection

@section('styles')
    <style>
        .ledger-input {
            background: #f6f1e4;
            border: 1px solid rgba(22, 35, 43, .18);
            border-radius: .75rem;
        }

        .ledger-input:focus {
            background: #fbf8ef;
            border-color: #b8935a;
            box-shadow: 0 0 0 .2rem rgba(184, 147, 90, .18);
        }

        .ledger-label {
            font-family: 'Big Shoulders Display', sans-serif;
            font-weight: 700;
            letter-spacing: .02em;
            text-transform: uppercase;
            font-size: .85rem;
            color: #142f3d;
        }

        .ledger-section-title {
            font-weight: 700;
            color: #16232b;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-size: .95rem;
            margin-bottom: 1rem;
        }

        .ledger-divider {
            border-top: 1px dashed rgba(22, 35, 43, .18);
            margin: 1.75rem 0;
        }

        .ledger-card {
            border-radius: 1rem;
            border: 1px solid rgba(22, 35, 43, .08);
        }

        .ledger-header {
            border-radius: 1rem;
        }

        .btn-brass {
            background: #b8935a;
            border: 1px solid #96703f;
            color: #16232b;
            font-weight: 600;
            border-radius: .75rem;
        }

        .btn-brass:hover {
            background: #a67f47;
            color: #16232b;
        }

        .btn-outline-ledger {
            border: 1px solid #142f3d;
            color: #142f3d;
            border-radius: .75rem;
            font-weight: 600;
        }

        .btn-outline-ledger:hover {
            background: #142f3d;
            color: #fff;
        }

        .faq-item {
            transition: box-shadow .15s ease;
        }

        .faq-item:hover {
            box-shadow: 0 .25rem .75rem rgba(22, 35, 43, .06);
        }

        .faq-badge {
            font-family: 'Big Shoulders Display', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            font-size: .8rem;
            letter-spacing: .03em;
            color: #b8935a;
        }

        .ledger-counter {
            font-weight: 600;
            font-size: .78rem;
            color: #6b7b83;
        }

        .ledger-counter-warning {
            color: #b8862f;
        }

        .ledger-counter-danger {
            color: #c0392b;
        }

        .invalid-feedback-live {
            display: block;
            font-size: .8rem;
            color: #c0392b;
            margin-top: .25rem;
            min-height: 1.1rem;
        }

        .note-editor.note-frame {
            border-radius: .75rem;
            border-color: rgba(22, 35, 43, .18) !important;
            overflow: hidden;
        }
    </style>
@endsection