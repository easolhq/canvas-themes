<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Using MySQL and PHP with Google Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>

    <script>
        var iconBase = '/event-map/';
      var customIcon = {
        'ukce': {
          icon: iconBase + 'ukce-map-pin_v2.png'
        },
        'wattbike': {
          icon: iconBase + 'wattbike-map-pin.png'
        },
        'cycling-weekly': {
          icon: iconBase + 'cycling-map-pin.png'
        },
        'brewin-dolphin': {
          icon: iconBase + 'velo-map-pin.png'
        },
        'adventure-cross': {
          icon: iconBase + 'adv-cross-map-pin.png'
        },
         'sigma-sports': {
          icon: iconBase + 'sigma-map-pin.png'
        },
        'wiggle': {
          icon: iconBase + 'wiggle-map-pin.png'
        },
        'altura': {
          icon: iconBase + 'altura-map-pin.png'
        },
        'aruk': {
          icon: iconBase + 'aruk-map-pin_v2.png'
        },
        'dallaglio': {
          icon: iconBase + 'dallaglio-map-pin.png'
        }
      };

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(54.082421, -1.810783),
          zoom: 6
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('/event-map/events_xml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var event_id = markerElem.getAttribute('event_id');
              var event_title = markerElem.getAttribute('event_title');
              var event_location = markerElem.getAttribute('event_location');
              var event_date_format = markerElem.getAttribute('event_date_format');
              var event_url = markerElem.getAttribute('event_url');
               var event_brand = markerElem.getAttribute('event_brand');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('event_venue_lat')),
                  parseFloat(markerElem.getAttribute('event_venue_long')));

              var infowincontent = '<a href="https://www.ukcyclingevents.co.uk/events/'+event_url+'/"><h3>'+event_title+'</h3></a>'+event_date_format+'<br />'+event_location+'<br /><a href="https://www.ukcyclingevents.co.uk/events/'+event_url+'/">Visit event page</a>';
              
              var icon = customIcon[event_brand] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon.icon
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC38g9IVpF4rv9Drxpqvz04rFB9Pzv_eYA&callback=initMap">
    </script>
  </body>
</html>