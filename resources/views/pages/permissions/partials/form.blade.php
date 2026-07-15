<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Name <span class="text-danger">*</span></label>
        
        <input type="text" 
               name="name" 
               value="{{ old('name', $permission->name ?? '') }}" 
               class="form-control rounded-3  bg-light px-3 py-2 shadow-none custom-form-input @error('name') is-invalid @enderror">
        
        @error('name') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>
</div>

<hr class="my-4 border-light opacity-100">
