@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="header mt-md-5">
            <div class="header-body">
                <h1 class="header-title">
                    {{ isset($role) ? 'Edit' : 'Add' }} Role
                </h1>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
                    @csrf
                    @if(isset($role)) @method('PUT') @endif

                    @include('pages.roles.partials.form')

                    <button type="submit" class="btn btn-primary mt-4">Save Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection

