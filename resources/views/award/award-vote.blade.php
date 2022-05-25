<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
@if (config('app.icon') !== null)
<link rel="icon" type="image/png" href="{{ asset('image').'/'.config('app.icon') }}"/>
@else
<link rel="icon" type="image/png" href="{{ asset('img/fem-creation-icon.png') }}"/>
@endif
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
      Awards Vote | Kilimo Marathon, Awards & EXPO
    </title>

    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="asset/css/slick.css">
    
    <link rel="stylesheet" media="screen" href="asset/css/all.min.css">
    <link rel="stylesheet" media="screen" href="asset/css/simple-line-icons.css">
    
    <link rel="stylesheet" type="text/css" href="asset/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="asset/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="asset/css/animate.css">
    <link rel="stylesheet" type="text/css" href="asset/css/normalize.css">
    
    <link rel="stylesheet" type="text/css" href="asset/css/main.css">
    
    <link rel="stylesheet" type="text/css" href="asset/css/responsive.css">
    
    <link rel="stylesheet" type="text/css" href="asset/css/green.css" media="screen">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="css/adminlte.min.css">
<style>
     




    
</style>
</head>
<body>

 @include('layouts.front_header')

<section id="team" class="" style="background-color: #006837;">
  @if($award_nominees != null)
  <div class="container">
  <h1 class="section-title wow fadeInUpQuick animated" data-wow-delay=".5s" style="color:#fff;visibility: visible;-webkit-animation-delay: .5s; -moz-animation-delay: .5s; animation-delay: .5s;">
  <p style="color:#ffffff;"> Kilimo Awards Nominees</p>
    
  </h1>
  
            <!-- =========================================================== -->
            <div class="row">
            @foreach ( $award_category as $category )
            @if(count($category->award_nominee))
            <div class="col-md-3 col-sm-6 col-6">
              <div class="info-box bg-success">
  
                <div class="info-box-content">
                  <span class="" style="text-align: center;">{{ $category->name }}</span>
                  <span class="info-box-number">{{ count($category->award_nominee) }} Nominees</span>
  
                  <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                  </div>
                  <a href="#" class="small-box-footer" style="color:#fff;">
                   Vote Now <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            @endif
           
            @endforeach
             
            
            </div>
            <!-- /.row -->
  </div>
  @endif
  </section>




@include('layouts.front_footer')
    
<script src="asset/js/jquery-min.js"></script>
<script src="asset/js/popper.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<script src="asset/js/jquery.mixitup.js"></script>
<script src="asset/js/smoothscroll.js"></script>
<script src="asset/js/wow.js"></script>
<script src="asset/js/owl.carousel.min.js"></script>
<script src="asset/js/waypoints.min.js"></script>
<script src="asset/js/jquery.counterup.min.js"></script>
<script src="asset/js/jquery.appear.js"></script>
<script src="asset/js/form-validator.min.js"></script>
<script src="asset/js/contact-form-script.min.js"></script>
<script src="asset/js/slick.min.js"></script>
<script src="asset/js/main.js"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
  

  $(document).ready(function () {
   
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });


  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        //Save vote into database  

        $(".btn-save").click(function(e){
              e.preventDefault();

              var _token = $("input[name='_token']").val();
              var nominee_id = $("input[name='nominee_id']").val();
              var category_id = $("input[name='category_id']").val();
              $.ajax({
                url: "{{ route('awards_vote_store') }}",
                type:'POST',
                data: { 
                "_token": "{{ csrf_token() }}",
                nominee_id:nominee_id,
                category_id:category_id,
                },
                success: function(data) {
                  document.getElementById("voteForm").reset(); 
              
                  Toast.fire({
                      icon: 'success',
                      background: '#218838',
                      title:"<span style='color:#fff;'>" + data['success'] + "</span>",
                    })
                  },
                  error: function(data, status, error){
                        $.each(data.responseJSON.errors, function (key, item){
                          $(document).Toasts('create', {
                                  class: 'bg-danger',
                                  title:item,
                          })
                        });
                      }
              });
        }); 
    
  });
</script>
    

</body></html>