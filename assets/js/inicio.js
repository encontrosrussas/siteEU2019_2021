// carrousel bootsrap
$('.carousel').carousel({
    interval: 4000
});
// elemento owl carousel noticias
var carrosel = $(".carousel-noticias");
// inicia carousel
carrosel.owlCarousel({
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
// obtem objeto do carrosel
var carroselData = carrosel.data()['owl.carousel'];
$('.go').on('click', function (e) {
    e.preventDefault();
    if ($(this).hasClass('go-left')) { // muda item carrosel para o anterior
        carroselData.prev();
    } else { // muda item carrosel para o proximo
        carroselData.next();
    }
});

$(function () {
    jQuery('.timeline').timeline({
        forceVerticalMode: 700,
        // mode: 'horizontal',
        verticalStartPosition: 'left',
        // visibleItems: 4
    });
});