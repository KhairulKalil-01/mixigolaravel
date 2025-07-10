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
                                <h4>All Quotations</h4>
                            </div>
                            <div class="card-body">
                                <table id="branchesTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>State</th>
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
        var table_branch = "#branchesTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];
            @can('Create Branch')
                buttons.push({
                    text: "Create New Quotation",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('quotations.create') }}";
                    }
                });
            @endcan

            var table = $(table_branch).DataTable({
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
                    url: "{{ route('branches.fetch') }}", 
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
                        data: "branch_name"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "mobileno"
                    },
                    {
                        data: "state"
                    },
                    {
                        data: null
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: 5,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let buttons = "";

                        @can('View Branch')
                            buttons +=
                                `<a href="/branches/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Branch')
                            buttons +=
                                `<a href="/branches/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endcan

                        @can('Delete Branch')
                            buttons +=
                                `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;
                        @endcan

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_branch + " tbody").on("click", ".deleteBtn", function() {
                let branchId = $(this).data("id");
                let url = `/branches/${branchId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this branch?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Branch deleted successfully.');
                            table.ajax.reload(); // Refresh the table
                        },
                        error: function(xhr) {
                            alert('Failed to delete the branch.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
