
jQuery(document).ready(function( $ ) {
	// $(window).on('load', function () {
        $(".loader").delay(400).fadeOut("slow");
        new WOW().init();
    // });
 
$(function () {

    (function mobileBtn() {
        var mobileBtnOpen = $('.open-nav-btn'),
            mobileBtnClose = $('.close-nav-btn'),
            mobileMenu = $('.header-nav');

        mobileBtnOpen.on('click', function(){
            mobileMenu.addClass('show');
            $('.overlay').addClass('show');
            $('body').addClass('no-scroll');
            $('html').addClass('no-scroll');
        });
        mobileBtnClose.on('click', function(){
            mobileMenu.removeClass('show');
            $('.overlay').removeClass('show');
            $('body').removeClass('no-scroll');
            $('html').removeClass('no-scroll');
        });
    }());

    $('.open-sidebar').on('click', function (e) {
        $('.sidebar--sticky').toggleClass('show');
        e.preventDefault();
    });

    $('.promo-close').on('click', function (e) {
        $('.promo').removeClass('show');
        e.preventDefault();
    });

    $('.testim-grid').masonry({
        // columnWidth: 200,
        itemSelector: '.testim-item'
    });

    $('.footer-box-open').on('click', function (e) {
        $(this).closest('.footer-box').toggleClass('show');
        e.preventDefault();
    });

    $('.login-info-open').on('click', function (e) {
        $(this).closest('.login-info').toggleClass('opened');
        e.preventDefault();
    });

    $('.header__search').on('click', function (e) {
        $('.header__charts').toggleClass('opened');
        e.preventDefault();
    });

    if ($(window).outerWidth() > 767) {
        $(".text-scroll-light").mCustomScrollbar({
            theme:"thin"
        });
        $(".sidebar--sticky").mCustomScrollbar({
            theme:"dark-thin"
        });

        $(".text-scroll").mCustomScrollbar({
            theme:"dark-thin"
        });

        $(".menu-scroll").mCustomScrollbar({
            theme:"minimal-dark"
        });


    }

    $(".chat-scroll").mCustomScrollbar({
        theme:"dark-thin",
        setTop:"-999999px",
        mouseWheelPixels: 150
    });

    $('.link-top').on('click', function (e) {
        $('body,html').animate({
            scrollTop : 0
        }, 500);
        e.preventDefault();
    });

    $(function() {
        $(document).scroll(function() {
            var y = $(this).scrollTop();
            if (y > 500) {
                $('.link-top').addClass('show');
            } else {
                $('.link-top').removeClass('show');
            }
        });
    });

    // pause video after closing modal
    $('.modal-video').on('shown.bs.modal', function () {
        $(this).find('video')[0].play();
    });
    $('.modal-video').on('hidden.bs.modal', function () {
        $(this).find('video')[0].pause();
    });


    $(document).on('scroll', function (){
        var scrollDoc = $(document).scrollTop(),
            heightSection = $('.education-section').height() + 182;
        if ( (scrollDoc >= heightSection)) {
            $('.banner--price').addClass('show');
        } else {
            $('.banner--price').removeClass('show');
        }
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100){
            $('.header').addClass("small");
        }
        else{
            $('.header').removeClass("small");
        }
    });

    $('.home-articles-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="home-articles-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button class="home-articles-next"><i class="fas fa-arrow-right"></i></button>',
        autoplay: false,
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,

                }
            }
        ]
    });

    $('.testim-section-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="testim-section-slider-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button class="testim-section-slider-next"><i class="fas fa-arrow-right"></i></button>',
        autoplay: false,
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,

                }
            }
        ]
    });

    $('.education-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="education-slider-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button class="education-slider-next"><i class="fas fa-arrow-right"></i></button>',
        autoplay: false,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,

                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,

                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,

                }
            }
        ]
    });

    $('.crypto-forecast-slider').slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="crypto-forecast-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button class="crypto-forecast-next"><i class="fas fa-arrow-right"></i></button>',
        autoplay: false,
        responsive: [
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,

                }
            }
        ]
    });

    $('.chart__slider').slick({
        dots: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<button class="chart__prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow: '<button class="chart__next"><i class="fas fa-angle-right"></i></button>',
        autoplay: false,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,

                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,

                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,

                }
            }
        ]
    });



    $('.menu__drop').on('click', function (e) {
        $(this).toggleClass('menu__drop--opened');
        $(this).closest('li').children('ul').slideToggle('');
        e.preventDefault();
    });

    $('.menu__toggle').on('click', function (e) {
        $(this).toggleClass('menu__toggle--active');
        $('.menu').toggleClass('menu--hide');
        $('.content').toggleClass('content--full');
        $('.footer').toggleClass('footer--full');
        e.preventDefault();
    });

    if ($(window).outerWidth() < 1200) {
        $('.menu__toggle').toggleClass('menu__toggle--active');
        $('.menu').addClass('menu--hide');
        $('.content').addClass('content--full');

    }

    $('.news-view-list').on('click', function (e) {
        $(this).addClass('active');
        $('.news-view-grid').removeClass('active');
        $('.news-grid').addClass('news-grid--list');
        e.preventDefault();
    });
    $('.news-view-grid').on('click', function (e) {
        $(this).addClass('active');
        $('.news-view-list').removeClass('active');
        $('.news-grid').removeClass('news-grid--list');
        e.preventDefault();
    });

    // lightgallery for image gallery
    $('.lightgallery').lightGallery({
        selector: '.report__image',
        exThumbImage: 'data-src',
        share: false,
        rotate: false,
        hash: false
    });

    $('.content__open-more a').on('click', function (e) {
        $(this).toggleClass('content__open-more--opened');
        $(this).closest('.content__more').find('.content__more-text').slideToggle('');
        e.preventDefault();
    });

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// end of main fn
});
