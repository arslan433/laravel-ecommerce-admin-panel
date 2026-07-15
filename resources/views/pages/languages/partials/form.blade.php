<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Name <span class="text-danger">*</span></label>
        <input type="text"
            name="name"
            value="{{ old('name', $language->name ?? '') }}"
            class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('name') is-invalid @enderror">
        @error('name')
        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>

    <!-- Code Field -->
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Code <span class="text-danger">*</span></label>
        <input type="text"
            name="code"
            value="{{ old('code', $language->code ?? '') }}"
            class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('code') is-invalid @enderror">
        @error('code')
        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4  opacity-300">

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Status</label>
        <select name="status" class="form-select rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input cursor-pointer @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $language->status ?? 0) ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !old('status', $language->status ?? 0) ? 'selected' : '' }}>Inactive</option>

        </select>
        @error('status')
        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Sort Order</label>
        <input type="number"
            name="sort_order"
            value="{{ old('sort_order', $language->sort_order ?? '') }}"
            class="form-control rounded-2 border-gray-400 bg-light px-2 py-2 shadow-none custom-form-input @error('sort_order') is-invalid @enderror">

        @error('sort_order')
        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4 opacity-300">
<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Directory</label>
        <input type="text"
            name="directory"
            value="{{ old('directory', $language->directory ?? '') }}"
            class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('directory') is-invalid @enderror">
        @error('directory')
        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Default</label>
        <select name="default" class="form-control rounded-2 border-gray-400 bg-light px-2 py-2 shadow-none custom-form-input @error('default') is-invalid @enderror">
            <option value="1" {{ old('default', $language->default ?? 0) ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !old('default', $language->default ?? 0) ? 'selected' : '' }}>No</option>
        </select>
    </div>
</div>