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
                <div class="section_title text-center style_six ">
                    <h1 class="pb-13">NEW IN STORE</h1>
                    <p>Latest products from our store</p>
                </div>
            </div>
        </div>

        <div class="product_cart">
            <div class="row">
<div class="product_tab_btn">

    <!-- ALL -->
    <button 
        class="{{ !request('type') ? 'active' : '' }}" 
        onclick="filterProduct('')">
        All <i class="flaticon flaticon-right-arrow"></i>
    </button>

    <!-- HEN -->
    <button 
        class="{{ request('type') == 'hen' ? 'active' : '' }}" 
        onclick="filterProduct('hen')">
        Hens <i class="flaticon flaticon-right-arrow"></i>
    </button>

    <!-- EGG -->
    <button 
        class="{{ request('type') == 'egg' ? 'active' : '' }}" 
        onclick="filterProduct('egg')">
        Egg <i class="flaticon flaticon-right-arrow"></i>
    </button>

</div>
<script>
function filterProduct(type) {
    let url = new URL(window.location.href);

    if(type === '') {
        url.searchParams.delete('type'); // 🔥 ALL ke liye remove
    } else {
        url.searchParams.set('type', type);
    }

    window.location.href = url.toString();
}
</script>

@forelse($products as $product)
    <div class="col-lg-3 col-md-6">
        <div class="product_single_item">

            <!-- Image -->
            <div class="product_thumb">
                <a href="{{ route('shop.show', $product->slug) }}">
                    <img 
                        src="{{ $product->getFirstMediaUrl('product_images') ?: asset('assets/images/default.png') }}" 
                        alt="{{ $product->name }}"
                    >
                </a>

                <div class="buddy_btn_home_three product_btn">
                    <a href="#" data-id="{{ $product->id }}">
                        Add to cart 
                        <i class="flaticon flaticon-right-arrow"></i>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="product_content">

                <h3>
                    <a href="{{ route('shop.show', $product->slug) }}">
                        {{ $product->name }}
                    </a>
                </h3>

                <p>
                    ₹{{ number_format($product->price, 2) }}
                </p>

            </div>

        </div>
    </div>

@empty
    <div class="col-12 text-center">
        <p>No products available</p>
    </div>
@endforelse


            </div>
        </div>

    </div>
</section>
<!--==================================================-->
<!-- End buddy Product Area-->
<!--==================================================-->



@endsection