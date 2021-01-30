$(document).ready(function () {

    $('.mehr').click(function () {
        $('#gallery-modal').slideDown("slow");
    });
    $('.close').click(function () {
        $('#gallery-modal').slideUp("slow");
    });

    $('.mehr-bilder').click(function () {
        $('#hochzeit-modal').slideDown("slow");
    });
    $('.close').click(function () {
        $('#hochzeit-modal').slideUp("slow");
    });

});


(function (document, window, $) {
    $(document).ready(function () {
        $('.gallery-grid ').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2100,
            dots: false,
            prevArrow: false,
            nextArrow: false,

        });
    });
}(document, window, jQuery))


/*embed google Map*/
function myMap() {
    var myCenter = new google.maps.LatLng(48.109994, 11.731998);
    var mapCanvas = document.getElementById("map");
    var mapOptions = {
        center: myCenter,
        zoom: 15,
        scrollwheel: false,
        navigationControl: false,
      
        center: myCenter

    };
    var map = new google.maps.Map(mapCanvas, mapOptions);
    var marker = new google.maps.Marker({
        position: myCenter
    });
    marker.setMap(map);
}

/*slick*/


/*smooth animation*/
$(function () {
    $('a[href*=\\#]:not([href=\\#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top - 60
                }, 300);
                return false;
            }
        }
    });
});
