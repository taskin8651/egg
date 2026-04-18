@extends('custom.master')
@section('content')


<!--==================================================-->
<!-- Start buddy Breadcumb Area -->
<!--==================================================-->
<div class="breadcumb-area d-flex align-items-center">
	<div class="container">
		<div class="row d-flex align-items-center">
			<div class="col-lg-12">
				<div class="breadcumb-content text-center">
					<div class="breadcumb-title">
						<h4>Shop</h4>
					</div>
					<ul>
						<li><a href=""><i class="bi bi-house-door-fill"></i> Home </a></li>
						<li class="rotates"><i class="bi bi-slash-lg"></i>Shop</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--==================================================-->
<!-- End buddy Breadcumb Area -->
<!--==================================================-->


<!--==================================================-->
<!-- Start buddy Product Area-->
<!--==================================================-->
<section class="product_area style_two">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="section_title text-center style_six pb-75">
                    <h1 class="pb-13">NEW IN STORE</h1>
                    <p>Latest products from our store</p>
                </div>
            </div>
        </div>

        <div class="product_cart">
            <div class="row">

                @foreach($products as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product_single_item">

                        <div class="product_thumb">
                            <img src="{{ $product->getFirstMediaUrl('product_images') ?: asset('assets/images/default.png') }}" alt="{{ $product->name }}">

                            <div class="buddy_btn_home_three product_btn">
                                <a href="#">Add to cart <i class="flaticon flaticon-right-arrow"></i></a>
                            </div>
                        </div>

                        <div class="product_content">
                            <div class="product_star">
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star active"></i>
                                <i class="fa fa-star"></i>
                            </div>

                            <h3>{{ $product->name }}</h3>
                            <p>₹{{ $product->price }}</p>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</section>
<!--==================================================-->
<!-- End buddy Product Area-->
<!--==================================================-->



@endsection