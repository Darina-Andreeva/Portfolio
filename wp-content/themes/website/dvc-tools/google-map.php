<?php

function nb_googleMaps($addresses, $addresses2 = null, $id2 = null) {
    $mapZoom = get_field('map-zoom');
    if (empty($mapZoom)) {
        $mapZoom = get_field('map-zoom', nb_get_page('contacts')->ID);
    }
    $center = $addresses[0]['google_maps'];
    $options = array(
        'zoom' => $mapZoom,
        'center' => "new google.maps.LatLng(" . $center['lat'] . ", " . $center['lng'] . ")",
    );
    $mapDefaultUi = get_field('map-default-ui');
    if (empty($mapDefaultUi))
        $mapDefaultUi = get_field('map-default-ui', nb_get_page('contacts')->ID);

    $mapScrollwheel = get_field('map-scrollwheel');
    if (empty($mapScrollwheel))
		$mapScrollwheel = get_field('map-scrollwheel', nb_get_page('contacts')->ID);
    if ($mapDefaultUi)
        $options['disableDefaultUI'] = $mapDefaultUi;
    if ($mapScrollwheel)
        $options['scrollwheel'] = 'true';
    else
        $options['scrollwheel'] = 'false';
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
		var map;
        function initialize() {
        var mapOptions = {
    <?php
    $place = 0;
    $end = ',';
    foreach ($options as $option => $value) {
        if ($place == (count($options) - 1))
            $end = '';
        ?>
            '<?php echo $option; ?>' : <?php echo $value; ?><?php echo $end; ?>

        <?php
        $place++;
    }
    ?>
        };
            mapCall('contacts-map', mapOptions);
        }
        function mapCall(id, mapOptions){
       map = new google.maps.Map(document.getElementById(id),
                mapOptions);
    <?php
    foreach ($addresses as $address) {
        if ($address['google_maps']) {
            ?>
                var image = '<?php echo $address['pin']['url']; ?>';
                var myLatLng = new google.maps.LatLng(<?php echo $address['google_maps']['lat']; ?>, <?php echo $address['google_maps']['lng']; ?>);
                var beachMarker = new google.maps.Marker({
                position: myLatLng,
                        map: map,
                        icon: image
                });
            <?php
        }
    }
    ?>
        }

        google.maps.event.addDomListener(window, 'load', initialize);
	$(function(){
		$('.address-link').click(function(){
			var lat = $(this).attr('data-lat');
			var lng = $(this).attr('data-lng');
			 map.panTo(new google.maps.LatLng(lat, lng));
			return false;
		});		
	});

    </script> <?php
}
