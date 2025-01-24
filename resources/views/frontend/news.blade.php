@extends('frontend.layout')
@section('title')
    News Blog
@endsection
@section('content')
    <main class="shop news-blog">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEWS BLOG
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($news as $new)
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                    <a href="/article/{{$new->slug}}">
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