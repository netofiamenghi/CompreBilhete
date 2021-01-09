$(document).ready(function () {
    var owl = $("#owl-banner");

    owl.owlCarousel({
        navigation: true,
        singleItem: true,
        items: 2,
        autoplay: true,
        autoPlaySpeed: 5000,
        autoPlayTimeout: 5000,
        autoplayHoverPause: true,
        transitionStyle: "fade"
    });

});
