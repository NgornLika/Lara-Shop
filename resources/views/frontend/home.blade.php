@extends('frontend.layout')
@section('title')
    Home
@endsection
@section('content')
    <main class="home">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEW PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($newProducts as $newProductsVal)
                         @if ($newProductsVal->qty > 0)
                            @php
                                $status = 'Promotion';
                            @endphp
                        @else
                            @php
                                $status = 'Out Of Stock';
                            @endphp
                        @endif

                        @if ($newProductsVal->sale_price > 0)
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
                                    <a href="/product/{{$newProductsVal->slug}}">
                                        <img src="/uploads/{{ $newProductsVal->thumbnail }}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                        <div class="price {{$regularPriceStatus}}">US {{$newProductsVal->regular_price}}</div>
                                        <div class="regular-price {{ $salePriceStatus }}"><strike> US {{ $newProductsVal->regular_price }}</strike></div>
                                        <div class="sale-price {{ $salePriceStatus }}">US {{ $newProductsVal->sale_price }}</div>
                                    </div>
                                    <h5 class="title">{{ $newProductsVal->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            PROMOTION PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($promotion as $Newpromotion)
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                    @if ($newProductsVal->qty> 0)
                                        <div class="status">Promotion</div>
                                    @endif
                                    
                                    <a href="/product/{{$Newpromotion->slug}}">
                                        <img src="/uploads/{{ $Newpromotion->thumbnail }}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                        @if ($newProductsVal->sale_price == 0)
                                            <div class="price d-none">US {{$Newpromotion->regular_price}}</div>
                                        @else
                                            <div class="regular-price "><strike> US {{$Newpromotion->regular_price}}</strike></div>
                                            <div class="sale-price" >US {{ $Newpromotion->sale_price }}</div> 
                                        @endif
                                    </div>
                                    <h5 class="title">{{ $Newpromotion->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>  

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            POPULAR PRODUCTS
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($popularProduct as $popularProducts)
                         @if ($popularProducts->qty > 0)
                            @php
                                $status = 'Promotion';
                            @endphp
                        @else
                            @php
                                $status = 'Out Of Stock';
                            @endphp
                        @endif

                        @if ($popularProducts->sale_price > 0)
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
                                    <a href="/product/{{$popularProducts->slug}}">
                                        <img src="/uploads/{{ $popularProducts->thumbnail }}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                        <div class="price {{$regularPriceStatus}}">US {{$popularProducts->regular_price}}</div>
                                        <div class="regular-price {{ $salePriceStatus }}"><strike> US {{ $newProductsVal->regular_price }}</strike></div>
                                        <div class="sale-price {{ $salePriceStatus }}">US {{ $popularProducts->sale_price }}</div>
                                    </div>
                                    <h5 class="title">{{ $popularProducts->name }}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>  
@endsection
