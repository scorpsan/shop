$(document).ready(function(){
    "use strict";
    var md = new MobileDetect(window.navigator.userAgent);
    if (md.phone()) {
        $('body').addClass('mobile');
    }
    if (md.tablet()) {
        $('body').addClass('tablet');
    }
    function slickProduct(x){
        $('.product').each(function() {
            var id = $(this).find('.js-product-thumbnail')
            var id2 = $(this).find('.js-slide-product')
            $(id).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: id2
            });
            $(id2).slick({
                slidesToShow: x,
                slidesToScroll: 1,
                arrows: true,
                asNavFor: id,
                dots: false,
                focusOnSelect: true,
                prevArrow: '<i class="fas fa-chevron-left arrow-left-slider-v2"></i>',
                nextArrow: '<i class="fas fa-chevron-right arrow-right-slider-v2"></i>'
            });
        });
    }
    function slickProductv5(){
        $('.js-product-show ').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.js-product-title'
        });
        $('.js-product-title').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            asNavFor: '.js-product-show',
            dots: false,
            focusOnSelect: true,
            prevArrow: '<i class="fas fa-chevron-left arrow-left-slider-v2"></i>',
            nextArrow: '<i class="fas fa-chevron-right arrow-right-slider-v2"></i>'
        });
    }
    function slideHeader(){
        $('.js-section-slider-v1').slick({
            arrows:true,
            fade: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots:true,
            pauseOnDotsHover:true,
            autoplay:true,
            infinite: true,
            prevArrow: '<button type="button" class="slick-button prev"><i class="fas fa-arrow-left arrow"></i></button>',
            nextArrow: '<button type="button" class="slick-button next"><i class="fas fa-arrow-right arrow"></i></button>'
        });
        $('.js-section-slider-v1 .title').eq(0).addClass('active');
        $('.js-section-slider-v1 .img-slider img').eq(0).addClass('active');
        $('.js-section-slider-v1').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            var prev = currentSlide ;
            $('.js-section-slider-v1 .title').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-section-slider-v1 .img-slider img').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
        });
    }
    function slideShowV2() {
        $('.js-slick-slide-v2').slick({
            arrows:true,
            fade: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots:true,
            pauseOnDotsHover:true,
            autoplay:false,
            prevArrow: '<button type="button" class="slick-button2 prev2"><i class="fas fa-arrow-left arrow"></i></button>',
            nextArrow: '<button type="button" class="slick-button2 next2"><i class="fas fa-arrow-right arrow"></i></button>'
        });
        $('.js-slick-slide-v2 .title').eq(0).addClass('active');
        $('.js-slick-slide-v2 .img-slider img').eq(0).addClass('active');
        $('.js-slick-slide-v2').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            var prev = currentSlide;
            $('.js-slick-slide-v2 .title').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-slick-slide-v2 .img-slider img').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
        });
    }
    function slickBrand(){
        $('.js-slick-brand').slick({
            arrows:false,
            infinite: true,
            speed: 2000,
            slidesToShow: 5,
            slidesToScroll: 5,
            dots:false,
            autoplay: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });
    }
    function menuPopup(){
        $('.js-click-megamenu').on('click', function(event) {
            $(".box-mobile-menu").addClass('open')
            $(".menu-overlay").fadeIn();
            event.preventDefault()
        });
        $('.menu-overlay').on('click', function(event) {
            $(".box-mobile-menu").removeClass('open')
            $(".menu-overlay").fadeOut();
            event.preventDefault()
        });
        $('.close-menu').on('click', function(event) {
            $(".box-mobile-menu").removeClass('open')
            $(".menu-overlay").fadeOut();
            event.preventDefault()
        });
        $('.menu-item-has-children').on('click', function() {
            $(this).find('.submenu').slideToggle("slow");
        }).on('click', function() {
            $(this).find('.down').toggleClass("rotate");
        });
    }
    function slickBrandv2(){
        $('.js-slick-brand-v2').slick({
            arrows:false,
            infinite: true,
            speed: 2000,
            slidesToShow: 5,
            slidesToScroll: 5,
            dots:false,
            autoplay: true,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });
    }
    function backToTop(){
        $(window).on('scroll',function(){
            if ($(this).scrollTop() > 300) {
                $('.back-to-top').fadeIn();
            } else {
                $('.back-to-top').fadeOut();
            }
        });
        $('.back-to-top').on('click',function(){
            $('html, body').animate({scrollTop : 0},500);
            return false;
        });
    }
    function slickCountdown() {
        $('.js-countdown-slick-show').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            fade: true,
            asNavFor: '.js-countdown-slick-title'
        });
        $('.js-countdown-slick-title').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            infinite: false,
            asNavFor: '.js-countdown-slick-show',
            dots: false,
            focusOnSelect: true,
            prevArrow: '<i class="fas fa-chevron-left arrow-left-slider-v2"></i>',
            nextArrow: '<i class="fas fa-chevron-right arrow-right-slider-v2"></i>'
        });
    }
    function slickChildHeaderHome2(){
        $('.js-header-child-home2').slick({
            arrows:true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            pauseOnDotsHover:true,
            nextArrow: '<i class="fas fa-chevron-right arrow-right-slider-v2"></i>'
        });
    }
    function slickHeaderv3() {
        var $status = $('.pagingInfo');
        var $slickElement = $('.js-section-slider-v3');
        $slickElement.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
            var i = (currentSlide ? currentSlide : 0) + 1;
            $status.html('<div class="pagingInfo">0' + i + '</div>');
        });
        $slickElement.on('afterChange', function(event, slick, currentSlide) {
            $('.slick-active').append('<div class="pagingInfo"');
        });
        $slickElement.slick({
            arrows:false,
            fade: true,
            speed: 300,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots:true,
            autoplay:true
        });
        $('.js-section-slider-v3 .caption').eq(0).addClass('active');
        $('.js-section-slider-v3 .img-slider img').eq(0).addClass('active');
        $slickElement.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            var prev = currentSlide ;
            $('.js-section-slider-v3 .caption').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-section-slider-v3 .img-slider img').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
        })
    }
    function countDownHome1(){
        if ($('.js-countdown').length > 0) {
            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;
            let countDown = new Date('Nov 31, 2021 00:00:00').getTime(),
            x = setInterval(function() {
                let now = new Date().getTime(),
                    distance = countDown - now;
                if (distance <= 0) {
                    $('.js-countdown').addClass('d-none');
                }
                document.getElementById('days').innerText = Math.floor(distance / (day)),
                document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
                document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
                document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
            }, second);
        }
        $(document).ready(function() {
            var height = $('.countdown-img').height() / 2
            if ($(window).width() < 1200) {
                $('.js-popup-lookbook').each(function() {
                    var top = $(this).position().top
                    var left = $(this).position().left
                    left = left + 15 - ($(window).width() - 237) / 2
                    var valueTop = $(this).children().height() + 10
                    var valueBot = $(this).height() + 10
                    if (top < height) {
                        $(this).children('.popup-lookbook').css({
                            'top': valueTop,
                            'left': '-' + left + 'px',
                            'bottom': ''
                        })
                    } else {
                        $(this).children('.popup-lookbook').css({
                            'bottom': valueBot,
                            'left': '-' + left + 'px',
                            'top': ''
                        })
                    }
                })
            }
            if ($(window).width() >= 1200) {
                $(this).children('.popup-lookbook').css({
                    'top': '',
                    'left': '',
                    'bottom': ''
                })
            }
            $(window).resize(function() {
                if ($(window).width() < 1200) {
                    $('.js-popup-lookbook').each(function() {
                        var top = $(this).position().top
                        var left = $(this).position().left
                        left = left + 15 - ($(window).width() - 237) / 2
                        var valueTop = $(this).children().height() + 10
                        var valueBot = $(this).height() + 10
                        if (top < height) {
                            $(this).children('.popup-lookbook').css({
                                'top': valueTop,
                                'left': '-' + left + 'px',
                                'bottom': ''
                            })
                        } else {
                            $(this).children('.popup-lookbook').css({
                                'bottom': valueBot,
                                'left': '-' + left + 'px',
                                'top': ''
                            })
                        }
                    })
                }
                if ($(window).width() >= 1200) {
                    $(this).children('.popup-lookbook').css({
                        'top': '',
                        'left': '',
                        'bottom': ''
                    })
                }
            })
        })
    }
    function slickHeaderHome5() {
        $('.js-slide-home5').slick({
            arrows:true,
            fade: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots:true,
            pauseOnDotsHover:true,
            autoplay:true,
            prevArrow: '<button type="button" class="slick-button5 prev5"><i class="fas fa-arrow-left arrow5"></i></button>',
            nextArrow: '<button type="button" class="slick-button5 next5"><i class="fas fa-arrow-right arrow5"></i></button>'
        });
        $('.js-slide-home5 .caption').eq(0).addClass('active');
        $('.js-slide-home5 .img-slider img').eq(0).addClass('active');
        $('.js-slide-home5').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            var prev = currentSlide;
            $('.js-slide-home5 .caption').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-section-slider-v3 .img-slider img').eq(mySlideNumber).addClass('active');
            $('.js-slide-home5 .img-slider img').eq(prev).removeClass('active');
        })
    }
    function sliderMenu(){
        var allPanels = $('.menu-shop').hide();
        $('sliderdown').click(function(){
            allPanels.slideUp();
            $(this).parent().next().slideDown();
            return false;
        });
    }
    function slickProductv3() {
        $('.js-slick-product').slick({
            arrows:true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots:false,
            autoplay:false,
            prevArrow: '<button type="button" class="slick-button prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-button next"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    function switchTab(){
        $('ul.tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');
            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        });
    }
    function menuToggle(){
        $('.item-menu a').on('click', function(e) {
            var parentLi = $(this).parents(".item-menu");
            if (parentLi.find('.submenu:first').length && !parentLi.hasClass("openMenu")){
                e.preventDefault();

                var otherLi = $('.item-menu');
                otherLi.removeClass("openMenu");
                otherLi.find('.submenu').slideUp("slow");
                otherLi.find('.down').removeClass("rotate");

                parentLi.addClass("openMenu");
                parentLi.find('.submenu:first').slideDown("slow");
                parentLi.find('.down:first').addClass("rotate");
            }
        });
        var activeLi = $('.item-menu.active');
        if (activeLi.find('.submenu:first').length) {
            activeLi.addClass("openMenu");
            activeLi.find('.submenu:first').slideDown("slow");
            activeLi.find('.down:first').addClass("rotate");
        } else if (activeLi.parents(".item-menu").find('.submenu:first').length) {
            activeLi.parents(".item-menu").addClass("openMenu");
            activeLi.parents(".item-menu").find('.submenu:first').slideDown("slow");
            activeLi.parents(".item-menu").find('.down:first').addClass("rotate");
        }
    }
    function slickProductv1(){
        $('.js-product-thumbnail1').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.js-slide-product1'
        });
        $('.js-slide-product1').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
            asNavFor: '.js-product-thumbnail1',
            dots: false,
            focusOnSelect: true,
            prevArrow: '<button type="button" class="slick-button prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-button next"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1920,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
    function slickProductv2(x) {
        $('.product-list-sidebar').each(function() {
            var id = $(this).find('.js-product-thumbnail2')
            var id2 = $(this).find('.js-slide-product2')
            $(id).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: id2
            });
            $(id2).slick({
                slidesToShow: x,
                slidesToScroll: 1,
                arrows: true,
                asNavFor: id,
                dots: false,
                vertical: true,
                adaptiveHeight: true,
                focusOnSelect: true,
                prevArrow: '<button type="button" class="slick-button2 prev2"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-button2 next2"><i class="fas fa-chevron-right"></i></button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {vertical:false}
                    }
                ]
            });
        });
    }
    function slickProduct2(){
        $('.js-product-thumbnail3').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.js-slide-product3'
        });
        $('.js-slide-product3').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.js-product-thumbnail3',
            dots: false,
            focusOnSelect: true,
            vertical:true
        });
    }
    function slickVideo(){
        $('.js-slick-video').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false
        });
    }
    function slickQuickview(){
        $('.js-product-thumbnail4').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.js-slide-product4'
        });
        $('.js-slide-product4').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.js-product-thumbnail4',
            dots: false,
            focusOnSelect: true,
            vertical:true
        });
    }
    function quickView(){
        $('.review').on('click', function(event) {
            $(".quick-view-product").removeClass('quick-view-active').addClass('d-block');
            $(".quick-view-overlay").addClass('d-block');
            event.preventDefault();
        });
        $('.js-quick-view-close, .quick-view-overlay').on('click', function(event) {
            $(".quick-view-product").addClass('quick-view-active').addClass('d-none');
            $(".quick-view-overlay").removeClass('d-block').addClass('d-none');
            event.preventDefault()
        });
    }
    function sortLayout() {
        setTimeout(function(){
            $('#showby-grid').on('change', function(){
                var value = $("#showby-grid").val();
                if (value == 2 ) {
                    $('.js-product-thumbnail, .js-slide-product').slick('unslick')
                    $('.js-slide-product').removeClass('d-none');
                    $('.js-sort-layout .js-sort-item').removeClass('col-lg-3 col-lg-4 col-md-3 col-md-4 col-3 col-4').addClass('col-lg-6 col-md-6 col-6');
                    slickProduct(4);
                } else if (value == 3 ) {
                    $('.js-product-thumbnail, .js-slide-product').slick('unslick')
                    $('.js-slide-product').removeClass('d-none');
                    $('.js-sort-layout .js-sort-item').removeClass('col-lg-3 col-lg-6 col-md-3 col-md-6 col-3 col-6').addClass('col-lg-4 col-md-4 col-4');
                    slickProduct(3);
                } else {
                    $('.js-product-thumbnail, .js-slide-product').slick('unslick');
                    $('.js-slide-product').removeClass('d-none');
                    $('.js-sort-layout .js-sort-item').removeClass('col-lg-4 col-lg-6 col-md-4 col-md-6 col-4 col-6').addClass('col-lg-3 col-md-3 col-3');
                    slickProduct(2);
                }
            });
        },200);
    }
    function FilterSidebarColecllectionInRight() {
        $('.js-filter').on( "click", function() {
            $(this).toggleClass('d-none');
            $('.js-close-filter').toggleClass('d-block');
            $('.js-filter-popup').toggleClass('active');
            $('.js-bg-filter').toggleClass('active');
        });
        $('.js-close-filter').on( "click", function() {
            $(this).addClass('d-none');
            $(this).removeClass('d-block');
            $('.js-filter').removeClass('d-none').addClass('d-block');
            $('.js-filter-popup').removeClass('active');
            $('.js-bg-filter').removeClass('active');
        });
        $('.js-bg-filter').on( "click", function() {
            $(this).removeClass('active');
            $('.js-filter-popup').removeClass('active');
            $('.js-close-filter').removeClass('d-block');
            $('.js-filter').removeClass('d-none').addClass('d-block');

        });
    }
    function showProduct() {
        setTimeout(function() {
            $('.js-sort').fadeToggle();
        });
        $('.js-grid').on('click', function() {
            $('.js-sort, .js-sort-item, .js-product-thumbnail, .js-layout-detail').addClass('d-block');
            $('.js-sort').removeClass('d-none');
            $('.js-sort-layout').addClass('d-none');
            $('.js-list').removeClass('active')
        });
        $('.js-list').on('click', function(){
            $('.js-sort').removeClass('d-block');
            $('.js-sort-layout').removeClass('d-none');
            $('.js-list').addClass('active')
        });
    }
    function headerFixed() {
        // Hide Header on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('.header-mobile').outerHeight();
        $(window).scroll(function() {
            didScroll = true;
        });
        function hasScrolled() {
            var st = $(this).scrollTop();
            if(Math.abs(lastScrollTop - st) <= delta)
                return;
            if (st > lastScrollTop && st > navbarHeight){
                // Scroll Down
                $('.header-mobile').removeClass('nav-down').addClass('nav-up');
            } else {
                // Scroll Up
                if(st + $(window).height() < $(document).height()) {
                    $('.header-mobile').removeClass('nav-up').addClass('nav-down');
                }
            }
            lastScrollTop = st;
        }
        setInterval(function() {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);
    }
    function mobileSearch() {
        $('.js-search').on('click', function() {
            $('.mobile-nav-search-form').addClass('d-block');
        });
        $('.mobile-nav-search-close').on('click', function() {
            $('.mobile-nav-search-form').removeClass('d-block');
        });
    }
    function menudestopscroll() {
        var $nav = $(".js-header");
        $nav.removeClass('menu-scroll-v1');
        $(document).scroll(function() {
            $nav.toggleClass('menu-scroll-v1', $(this).scrollTop() > $nav.height());
        });
    }
    function slideHeaderHome4() {
        $('.js-slideshow-v4').slick({
            dots: false,
            fade:true,
            arrows: true,
            speed: 300,
            autoplay: false,
            adaptiveHeight: true,
            prevArrow: '<button type="button" class="slick-button3 prev3"><i class="fas fa-arrow-left arrow3"></i></button>',
            nextArrow: '<button type="button" class="slick-button3 next3"><i class="fas fa-arrow-right arrow3"></i></button>',
            asNavFor: '.js-slideshow-thumb'
        });
        $('.js-slideshow-thumb').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade:true,
            speed: 1000,
            asNavFor: '.js-slideshow-v4',
            dots: false,
            arrows: false,
            focusOnSelect: true
        });
        $('.js-slideshow-v4 .slider-info').eq(0).addClass('active');
        $('.js-slideshow-v4 .slider-content').eq(0).addClass('active');
        $('.js-slideshow-v4 .img-slick').eq(0).addClass('active');
        $('.js-slideshow-thumb .slideshow-thumb  img').eq(0).addClass('active');
        $('.js-slideshow-v4').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            var prev = mySlideNumber - 2;
            $('.js-slideshow-v4 .slider-info').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-slideshow-v4 .slider-content').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-slideshow-v4 .img-slick').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
            $('.js-slideshow-thumb .slideshow-thumb  img').eq(mySlideNumber).addClass('active').eq(prev).removeClass('active');
        });
    }
    function ratingStar() {
        $('.select-rating').barrating({theme: 'fontawesome-stars'});
    }


    function miniCart(){
        $('.js-cart-pull-right').on('click', function() {
            $('.js-bg').toggleClass('active');
            $('.js-cart-popup').toggleClass('active');
        });
        $('.js-bg').on('click', function() {
            $(this).removeClass('active');
            $('.js-cart-popup').removeClass('active');
        });
        $('.closebtn').on('click', function() {
            $('.js-bg').removeClass('active');
            $('.js-cart-popup').removeClass('active');
        });
    }
    function errorMessage(message) {
        if (message) {
            $('.error-popup .error-message').html('Error: ' + message);
            $('.error-popup').addClass('active');
            setTimeout(function () {
                $('.error-popup').removeClass('active');
            }, 6000);
        }
    }
    function addCart() {
        var miniCart = $(document).find('.minicart-scroll');
        var miniUrl = miniCart.data('url');
        var qtyCart = $('.qty-in-cart');
        miniCart.load(miniUrl);
        $(document).on('click', '.add-to-cart, .from-wish-to-cart', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var data = {};
            data.id = $(this).data('id');
            data.qty = $('#quanlity').val();
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    errorMessage(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        $('.product-popup .product-image img').attr('src', resp.image);
                        $('.product-popup .product-name').html(resp.name);
                        $('.product-popup .success-message').html(resp.message);
                        $('.product-popup').addClass('active');
                        setTimeout(function () {
                            $('.product-popup').removeClass('active');
                        }, 10000);
                        qtyCart.html(resp.qty);
                        miniCart.load(miniUrl);
                        if ($('#wish-pjax').length) {
                            $.pjax.reload({container: '#wish-pjax', timeout: false});
                        }
                    } else {
                        errorMessage(resp.message);
                    }
                }
            });
        });
        $(document).on('click', '.delete-from-cart, .item-minus-cart, .item-plus-cart, .clear-cart', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var data = {};
            data.id = $(this).data('id');
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    errorMessage(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        qtyCart.html(resp.qty);
                        miniCart.load(miniUrl);
                        if ($('#cart-pjax').length) {
                            $.pjax.reload({container: '#cart-pjax', timeout: false});
                        }
                    } else {
                        errorMessage(resp.message);
                    }
                }
            });
        });
        $(document).on('click', '.update-cart', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var data = {};
            data.update = $('input[name^=updates]').map(function(idx, elem) {
                return {'id':$(elem).data('id'), 'qty':$(elem).val()};
            }).get();
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    errorMessage(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        qtyCart.html(resp.qty);
                        miniCart.load(miniUrl);
                        if ($('#cart-pjax').length) {
                            $.pjax.reload({container: '#cart-pjax', timeout: false});
                        }
                    } else {
                        errorMessage(resp.message);
                    }
                }
            });
        });
        $(document).on('click', '.add-to-wish, .from-cart-to-wish', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var data = {};
            data.id = $(this).data('id');
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    errorMessage(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        $('.wishlist-popup .product-image img').attr('src', resp.image);
                        $('.wishlist-popup .product-name').html(resp.name);
                        $('.wishlist-popup .success-message').html(resp.message);
                        $('.wishlist-popup').addClass('active');
                        setTimeout(function () {
                            $('.wishlist-popup').removeClass('active');
                        }, 10000);
                        if (!isNaN(resp.qty)) {
                            qtyCart.html(resp.qty);
                            miniCart.load(miniUrl);
                            if ($('#cart-pjax').length) {
                                $.pjax.reload({container: '#cart-pjax', timeout: false});
                            }
                        }
                    } else {
                        errorMessage(resp.message);
                    }
                }
            });
        });
        $(document).on('click', '.delete-from-wish', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            var data = {};
            data.id = $(this).data('id');
            $.ajax({
                url: url,
                data: data,
                type: 'POST',
                error: function (resp) {
                    errorMessage(resp.message);
                },
                success: function (resp) {
                    if (resp.success) {
                        if ($('#wish-pjax').length) {
                            $.pjax.reload({container: '#wish-pjax', timeout: false});
                        }
                    } else {
                        errorMessage(resp.message);
                    }
                }
            });
        });
        $(document).on('click', '.overlay, .continue-shopping, .close-window', function() {
            $(".engo-popup").removeClass('active');
        });
    }

    slickProduct(3);
    slickProductv5();
    slideHeader();
    slickBrand();
    menuPopup();
    slickCountdown();
    slickBrandv2();
    countDownHome1();
    slickChildHeaderHome2();
    slickHeaderv3();
    slickHeaderHome5();
    sliderMenu();
    slickProductv3();
    switchTab();
    menuToggle();
    slickProductv1();
    slickProductv2(3);
    slickProduct2();
    slickVideo();
    slickQuickview();
    quickView();
    sortLayout();
    FilterSidebarColecllectionInRight();
    showProduct();
    headerFixed();
    mobileSearch();
    slideShowV2() ;
    menudestopscroll();
    slideHeaderHome4();
    ratingStar();

    backToTop();
    miniCart();
    addCart();
});