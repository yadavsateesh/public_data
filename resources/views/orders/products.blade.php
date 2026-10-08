@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <h2>Products</h2>

    <a href="{{ route('orders.my') }}" class="btn btn-primary mb-3">
        My Orders
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

    <div class="row">

        @forelse($products as $product)

            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $product->name }}
                        </h5>

                        <p>{{ $product->description }}</p>

                        <p>
                            Price: ₹{{ number_format((float) $product->price, 2) }}
                        </p>

                        <p>
                            Available Stock: {{ $product->stock }}
                        </p>

                        <form action="{{ route('orders.store') }}" method="POST">

                            @csrf

                            <input type="hidden"
                                   name="product_id"
                                   value="{{ $product->id }}">

                            <label class="form-label">Quantity</label>

                            <input type="number"
                                   name="quantity"
                                   value="1"
                                   min="1"
                                   max="100"
                                   class="form-control mb-3"
                                   required>

                            <button type="submit" class="btn btn-success">
                                Place Order
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <p>No products available.</p>

        @endforelse

    </div>

</div>

</body>
</html>
@endsection