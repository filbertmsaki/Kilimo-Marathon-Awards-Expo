@php($title = 'Service Unavailable')
@php($code = '503')
<x-web.layout.error-layout :pageName="$title" :code="$code">
    <section class="error-page h-p100">
		<div class="container h-p100">
		  <div class="row h-p100 align-items-center justify-content-center text-center">
			  <div class="col-lg-7 col-md-10 col-12">
				  <div>
					  <img src="{{ asset('images/error/404.png') }}" class="max-w-650 w-p100" alt="" />
					  <h1>{{ $title }} !</h1>
					  <h3>Opps! Service Unavailable</h3>
				  </div>
			  </div>
		  </div>
		</div>
	</section>
</x-web.layout.error-layout>