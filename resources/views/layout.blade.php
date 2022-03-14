<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('/css/filter_multi_select.css')}}" />

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">
 

  <style>
    .error{
      color:red;
    }
    .success{
      color:green;
    }
  </style>



</head>
<body>

@yield('content')

@stack('footer-script')
<script src="{{asset('/js/filter-multi-select-bundle.min.js')}}"></script>

<script>
  $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    
    swal({
        title: 'Are you sure?',
        text: 'Once deleted, you will not be recover!',
        icon: 'warning',
        
        dangerMode: true,
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
            swal("success!", "Successfully deleted!", "success");
            window.location.href = url;
        }
    });
});

</script>
</body>
</html>
