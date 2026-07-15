@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="text-center p-5 shadow-lg rounded bg-white" style="max-width: 500px; width: 100%;">
        <div class="mb-4">
            <i class="bi bi-shield-lock text-danger" style="font-size: 5rem;"></i>
        </div>
        <h1 class="display-4 fw-bold text-danger">403</h1>
        <h2 class="text-secondary">Access Forbidden</h2>
        <p class="text-muted mt-3">
            You do not have the necessary permissions to view this page. If you believe this is an error, please contact your administrator.
        </p>
        <div class="mt-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark rounded-pill px-4 shadow-sm fw-medium">
                <i class="fe fe-home me-2"></i>Go Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
