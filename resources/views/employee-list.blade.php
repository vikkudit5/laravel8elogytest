@extends('layout')

@section('content')
    

<div class="container">
  
    <a href="{{route('post.add-employee')}}" class="btn btn-primary" style="margin:5px;">Add Employee</a>
    <div class="row">
   
    <div class="col-md-8">
    <form>
      <div class="form-group">
      <input type="text" class="form-control search" placeholder="Search By Employee Name or Email....." name="search" >
      </div>
    </form>
</div>

<div class="col-md-4">
  <form>
    <div class="form-group">
      <select class="form-control" id="sort">
        <option>Sort</option>
        <option value="desc">Descending</option>
        <option value="asc">Asceding</option>
      </select>
    </div>
  </form>
</div>




      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th>Si</th>
              <th>Photo</th>
              <th>Employee Name</th>
              <th>Email</th>
              <th>Contact Number</th>
              <th>Gender</th>
              <th>Department</th>
              <th>DOB</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tableData">
           
           
          </tbody>
        </table>
      </div>
    </div>
    
   </div>

   @endsection

   @push('footer-script')
      
   <script>
// for sorting
$(document).on("change",'#sort',function(){
    
    var sort = $(this).val();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
      type:"get",
      data:{
        "sort":sort,
      
      },
      url:"{{route('post.employee-record')}}",
      dataType:"html",
      success:function(result)
      {
        $('#tableData').html(result);
        console.log(result);
      }
    })
});

// for fetch all employee record
     function getEmployeeData()
     {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var sort = 'asc';
        $.ajax({
            type:"get",
            data:{"sort":sort,},
            url:"{{route('post.employee-record')}}",
            dataType:"html",
            success:function(result)
            {
              $('#tableData').html(result);
              // console.log(result);
            }
          })
     }

     getEmployeeData();

     // for search
     $(document).on("keyup",'.search',function(){
    
        var search = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          type:"post",
          data:{
            "search":search,
          
          },
          url:"{{route('post.employee-search')}}",
          dataType:"html",
          success:function(result)
          {
            $('#tableData').html(result);
            // console.log(result);
          }
        })
});





   </script>
   @endpush