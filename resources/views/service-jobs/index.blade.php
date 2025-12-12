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
                                <h4>All Jobs</h4>
                            </div>
                            <div class="card-body">
                                <table id="jobsTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Inv Num</th>
                                            <th>Client</th>
                                            <th>In Charge</th>
                                            <th>Date</th>
                                            <th>Time</th>
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
        var table_job = "#jobsTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];
            @can('Create Job')
                buttons.push({
                    text: "Create New Job",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('service-jobs.create') }}";
                    }
                });
            @endcan

            var table = $(table_job).DataTable({
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
                    url: "{{ route('service-jobs.fetch') }}",
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
                        data: 'invoice_number'
                    },
                    {
                        data: "client_name"
                    },
                    {
                        data: "caregiver_name"
                    },
                    {
                        data: "start_date",
                    },
                      {
                        data: "start_time",
                    },
                    {
                        data: null
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: 6,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let buttons = "";

                        @can('View Job')
                            buttons +=
                                `<a href="/service-jobs/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Job')
                            buttons +=
                                `<a href="/service-jobs/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endcan

                        @can('Delete Job')
                            buttons +=
                                `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;
                        @endcan

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_job + " tbody").on("click", ".deleteBtn", function() {
                let jobId = $(this).data("id");
                let url = `/service-jobs/${jobId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this job?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Job deleted successfully.');
                            table.ajax.reload(); 
                        },
                        error: function(xhr) {
                            alert('Failed to delete the client job.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
