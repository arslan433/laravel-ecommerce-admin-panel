<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Name <span class="text-danger">*</span></label>
        <input type="text" 
               name="name" 
               value="{{ old('name', $user->name ?? '') }}" 
               class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('name') is-invalid @enderror">
        @error('name') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>

    <!-- Email Field -->
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Email <span class="text-danger">*</span></label>
        <input type="email" 
               name="email" 
               value="{{ old('email', $user->email ?? '') }}" 
               class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('name') is-invalid @enderror">
        @error('email') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>
</div>

<hr class="my-4  opacity-300">

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Role</label>
        @php
            $roleValue = old('role', $selectedRole ?? null);
        @endphp
        <select name="role" class="form-select rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input cursor-pointer @error('role') is-invalid @enderror">
            <option value="">— No Role —</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (string)$roleValue === (string)$role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>
</div>

<hr class="my-4 opacity-300">

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Password {{ isset($user) ? '(leave blank to keep current)' : '' }}</label>
        <input type="password" 
               name="password" 
               class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('password') is-invalid @enderror" 
               autocomplete="new-password">
        @error('password') 
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-2">Confirm Password {{ isset($user) ? '' : '*' }}</label>
        <input type="password" 
               name="password_confirmation" 
               class="form-control rounded-3 border-gray-400  bg-light px-3 py-2 shadow-none custom-form-input" 
               autocomplete="new-password">
    </div>
</div>
