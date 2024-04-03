function fetchCityCoordinates() {
    // AJAX request to fetch city coordinates from your PHP script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_coordinates.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Parse the JSON response
            var cities = JSON.parse(xhr.responseText);
            // Call a function to initialize the map with the fetched city coordinates
            initMap(cities);
        } else {
            console.error('Error fetching city coordinates:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Error fetching city coordinates:', xhr.statusText);
    };
    xhr.send();
}

function initMap(cities) {
    // Initialize map
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 4 // You can adjust the initial zoom level
    });

    // Add markers for each city
    cities.forEach(function(city) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(city.latitude), lng: parseFloat(city.longitude)},
            map: map,
            title: city.name
        });
    });
}

// Call the function to fetch city coordinates when the page loads
window.onload = fetchCityCoordinates;
