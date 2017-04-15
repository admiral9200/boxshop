{{-- col beging   --}}
<?php
if (isset($productSuggestion)) {
    $auxProduct=isset($product) ? $product : '';
    $product=$productSuggestion;
}
 ?>
<div class="col-xs-12 col-sm-6 col-md-3 clearfix product-overflow">

    {{-- product box begin --}}
    
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
                <div class="product-img-container" style="background: url({{ $product['features']['images'][0] }});">
            @else
                </div>
                <div class="product-noimg-container" style="background: url({{assset('img/no-image.jpg')}});">
            @endif
                </div>    
        </div>
        {{-- actions begin --}}
        <div class="product-actions actions">
            <div class="row">
                {{-- add to cart (only products not free)  --}}
                <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4 wrapper add_to_card" ng-click="submit('#add-{{ $product['id'] }}')">
                    <div class = "glyphicon glyphicon-shopping-cart option " >
                        @if ($product['type'] != 'freeproduct')
                            {!! Form::open(['method' => 'put', 'route' => ['orders.add_to_order','cart', $product['id']], 'id' => 'add-'.$product['id'] ]) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                    <span id="card_text">Сагс</span>
                </div>
                {{-- view --}}
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4 wrapper quick_view " ng-click = "goTo('{{ route('products.show',[$product['id']]) }}')">
                    <div class="glyphicon glyphicon-eye-open option"></div>
                </div>
            </div>
        </div>
        {{-- actions end --}}
        <h6 class="product-name">
            <a href = "{{ route('products.show',[$product['id']]) }}">
                {{ $product['name'] }}
            </a>
        </h6>

        <div class="product-price">
            <span>{{ $product['price'] }} ₮</span>
        </div>
    </div>
    
    {{-- product box end --}}


</div>
{{-- col end   --}}
<?php
if (isset($productSuggestion)) {
    $product=$auxProduct;
}
 ?>