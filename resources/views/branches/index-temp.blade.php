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
                                <h4>All Branches</h4>
                            </div>
                            <div class="card-body">
                                <table id="branchesTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Branch Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>State</th>
                                            <th>Actisdfgdsfgon</th>
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
                buttons.push({
                    text: "Create New Branch",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        action_modal({}, "create");
                    }
                });


                var table = $(table_branch).DataTable({
                    destroy: true,
                    scrollX: true,
                    lengthChange: false,
                    dom: "Bfrtip",
                    buttons: buttons, // Use the dynamically generated buttons array
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
                        url: "/fetch-branches",
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
                    }, {
                        data: "branch_name"
                    }, {
                        data: "email"
                    }, {
                        data: "mobileno"
                    }, {
                        data: "state"
                    }, {
                        data: null
                    }],
                    order: [
                        [0, "asc"]
                    ],
                    columnDefs: [{
                        targets: 5,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            let buttons = "";
                            buttons +=
                                "<button class='btn btn-info viewBtn'>View</button>&nbsp;"

                            buttons += "<button class='btn btn-primary editBtn'>Edit</button>";

                            return buttons;
                        },
                    }],
                });



                $(table_branch + " tbody").on("click", "tr td .viewBtn, tr td .editBtn", function() {
                    let row_data = table.row($(this).parents("tr").get(0)).data();
                    if ($(this).hasClass("viewBtn")) {
                        action_modal(row_data, "view");
                    } else if ($(this).hasClass("editBtn")) {
                        action_modal(row_data, "edit");
                    }
                });
        });
    </script>
@endsection
