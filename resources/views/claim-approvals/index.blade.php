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
                                <h4>All Staff Claims</h4>
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
                                            <th>Approved Amt</th>
                                            <th>Payment Method</th>
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
                    url: "{{ route('claim-approvals.fetch') }}",
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
                        data: "approved_amount"
                    },
                    {
                        data: "payment_method"
                    },
                    {
                        data: null
                    }
                ],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                    targets: 7,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let buttons = "";

                        @can('View Claim Approval')
                            buttons +=
                                `<a href="/claim-approvals/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Claim Approval')
                            buttons +=
                                `<a href="/claim-approvals/${row.id}/edit" class="btn btn-primary editBtn">Approval</a>&nbsp;`;
                        @endcan

                        return buttons;
                    }
                }]
            });
        });
    </script>
@endsection
