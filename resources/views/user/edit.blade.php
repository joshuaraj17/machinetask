

@extends('layouts.app')
@section('content')
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Employee Add</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Employee View</a></li>
               <li class="breadcrumb-item active">Employee Add</li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <!-- Form Element sizes -->
            <!-- general form elements disabled -->
            <div class="card card-warning">
               <!-- <div class="card-header">
                  <h3 class="card-title">General Elements</h3>
                  </div> -->
               @if ($errors->any())
               <div class="alert alert-danger">
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               {!! Form::open(['method' => 'POST', 'route' => ['employee.update',$user->id] , 'class' => 'user-add-form dropzone','id' => 'regForm','enctype'=>'multipart/form-data']) !!}
               <!-- /.card-header -->
               <div class="col-sm-6">
                  <h1>Education Details</h1>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                           <label>First Name</label>
                           <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" placeholder="Enter First Name ...">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Last Name</label>
                           <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" placeholder="Enter Last Name ...">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                           <label>Email</label>
                           <input type="text" class="form-control" name="email"  value="{{ $user->email }}" placeholder="Enter Email">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Linkedin Url</label>
                           <input type="text" class="form-control" name="linkedin_url" value="{{ $user->linkedin_url }}" placeholder="Linkedin Url">
                        </div>
                     </div>

                     <div class="col-sm-3">
                        <div class="form-group">
                           <label>Country Code</label>
                           <input type="number" class="form-control" name="country_code" value="{{$user->country_code}}" placeholder="Enter country code">
                        </div>
                     </div>

                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Phone Number</label>
                           <input type="number" class="form-control" name="phone_no" value="{{ $user->phone_no }}" placeholder="Enter Phone No">
                        </div>
                     </div>



                  </div>
               </div>
               <div class="col-sm-6">
                  <h1>Education Details</h1>
               </div>
               <div class="card-body">
               <div id="education_details">
               @if($educations)
               @foreach($educations as $index =>$education)
               <input type="hidden" class="form-control" name="education_id[]"  value="{{$education->id}}">

                  <div class="row">
                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                           <label>Course Name</label>
                           <input type="text" class="form-control" name="course_name[]" placeholder="Enter Course name" value="{{$education->course_name}}">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Institution Name</label>
                           <input type="text" class="form-control" name="institution_name[]" value="{{$education->institution_name}}" placeholder="Enter Institution Name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                           <label>Year</label>
                           <input type="number" class="form-control" name="year[]" value="{{$education->year}}" placeholder="Enter year">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Percentage</label>
                           <input type="number" class="form-control" name="percentage[]" value="{{$education->percentage}}" placeholder="Enter Percentage">
                        </div>
                     </div>
                  </div>
                  @endforeach
            @endif

</div>

               </div>
               <div class="col-sm-6">
                  <h1>Experience Details</h1>
               </div>
               <div class="card-body">
               <div id="experience_details">
               @if($experiences)
               @foreach($experiences as $index =>$experience)
               <input type="hidden" class="form-control" name="experience_id[]"  value="{{$experience->id}}">

                  <div class="row">
                     <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                           <label>Company Name</label>
                           <input type="text" class="form-control" name="company_name[]" value="{{$experience->company_name}}" placeholder="Enter Company name">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Job position</label>
                           <input type="text" class="form-control" name="job_position[]" value="{{$experience->company_name}}" placeholder="Enter Job position">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Started year</label>
                           <input type="text" class="form-control" name="started_year[]" value="{{$experience->started_year}}" placeholder="Enter Started Year">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Start Month</label>
                           <input type="text" class="form-control" name="started_month[]" value="{{$experience->started_month}}" placeholder="Enter End Year">
                        </div>
                     </div>

                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                        <label>End Year</label>
                           <input type="number" class="form-control" name="end_year[]" value="{{$experience->end_year}}" placeholder="Enter End Year">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                        <label>End Month</label>
                           <input type="number" class="form-control" name="end_month[]"  value="{{$experience->end_month}}" placeholder="Enter End Month">

                        </div>
                     </div>

                  </div>

                  @endforeach
            @endif

</div>

                  <!-- <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label>Resume</label>
                           <input type="file" accept="image/*" name="resume" class="dropify form-control-file" id="resume" aria-describedby="fileHelp">
                        </div>
                     </div>
                  </div> -->
               </div>
               <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
               {{ Form::close() }}
            </div>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('javascript') 
<script>
   $(document).ready(function() {
               $("#regForm").validate({
                   rules: {
                       first_name: "required",
                       last_name: "required",
                       email: {
                           required: true,
                           email: true,
                       },
                       phone_no: 
                       {
                         required: true,
                         number : true,
                         minlength:10,
                         maxlength:10
                       },
                    
                   },
                   messages: {
                   first_name: {
                     required: "Name is required",
                   },
                   last_name: {
                     required: "Name is required",
                   },
                   email: {
                     required: "Email is required",
                     email: "Email must be a valid email address",
                   },
                   mobile_no: {
                     required: "Mobile number is required",
                     minlength: "Mobile number must be of 10 digits"
                   },
                   
                 }
               });
           });
   
     
</script>
<script>
  $("#add_education").click(function (e) {
$("#education_details").append('<div class="row"> <div class="col-sm-6"> <div class="form-group"><label>Course Name</label> <input type="text" name="course_name[]" placeholder="Enter Course name" class="form-control"> </div> </div> <div class="col-sm-6"> <div class="form-group"> <label>Institution Name</label> <input type="text" class="form-control" name="institution_name[]" placeholder="Enter Institution Name"> </div></div> </div>  <div class="row"> <div class="col-sm-6">  <div class="form-group"> <label>Year</label> <input type="text" class="form-control" name="year[]" placeholder="Enter year"> </div> </div> <div class="col-sm-6"> <div class="form-group"> <label>Percentage</label> <input type="text" class="form-control" name="percentage[]" placeholder="Enter Percentage">  </div></div> </div>'
); 
// $("#remove_education").show();

});

$("#add_experience").click(function (e) {
   $("#experience_details").append('<div class="row"> <div class="col-sm-6"> <div class="form-group"><label>Company Name</label> <input type="text" name="company_name[]" placeholder="Enter Company name" class="form-control"> </div> </div> <div class="col-sm-6"> <div class="form-group"> <label>Job Position</label> <input type="text" class="form-control" name="job_position[]" placeholder="Enter Job POsition"> </div></div> </div>  <div class="row"> <div class="col-sm-6">  <div class="form-group"> <label>Started Year</label> <input type="number" class="form-control" name="started_year[]" placeholder="Started year"> </div> </div> <div class="col-sm-6"> <div class="form-group"> <label>Start month</label> <input type="number" class="form-control" name="started_month[]" placeholder="Started Month">  </div></div> </div>   <div class="row"> <div class="col-sm-6">  <div class="form-group"> <label>End Year</label> <input type="number" class="form-control" name="end_year[]" placeholder="End year"> </div> </div> <div class="col-sm-6"> <div class="form-group"> <label>End Month</label> <input type="number" class="form-control" name="end_month[]" placeholder="End Month">  </div></div> </div>'
); 
});

</script>
@endsection