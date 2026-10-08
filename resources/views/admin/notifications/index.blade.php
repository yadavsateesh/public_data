@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Notifications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <h2>Order Notifications</h2>

    <a href="{{ route('admin.orders.index') }}"
       class="btn btn-primary mb-3">
        Back to Orders
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @forelse($notifications as $notification)

        <div class="card mb-3">

            <div class="card-body">

                <h5>
                    New Order #{{ $notification->data['order_id'] }}
                </h5>

                <p>
                    Customer:
                    {{ $notification->data['customer_name'] }}
                </p>

                <p>
                    Product:
                    {{ $notification->data['product_name'] }}
                </p>

                <p>
                    Quantity:
                    {{ $notification->data['quantity'] }}
                </p>

                <p>
                    {{ $notification->data['message'] }}
                </p>

                <p>
                    {{ $notification->created_at->diffForHumans() }}
                </p>

                @if($notification->read_at === null)

                    <form
                        action="{{ route('admin.notifications.read', $notification->id) }}"
                        method="POST">

                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn btn-success">
                            Mark as Read
                        </button>

                    </form>

                @else

                    <span class="badge bg-secondary">
                        Read
                    </span>

                @endif

            </div>

        </div>

    @empty

        <p>No notifications available.</p>

    @endforelse

    {{ $notifications->links() }}

</div>

</body>
</html>
@endsection