@extends('layouts.app')

@section('content')
    <x-datatable 
        id="roles-table"
        title="Roles Management"
        description="Manage system roles and access permissions."
        :route="route('admin.roles.index')"
        :createRoute="route('admin.roles.create')"
        createLabel="Add Role"
        :columns="[
            ['data' => 'id', 'name' => 'id', 'className' => 'px-6 py-3.5 font-medium text-gray-900 dark:text-white'],
            ['data' => 'name', 'name' => 'name', 'className' => 'px-6 py-3.5 text-gray-700 dark:text-gray-300'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'className' => 'px-6 py-3.5 text-right pr-6']
        ]"
    >
        <!-- Table Headings -->
        <th scope="col" class="px-6 py-3 font-semibold w-16">#</th>
        <th scope="col" class="px-6 py-3 font-semibold">Name</th>
        <th scope="col" class="px-6 py-3 font-semibold text-right pr-6 w-32">Actions</th>
    </x-datatable>
@endsection
