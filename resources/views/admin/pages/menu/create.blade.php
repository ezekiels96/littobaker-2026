@extends('admin.layouts.app')

@section('content')
<h1>Add Menu Item</h1>

{{-- Global error block --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the errors below:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.menu.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Title</label>
        <input
            type="text"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title') }}"
            required
        >
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea
            name="description"
            class="form-control @error('description') is-invalid @enderror"
        >{{ old('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input
            type="number"
            step="0.01"
            name="price"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price') }}"
            required
        >
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Quantity Type</label>
        <select
            name="quantity_type"
            class="form-control @error('quantity_type') is-invalid @enderror"
            required
        >
            <option value="">Select one</option>
            <option value="dozen" {{ old('quantity_type') === 'dozen' ? 'selected' : '' }}>Dozen</option>
            <option value="order" {{ old('quantity_type') === 'order' ? 'selected' : '' }}>Order</option>
            <option value="pieces" {{ old('quantity_type') === 'pieces' ? 'selected' : '' }}>Pieces</option>
        </select>
        @error('quantity_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>Image URLs (one per line)</label>
        <textarea
            name="image_urls"
            class="form-control @error('image_urls') is-invalid @enderror"
            rows="3"
        >{{ old('image_urls') }}</textarea>
        @error('image_urls')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Create</button>
</form>
@endsection
