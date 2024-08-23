$(".carousel-rodape").owlCarousel({
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
            items: 1,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
        600: {
            items: 2,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
        1000: {
            items: 4,
            nav: false,
            loop: true,
            autoplayHoverPause: true,
        },
    },
});
