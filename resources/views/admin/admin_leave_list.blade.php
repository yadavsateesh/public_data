@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
        <title>Leave List</title>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.12.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://cdn.datatables.net/1.12.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.4/js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/3.1.3/css/dataTables.dataTables.min.css" />
        <script src="https://cdn.datatables.net/3.1.3/js/dataTables.min.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="card mt-5">
                <h3 class="card-header p-3">Leave List</h3>

                <div class="card-body">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>leave_type</th>
                                <th>start_date</th>
                                <th>end_date</th>
                                <th>status</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>

    <!-- Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="record_id">
                    <div class="form-group">
                        <label>Select Status</label>
                        <select id="new_status" name="status" class="form-control">
                            <option value="pending">pending</option>
                            <option value="rejected">rejected</option>
                            <option value="approved">approved</option>

                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let table;

        $(function() {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.leave.list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'leave_type',
                        name: 'leave_type'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'status_btn',
                        name: 'status_btn',
                        orderable: false,
                        searchable: false
                    }


                ]
            });

        });

        // Open popup on status button click
        $('.data-table').on('click', '.status-btn', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');

            // Pass ID to modal input
            $('#record_id').val(id);
            $('#new_status').val(id);

            // Show Bootstrap Modal
            $('#statusModal').modal('show');
        });

        // Handle AJAX status update on modal save button click
        $('#saveStatusBtn').click(function() {
            var id = $('#record_id').val();
            var status = $('#new_status').val();
            alert(status);

            $.ajax({
                // url: "/admin/update-status" + id,
                url: "{{ route('status.update') }}",

                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    alert(1);
                    $('#statusModal').modal('hide');
                    table.ajax.reload(null, false);
                }
            });
        });
    </script>



    </html>
@endsection
