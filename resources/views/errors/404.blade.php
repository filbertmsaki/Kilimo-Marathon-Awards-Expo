@php($title = 'Page Not Found')
@php($code = '404')
<x-web.layout.error-layout :pageName="$title" :code="$code">
    <section class="error-page h-p100">
		<div class="container h-p100">
		  <div class="row h-p100 align-items-center justify-content-center text-center">
			  <div class="col-lg-7 col-md-10 col-12">
				  <div>
					  <img src="{{ asset('images/auth-bg/404.png') }}" class="max-w-650 w-p100" alt="" />
					  <h1>{{ $title }} !</h1>
					  <h3>looks like, page doesn't exist</h3>
					  <div class="my-30"><a href="{{ route('web.index') }}" class="btn btn-primary">Back to Home</a></div>


				  </div>
			  </div>
		  </div>
		</div>
	</section>

</x-web.layout.error-layout>
