@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Add Post
    @endsection
    @section('page-main-title')
        Update Product
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-product-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-danger text-center mb-0 mt-3">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="hidden" name="id" value="{{$product->id}}">  

                                    <label for="formFile" class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{$product->name}}" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Quantity</label>
                                    <input class="form-control" type="text" name="qty" value="{{$product->qty}}" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Regular Price</label>
                                    <input class="form-control" type="number" name="regular_price" value="{{$product->regular_price}}"/>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Sale Price</label>
                                    <input class="form-control" type="number" name="sale_price" value="{{$product->sale_price}}"/>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Available Size</label>
                                    <select name="size[]" class="form-control size-color" multiple="multiple" > 
                                        @foreach ($attrSize as $sizeVal)
                                            @if (in_array($sizeVal->value,$size))
                                                <option selected value="{{$sizeVal->value}}">{{$sizeVal->value}}</option>
                                            @else
                                                <option value="{{$sizeVal->value}}">{{$sizeVal->value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Available Color</label>
                                    <select name="color[]" class="form-control size-color" multiple="multiple">
                                        @foreach ($attrColor as $colorVal)
                                            @if (in_array($colorVal->value,$color))
                                                <option selected value="{{$colorVal->value}}">{{$colorVal->value}}</option>
                                            @else
                                                <option value="{{$colorVal->value}}">{{$colorVal->value}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label" >Category</label>
                                    <select name="category" class="form-control" value="" >
                                        @foreach ($category as $cate)
                                        @if ($cate->id==$product->category)
                                            <option selected value="{{$cate->id}}">{{$cate->name}}</option>
                                        @else
                                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <img src="/uploads/{{ $product->thumbnail }}" width="100px"><br>
                                    <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels.</label>
                                    <input class="form-control" type="hidden" name="old_thumbnail" value="{{$product->thumbnail}}"/>
                                    <input class="form-control" type="file" name="thumbnail" />
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="formFile" class="form-label text-danger">Description</label>
                                    <textarea name="description" class="form-control"  cols="30" rows="10">{{$product->description}}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Edit Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
