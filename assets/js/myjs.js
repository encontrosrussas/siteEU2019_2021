$(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
        $('a[href="#top"]').fadeIn();
    } else {
        $('a[href="#top"]').fadeOut();
    }
});
$('a[href^="#"]').on('click', function (e) {
    e.preventDefault();
    var targetEle = this.hash;
    var $targetEle = $(targetEle);
    $('html, body').stop().animate({
        'scrollTop': $targetEle.offset().top
    }, 800, 'swing', function () {
        window.location.hash = targetEle;
    });
});
$('.carousel').carousel({
    interval: 4000
});
$(".owl-carousel").owlCarousel({
    loop: true,
    margin: 15,
    autoplay: true,
    autoplayTimeout: 2500,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
        480: {
            items: 2,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
        600: {
            items: 3,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
        1000: {
            items: 4,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        }
    }
});

$("#ano").html(new Date().getFullYear());