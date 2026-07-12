<div class="row g-3">
    <div class="col-md-6">
        <label class="cat-labels">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $role->name ?? '') }}" class="form-control @error('name') is-invalid @enderror">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<hr class="my-4">

<div class="mb-3">
    <label class="cat-labels">Permissions</label>

    @php
        $selected = old('permissions', $role_permissions ?? []);
        $selected = is_array($selected) ? $selected : [];
    @endphp

    @if(isset($permissions) && $permissions->count())
        <div class="row g-2">
            @foreach($permissions as $permission)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="permissions[]"
                               value="{{ $permission->name }}"
                               id="perm_{{ $permission->id }}"
                            {{ in_array($permission->id, $selected) || in_array($permission->name, $selected) ? 'checked' : '' }}>
                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-muted small">No permissions found.</div>
    @endif
</div>

