@extends('backend.master')
@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Products
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          @if (Session::has('message'))
            <p class="text-danger text-center mt-3 mb-0">{{ Session::get('message') }}</p>
          @endif
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Thumbnail</th>
                  <th>Qty</th>
                  <th>Regular Price</th>
                  <th>Sale Price</th>
                  <th>Category</th>
                  <th>Size</th>
                  <th>Color</th>
                  <th>Viewer</th>
                  <th>Author</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($products as $product)
                  <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$product->name}}</strong></td>
                    
                    <td>
                      <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                        <img src="/uploads/{{$product->thumbnail}}" alt="Avatar" style="width: 75px;height: 75px; object-fit: contain">
                      </ul>
                    </td>
                    <td><span class="badge bg-label-info me-1">{{$product->qty}}</span></td>
                    <td><span class="badge bg-label-success me-1">$ {{$product->regular_price}}</span></td>
                    <td><span class="badge bg-label-danger me-1">$ {{$product->sale_price}}</span></td>
                    <td><span class="badge bg-label-primary me-1">{{$product->category_name}}</span></td>
                    <td><span class="badge bg-label-secondary me-1">{{$product->size}}</span></td>
                    <td><span class="badge bg-label-secondary me-1">{{$product->color}}</span></td>
                    <td>{{$product->viewer}}</td>
                    <td><span class="badge bg-label-warning me-1">{{ $product->username }}</span></td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="/admin/update-product/{{$product->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                          <a class="dropdown-item remove-post-key"  data-value="{{$product->id}}" data-bs-toggle="modal" data-bs-target="#basicModal" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>Delete</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-3">
          <form action="/admin/remove-product-submit" method="post">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" class="remove-val" name="remove_id">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        
      <hr class="my-5" />
    </div>
    <!-- / Content -->
  </div>
</div>

@endsection
