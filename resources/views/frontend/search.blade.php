@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')
<main class="shop">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title">
                        Product Result
                    </h3>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                     @if ($product->qty > 0)
                        @php
                            $status = 'Promotion';
                        @endphp
                    @else
                        @php
                            $status = 'Out Of Stock';
                        @endphp
                    @endif

                    @if ($product->sale_price > 0)
                        @php
                            $promoStatus ='d-block';
                            $regularPriceStatus = 'd-none';
                            $salePriceStatus    = 'd-block';
                        @endphp
                    @else
                        @php
                            $promoStatus ='d-none';
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
                                <a href="/product/{{$product->slug}}">
                                    <img src="/uploads/{{ $product->thumbnail }}" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    <div class="price {{$regularPriceStatus}}">US {{$product->regular_price}}</div>
                                    <div class="regular-price {{ $salePriceStatus }}"><strike> US {{ $product->regular_price }}</strike></div>
                                    <div class="sale-price {{ $salePriceStatus }}">US {{ $product->sale_price }}</div>
                                </div>
                                <h5 class="title">{{ $product->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
                
            </div>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="main-title">
                        News Result
                    </h3>
                </div>
            </div>
            <div class="row">
                @foreach ($news as $new)
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                <a href="">
                                    <img src="/uploads/{{$new->thumbnail}}" width="350" height="330" style="object-fit: cover" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <h5 class="title">{{$new->title}}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
                
            </div>
        </div>
    </section>

</main>
@endsection