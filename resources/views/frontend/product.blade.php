@extends('frontend.layout')
@section('title')
    Product Detail
@endsection
@section('content')
<main class="product-detail">

    <section class="review">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="thumbnail">
                        <img src="/uploads/{{ $productDetail[0]->thumbnail }}" alt="">
                    </div>
                </div>
                <div class="col-7">
                    <div class="detail">
                        <div class="price-list">
                                @php
                                    if($productDetail[0]->sale_price > 0){
                                        $stateRegular = 'd-none';
                                        $stateSale = 'd-block';
                                    }else{
                                        $stateRegular = 'd-block';
                                        $stateSale = 'd-none';
                                    }
                                @endphp
                                <div class="regular-price {{$stateSale}}" ><strike> US {{$productDetail[0]->regular_price}}</strike></div>
                                <div class="sale-price {{$stateSale}}" >US {{$productDetail[0]->sale_price}}</div>
                                <div class="price {{$stateRegular}}" >US {{$productDetail[0]->regular_price}}</div>
                        </div>
                        <h5 class="title">{{$productDetail[0]->name}}</h5>
                        <div class="group-size">
                            <span class="title">Color Available</span>
                            <div class="group">{{$productDetail[0]->color}}</div>
                        </div>
                        <div class="group-size">
                            <span class="title">Size Available</span>
                            <div class="group">{{$productDetail[0]->size}}</div>
                        </div>
                        <div class="group-size">
                            <span class="title">Description</span>
                            <div class="description">{{$productDetail[0]->description}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title">
                        RELATED PRODUCTS
                    </h3>
                </div>
            </div>
            <div class="row">
                @foreach ($releteProduct as $releteProductVal)
                    @if ($releteProductVal->qty> 0)
                        @php
                            $status = 'Promotion';
                        @endphp
                    @else
                        @php
                            $status = 'Out Of Stock';
                        @endphp
                    @endif

                    @if ($releteProductVal->sale_price > 0)
                        @php
                            $promoStatus = 'd-block';
                            $regularPriceStatus = 'd-none';
                            $salePriceStatus    = 'd-block';
                        @endphp
                    @else
                        @php
                            $promoStatus = 'd-none';
                            $regularPriceStatus = 'd-block';
                            $salePriceStatus    = 'd-none';
                        @endphp
                    @endif
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                <div class="status {{$promoStatus}}" >
                                    {{$status}}
                                </div>
                                <a href="/product/{{$releteProductVal->slug}}">
                                    <img src="/uploads/{{ $releteProductVal->thumbnail }}" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    <div class="price {{$regularPriceStatus}}">US {{$releteProductVal->regular_price}}</div>
                                    <div class="regular-price {{ $salePriceStatus }}"><strike> US {{ $releteProductVal->regular_price }}</strike></div>
                                    <div class="sale-price {{ $salePriceStatus }}">US {{ $releteProductVal->sale_price }}</div>
                                </div>
                                <h5 class="title">{{ $releteProductVal->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
                
            </div>
        </div>
    </section>

</main>
@endsection