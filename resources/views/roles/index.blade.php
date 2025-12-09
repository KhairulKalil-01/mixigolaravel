@extends('layouts.app')

@section('styles')
    @include('partials.datatables.css')
@endsection


@section('content')
    <div class="themebody-wrap">
        <div class="theme-body common-dash" data-simplebar>
            <div class="custom-container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Roles</h4>
                            </div>
                            <div class="card-body">
                                <table id="rolesTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>Guard Name</th>
                                            <th>Action</th>
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
@section('scripts')
    @include('partials.datatables.js')

    <!-- Initialize DataTable -->
    <script>
        var table_role = "#rolesTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];
            @can('Create Role')
                buttons.push({
                    text: "Create New Role",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('roles.create') }}";
                    }
                });
            @endcan

            var table = $(table_role).DataTable({
                destroy: true,
                scrollX: true,
                lengthChange: false,
                dom: "Bfrtip",
                buttons: buttons,
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "All"]
                ],
                processing: true,
                serverSide: false,
                serverMethod: "POST",
                bDeferRender: true,
                ajax: {
                    url: "/fetch-roles", /* buat route */
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "guard_name"
                    },
                    {
                        data: null
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: 3,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let buttons = "";

                        @role('superadmin')
                            buttons += `<a href="/roles/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endrole

                        @role('superadmin')
                            buttons += `<a href="/roles/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endrole

                        @role('superadmin')
                            buttons += `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;
                        @endrole

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_role + " tbody").on("click", ".deleteBtn", function() {
                let roleId = $(this).data("id");
                let url = `/roles/${roleId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this role?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Role deleted successfully.');
                            table.ajax.reload(); // Refresh the table
                        },
                        error: function(xhr) {
                            alert('Failed to delete the Role.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
