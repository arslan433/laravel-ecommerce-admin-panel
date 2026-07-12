@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 px-4 sm:px-6 lg:px-8 transition-colors duration-200">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/70 overflow-hidden p-6">
            
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6">
                {{ isset($role) ? 'Edit Role' : 'Create Role' }}
            </h2>

            <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
                @csrf
                @if(isset($role)) @method('PUT') @endif

                <!-- Form Row Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Text Input Component -->
                    <x-form.input 
                        name="name" 
                        label="Name" 
                        :value="$role->name ?? ''" 
                        :required="true" 
                        placeholder="e.g. Administrator"
                    />
                </div>

                <hr class="my-5 border-gray-200 dark:border-gray-700">

                <!-- Checkbox Group Component for Permissions -->
                <x-form.checkbox-group 
                    name="permissions" 
                    label="Permissions" 
                    :items="$permissions" 
                    :selected="$role_permissions ?? []"
                />

                <!-- Form Actions Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg shadow-sm transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
