@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Add Post
    @endsection
    @section('page-main-title')
        Edit Attribute
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/admin/update-attribute-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                       
                        <div class="card-body">

                            <div class="row">
                                
                                <div class="mb-3 col-6">
                                    <input type="hidden" name="id" value="{{$attribute->id}}">  
                                    <label for="formFile" class="form-label">Type</label>
                                    <select name="type" class="form-control" value="{{$attribute->type}}">
                                        <option value="size">Size</option>
                                        <option value="color">Color</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Value</label>
                                    <input class="form-control" type="text" name="value" value="{{$attribute->value}}" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
