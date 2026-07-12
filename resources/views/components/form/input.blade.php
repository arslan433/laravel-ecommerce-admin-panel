@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'placeholder' => '',
])

<div>
    <label for="{{ $name }}" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 text-sm bg-white dark:bg-gray-900 border rounded-lg outline-none transition-all duration-150 ' . 
            ($errors->has($name) 
                ? 'border-red-500 focus:ring-1 focus:ring-red-500' 
                : 'border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500')
        ]) }}
    >

    @error($name)
        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>
