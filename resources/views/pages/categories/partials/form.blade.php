<ul class="nav nav-tabs border-bottom-0 mb-4" id="langTabs" role="tablist"> 
    @foreach(getLanguages() as $lang) 
        <li class="nav-item" role="presentation"> 
            <button class="nav-link fw-semibold px-4 py-2.5 rounded-t-lg transition-all {{ $loop->first ? 'active bg-white border border-bottom-0' : 'text-secondary border-0 bg-transparent' }}" 
                    id="tab-lang-{{ $lang->id }}" 
                    data-bs-toggle="tab" 
                    data-bs-target="#lang-pane-{{ $lang->id }}" 
                    type="button" 
                    role="tab"
                    aria-controls="lang-pane-{{ $lang->id }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"> 
                {{ ucfirst($lang->name) }} 
            </button> 
        </li> 
    @endforeach 
</ul> 

<div class="tab-content" id="langTabsContent"> 
    @foreach(getLanguages() as $lang) 
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
             id="lang-pane-{{ $lang->id }}" 
             role="tabpanel"
             aria-labelledby="tab-lang-{{ $lang->id }}"> 
            
            <input type="hidden" name="translations[{{ $lang->id }}][language_id]" value="{{ $lang->id }}"> 

            <!-- Row 1: Name & Slug (If Edit Mode) -->
            <div class="row g-4 mb-4">
                <div class="{{ isset($category) ? 'col-md-6' : 'col-12' }}"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Name ({{ ucfirst($lang->name) }}) <span class="text-danger">*</span></label> 
                    <input type="text" 
                           name="translations[{{$lang->id}}][name]" 
                           value="{{ old('translations.'.$lang->id.'.name', $description[$lang->id]->name ?? '') }}" 
                           class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.name') is-invalid @enderror"> 
                    @error('translations.'.$lang->id.'.name') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 

                @if(isset($category)) 
                    <div class="col-md-6"> 
                        <label class="form-label fw-semibold text-secondary small mb-1">Slug ({{ ucfirst($lang->name) }})</label> 
                        <div class="input-group"> 
                            <input type="text" 
                                   id="slug-input-{{ $lang->id }}" 
                                   name="translations[{{ $lang->id }}][slug]" 
                                   value="{{ old('translations.'.$lang->id.'.slug', $description[$lang->id]->slug ?? '') }}" 
                                   class="form-control rounded-start-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input" readonly> 
                            <button type="button" class="btn btn-dark rounded-end-3 px-3 edit-slug-btn" data-target="slug-input-{{ $lang->id }}"> 
                                Edit Slug 
                            </button> 
                        </div> 
                    </div> 
                @endif 
            </div>

            <!-- Row 2: Description & Meta Description -->
            <div class="row g-4 mb-4">
                <div class="col-md-6"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Description ({{ ucfirst($lang->name) }})</label> 
                    <textarea name="translations[{{$lang->id}}][description]" 
                              class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.description') is-invalid @enderror" 
                              rows="3">{{ old('translations.'.$lang->id.'.description', $description[$lang->id]->description ?? '') }}</textarea> 
                    @error('translations.'.$lang->id.'.description') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 

                <div class="col-md-6"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Meta Description ({{ ucfirst($lang->name) }})</label> 
                    <textarea name="translations[{{ $lang->id }}][meta_description]" 
                              rows="3" 
                              class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.meta_description') is-invalid @enderror">{{ old('translations.'.$lang->id.'.meta_description', $description[$lang->id]->meta_description ?? '') }}</textarea> 
                    @error('translations.'.$lang->id.'.meta_description') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 
            </div>

            <!-- Row 3: Meta Keywords & Page Title -->
            <div class="row g-4 mb-4">
                <div class="col-md-6"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Meta Keywords ({{ ucfirst($lang->name) }})</label> 
                    <input type="text" 
                           name="translations[{{ $lang->id }}][meta_keywords]" 
                           value="{{ old('translations.'.$lang->id.'.meta_keywords', $description[$lang->id]->meta_keywords ?? '') }}" 
                           class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.meta_keywords') is-invalid @enderror"> 
                    @error('translations.'.$lang->id.'.meta_keywords') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 

                <div class="col-md-6"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Page Title ({{ ucfirst($lang->name) }})</label> 
                    <input type="text" 
                           name="translations[{{ $lang->id }}][title_tag]" 
                           value="{{ old('translations.'.$lang->id.'.title_tag', $description[$lang->id]->title_tag ?? '') }}" 
                           class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.title_tag') is-invalid @enderror"> 
                    @error('translations.'.$lang->id.'.title_tag') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 
            </div>

            <!-- Row 4: Alt Tags -->
            <div class="row g-4">
                <div class="col-md-6"> 
                    <label class="form-label fw-semibold text-secondary small mb-1">Alt Tags</label> 
                    <input type="text" 
                           name="translations[{{ $lang->id }}][alt_tag]" 
                           value="{{ old('translations.'.$lang->id.'.alt_tag', $description[$lang->id]->alt_tag ?? '') }}" 
                           class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('translations.'.$lang->id.'.alt_tag') is-invalid @enderror"> 
                    @error('translations.'.$lang->id.'.alt_tag') 
                        <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div> 
                    @enderror 
                </div> 
            </div>

        </div> 
    @endforeach 
</div>

<hr class="mt-3 opacity-0">

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-1">Parent Category</label>
        <select name="parent_id" class="form-select rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input">
            <option value="0">— No Parent (Top Level) —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id ?? 0) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->lang()->name ?? 'Unnamed Category' }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-1">Image</label>
        <input type="file" name="category_image" class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('category_image') is-invalid @enderror">
        @error('category_image')
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
        @if(isset($category) && $category->image)
            <div class="mt-2">
                <img src="{{ asset('storage/'. $category->image) }}" alt="{{ $category->lang()->name ?? 'Category Image' }}" width="120" style="border-radius: 6px;">
            </div>
        @endif
    </div>
</div>



<hr class="mt-3 opacity-0">

<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-control rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input @error('sort_order') is-invalid @enderror">
        @error('sort_order')
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small mb-1">Status</label>
        <select name="status" class="form-select rounded-3 border-gray-400 bg-light px-3 py-2 shadow-none custom-form-input cursor-pointer @error('status') is-invalid @enderror">
            <option value="1" {{ old('status', $category->status ?? 0) ? 'selected' : '' }}>Active</option>
            <option value="0" {{ !old('status', $category->status ?? 0) ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
            <div class="invalid-feedback ps-2 mt-1 small font-medium">{{ $message }}</div>
        @enderror
    </div>
</div>
