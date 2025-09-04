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
                                <h4>My Claims</h4>
                            </div>
                            <div class="card-body">
                                <table id="claimsTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff </th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
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
        var table_claim = "#claimsTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];
            @can('Create Staff Claim')
                buttons.push({
                    text: "Create New Claim",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('staff-claims.create') }}";
                    }
                });
            @endcan

            var table = $(table_claim).DataTable({
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
                    url: "{{ route('staff-claims.fetch') }}",
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
                        data: "staff_name"
                    },
                    {
                        data: "claim_type"
                    },
                    {
                        data: "amount"
                    },
                    {
                        data: "status"
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

                        @can('View Staff Claim')
                            buttons +=
                                `<a href="/staff-claims/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Staff Claim')
                            buttons +=
                                `<a href="/staff-claims/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endcan

                        @can('Delete Staff Claim')
                            buttons +=
                                `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;
                        @endcan

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_claim + " tbody").on("click", ".deleteBtn", function() {
                let claimId = $(this).data("id");
                let url = `/staff-claims/${claimId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this claim?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Claim deleted successfully.');
                            table.ajax.reload(); // Refresh the table
                        },
                        error: function(xhr) {
                            let res = xhr.responseJSON;
                            if (res && res.message) {
                                alert(res.message);
                            } else {
                                alert('Failed to delete the claim.');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
