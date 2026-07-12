@props([
    'name',
    'label',
    'items' => [],
    'selected' => [],
    'idKey' => 'id',
    'valueKey' => 'name',
    'labelKey' => 'name'
])

@php
    $oldSelected = old($name, $selected ?? []);
    // Ensure it's an array or a collection converted to array
    $oldSelected = is_array($oldSelected) ? $oldSelected : (is_object($oldSelected) ? $oldSelected->toArray() : []);
@endphp

<div>
    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">
        {{ $label }}
    </label>

    @if(count($items))
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($items as $item)
                @php
                    $itemId = data_get($item, $idKey);
                    $itemVal = data_get($item, $valueKey);
                    $itemLabel = data_get($item, $labelKey);
                    
                    $isChecked = in_array($itemId, $oldSelected) || in_array($itemVal, $oldSelected);
                @endphp
                <div class="flex items-center space-x-3 p-2 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/30">
                    <input 
                        type="checkbox" 
                        name="{{ $name }}[]" 
                        value="{{ $itemVal }}" 
                        id="{{ $name }}_{{ $itemId }}"
                        {{ $isChecked ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                    >
                    <label for="{{ $name }}_{{ $itemId }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                        {{ $itemLabel }}
                    </label>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-xs text-gray-500 dark:text-gray-400 italic">No items found.</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>
