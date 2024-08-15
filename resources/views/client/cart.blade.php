@extends('client.layouts.master')
@section('title')
    Giỏ hàng
@endsection
@section('content')
    <style>
        img {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }
    </style>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($carts as $productId => $product)
                            <tr data-id="{{ $productId }}">
                                <td class="align-middle">
                                    {{ $product['name'] }}
                                </td>
                                @php
                                    $url = $product['image'];
                                    if (!\Str::contains($url, 'http')) {
                                        $url = Storage::url($url);
                                    }
                                @endphp
                                <td class="align-middle cart-img"><img src="{{ $url }}" alt=""></td>
                                <td class="align-middle">${{ $product['price'] }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" data-id="{{ $productId }}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary text-center quantity-input"
                                            value="{{ $product['quantity'] }}" readonly>
                                        <div class="input-group-btn">
                                            <a class="btn btn-sm btn-primary btn-plus" data-id="{{ $productId }}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total-price">${{ $product['quantity'] * $product['price'] }}</td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-primary btn-remove" data-id="{{ $productId }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Giỏ hàng trống</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">$160</h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.btn-minus, .btn-plus, .btn-remove').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                console.log(button);
                var productId = button.data('id');
                var action = button.hasClass('btn-minus') ? 'decrease' : (button.hasClass('btn-plus') ?
                    'increase' : 'remove');
                $.ajax({
                    url: action === 'remove' ? '{{ route('cart.remove') }}' :
                        '{{ route('cart.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: productId,
                        action: action
                    },
                    success: function(response) {
                        if (response.error) {
                            toastr.error(response.error);
                        } else {
                            if (action === 'remove') {
                                button.closest('tr').remove();
                                $('#cart-count').text(response.cart_count);
                            } else {
                                var quantityInput = button.closest('.quantity').find(
                                    '.quantity-input');
                                var newQuantity = response.new_quantity;
                                var newTotalPrice = response.new_total_price;

                                quantityInput.val(newQuantity);
                                button.closest('tr').find('.total-price').text('$' +
                                    newTotalPrice);
                            }
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Đã xảy ra lỗi. Vui lòng thử lại.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        toastr.error(errorMessage);
                    }
                });
            });
        });
    </script>
@endsection
