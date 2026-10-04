@extends('layouts.app')

@section('content')
    <div class="container py-5">
        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif

        <div class="row justify-content-center text-center">
            <div class="col-lg-8 py-5">
                <h1 class="display-5 fw-bold">Welcome to the Admin Dashboard</h1>
                <p class="lead text-muted mb-0">Manage users and leave requests using the navigation above.</p>
            </div>
        </div>
    </div>
@endsection
