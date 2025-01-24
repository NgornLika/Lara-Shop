@extends('frontend.layout')
@section('title')
    Shop
@endsection
@section('content')
<main class="shop">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        @foreach ($products as $ProductsVal)
                            @if ($ProductsVal->qty > 02)
                                @php
                                    $status = 'Promotion';
                                @endphp
                            @else
                                @php
                                    $status = 'Out Of Stock';
                                @endphp
                            @endif

                            @if ($ProductsVal->sale_price > 0)
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
                            <div class="col-4">
                                <figure>
                                    <div class="thumbnail">
                                        <div class="status {{$promoStatus}}" >
                                            {{$status}}
                                        </div>
                                        <a href="/product/{{$ProductsVal->slug}}">
                                            <img src="/uploads/{{ $ProductsVal->thumbnail }}" alt="">
                                        </a>
                                    </div>
                                    <div class="detail">
                                        <div class="price-list">
                                            <div class="price {{$regularPriceStatus}}">US {{$ProductsVal->regular_price}}</div>
                                            <div class="regular-price {{ $salePriceStatus }}"><strike> US {{ $ProductsVal->regular_price }}</strike></div>
                                            <div class="sale-price {{ $salePriceStatus }}">US {{ $ProductsVal->sale_price }}</div>
                                        </div>
                                        <h5 class="title">{{ $ProductsVal->name }}</h5>
                                    </div>
                                </figure>
                            </div>
                        @endforeach

                        {{-- pagination product --}}
                        <div class="col-12">
                            <ul class="pagination">
                                @for ($i = 1; $i <= $totalPage; $i++)
                                    @if (request()->get('cate'))
                                        <li>
                                            <a href="/shop?cate={{ request()->get('cate') }}&page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @elseif (request()->get('price'))
                                        <li>
                                            <a href="/shop?price={{ request()->get('price') }}&page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @elseif (request()->get('promotion'))
                                        <li>
                                            <a href="/shop?promotion=true&page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="/shop?page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-3 filter">
                    <h4 class="title">Category</h4>
                    <ul>
                        <li>
                            <a href="/shop">ALL</a>
                        </li>
                        @foreach ($allCategory as $cate)
                            <li>
                                <a href="/shop?cate={{ $cate->slug }}">{{ $cate->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    
                    <h4 class="title mt-4">Price</h4>
                    <div class="block-price mt-4">
                        <a href="/shop?price=max">High</a>
                        <a href="/shop?price=min">Low</a>
                    </div>

                    <h4 class="title mt-4">Promotion</h4>
                    <div class="block-price mt-4">
                        <a href="/shop?promotion=true">Promotion Product</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>
@endsection