<?php
function get_distance_between_coordinates($latitude1, $longitude1, $latitude2, $longitude2)  {
	$theta = $longitude1 - $longitude2;
	$distance = sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)) + (
		cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))
	);
	$distance = acos($distance);
	$distance = rad2deg($distance) * 60 * 1.1515;
	$distance = $distance * 1609.344; // To meters
	return $distance;
}

/**
 * Retrieve a range of poi.
 *
 * I monstrously speed-up performance filtering by a simple square radius
 * from the MySQL side and stripping the surplus from PHP.
 *
 * @param $latitude float
 * @param $longitude float
 * @param $radius float meters
*/
function get_pois_in_radius($lat, $lon, $radius) {
	$comparable_radius = $radius / (111000); // 111Km are ~ 1°

	// Filter poi in MySQL with a simple square margin
	$max_lat  = $lat + $comparable_radius;
	$min_lat  = $lat - $comparable_radius;
	$max_lon = $lon + $comparable_radius;
	$min_lon = $lon - $comparable_radius;
	$results = $GLOBALS['db']->getResults( $sql = sprintf(
		"SELECT station.idImpianto, station.gestore, station.latitudine, station.longitudine FROM station WHERE " .
		"station.latitudine BETWEEN %f AND %f AND " .
		"station.longitudine BETWEEN %f AND %f",
		$min_lat,
		$max_lat,
		$min_lon,
		$max_lon
	));

	// Stripping the surplus out the circle radius
	$filtered = array();
	$n = count($results);
	for($i=0; $i<count($results); $i++) {
		$result_lat = $results[$i]->latitudine;
		$result_lng = $results[$i]->longitudine;
		if(get_distance_between_coordinates($lat, $lon, $result_lat, $result_lng) <= $radius) {
			$filtered[] = $results[$i];
			unset($results[$i]);
		}
	}
	return $filtered;
}
