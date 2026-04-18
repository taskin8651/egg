@extends('custom.master')
@section('content')

<!--================ Breadcumb =================-->
<div class="breadcumb-area d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcumb-content">
                    <h4>Cart</h4>
                    <ul>
                        <li>
                            <a href="/">
                                <i class="bi bi-house-door-fill"></i> Home
                            </a>
                        </li>
                        <li><i class="bi bi-slash-lg"></i> Cart</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--================ CART =================-->
<div class="cart-section pt-80 pb-80">
    <div class="container">

        @php
            $cart = session('cart', []);
            $total = 0;
        @endphp

        @if(count($cart) > 0)

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cart as $id => $item)

                        @php
                            $itemTotal = $item['price'] * $item['qty'];
                            $total += $itemTotal;
                        @endphp

                        <tr>
                            <td>
                                <img src="{{ $item['image'] ?: asset('assets/images/default.png') }}"
                                     width="70">
                            </td>

                            <td>{{ $item['name'] }}</td>

                            <td>₹{{ number_format($item['price'], 2) }}</td>

                            <td>{{ $item['qty'] }}</td>

                            <td>₹{{ number_format($itemTotal, 2) }}</td>

                            <td>
                                <a href="{{ route('cart.remove', $id) }}"
                                   class="btn btn-danger btn-sm">
                                    Remove
                                </a>
                            </td>
                        </tr>

                    @endforeach
                </tbody>

            </table>
        </div>

        <!-- TOTAL -->
        <div class="row mt-4">
            <div class="col-lg-6"></div>

            <div class="col-lg-6">
                <div class="border p-4 rounded bg-light">

                    <h5>Cart Total</h5>
                    <hr>

                    <h4>₹{{ number_format($total, 2) }}</h4>

                    <div class="mt-3">
                        <a href="#" class="btn btn-success w-100">
                            Proceed to Checkout
                        </a>
                    </div>

                </div>
            </div>
        </div>

        @else

        <!-- EMPTY CART -->
        <div class="text-center py-5">
            <h4>Your cart is empty 😢</h4>
            <p>Add some products to continue shopping</p>

            <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                Go to Shop
            </a>
        </div>

        @endif

    </div>
</div>

@endsection