// *
// * Add a marker
// * 2013 - en.marnoto.com
// *

// map center coordinates
//var barraBeach = new google.maps.LatLng(47.927723, 33.399854);

// marker coordinates
//var factory = new google.maps.LatLng(47.927723, 33.399854);

function initialize() {
    var mapOptions = {
        center: barraBeach, // map center coordinates
        zoom: 15,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);

    // variable that sets the URL to the new image
    var myImage = '../carskoe-selo.com.ua/wp-content/themes/TsarskoyeSelo/images/lighthouse.png';

    // variable that sets marker options
    var marker = new google.maps.Marker({
        position: factory, // marker coordinates
        map: map,
        title: "Lighthouse of Aveiro",
        icon: myImage // set new image
    });
}
//google.maps.event.addDomListener(window, 'load', initialize);