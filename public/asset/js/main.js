(function($){var $main_window=$(window);$('#preloader').fadeOut();$main_window.on("scroll",function(){if($(this).scrollTop()>250){$(".back-to-top").fadeIn(200);}else{$(".back-to-top").fadeOut(200);}});$(".back-to-top").on("click",function(){$("html, body").animate({scrollTop:0},"slow");return false;});$(window).on('scroll',function(event){var scroll=$(window).scrollTop();if(scroll<10){$(".navbar-area").removeClass("sticky");}else{$(".navbar-area").addClass("sticky");}});$(".navbar-nav a").on('click',function(){$(".navbar-collapse").removeClass("show");});$(".navbar-toggler").on('click',function(){$(this).toggleClass("active");});$(".navbar-nav a").on('click',function(){$(".navbar-toggler").removeClass('active');});var subMenu=$(".sub-menu-bar .navbar-nav .sub-menu");if(subMenu.length){subMenu.parent('li').children('a').append(function(){return '<button class="sub-nav-toggler"> <span></span> </button>';});var subMenuToggler=$(".sub-menu-bar .navbar-nav .sub-nav-toggler");subMenuToggler.on('click',function(){$(this).parent().parent().children(".sub-menu").slideToggle();return false});}
function mainSlider(){var BasicSlider=$('.header-slider-active');BasicSlider.on('init',function(e,slick){var $firstAnimatingElements=$('.single_slider:first-child').find('[data-animation]');doAnimations($firstAnimatingElements);});BasicSlider.on('beforeChange',function(e,slick,currentSlide,nextSlide){var $animatingElements=$('.single_slider[data-slick-index="'+nextSlide+'"]').find('[data-animation]');doAnimations($animatingElements);});BasicSlider.slick({autoplay:false,autoplaySpeed:10000,dots:true,fade:true,arrows:true,prevArrow:'<span class="prev"></span>',nextArrow:'<span class="next"></span>',responsive:[{breakpoint:767,settings:{arrows:false}}]});function doAnimations(elements){var animationEndEvents='webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';elements.each(function(){var $this=$(this);var $animationDelay=$this.data('delay');var $animationType='animated '+$this.data('animation');$this.css({'animation-delay':$animationDelay,'-webkit-animation-delay':$animationDelay});$this.addClass($animationType).one(animationEndEvents,function(){$this.removeClass($animationType);});});}}
mainSlider();var wow=new WOW({mobile:false});wow.init();$('#portfolio').mixItUp();if($(".counter").length>0){$(".counter").counterUp({delay:1,time:800});}
$('.skill-shortcode').appear(function(){$('.progress').each(function(){$('.progress-bar').css('width',function(){return($(this).attr('data-percentage')+'%')});});},{accY:-100});var detailsslider=$("#clients-scroller");detailsslider.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:30,loop:true,responsiveClass:true,responsive:{0:{items:1,},575:{items:2,},991:{items:4,}}});var newproducts=$("#color-client-scroller");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:3,},991:{items:4,}}});var newproducts=$("#testimonial-item");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:10,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:2,},991:{items:2,}}});var newproducts=$("#testimonial-dark");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:2,},991:{items:3,}}});var newproducts=$("#single-testimonial-item");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:1,},991:{items:1,}}});var newproducts=$("#image-carousel");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:3,},991:{items:4,}}});var newproducts=$("#carousel-image-slider");newproducts.owlCarousel({autoplay:false,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,responsiveClass:true,responsive:{0:{items:1,},575:{items:2,},991:{items:1,}}});var newproducts=$("#carousel-about-us");newproducts.owlCarousel({autoplay:true,nav:false,autoplayHoverPause:true,smartSpeed:350,dots:true,margin:5,loop:true,navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],responsiveClass:true,responsive:{0:{items:1,},575:{items:1,},991:{items:1,}}});})(jQuery);