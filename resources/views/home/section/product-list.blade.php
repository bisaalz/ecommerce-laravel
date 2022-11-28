<div class="row isotope-grid">

    @if(isset($products) && $products->count() > 0)

        @foreach($products as $prod_info)
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $prod_info->cat_id }}">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <a href="{{ route('product-detail', $prod_info->slug) }}">
                            <img src="{{ asset('uploads/product/'.$prod_info->image) }}" alt="IMG-PRODUCT">
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="{{ route('product-detail', $prod_info->slug) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                {{ $prod_info->title }}
                            </a>

                            <span class="stext-105 cl3">
                                @php
                                    $price = $prod_info->price;
                                    if($prod_info->discount > 0){
                                        $price = $price - (($price * $prod_info->discount)/100);
                                    }
                                @endphp
                                NPR. {{ number_format($price) }}
                                @if($prod_info->discount > 0)
                                    <del style="color: #ff0000">
                                       NPR. {{ $prod_info->price }}
                                    </del>
                                    {{ $prod_info->discount }} %
                                @endif
                            </span>

                            <a href="javascript:0;" onclick="addToCart(this)" data-product_id="{{ $prod_info->id }}" data-quantity="1">
                                Add to Cart
                            </a>
                        </div>


                    </div>
                </div>
            </div>

        @endforeach

    @else
        Product Not found
    @endif
</div>
{{ $products->links() }}
