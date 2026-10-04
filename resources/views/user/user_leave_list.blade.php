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
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leave.list') }}",
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

                ]
            });

        });
    </script>

    </html>
@endsection
