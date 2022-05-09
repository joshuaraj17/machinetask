@extends('layouts.app')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Employee List</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Employee List</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Employee List</h3>
          <a href="{{ url('/') }}/employee/create"><button type="button" class="btn btn-primary" style="position: absolute;
    right: 10px;
    top: 5px;">New Employee</button></a>
        </div>

        @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if($users)
              @foreach($users as $index =>$user)
              <tr>
               <td>{{ $index + 1 }}</td>
                <td>{{ $user->first_name}}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->country_code}} {{ $user->phone_no}}</td>
                <td><a href="{{ route('employee.edit', $user->id) }}"><button type="button" class="btn btn-primary btn-sm">Edit</button></a> 
              <button type="button" data-id="{{ $user->id}}"  class="btn btn-danger btn-sm delete_user">Delete</button>
              
            </td>
              </tr>
              @endforeach
            @endif
            </tbody>
          </table>
        </div>
        


        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
      <!-- /.container-fluid -->
</section>
@endsection
@section('javascript') 
  <script>

    $('.delete_user').click(function()
    {
      var id=$(this).data('id');
      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/employee/destroy",
        data: {  "_token" : "{{ csrf_token() }}",'id' :id},
        success: function(msg) {
          if(msg==1)
          {
            location.reload();
          }          
        },
        error: function() {
          location.reload();
        }
      });
    });

    $(document).ready(function() {
            $("#regForm").validate({
                rules: {
                    email: {
                        email: true,
                    },
                    phone_no: 
                    {
                      number : true,
                      minlength:10,
                      maxlength:10
                    },
                },
            });
        });
        </script>
  @endsection