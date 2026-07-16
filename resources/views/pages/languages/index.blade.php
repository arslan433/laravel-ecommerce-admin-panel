@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-md-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 pb-3 border-bottom border-light">
                        <div>
                            <h4 class="card-title fw-bold text-dark m-0 mb-1 d-inline-block">Languages Management</h4>

                        </div>
                        <div>
                            @can('language-create')
                            <a class="btn btn-dark rounded-pill px-4 shadow-sm fw-medium" href="{{ route('admin.languages.create') }}">
                                Add Language
                            </a>
                            
                            @else
                            <button class="btn btn-dark rounded-pill px-4 shadow-sm fw-medium opacity-50 cursor-not-allowed" disabled>
                                Add Language
                            </button>
                            @endcan
                        </div>
                    </div>

                    <x-alert-message />

                    @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                        <div>{{ session('error') }}</div>
                    </div>
                    @endif

                    <!-- Filter & Search Toolbar Layout -->
                    <div class="row align-items-center mb-4 justify-content-between g-3" id="languages-toolbar">
                        <div class="col-sm-auto">
                            <div id="dt-length" class="custom-dt-length"></div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div id="dt-search" class="custom-dt-search position-relative"></div>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3 border border-light custom-table-wrapper">
                        <table id="languages-table" class="table align-middle table-hover mb-0 w-100">
                            <thead class="table-light text-uppercase tracking-wider">
                                <tr>
                                    <th class="py-2 text-muted fw-bold">#</th>
                                    <th class="py-2 text-muted fw-bold">Name</th>
                                    <th class="py-2 text-muted fw-bold">Code</th>
                                    <th class="py-2 text-muted fw-bold">Default</th>
                                    <th class="py-2 text-muted fw-bold">Status</th>
                                    <th class="py-2 px-4 text-muted fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
<script>
    $(document).ready(function() {
        $('#languages-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.languages.index") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'default',
                    name: 'default'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            dom: "<'row d-none'<'col-12'lf>>" +
                "tr" +
                "<'row align-items-center mt-4'<'col-sm-6 text-muted small'i><'col-sm-6 d-flex justify-content-sm-end mt-2 mt-sm-0'p>>",
            pageLength: 10,
            buttons: [],
            responsive: true,
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Quick lookup languages..."
            },
            initComplete: function() {
                $('#dt-length').append($('.dataTables_length'));
                $('#dt-search').append($('.dataTables_filter'));

                $('.dataTables_filter input')
                    .unwrap()
                    .addClass('form-control rounded-pill border-light bg-light px-4 py-2 text-sm shadow-none')
                    .css('width', '250px');

                $('.dataTables_length select')
                    .addClass('form-select form-select-sm d-inline-block rounded-pill border-light bg-light px-3 py-1.5 mx-2 shadow-none cursor-pointer')
                    .css('width', '80px');

                $('.dataTables_length label').addClass('d-flex align-items-center text-muted small m-0');

                $('#dt-search').prepend('<label class="small text-muted mb-1 d-block text-end pe-2">Search</label>');
            }
        });
    });
</script>

@endsection