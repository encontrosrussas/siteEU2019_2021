import Flickity from 'flickity';

var carouselNoticias = document.querySelector('#carousel-noticias');

var flicn = new Flickity(carouselNoticias, {
    cellAlign: 'left',
    pageDots: false,
    prevNextButtons: true,
    adaptiveHeight: false,
    fade: true
});

var carouselFotos = document.querySelector('#carousel-fs')

var flicf = new Flickity(carouselFotos, {
    cellAlign: 'left',
    setGallerySize: false,
    contain: true,
    prevNextButtons: false,
    pageDots: true,
    wrapAround: true,
    autoPlay: 5000,
    percentPosition: false,
    fade: true
})