<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Name <span class="text-danger">*</span></label>
        
        <input type="text" 
               name="name" 
               value="{{ old('name', $role->name ?? '') }}" 
               class="form-control rounded-3  bg-light px-3 py-2 shadow-none custom-form-input @error('name') is-invalid @enderror">
        
        @error('name') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>
</div>

<hr class="my-4 border-light opacity-100">

<div class="mb-3">
    <label class="form-label fw-bold text-dark mb-3">Assign Permissions</label>

    @php
        $selected = old('permissions', $role_permissions ?? []);
        $selected = is_array($selected) ? $selected : [];
    @endphp

    @if(isset($permissions) && $permissions->count())
        <div class="row g-3">
            @foreach($permissions as $permission)
                <div class="col-md-6 col-lg-4">
                    <div class="form-check custom-permission-card p-3 rounded-3 border border-light bg-light d-flex align-items-center m-0 transition-all">
                        <input class="form-check-input ms-0 me-3 cursor-pointer shadow-none custom-checkbox-input"
                               type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               id="perm_{{ $permission->id }}"
                            {{ in_array($permission->id, $selected) || in_array($permission->name, $selected) ? 'checked' : '' }}>
                        
                        <label class="form-check-label fw-medium text-dark text-sm cursor-pointer select-none w-100" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-muted small italic p-4 bg-light border border-light rounded-3 text-center">
            <i class="bi bi-shield-slash me-1"></i> No permissions found in the matrix database system.
        </div>
    @endif
</div>
