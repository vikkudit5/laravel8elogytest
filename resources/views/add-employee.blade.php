@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
          <h2>Add Employee Details</h2>
          <a href="{{route('post.employee-list')}}" class="btn btn-primary">Employee List</a>
          @include('flash-message')
            <form action="{{route('post.add-employee')}}" method="post" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" class="form-control" required id="name" value="{{old('name')}}" placeholder="Enter Name" name="name">
                    @if ($errors->has('name'))
                    <div class="error">
                        {{ $errors->first('name') }}
                    </div>
                    @endif

                  </div>

                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" required id="email" value="{{old('email')}}" placeholder="Enter email" name="email">
                    <span id="msg"></span>
                    @if ($errors->has('email'))
                    <div class="error">
                        {{ $errors->first('email') }}
                    </div>
                    @endif

                  </div>
                  <div class="form-group">
                    <label for="email">Gender:</label>
                    <select class="form-control" required name="gender">
                        <option>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    @if ($errors->has('gender'))
                    <div class="error">
                        {{ $errors->first('gender') }}
                    </div>
                    @endif
                  </div>

              <div class="form-group">
                <label for="email">Contact Number:</label>
                <input type="number" class="form-control" required  value="{{old('contact_number')}}" id="contact_number" placeholder="Enter Contact" name="contact_number">

                @if ($errors->has('contact_number'))
                <div class="error">
                    {{ $errors->first('contact_number') }}
                </div>
                @endif

              </div>

              <div class="form-group">
                <label for="email">Address:</label>
                <textarea class="form-control" required name="address"></textarea>
                @if ($errors->has('address'))
                <div class="error">
                    {{ $errors->first('address') }}
                </div>
                @endif

              </div>

              <div class="form-group">
                <label for="email">Joining Date:</label>
                <input type="date" class="form-control" required id="joining_date" value="{{old('joining_date')}}" placeholder="Enter Joining date" name="joining_date">
                @if ($errors->has('joining_date'))
                <div class="error">
                    {{ $errors->first('joining_date') }}
                </div>
                @endif
              </div>

              <div class="form-group">
                <label for="email">DOB:</label>
                <input type="date" class="form-control" required id="dob" value="{{old('dob')}}" placeholder="Enter Contact" name="dob">
                @if ($errors->has('dob'))
                <div class="error">
                    {{ $errors->first('dob') }}
                </div>
                @endif
              </div>

              <div class="form-group">
                <label for="email">Hobbies:</label>
                <select class="form-control filter-multi-select" required name="hobbies_id[]" id="hobbies_id" multiple>
                    <option>Select Education</option>
                    @if(!empty($hobbies))
                    @foreach($hobbies as $hobbi)
                        <option value="{{$hobbi->hobbies_name}}">{{$hobbi->hobbies_name}}</option>
                      @endforeach
                      @endif
                </select>
                @if ($errors->has('hobbies_id'))
                <div class="error">
                    {{ $errors->first('hobbies_id') }}
                </div>
                @endif
              </div>


              <div class="form-group">
                <label for="email">Experience:</label>
                <input type="text" class="form-control" required id="experience" value="{{old('experience')}}" placeholder="Enter experience" name="experience">
                @if ($errors->has('experience'))
                <div class="error">
                    {{ $errors->first('experience') }}
                </div>
                @endif
              </div>

              <div class="form-group">
                <label for="email">Department:</label>
                <select class="form-control" required name="departmentId">
                  <option>Select Department</option>
                  @if(!empty($departments))
                  @foreach($departments as $department)
                      <option value="{{$department->id}}">{{$department->department_name}}</option>
                    @endforeach
                    @endif
                   
                </select>
                @if ($errors->has('departmentId'))
                <div class="error">
                    {{ $errors->first('departmentId') }}
                </div>
                @endif
              </div>

              <div class="form-group">
                <label for="email">Education:</label>
                <select class="form-control" required name="education_id">
                    <option>Select Education</option>
                    @if(!empty($educations))
                    @foreach($educations as $education)
                        <option value="{{$education->id}}">{{$education->education_name}}</option>
                      @endforeach
                      @endif
                </select>
                @if ($errors->has('education_id'))
                <div class="error">
                    {{ $errors->first('education_id') }}
                </div>
                @endif
              </div>

            

              

              <div class="form-group">
                <label for="email">Photo:</label>
                <input type="file" required  class="form-control" name="image">
                @if ($errors->has('image'))
                <div class="error">
                    {{ $errors->first('image') }}
                </div>
                @endif
              </div>


             
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
    </div>
   
@endsection

@push('footer-script')
<script>

$(document).on("keyup",'#email',function(){
    var email = $(this).val();

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

    $.ajax({
      type:"post",
      data:{
        "email":email
      },
      url:"{{route('post.check-email')}}",
      dataType:"json",
      success:function(result)
      {
        
          $('#msg').html(result.msg);
      }
      
    });
})
// for ajax email validation
  $(function () {
    // Apply the plugin 
  
    $('#hobbies_id').on("optionselected", function(e) {
      createNotification("selected", e.detail.label);
    });
    $('#hobbies_id').on("optiondeselected", function(e) {
      createNotification("deselected", e.detail.label);
    });
   

  
  });
</script>
@endpush