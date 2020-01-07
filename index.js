let userCoords;

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error);
}

function success(position) {
    userCoords = position.coords;
}

function error() {
    status.textContent = 'Unable to retrieve your location';
}

var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 54.9783, lng: -1.6178 },
        zoom: 8,
        streetViewControl: false,
        fullscreenControl: false,
        mapTypeControlOptions: {
            position: google.maps.ControlPosition.BOTTOM_LEFT
        },
        styles: [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 33
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2e5d4"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5dac6"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5c6c6"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e4d7c6"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#fbfaf7"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#acbcc9"
                    }
                ]
            }
        ]
    });
}

//can only add markers once the DOM is loaded
window.addEventListener("load", () => {
    let bounds = new google.maps.LatLngBounds();

    locations.forEach(location => {
        let icon;

        let marker = new google.maps.Marker({
            position: new google.maps.LatLng(location.lat, location.long),
            map: map
        });

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(JSON.parse(this.response).sprites.front_default)
                marker.setIcon(JSON.parse(this.response).sprites.front_default);
            }
        };
        xhttp.open("GET", `https://pokeapi.co/api/v2/pokemon/${Math.floor(Math.random() * 100) + 1  }/`, true);
        xhttp.send();        

        bounds.extend(marker.getPosition());

        let content =
            `<div class="tweet_small">
                            <div><img src="${location.profilePicture}" alt="Avatar" /></div>

                            <div>
                                <h2>${location.username}</h2>
                                <p>${location.text}</p>
                            </div>
                        </div>`;

        var infoWindow = new google.maps.InfoWindow({
            content
        });

        marker.addListener('mouseover', function () {
            infoWindow.open(map, marker);
            let userLatLng = new google.maps.LatLng(userCoords.latitude, userCoords.longitude);

            let distance = google.maps.geometry.spherical.computeDistanceBetween(marker.getPosition(), userLatLng);
            setDistance(distance);
        });

        marker.addListener('mouseout', function () {
            infoWindow.close();
            removeDistance();
        });
    })

    map.fitBounds(bounds);

    if (locations.length === 1) {
        let zoom = map.getZoom();
        map.setZoom(zoom > 12 ? 12 : zoom);
    }
})

function setDistance(distance) {
    let distanceContainer = document.getElementById("distance--hidden");
    let text = distanceContainer.querySelector("p");

    text.innerHTML =(distance / 1609.344).toFixed(2) + " miles away";

    distanceContainer.id = "distance";
}

function removeDistance() {
    let distanceContainer = document.getElementById("distance");
    distanceContainer.id = "distance--hidden";
}