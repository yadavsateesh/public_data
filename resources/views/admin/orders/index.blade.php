
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Order Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <h2>Admin Order Management</h2>

    <a href="{{ route('admin.notifications.index') }}"
       class="btn btn-dark mb-3">

        Notifications

        @if(auth()->user()->unreadNotifications()->count() > 0)
            <span class="badge bg-danger">
                {{ auth()->user()->unreadNotifications()->count() }}
            </span>
        @endif

    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($orders as $order)

                <tr>

                    <td>{{ $order->id }}</td>

                    <td>{{ $order->user->name }}</td>

                    <td>{{ $order->product->name }}</td>

                    <td>{{ $order->quantity }}</td>

                    <td>
                        ₹{{ number_format((float) $order->total_amount, 2) }}
                    </td>

                    <td>
                        {{ ucfirst($order->status) }}
                    </td>

                    <td>

                        <form
                            action="{{ route('admin.orders.status', $order) }}"
                            method="POST">

                            @csrf
                            @method('PATCH')

                            <select name="status"
                                    class="form-select mb-2"
                                    required>

                                <option value="pending"
                                    @selected($order->status === 'pending')>
                                    Pending
                                </option>

                                <option value="processing"
                                    @selected($order->status === 'processing')>
                                    Processing
                                </option>

                                <option value="delivered"
                                    @selected($order->status === 'delivered')>
                                    Delivered
                                </option>

                            </select>

                            <button type="submit"
                                    class="btn btn-primary btn-sm">
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No orders found.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

    {{ $orders->links() }}

</div>

</body>
</html>
@endsection