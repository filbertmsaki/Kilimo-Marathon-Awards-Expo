 @if ($isPagetitle)
     <!---page Title --->
     <section class="bg-img pt-150 pb-20" data-overlay="7"
         style="background-image: url({{ asset('images/bg.jpg') }});">
         <div class="container">
             <div class="row">
                 <div class="col-12">
                     <div class="text-center">
                         <h2 class="page-title text-white">{{ $pageTitle }}</h2>
                         <ol class="breadcrumb bg-transparent justify-content-center">
                             <li class="breadcrumb-item"><a href="#" class="text-white-50"><i
                                         class="mdi mdi-home-outline"></i></a></li>
                             <li class="breadcrumb-item text-white active" aria-current="page">{{ $pageTitle }}</li>
                         </ol>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endif
