@extends('client.layouts.master')
@section('title')
    Shop
@endsection
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4" type="button" data-toggle="collapse" data-target="#catalogueList"
                        aria-expanded="true" aria-controls="catalogueList">
                        Filter by Category
                    </h5>
                    <div id="catalogueList" class="collapse show">
                        <ul class="list-group">
                            @foreach ($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('shop', ['category_id' => $category->id, 'min_price' => $min_price, 'max_price' => $max_price]) }}"
                                        class="text-decoration-none">{{ $category->name }}</a>
                                    <span class="badge border font-weight-normal">{{ $category->total_product }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form action="{{ route('shop') }}" method="GET">
                        <input type="hidden" name="category_id" value="{{ $category_id }}">
                        <div class="form-group mb-3">
                            <label for="min_price">Min Price:</label>
                            <input type="number" id="min_price" name="min_price" class="form-control" min="0"
                                step="0.01" value="{{ $min_price }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="max_price">Max Price:</label>
                            <input type="number" id="max_price" name="max_price" class="form-control" min="0"
                                step="0.01" value="{{ $max_price }}">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-transparent text-primary">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item"
                                        href="{{ route('shop', ['category_id' => $category_id, 'min_price' => $min_price, 'max_price' => $max_price, 'minPrice' => true]) }}">MinPrice</a>
                                    <a class="dropdown-item"
                                        href="{{ route('shop', ['category_id' => $category_id, 'min_price' => $min_price, 'max_price' => $max_price, 'maxPrice' => true]) }}">maxPrice</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ $product->image_thumbnail }}" alt="">
                                    {{-- <span class="badge badge-danger position-absolute"
                                        style="top: 5px; right: 10px;">new</span> --}}
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>${{ $product->price_sale }}</h6>
                                        <h6 class="text-muted ml-2"><del>${{ $product->price_regular }}</del></h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="{{ route('detail', $product->id) }}" class="btn btn-sm text-dark p-0"><i
                                            class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="" class="btn btn-sm text-dark p-0 addToCart"
                                        data-id="{{ $product->id }}"><i
                                            class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 pb-1">
                        {{ $products->appends(['category_id' => $category_id, 'min_price' => $min_price, 'max_price' => $max_price, 'maxPrice' => $maxPrice, 'minPrice' => $minPrice])->links('pagination.custom-pagination') }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection


