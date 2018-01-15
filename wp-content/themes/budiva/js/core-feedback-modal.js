$(document).ready(function() {
    $(document).on('click', '.btn1', function() {
        $('#small-modal').arcticmodal();
    });

    $('.bxslider').bxSlider({
        adaptiveHeight: true,
        autoHover: true,
        auto: true,
        mode: 'fade',
        pause: sliders_speed.slider_home_speed
    });

    $('.bxslider2').bxSlider({
        pagerCustom: '#bx-pager',
        pause: sliders_speed.slider_advantages_speed
    });

    $('.slider1').bxSlider({
        slideWidth: 160,
        minSlides: 1,
        maxSlides: 5,
        moveSlides: 1,
        slideMargin: 70,
        auto: true,
        pause: sliders_speed.slider_manufacturers_speed
    });

    $('.category-slider-start').bxSlider({
        slideWidth: 250,
        minSlides: 1,
        maxSlides: 4,
        moveSlides: 1,
        slideMargin: 10,
        auto: true,
        pause: sliders_speed.slider_manufacturers_speed,
        infiniteLoop: false,
        onSliderLoad: function(currentIndex) {
            var c = $(".category-slider"),
                next = c.find(".bx-next"),
                prev = c.find(".bx-prev"),
                all = c.find(".bx-viewport").height();
            next.attr("style", "bottom: " + ( (all - next.height() ) / 2 ) + "px !important");
            prev.attr("style", "bottom: " + ( (all - prev.height() ) / 2 ) + "px !important");
        }
    });

    $('.builders-slider-start').bxSlider({
        slideWidth: 250,
        minSlides: 2,
        maxSlides: 10,
        moveSlides: 1,
        slideMargin: 10,
        auto: true,
        pause: sliders_speed.slider_manufacturers_speed
    });

    if($(document).width() < 767) {
        $('.news-image .thumbnails').append('<div class="slide"></div>');
        $('.news-image .thumbnails .slide:last-child').append($('.news-image .thumbnails + a').clone());
        $('.news-image .thumbnails + a').remove();
        $(".news-image .thumbnails").bxSlider({
            slideWidth: 230,
            minSlides: 1,
            maxSlides: 1,
            slideMargin: 0,
            moveSlides: 1,
            infiniteLoop: false,
            mode: 'horizontal',
            onSliderLoad: function() {
                $(".news-image .thumbnails").css("overflow", 'visible');
            }
        });
    }
    else {
        $(".news-image .thumbnails").bxSlider({
            slideWidth: 100,
            minSlides: 2,
            maxSlides: 6,
            slideMargin: 10,
            moveSlides: 1,
            infiniteLoop: false,
            mode: 'vertical',
            onSliderLoad: function() {
                $(".news-image .thumbnails").css("overflow", 'visible');
            }
        });
    }
});