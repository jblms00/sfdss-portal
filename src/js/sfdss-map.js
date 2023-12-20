$(document).ready(function () {
    initMap();
});

function initMap() {
    var location = { lat: 14.3603287481834, lng: 121.05908636502292 };

    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location,
    });

    var marker = new google.maps.Marker({
        position: location,
        map: map,
    });
}