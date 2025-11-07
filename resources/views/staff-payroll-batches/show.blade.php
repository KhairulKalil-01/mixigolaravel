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
                                <h4>Payroll for
                                    {{ \Carbon\Carbon::create()->month($batch->month)->format('F') }}
                                    {{ $batch->year }}</h4>
                            </div>
                            <div class="card-body">
                                <table id="payrollTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff </th>
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
        var table_payroll = "#payrollTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];

            var table = $(table_payroll).DataTable({
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
                    url: "{{ route('staff-payroll-records.fetch') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        batch_id: "{{ $batch->id }}",
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
                        data: "status",
                        render: function(data, type, row) {
                            let badgeClass = "";
                            switch (data) {
                                case "Paid":
                                    badgeClass = "badge badge-success";
                                    break;
                                case "Approved":
                                    badgeClass = "badge badge-primary";
                                    break;
                                case "Pending":
                                    badgeClass = "badge badge-warning";
                                    break;
                                default:
                                    badgeClass = "badge badge-secondary";
                            }
                            return `<span class="${badgeClass}">${data}</span>`;
                        }

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

                        @can('View Staff Payroll Batch')
                            buttons +=
                                `<a href="/staff-payroll-batches/${row.batch_id}/staff/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan
                        @can('Edit Staff Payroll Batch')
                            buttons +=
                                `<a href="/staff-payroll-batches/${row.id}/edit" class="btn btn-primary editBtn">Approval</a>&nbsp;`;
                        @endcan
                        return buttons;
                    }
                }]
            });
        });
    </script>
@endsection
