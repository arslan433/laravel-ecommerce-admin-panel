@extends('layouts.app')

@section('content')
<div class="container py-4 px-md-4" style="max-width: 900px;">
    <div class="d-flex flex-column mb-4 pb-3 border-bottom border-light">
        <h1 class="h3 fw-bold text-dark m-0 mb-1">
            {{ isset($role) ? 'Edit' : 'Add' }} Role Position
        </h1>
        <small class="text-muted">Define the position title, assign permissions, and layout system entry parameters.</small>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}" method="POST">
                @csrf
                @if(isset($role)) @method('PUT') @endif

                <div class="form-content-wrapper text-dark">
                    @include('pages.roles.partials.form')
                </div>

                <div class="d-flex justify-content-end align-items-center gap-2 mt-5 pt-3 border-top border-light">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-light rounded-pill px-4 fw-medium border-light text-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm fw-medium transition-all">
                        <i class="fa fa-check"></i>
                        {{ isset($role) ? 'Update' : 'Save' }}
                        Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection