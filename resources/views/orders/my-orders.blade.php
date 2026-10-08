@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <h2>My Orders</h2>

    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">
        Shop Products
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>

        <tbody>

            @forelse($orders as $order)

                <tr>

                    <td>{{ $order->id }}</td>

                    <td>{{ $order->product->name }}</td>

                    <td>{{ $order->quantity }}</td>

                    <td>
                        ₹{{ number_format((float) $order->total_amount, 2) }}
                    </td>

                    <td>

                        @if($order->status === 'pending')
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        @elseif($order->status === 'processing')
                            <span class="badge bg-primary">
                                Processing
                            </span>
                        @elseif($order->status === 'delivered')
                            <span class="badge bg-success">
                                Delivered
                            </span>
                        @endif

                    </td>

                    <td>{{ $order->created_at->format('d-m-Y h:i A') }}</td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="text-center">
                        You have not placed any orders yet.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>
</html>

@endsection