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
                                <h4>All Staff Overtimes</h4>
                            </div>
                            <div class="card-body">
                                <table id="overtimeTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff </th>
                                            <th>Date</th>
                                            <th>Hours
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
        var table_overtime = "#overtimeTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];

            var table = $(table_overtime).DataTable({
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
                    url: "{{ route('overtimes.fetch') }}",
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
                        data: "overtime_date"
                    },
                    {
                        data: "hours"
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

                        @can('View Staff Overtime')
                            buttons +=
                                `<a href="/staff-overtime-approvals/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Staff Overtime')
                            buttons +=
                                `<a href="/staff-overtime-approvals/${row.id}/edit" class="btn btn-primary editBtn">Approval</a>&nbsp;`;
                        @endcan

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_overtime + " tbody").on("click", ".deleteBtn", function() {
                let overtimeId = $(this).data("id");
                let url = `/staff-overtimes/${overtimeId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this overtime?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Overtime record deleted successfully.');
                            table.ajax.reload(); // Refresh the table
                        },
                        error: function(xhr) {
                            let res = xhr.responseJSON;
                            if (res && res.message) {
                                alert(res.message);
                            } else {
                                alert('Failed to delete the overtime record.');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
