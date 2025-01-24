@extends('backend.master')
@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Post
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Post Type</th>
                  <th>Author</th>
                  <th>Actions</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($logs as $log)
                <tr>
                  <td>{{$log->title}}</td>
                  <td>{{$log->post_type}}</td>
                  <td><span class="badge bg-label-primary me-1">{{$log->name}}</span></td>
                  <td><span class="badge bg-label-danger me-1">{{$log->action}}</span></td>
                  <td>{{$log->created_at}}</td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-3">
          <form action="" method="post">
          <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                  <input type="hidden" id="remove-val" name="remove-id">
                  <button type="submit" class="btn btn-danger">Confirm</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
