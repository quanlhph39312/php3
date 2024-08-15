 @extends('client.layouts.master')
 @section('title')
     Chi tiết sản phẩm
 @endsection
 @section('css')
     <style>
         .thumbnail-item {
             flex: 0 0 auto;
             padding-right: 5px;
         }

         .thumbnail {
             cursor: pointer;
             max-width: 100px;
             max-height: 100px;
         }

         .thumbnail.active {
             border: 2px solid green;
         }
     </style>
 @endsection
 @section('content')
     <!-- Shop Detail Start -->
     <div class="container-fluid py-5">
         <div class="row px-xl-5">
             <div class="col-lg-5 pb-5">
                 <div id="product-carousel" class="carousel slide" data-ride="carousel">
                     <!-- Main image display -->
                     <div class="carousel-inner border">
                         <div class="carousel-item active">
                             <img class="w-100 h-100" src="{{ $product->image_thumbnail }}" alt="Image">
                         </div>
                     </div>
                     <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                         <i class="fa fa-2x fa-angle-left text-dark"></i>
                     </a>
                     <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                         <i class="fa fa-2x fa-angle-right text-dark"></i>
                     </a>
                 </div>
             </div>

             <div class="col-lg-7 pb-5">
                 <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
                 <div class="d-flex mb-3">
                     <small class="pt-1">{{ $categoryName }}</small>
                     <small class="pt-1">View: {{ $product->view }}</small>
                 </div>
                 <div class="d-flex">
                     @if ($product->price_sale)
                         <h3 class="font-weight-semi-bold mb-4">${{ $product->price_sale }}</h3>
                         <h3 class="text-muted ml-2"><del>${{ $product->price_regular }}</del></h6>
                         @else
                             <h3 class="font-weight-semi-bold mb-4">${{ $product->price_regular }}</h6>
                     @endif
                 </div>
                 <div class="d-flex mb-3">
                     <p class="text-dark font-weight-medium mb-0 mr-3"> Description: </p>
                     <span>{{ $product->description }}</span>
                 </div>
                 <div class="d-flex mb-3">
                     <p class="text-dark font-weight-medium mb-0 mr-3"> Material: </p>
                     <span>{{ $product->material }}</span>
                 </div>

                 <div class="d-flex align-items-center mb-4 pt-2">
                     <div class="input-group quantity mr-3" style="width: 130px;">
                         <div class="input-group-btn">
                             <button class="btn btn-primary btn-minus">
                                 <i class="fa fa-minus"></i>
                             </button>
                         </div>
                         <input type="text" class="form-control bg-secondary text-center" value="1">
                         <div class="input-group-btn">
                             <button class="btn btn-primary btn-plus">
                                 <i class="fa fa-plus"></i>
                             </button>
                         </div>
                     </div>
                     <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                 </div>

                 <div class="d-flex pt-2">
                     <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                     <div class="d-inline-flex">
                         <a class="text-dark px-2" href="">
                             <i class="fab fa-facebook-f"></i>
                         </a>
                         <a class="text-dark px-2" href="">
                             <i class="fab fa-twitter"></i>
                         </a>
                         <a class="text-dark px-2" href="">
                             <i class="fab fa-linkedin-in"></i>
                         </a>
                         <a class="text-dark px-2" href="">
                             <i class="fab fa-pinterest"></i>
                         </a>
                     </div>
                 </div>
             </div>
         </div>

         <div class="row px-xl-5">
             <div class="col">
                 <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                     <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Content</a>
                     {{-- <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a> --}}
                     <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                 </div>
                 <div class="tab-content">
                     <div class="tab-pane fade show active" id="tab-pane-1">
                         <h4 class="mb-3">Product Content</h4>
                         <p>{{ $product->content }}</p>
                     </div>
                     {{-- <div class="tab-pane fade" id="tab-pane-2">
                         <h4 class="mb-3">Additional Information</h4>
                         <p></p>
                         <div class="row">
                             <div class="col-md-6">
                                 <ul class="list-group list-group-flush">
                                     <li class="list-group-item px-0">
                                         Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                     </li>
                                 </ul>
                             </div>
                             <div class="col-md-6">
                                 <ul class="list-group list-group-flush">
                                     <li class="list-group-item px-0">
                                         Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                     </li>
                                     <li class="list-group-item px-0">
                                         Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div> --}}
                     <div class="tab-pane fade" id="tab-pane-3">
                         <div class="row">
                             <div class="col-md-6">
                                 <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                                 <div class="media mb-4">
                                     <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                         style="width: 45px;">
                                     <div class="media-body">
                                         <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                         <div class="text-primary mb-2">
                                             <i class="fas fa-star"></i>
                                             <i class="fas fa-star"></i>
                                             <i class="fas fa-star"></i>
                                             <i class="fas fa-star-half-alt"></i>
                                             <i class="far fa-star"></i>
                                         </div>
                                         <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et
                                             no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <h4 class="mb-4">Leave a review</h4>
                                 <small>Your email address will not be published. Required fields are marked *</small>
                                 <div class="d-flex my-3">
                                     <p class="mb-0 mr-2">Your Rating * :</p>
                                     <div class="text-primary">
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                         <i class="far fa-star"></i>
                                     </div>
                                 </div>
                                 <form>
                                     <div class="form-group">
                                         <label for="message">Your Review *</label>
                                         <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                     </div>
                                     <div class="form-group">
                                         <label for="name">Your Name *</label>
                                         <input type="text" class="form-control" id="name">
                                     </div>
                                     <div class="form-group">
                                         <label for="email">Your Email *</label>
                                         <input type="email" class="form-control" id="email">
                                     </div>
                                     <div class="form-group mb-0">
                                         <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Shop Detail End -->


     <!-- Products Start -->
     <div class="container-fluid py-5">
         <div class="text-center mb-4">
             <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
         </div>
         <div class="row px-xl-5">
             <div class="col">
                 <div class="owl-carousel related-carousel">
                     @foreach ($ProductView as $product)
                         <div class="card product-item border-0">
                             <div
                                 class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                 <img class="img-fluid w-100" src="{{ $product->image_thumbnail }}" alt="">
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
                                 <a href="" class="btn btn-sm text-dark p-0"><i
                                         class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                             </div>
                         </div>
                     @endforeach
                 </div>
             </div>
         </div>
     </div>
     <!-- Products End -->
 @endsection

 @section('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             const thumbnails = document.querySelectorAll('.thumbnail');
             thumbnails.forEach(thumbnail => {
                 thumbnail.addEventListener('click', function() {
                     thumbnails.forEach(t => t.classList.remove('active'));
                     this.classList.add('active');
                 });
             });
         });
     </script>
 @endsection
