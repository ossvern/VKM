var map, marker;
function initMap() {
    var myLatlng = new google.maps.LatLng(50.7421, 25.359294);
    var myLatlng_r = myLatlng;
    var mapOptions = {
        zoom: 16,
        center: myLatlng_r,
        // mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        navigationControl: true,
        mapTypeControl: false,
        scaleControl: false,
        control: true,
        disableDefaultUI: true,
        mapTypeControl: false,
        disableDefaultUI: true,
        draggable: true,
        styles:
            [
                {
                    "featureType": "all",
                    "elementType": "all",
                    "stylers": [
                        {
                            "hue": "#008eff"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": -70
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "on"
                        }
                    ]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "simplified"
                        },
                        {
                            "saturation": -60
                        }
                    ]
                }
            ]
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: myLatlng,
        icon:'./img/map.png'

    });
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}
function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}