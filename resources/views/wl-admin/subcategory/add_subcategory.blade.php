@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">

        @include('wl-admin.layouts.sessionmessage')

        <!-- ================= PAGE HEADER ================= -->
        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header">

            <div>
                <h2 class="mb-1">Add Subcategory</h2>
                <p class="mb-0 text-secondary">
                    Create a subcategory and assign it to a category.
                </p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.subcategories.list') }}"
                   class="btn btn-outline-ledger">
                    Subcategory List
                </a>

                <a href="{{ route('admin.categories.listCategory') }}"
                   class="btn btn-outline-ledger">
                    Category List
                </a>
            </div>

        </div>


        <!-- ================= FORM CARD ================= -->
        <div class="card ledger-card mb-4">

            <div class="card-body">

                <form method="POST"
                      action="{{ route('admin.subcategory.store') }}">

                    @csrf

<!-- ================= CATEGORY ================= -->
<div class="mb-3">

    <label for="category_id"
           class="form-label ledger-label">
        Parent Category
    </label>

    <select id="category_id"
            name="category_id"
            class="form-select ledger-input @error('category_id') is-invalid @enderror">

        <option value="">
            Select Category
        </option>

        @foreach($categories as $category)

            <option value="{{ $category->id }}"
                {{ old('category_id') == $category->id ? 'selected' : '' }}>

                {{ $category->name }}

            </option>

        @endforeach

    </select>

    @error('category_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= NAME ================= -->
<div class="mb-3">

    <label for="name"
           class="form-label ledger-label">
        Subcategory Name
    </label>

    <input type="text"
           id="name"
           name="name"
           value="{{ old('name') }}"
           class="form-control ledger-input @error('name') is-invalid @enderror">

    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= SLUG ================= -->
<div class="mb-3">

    <label for="slug"
           class="form-label ledger-label">
        Slug (optional)
    </label>

    <input type="text"
           id="slug"
           name="slug"
           value="{{ old('slug') }}"
           class="form-control ledger-input @error('slug') is-invalid @enderror">

    <div class="form-text text-secondary">
        Leave blank to auto-generate from the subcategory name.
    </div>

    @error('slug')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= TITLE ================= -->
<!-- ================= META TITLE ================= -->
<div class="mb-3">

    <label for="meta_title"
           class="form-label ledger-label">
        Meta Title
    </label>

    <input type="text"
           id="meta_title"
           name="meta_title"
           value="{{ old('meta_title') }}"
           maxlength="255"
           class="form-control ledger-input @error('meta_title') is-invalid @enderror"
           placeholder="Enter meta title...">

    @error('meta_title')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>

  <div class="row g-3 mt-1">
                        <div class="col-md-12">
                            <label class="form-label ledger-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control ledger-input @error('meta_keywords') is-invalid @enderror">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
<!-- ================= META DESCRIPTION ================= -->
<div class="mb-3">

    <label for="meta_description"
           class="form-label ledger-label">
        Meta Description
    </label>

    <textarea id="meta_description"
              name="meta_description"
              rows="3"
              maxlength="160"
              class="form-control ledger-input @error('meta_description') is-invalid @enderror"
              placeholder="Enter a short description for search engines...">{{ old('meta_description') }}</textarea>

    <div class="d-flex justify-content-between mt-1">

        <div class="form-text text-secondary">
            Recommended length: 150–160 characters.
        </div>

        <div class="form-text">
            <span id="meta-description-count">0</span>/160
        </div>

    </div>

    @error('meta_description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= CONTENT / SUMMERNOTE ================= -->
<div class="mb-3">

    <label for="description"
           class="form-label ledger-label">
        Content
    </label>

    <textarea id="description"
              name="description"
              rows="6"
              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= STATUS ================= -->
<div class="mb-3">

    <label for="status"
           class="form-label ledger-label">
        Status
    </label>

    <select id="status"
            name="status"
            class="form-select ledger-input @error('status') is-invalid @enderror">

        <option value="active"
            {{ old('status') == 'active' ? 'selected' : '' }}>
            Active
        </option>

        <option value="inactive"
            {{ old('status') == 'inactive' ? 'selected' : '' }}>
            Inactive
        </option>

    </select>

    @error('status')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>


<!-- ================= BUTTON ================= -->
<button type="submit"
        class="btn btn-brass">
    Save Subcategory
</button>


                </form>

            </div>

        </div>

    </div>
@endsection


{{-- =========================================================
     PAGE STYLES
========================================================= --}}
@section('styles')

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

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


        /* ================= HEADER ================= */

        .ledger-header h2,
        .ledger-header h5 {

            font-family: var(--display-font);

        }


        /* ================= CARD ================= */

        .ledger-card {

            border: 1px solid rgba(22, 35, 43, .08);

            border-radius: .75rem;

            background: #fffdf8;

            box-shadow: 0 4px 14px rgba(11, 29, 38, .06);

        }


        /* ================= LABEL ================= */

        .ledger-label {

            font-family: var(--display-font);

            font-weight: 700;

            letter-spacing: .02em;

            text-transform: uppercase;

            font-size: .85rem;

            color: var(--navy-soft);

        }


        /* ================= INPUT ================= */

        .ledger-input {

            border: 1px solid rgba(22, 35, 43, .18);

            border-radius: .75rem;

            background: var(--paper);

            color: var(--ink);

        }


        .ledger-input:focus {

            border-color: var(--brass);

            box-shadow: 0 0 0 .2rem rgba(201, 162, 106, .2);

        }


        /* ================= BUTTON ================= */

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


        /* ================= OUTLINE BUTTON ================= */

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


        /* ================= FORM TEXT ================= */

        .form-text {

            color: var(--ink-soft);

        }


        /* =====================================================
           SUMMERNOTE
        ===================================================== */

        .note-editor.note-frame {

            border: 1px solid rgba(22, 35, 43, .18) !important;

            border-radius: .75rem !important;

            overflow: hidden;

            background: #ffffff;

        }


        .note-editor .note-toolbar {

            background: var(--paper);

            border-bottom: 1px solid rgba(22, 35, 43, .12);

        }


        .note-editor .note-editable {

            background: #ffffff;

            min-height: 300px;

            color: var(--ink);

            font-family: var(--body-font);

            font-size: 15px;

            line-height: 1.6;

        }


        .note-editor .note-statusbar {

            background: var(--paper);

        }


        .note-editor .note-btn {

            border-radius: .35rem;

        }


        .note-editor .note-btn:hover {

            background: #e9dfca;

        }


        .note-placeholder {

            color: #8a969c !important;

        }


        /* ================= MOBILE ================= */

        @media (max-width: 768px) {

            .page-header {

                padding: 20px !important;

            }

            .page-header .d-flex {

                margin-top: 15px;

            }

            .note-editor .note-toolbar {

                flex-wrap: wrap;

            }

        }

    </style>

@endsection


{{-- =========================================================
     SUMMERNOTE SCRIPT
========================================================= --}}
@section('scripts')

    <script>

        $(document).ready(function () {

            $('#description').summernote({

                placeholder: 'Write subcategory content here...',

                tabsize: 2,

                height: 300,

                toolbar: [

                    ['style', ['style']],

                    ['font', [
                        'bold',
                        'italic',
                        'underline',
                        'clear'
                    ]],

                    ['fontname', ['fontname']],

                    ['color', ['color']],

                    ['para', [
                        'ul',
                        'ol',
                        'paragraph'
                    ]],

                    ['table', ['table']],

                    ['insert', [
                        'link',
                        'picture',
                        'video'
                    ]],

                    ['view', [
                        'fullscreen',
                        'codeview',
                        'help'
                    ]]

                ]

            });

        });

    </script>

@endsection