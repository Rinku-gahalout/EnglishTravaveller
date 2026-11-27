@extends('wl-admin.layouts.app')

@section('content')

<div class="container-fluid py-4 ledger-dash">

    @include('wl-admin.layouts.sessionmessage')

    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header">

        <div>
            <h2 class="mb-1">Edit Subcategory</h2>

            <p class="mb-0 text-secondary">
                Update the subcategory details and parent category.
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


    <!-- ================= SUBCATEGORY FORM ================= -->
    <div class="card ledger-card mb-4">

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.subcategory.update', $subcategory->id) }}">

                @csrf
                @method('PUT')


                <!-- =====================================================
                     1. CATEGORY
                ====================================================== -->
                <div class="mb-3">

                    <label for="category_id"
                           class="form-label ledger-label">
                        Category
                    </label>

                    <select id="category_id"
                            name="category_id"
                            class="form-select ledger-input @error('category_id') is-invalid @enderror">

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>

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


                <!-- =====================================================
                     2. SUBCATEGORY
                ====================================================== -->
                <div class="mb-3">

                    <label for="name"
                           class="form-label ledger-label">
                        Subcategory
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $subcategory->name) }}"
                           maxlength="255"
                           autocomplete="off"
                           class="form-control ledger-input @error('name') is-invalid @enderror"
                           placeholder="Enter subcategory name...">

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     3. SLUG
                ====================================================== -->
                <div class="mb-3">

                    <label for="slug"
                           class="form-label ledger-label">
                        Slug
                    </label>

                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug', $subcategory->slug) }}"
                           maxlength="255"
                           autocomplete="off"
                           class="form-control ledger-input @error('slug') is-invalid @enderror"
                           placeholder="Enter slug...">

                    <div class="form-text text-secondary">
                        Leave blank to automatically generate the slug from the subcategory name.
                    </div>

                    @error('slug')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     4. META TITLE
                ====================================================== -->
                <div class="mb-3">

                    <label for="meta_title"
                           class="form-label ledger-label">
                        Meta Title
                    </label>

                    <input type="text"
                           id="meta_title"
                           name="meta_title"
                           value="{{ old('meta_title', $subcategory->meta_title ?? '') }}"
                           maxlength="255"
                           autocomplete="off"
                           class="form-control ledger-input @error('meta_title') is-invalid @enderror"
                           placeholder="Enter SEO meta title...">

                    @error('meta_title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     5. META DESCRIPTION
                ====================================================== -->
                <div class="mb-3">

                    <label for="meta_description"
                           class="form-label ledger-label">
                        Meta Description
                    </label>

                    <textarea id="meta_description"
                              name="meta_description"
                              rows="3"
                              maxlength="160"
                              autocomplete="off"
                              class="form-control ledger-input @error('meta_description') is-invalid @enderror"
                              placeholder="Write SEO meta description here...">{{ old('meta_description', $subcategory->meta_description ?? '') }}</textarea>

                    <div class="d-flex justify-content-between mt-1">

                        <div class="form-text text-secondary">
                            Recommended length: up to 160 characters.
                        </div>

                        <small id="metaDescriptionCount"
                               class="text-secondary">
                            {{ strlen(old('meta_description', $subcategory->meta_description ?? '')) }}/160
                        </small>

                    </div>

                    @error('meta_description')

                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     6. CONTENT
                ====================================================== -->
                <div class="mb-3">

                    <label for="description"
                           class="form-label ledger-label">
                        Content
                    </label>

                    <textarea id="description"
                              name="description"
                              rows="6"
                              class="form-control ledger-input @error('description') is-invalid @enderror"
                              placeholder="Write subcategory content here...">{{ old('description', $subcategory->description ?? '') }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     7. STATUS
                ====================================================== -->
                <div class="mb-3">

                    <label for="status"
                           class="form-label ledger-label">
                        Status
                    </label>

                    <select id="status"
                            name="status"
                            class="form-select ledger-input @error('status') is-invalid @enderror">

                        <option value="active"
                            {{ old('status', $subcategory->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $subcategory->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('status')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- =====================================================
                     UPDATE BUTTON
                ====================================================== -->
                <button type="submit"
                        class="btn btn-brass">
                    Update Subcategory
                </button>

            </form>

        </div>

    </div>

</div>

@endsection


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
    border-radius: .75rem;
    background: var(--paper);
    color: var(--ink);

}


.ledger-input:focus {

    border-color: var(--brass);
    box-shadow: 0 0 0 .2rem rgba(201, 162, 106, .2);

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

}


.note-editor .note-toolbar {

    background: var(--paper);
    border-bottom: 1px solid rgba(22, 35, 43, .12);

}


.note-editor .note-editable {

    background: #ffffff;
    min-height: 300px;
    color: var(--ink);

}


.note-editor .note-statusbar {

    background: var(--paper);

}


/* =====================================================
   META DESCRIPTION
===================================================== */

#meta_description {

    resize: vertical;
    min-height: 90px;

}

</style>

@endsection


@section('scripts')

<script>

$(document).ready(function () {


    /* =====================================================
       SUMMERNOTE
    ===================================================== */

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


    /* =====================================================
       META DESCRIPTION CHARACTER COUNTER
    ===================================================== */

    function updateMetaDescriptionCount() {

        let length = $('#meta_description').val().length;

        $('#metaDescriptionCount').text(length + '/160');

    }


    $('#meta_description').on('input', function () {

        updateMetaDescriptionCount();

    });


    updateMetaDescriptionCount();

});

</script>

@endsection