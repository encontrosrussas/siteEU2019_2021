// Botao voltar para o topo aparecer/sumir
$(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
        $('a[href="#top"]').fadeIn();
    } else {
        $('a[href="#top"]').fadeOut();
    }
});
// Scroll para elemento
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
// carrousel bootsrap
$('.carousel').carousel({
    interval: 4000
});
$(document).ready(function ($){
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
    $('.go').on('click', function(e){
        e.preventDefault();
        if ($(this).hasClass('go-left')){ // muda item carrosel para o anterior
            carroselData.prev();
        } else { // muda item carrosel para o proximo
            carroselData.next();
        }
    });
    // inicia carrosel do rodape
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
                items: 2,
                nav: false,
                loop: true,
                autoplayHoverPause: true,
            }
        }
    });
});
// Altera ano atual no rodape
$("#ano").html(new Date().getFullYear());