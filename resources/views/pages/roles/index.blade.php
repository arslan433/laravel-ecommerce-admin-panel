@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Roles</h4>
                                <p class="card-description">
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.create') }}">Add Role</a>
                                </p>
                            </div>

                            <x-alert-message/>
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <div class="row align-items-end mb-3 g-3 justify-content-between" id="roles-toolbar">
                                <div class="col-md-2 d-flex gap-2.5">
                                    <div id="dt-length"></div>
                                </div>

                                <div class="col-md-3 text-end">
                                    <label class="small text-muted">Search</label>
                                    <div id="dt-search"></div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="roles-table" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    <script>
        $(document).ready(function () {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.roles.index") }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                dom:
                    "<'row'<'col-sm-12 col-md-6 mb-3'l><'col-sm-12 col-md-6 mb-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                pageLength: 10,
                buttons: [],
                responsive: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                },
            });

            $('#dt-length').append($('.dataTables_length'));
            $('#dt-search').append($('.dataTables_filter'));
            $('.d-flex.justify-content-end.mb-3').hide();
        });
    </script>
@endsection

