@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add New User</h2>
        <div id="response-msg" class="mt-2"></div>

        <form action="{{ route('admin.user.store') }}" id="ajax-form">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                <div id="name-error" class="field-error text-danger small"></div>
                @error('name')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                <div id="email-error" class="field-error text-danger small"></div>
                @error('email')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
                <div id="password-error" class="field-error text-danger small"></div>
                @error('password')
                    <span style="color: red; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <div id="password_confirmation-error" class="field-error text-danger small"></div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Save User</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function() {
            // Setup CSRF header for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#ajax-form').submit(function(e) {
                e.preventDefault();

                $('.field-error').html('');
                $('#response-msg').html('');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.user.store') }}",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#response-msg').html('<p style="color:green;">' + response.success +
                            '</p>');
                        $('#ajax-form')[0].reset();
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON && xhr.responseJSON.errors ? xhr
                            .responseJSON.errors : null;

                        if (errors) {
                            $.each(errors, function(field, messages) {
                                let selector = '#' + field + '-error';
                                let html = '';

                                $.each(messages, function(index, message) {
                                    html += '<div>' + message + '</div>';
                                });

                                $(selector).html(html);
                            });
                        }

                        if (!errors) {
                            $('#response-msg').html(
                                '<p style="color:red;">Submission failed. Please check inputs.</p>'
                                );
                        }
                    }
                });
            });
        });
    </script>
@endsection
