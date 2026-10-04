@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Apply for Leave</title>
        <!-- Optional: Bootstrap for quick styling -->
        {{-- <link href="https://jsdelivr.net" rel="stylesheet"> --}}
    </head>

    <body class="bg-light">

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Leave Application Form</h4>
                        </div>
                        <div class="card-body">

                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('leave.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="leave_type" class="form-label @error('leave_type') is-invalid @enderror">Leave Type</label>
                                    <select name="leave_type">
                                        <option devalue="" disabled selected>Select leave type</option>
                                        <option value="sick">Sick Leave</option>
                                        <option value="vacation">Vacation</option>
                                        <option value="vacation">Persnol leave</option>
                                    </select>
                                    @error('leave_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <!-- From Date -->
                                <div class="mb-3">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input type="date" name="from_date" id="from_date"
                                        class="form-control @error('from_date') is-invalid @enderror"
                                        value="{{ old('from_date') }}">
                                    @error('from_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- End Date (To Date) -->
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Reason (Optional but recommended) -->
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason for Leave</label>
                                    <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Submit Application</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
