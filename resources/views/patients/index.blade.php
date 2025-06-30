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
                                <h4>All Patients</h4>
                            </div>
                            <div class="card-body">
                                <table id="PatientsTable" class="display dataTable cell-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>City</th>
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
        var table_patient = "#PatientsTable";

        $(document).ready(function() {
            var buttons = ["copy", "csv", "excel", "pdf", "colvis", "pageLength"];
            @can('Create Patient')
                buttons.push({
                    text: "Create New Patient",
                    attr: {
                        title: "Create",
                        id: "create"
                    },
                    className: "btn-primary",
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route('patients.create') }}";
                    }
                });
            @endcan

            var table = $(table_patient).DataTable({
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
                    url: "{{ route('patients.fetch') }}", 
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
                        data: "sex"
                    },
                    {
                        data: "mobileno"
                    },
                    {
                        data: "address"
                    },
                    {
                        data: "city"
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
                    targets: 7,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let buttons = "";

                        @can('View Patient')
                            buttons +=
                                `<a href="/patients/${row.id}" class="btn btn-info viewBtn">View</a>&nbsp;`;
                        @endcan

                        @can('Edit Patient')
                            buttons +=
                                `<a href="/patients/${row.id}/edit" class="btn btn-primary editBtn">Edit</a>&nbsp;`;
                        @endcan

                        @can('Delete Patient')
                            buttons +=
                                `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;
                        @endcan

                        return buttons;
                    }
                }]
            });

            // AJAX DELETE
            $(table_patient + " tbody").on("click", ".deleteBtn", function() {
                let patientId = $(this).data("id");
                let url = `/patients/${patientId}`;
                let csrfToken = "{{ csrf_token() }}";

                if (confirm("Are you sure you want to delete this patient?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken
                        },
                        success: function(response) {
                            alert(response.message || 'Patient deleted successfully.');
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to delete the patient.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
