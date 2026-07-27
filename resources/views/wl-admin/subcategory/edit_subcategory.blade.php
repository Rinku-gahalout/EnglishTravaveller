@extends('wl-admin.layouts.app')

@section('content')
    <div class="container-fluid py-4 ledger-dash">
        @include('wl-admin.layouts.sessionmessage')

        <div class="page-header mb-4 p-4 rounded-4 shadow-sm bg-white border ledger-header">
            <div>
                <h2 class="mb-1">Edit Subcategory</h2>
                <p class="mb-0 text-secondary">Update the subcategory details and parent category.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.subcategories.list') }}" class="btn btn-outline-ledger">Subcategory List</a>
                <a href="{{ route('admin.categories.listCategory') }}" class="btn btn-outline-ledger">Category List</a>
            </div>
        </div>

        <div class="card ledger-card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.subcategory.update', $subcategory->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="category_id" class="form-label ledger-label">Parent Category</label>
                        <select id="category_id" name="category_id" class="form-select ledger-input @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label ledger-label">Subcategory Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $subcategory->name) }}"
                            class="form-control ledger-input @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label ledger-label">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $subcategory->slug) }}"
                            class="form-control ledger-input @error('slug') is-invalid @enderror">
                        <div class="form-text text-secondary">Leave blank to auto-generate from the subcategory name.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label ledger-label">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-control ledger-input @error('description') is-invalid @enderror">{{ old('description', $subcategory->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label ledger-label">Status</label>
                        <select id="status" name="status" class="form-select ledger-input @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $subcategory->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $subcategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-brass">Update Subcategory</button>
                </form>
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
    </style>
@endsection
