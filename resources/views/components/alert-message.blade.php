@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between px-3 py-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn text-white p-0" data-bs-dismiss="alert" aria-label="Close">
            <i class="fe fe-x fs-2"></i>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between px-3 py-2" role="alert">
        {{ session('error') }}
        <button type="button" class="btn text-white p-0" data-bs-dismiss="alert" aria-label="Close">
            <i class="fe fe-x fs-2"></i>
        </button>
    </div>
@endif
