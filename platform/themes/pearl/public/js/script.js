(function($) {
  function headerStyle() {
    if ($(".main-header").length) {
      var windowpos = $(window).scrollTop();
      var siteHeader = $(".main-header");
      var scrollLink = $(".scroll-to-top");
      var sticky_header = $(
        ".main-header .sticky-header, .main-header .mobile-sticky-header"
      );
      if (windowpos > 500) {
        siteHeader.addClass("fixed-header");
        sticky_header.addClass("animated slideInDown");
        scrollLink.fadeIn(300);
      } else {
        siteHeader.removeClass("fixed-header");
        sticky_header.removeClass("animated slideInDown");
        scrollLink.fadeOut(300);
      }
    }
  }
  headerStyle();

  	// Open modal in AJAX callback
	$('#appointment-btn').on('click', function(event) {
	  event.preventDefault();
	  this.blur();
	  $.get(this.href, function(html) {
	    $(html).appendTo('body').modal({
			clickClose: false,
			fadeDuration: 300,
			fadeDelay: 0.15,
	    });
	  });
	});


  //sticky-header Hide Show
  if ($(".sticky-header").length) {
    var stickyMenuContent = $(".main-header .main-box .nav-outer").html();
    $(".sticky-header .main-box").append(stickyMenuContent);
    //Sidebar Cart
    $(".main-header .cart-btn, .mobile-header .cart-btn").on(
      "click",
      function() {
        $("body").addClass("sidebar-cart-active");
      }
    );

    //Menu Toggle Btn
    $(".main-header .cart-back-drop, .main-header .close-cart").on(
      "click",
      function() {
        $("body").removeClass("sidebar-cart-active");
      }
    );
  }

  // Mobile Navigation
  if ($("#nav-mobile").length) {
    jQuery(function($) {
      var $navbar = $("#navbar");
      var $mobileNav = $("#nav-mobile");

      $navbar
        .clone()
        .removeClass("navbar")
        .appendTo($mobileNav);

      $mobileNav.mmenu({
        counters: false,
        navbars: [
          {
            position: "top",
            content: ["prev", "title"],
          },
          {
            position: "bottom",
            content: [
              "<a class='fab fa-facebook-f' href='#'></a>",
              "<a class='fab fa-twitter' href='#'></a>",
              "<a class='fab fa-linkedin-in' href='#'></a>",
              "<a class='fab fa-instagram' href='#'></a>",
            ],
          },
        ],
        extensions: ["theme-dark"],
        offCanvas: {
          position: "left",
          zposition: "front",
        },
      });
    });
  }

  //Banner Carousel
  if ($(".banner-carousel").length) {
    $(".banner-carousel").owlCarousel({
      animateOut: "fadeOut",
      animateIn: "fadeIn",
      loop: true,
      margin: 0,
      nav: true,
      smartSpeed: 500,
      autoHeight: true,
      autoplay: true,
      autoplayTimeout: 5000,
      navText: [
        '<span class="fa fa-angle-left"></span>',
        '<span class="fa fa-angle-right"></span>',
      ],
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 1,
        },
        1024: {
          items: 1,
        },
      },
    });
  }

	//Testimonial Carousel Two
	if ($('.testimonial-carousel-two').length) {
		$('.testimonial-carousel-two').owlCarousel({
			loop:true,
			margin:0,
			nav:true,
			smartSpeed: 700,
			autoplay: true,
			navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1024:{
					items:2
				},
			}
		});    		
	}



  //Services Carousel
	if ($('.services-carousel').length) {
		$('.services-carousel').owlCarousel({
			loop:true,
			margin:0,
			nav:true,
			smartSpeed: 700,
			autoplayTimeout:10000,
			autoplay: false,
			navText: [ '', '' ],
			responsive:{
				0:{
					items:1
				},
				768:{
					items:2
				},
				1024:{
					items:3
				}
			}
		});    		
	}
  // Elements Animation
  if ($(".wow").length) {
    var wow = new WOW({
      boxClass: "wow", // animated element css class (default is wow)
      animateClass: "animated", // animation css class (default is animated)
      offset: 0, // distance to the element when triggering the animation (default is 0)
      mobile: false, // trigger animations on mobile devices (default is true)
      live: true, // act on asynchronously loaded content (default is true)
    });
    wow.init();
  }

  //Fact Counter + Text Count
  if ($(".count-box").length) {
    $(".count-box").appear(
      function() {
        var $t = $(this),
          n = $t.find(".count-text").attr("data-stop"),
          r = parseInt($t.find(".count-text").attr("data-speed"), 10);

        if (!$t.hasClass("counted")) {
          $t.addClass("counted");
          $({
            countNum: $t.find(".count-text").text(),
          }).animate(
            {
              countNum: n,
            },
            {
              duration: r,
              easing: "linear",
              step: function() {
                $t.find(".count-text").text(Math.floor(this.countNum));
              },
              complete: function() {
                $t.find(".count-text").text(this.countNum);
              },
            }
          );
        }
      },
      { accY: 0 }
    );
  }

  // Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 1500);
	
		});
	}

  $(window).on('scroll', function() {
		headerStyle();
	});

  /* ==========================================================================
   When document is Scrollig, do
   ========================================================================== */

  $(window).on("scroll", function() {
    headerStyle();
  });
})(window.jQuery);


$(document).ready(function () {
  var showError = function (message) {
    $('.appointment-error-message').html(message).show();
  }
  var showSuccess = function (message) {
    $('.appointment-success-message').html(message).show();
  }

  var handleError = function (data) {
    if (typeof (data.errors) !== 'undefined' && data.errors.length) {
        handleValidationError(data.errors);
    } else {
        if (typeof (data.responseJSON) !== 'undefined') {
            if (typeof (data.responseJSON.errors) !== 'undefined') {
                if (data.status === 422) {
                    handleValidationError(data.responseJSON.errors);
                }
            } else if (typeof (data.responseJSON.message) !== 'undefined') {
                showError(data.responseJSON.message);
            } else {
                $.each(data.responseJSON, (index, el) => {
                    $.each(el, (key, item) => {
                        showError(item);
                    });
                });
            }
        } else {
            showError(data.statusText);
        }
    }
}

  var handleValidationError = function (errors) {
    let message = '';
    $.each(errors, (index, item) => {
      if (message !== '') {
        message += '<br>';
      }
      message += item;
    });
    showError(message);
  }

  $(document).on('click', '.appointment-form button[type=submit]', function (event) {
    event.preventDefault();
    event.stopPropagation();

    $(this).addClass('button-loading');
    $('.appointment-success-message').html('').hide();
    $('.appointment-error-message').html('').hide();

    $.ajax({
        type: 'POST',
        cache: false,
        url: $(this).closest('form').prop('action'),
        data: new FormData($(this).closest('form')[0]),
        contentType: false,
        processData: false,
        success: res => {
            if (!res.error) {
                $(this).closest('form').find('input[type=text]').val('');
                $(this).closest('form').find('input[type=email]').val('');
                $(this).closest('form').find('input[type=tel]').val('');
                $(this).closest('form').find('input[type=date]').val('');
                $(this).closest('form').find('select').val('default');
                $(this).closest('form').find('textarea').val('');
                showSuccess(res.message);
            } else {
                showError(res.message);
            }

            $(this).removeClass('button-loading');

            if (typeof refreshRecaptcha !== 'undefined') {
                refreshRecaptcha();
            }
        },
        error: res => {
            if (typeof refreshRecaptcha !== 'undefined') {
                refreshRecaptcha();
            }
            $(this).removeClass('button-loading');
            handleError(res);
        }
    });
});

});