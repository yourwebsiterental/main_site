jQuery(document).ready(function ($) {

    var slider_auto, slider_loop, rtl;

    if (minimal_travel_data.auto == '1') {
        slider_auto = true;
    } else {
        slider_auto = false;
    }

    if (minimal_travel_data.loop == '1') {
        slider_loop = true;
    } else {
        slider_loop = false;
    }

    if (minimal_travel_data.rtl == '1') {
        rtl = true;
    } else {
        rtl = false;
    }


    //Banner slider js

    $('.site-banner.style-eight .item-wrap').owlCarousel({
        items: 1,
        autoplay: slider_auto,
        loop: slider_loop,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        autoplayTimeout: minimal_travel_data.speed,
        rtl: rtl,
    });


    $('.promo-section .bttk-itw-holder').addClass('owl-carousel');

    $('.promo-section .bttk-itw-holder').owlCarousel({
        items: 3,
        margin: 30,
        autoplay: true,
        nav: true,
        dots: false,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        rtl: rtl,
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1025: {
                items: 3,
            }
        }
    });
})

