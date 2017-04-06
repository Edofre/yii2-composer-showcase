<?php
$geo_coding_client = new \dosamigos\google\maps\services\GeocodingClient();

$map = new \dosamigos\google\maps\Map([
    'center' => new \dosamigos\google\maps\LatLng(['lat' => 52.1326, 'lng' => 5.2913]),
    'zoom'   => 7,
]);

$lookup_response = $geo_coding_client->lookup([
    'address' => 'Stationsplein, 1012 AB Amsterdam',
    'region'  => 'Netherlands',
]);

// The lookup response can return more results or even return errors if the location can't be found,
// the following will set the first found result in $lat and $lng variables
$lat = isset($lookup_response->results[0]->geometry->location->lat) ? $lookup_response->results[0]->geometry->location->lat : null;
$lng = isset($lookup_response->results[0]->geometry->location->lng) ? $lookup_response->results[0]->geometry->location->lng : null;

// OLD
//$lat = isset($lookup_response['results'][0]['geometry']['location']['lat']) ? $lookup_response['results'][0]['geometry']['location']['lat'] : null;
//$lng = isset($lookup_response['results'][0]['geometry']['location']['lng']) ? $lookup_response['results'][0]['geometry']['location']['lng'] : null;

if (!is_null($lat) && !is_null($lng)) {
    $marker = new \dosamigos\google\maps\overlays\Marker([
        'position' => new \dosamigos\google\maps\LatLng([
            'lat' => $lat,
            'lng' => $lng,
        ]),
        'title'    => 'Station Amsterdam',
    ]);
}

$map->addOverlay($marker);
$map->center = $map->getMarkersCenterCoordinates();
$map->zoom = $map->getMarkersFittingZoom() - 1;
?>

<?= $map->display(); ?>