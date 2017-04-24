{{-- col beging   --}}
<?php
if (isset($productSuggestion)) {
    $auxProduct=isset($product) ? $product : '';
    $product=$productSuggestion;
}
 ?>
<div class="col-xs-12 col-md-6 clearfix product-overflow">

    {{-- product box begin --}}
    <a href = "{{ route('products.show',[$product['id']]) }}">
        <div class="product-box clearfix product-overflow" ng-controller = "ProductBox">

        <div class="product-reviews @if (!$product['rate_val']) hide @endif">
            {!! \Utility::thousandSuffix($product['rate_val']) !!}
            <small>
                {{ trans_choice('store.review', $product['rate_val']) }}
            </small>
        </div>

        @if ($product['type'] == 'freeproduct')
            <div class="free-products-box-sign"><span>{{ trans('globals.free') }}</span></div>
        @endif

        <div class="product-img-box" ng-click = "goTo('{{ route('products.show',[$product['id']]) }}')">       
            @if (isset($product["features"]["images"][0]))
                <div class="product-img-container" style="background: url({{ $product["features"]["images"][0] }}');></div>
            @else
                <div class="product-noimg-container" style="background: url({{assset('img/no-image.jpg')}});"></div>
            @endif
        </div>
        {{-- actions begin --}}
        <div class="product-actions actions">

            {{-- add to cart (only products not free)  --}}
            <div class="col-md-4 col-xs-4 wrapper add_to_card" ng-click="submit('#add-{{ $product['id'] }}')">
                <div class = "glyphicon glyphicon-shopping-cart option " >
                    @if ($product['type'] != 'freeproduct')
                        {!! Form::open(['method' => 'put', 'route' => ['orders.add_to_order','cart', $product['id']], 'id' => 'add-'.$product['id'] ]) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
                <span id="card_text">Сагс</span>
            </div>

            {{-- wish list (only products not free) --}}
            <div class="col-md-4 col-sm-4 col-xs-4 wrapper add_to_heart"  ng-click = "goTo('{{ route('orders.add_to_order',['wishlist', $product[($product['type']=='freeproduct')?'parent_id':'id']]) }}')">
                <div class="glyphicon glyphicon-heart option"></div>
            </div>

            {{-- view --}}
            <div class="col-md-4 col-xs-4 wrapper quick_view " ng-click = "goTo('{{ route('products.show',[$product['id']]) }}')">
                <div class="glyphicon glyphicon-eye-open option"></div>
            </div>
        </div>
        {{-- actions end --}}
        <h6 class="product-name">
            
                {{ $product['name'] }}
           
        </h6>

        <div class="product-price">
            <!-- {!! \Utility::showPrice($product['price']) !!} -->
            {{ $product['price'] }} ₮
        </div>

        </div>
    </a>
    {{-- product box end --}}


</div>
{{-- col end   --}}
<?php
if (isset($productSuggestion)) {
    $product=$auxProduct;
}
 ?>