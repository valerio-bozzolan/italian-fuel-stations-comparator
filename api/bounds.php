<?php
/*
 * Landscapefor-map - The "Landscapefor" map management system
 * Copyright (C) 2015 Valerio Bozzolan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require '../load.php';

$results = array();

if( isset( $_GET['lat_n'], $_GET['lat_s'], $_GET['lng_e'], $_GET['lng_w'] ) ) {

	$lat_n = & $_GET['lat_n'];
	$lat_s = & $_GET['lat_s'];
	$lng_e = & $_GET['lng_e'];
	$lng_w = & $_GET['lng_w'];

	$results = $db->getResults(
		sprintf(
			"SELECT station.station_ID, station.station_lat, station.station_lon, " .
			"stationowner.stationowner_uid, stationowner.stationowner_name " .
			"FROM {$db->getTables('station', 'stationowner')} " .
			"WHERE station.station_lat BETWEEN %f AND %f " .
			"AND station.station_lon BETWEEN %f AND %f " .
			"AND station.stationowner_ID = stationowner.stationowner_ID",
			$lat_s,
			$lat_n,
			$lng_w,
			$lng_e
		),
		'Station'
	);
	$n_results = count( $results );

	$results->error = $n_results > 90;

	if(! $results->error) {

		// Get prices
		for($i=0; $i<$n_results; $i++) {
			$results[$i]->prices = $db->getResults(
				sprintf(
					"SELECT DISTINCT price.price_value, price.price_self, " .
					"fuel.fuel_uid, fuel.fuel_name " .
					"FROM {$db->getTables('price', 'fuel')} " .
					"WHERE price.station_ID = %d " .
					"AND price.fuel_ID = fuel.fuel_ID " .
					"ORDER BY price.price_value",
					$results[$i]->idImpianto
				),
				'Price'
			);
		}
	}

}

http_json_header();

echo json_encode(
	$results,
	isset( $_GET['pretty'] ) ? JSON_PRETTY_PRINT : 0
);
