<?php
//get prayer times
function prayerTimeCallback( $data ) {
    return PrayerTimes::getTimes($data['lat'], $data['long']);
}
//init api route
add_action( 'rest_api_init', function () {
    register_rest_route( 'wfc/v1', '/prayertimes', array(
      'methods' => 'GET',
      'callback' => 'prayerTimeCallback',
    ) );
} );
//verify day
function dataRetreivedDayCallback( $data ) {
    return PrayerTimes::verifyTimes($data['day']);

}
//init api route
add_action( 'rest_api_init', function () {
    register_rest_route( 'wfc/v1', '/data-verify', array(
      'methods' => 'GET',
      'callback' => 'dataRetreivedDayCallback',
    ) );
} );