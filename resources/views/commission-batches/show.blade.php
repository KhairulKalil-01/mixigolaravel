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
                                <h4>Commission for
                                    {{ \Carbon\Carbon::create()->month($batch->month)->format('F') }}
                                    {{ $batch->year }}</h4>
                            </div>
                            <div class="card-body">
                                <table id="commissionTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Claimer Type</th>
                                            <th>Invoice Num</th>
                                            <th>Amount</th>
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
        var table_commission = "#commissionTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];

            var table = $(table_commission).DataTable({
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
                    url: "{{ route('commission-batch-records.fetch') }}",
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
                        data: "name"
                    },
                    {
                        data: "claimer_type"
                    },
                    {
                        data: "invoice_number"
                    },
                     {
                        data: "amount"
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

                        @can('View Commission Batch')
                            buttons +=
                                `<a href="/commission-batches/${row.batch_id}/record/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan
                        return buttons;
                    }
                }]
            });
        });
    </script>
@endsection
