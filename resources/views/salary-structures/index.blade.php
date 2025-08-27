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
                                <h4>Staff Salary Structures</h4>
                            </div>
                            <div class="card-body">
                                <table id="table" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff</th>
                                            <th>Base Salary</th>
                                            <th>Employee EPF (%)</th>
                                            <th>Employer EPF (%)</th>
                                            <th>Effective From</th>
                                            <th>Effective To</th>
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
        var tableStructure = "#table";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];

            var table = $(tableStructure).DataTable({
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
                    url: "{{ route('salary-structures.fetch') }}",
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
                        data: "full_name"
                    },
                    {
                        data: "base_salary"
                    },
                    {
                        data: "epf_employee"
                    },
                    {
                        data: "epf_employer"
                    },
                    {
                        data: "effective_from"
                    },
                    {
                        data: "effective_to"
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

                        @can('View Salary Structure')
                            buttons +=
                                `<a href="/salary-structures/${row.staff_id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Salary Structure')
                            buttons +=
                                `<a href="/salary-structures/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endcan
                        buttons +=
                            `<a href="/salary-structures/${row.id}/history" class="btn btn-success editBtn">Create Payslip</a>&nbsp;`;
                        return buttons;
                    }
                }]
            });

        });
    </script>
@endsection
