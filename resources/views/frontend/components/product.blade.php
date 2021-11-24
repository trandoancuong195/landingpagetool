@if((new \Jenssegers\Agent\Agent())->isMobile())
    <div class="row row-customer row-landing-page-v1 product-theme-tet">
        @foreach($cp['data'] as $product)
            @if(!empty($product))
                <div class="col-xs-6 parent-product">
                    <div class="item product-item">
                        <div class="products-img">
                            <a href="{{$product['url']}}" title="{{$product['name']}}" target="_top">
                                <img data-src="{{str_replace("images/detailed","images/thumbnails/200/200/detailed",$product['image'])}}" alt="{{$product['name']}}"
                                     class="img-fluid mx-auto d-block lazy">
                            </a>

                        </div>
                        <h3 class="products-name">
                            <a href="{{$product['url']}}" target="_top"
                               title="{{$product['name']}}">{{$product['name']}}</a>
                        </h3>
                        @if(!empty($product['promotion_price']) && $product['promotion_price'] > 0)
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                                <span class="line">
                                <span class="old-price">{{number_format($product['promotion_price'],0,'.',',')}} ₫</span>
                                    <span class="discount">-{{$product['promotion_price']-($product['price'])}}%</span>
                                    <span class="discount">-{{round((($product['promotion_price'] - $product['price'])/$product['promotion_price'])*100)}}%</span>
                                </span>
                            </div>
                        @else
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                            </div>
                        @endif
                    </div>

                </div>
            @endif
        @endforeach
    </div>
    @else
    @if($cp['product_in_rows'] == 4)
        <div class="row row-customer row-landing-page-v1 product-theme-tet">
            @foreach($cp['data'] as $product)
                @if(!empty($product))
                <div class="col-md-3 parent-product">
                    <div class="item product-item">
                        <div class="products-img">
                            <a href="{{$product['url']}}" title="{{$product['name']}}" target="_top">
                                <img data-src="{{str_replace("images/detailed","images/thumbnails/200/200/detailed",$product['image'])}}" alt="{{$product['name']}}"
                                     class="img-fluid mx-auto d-block lazy">
                            </a>

                        </div>
                        <h3 class="products-name">
                            <a href="{{$product['url']}}" target="_top"
                               title="{{$product['name']}}">{{$product['name']}}</a>
                        </h3>
                        @if(!empty($product['promotion_price']) && $product['promotion_price'] > 0)
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                                <span class="line">
                                <span class="old-price">{{number_format($product['promotion_price'],0,'.',',')}} ₫</span>
                                    <span class="discount">-{{$product['promotion_price']-($product['price'])}}%</span>
                                    <span class="discount">-{{round((($product['promotion_price'] - $product['price'])/$product['promotion_price'])*100)}}%</span>
                                </span>
                            </div>
                        @else
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                            </div>
                        @endif
                    </div>

                </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="product-ul bg-white row-landing-page-v1 product-theme-tet">
            @foreach($cp['data'] as $product)
                @if(!empty($product))
                <div class="product-li">
                    <div class="item product-item">
                        <div class="products-img">
                            <a href="{{$product['url']}}" title="{{$product['name']}}" target="_top">
                                <img data-src="{{str_replace("images/detailed","images/thumbnails/200/200/detailed",$product['image'])}}" alt="{{$product['name']}}"
                                     class="img-fluid mx-auto d-block lazy">
                            </a>

                        </div>
                        <h3 class="products-name">
                            <a href="{{$product['url']}}" target="_top"
                               title="{{$product['name']}}">{{$product['name']}}</a>
                        </h3>
                        @if(!empty($product['promotion_price']) && $product['promotion_price'] > 0)
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                                <span class="line">
                                <span class="old-price">{{number_format($product['promotion_price'],0,'.',',')}} ₫</span>
                                    <span class="discount">-{{$product['promotion_price']-($product['price'])}}%</span>
                                    <span class="discount">-{{round((($product['promotion_price'] - $product['price'])/$product['promotion_price'])*100)}}%</span>
                                </span>
                            </div>
                        @else
                            <div class="products-price">
                                <span class="price">{{number_format($product['price'],0,'.',',')}} ₫</span>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endif
@endif
