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

http_json_header();

$lat_n = @$_GET['lat_n'];
$lat_s = @$_GET['lat_s'];
$lng_e = @$_GET['lng_e'];
$lng_w = @$_GET['lng_w'];

$results = array();

if( ! empty($lat_n) && ! empty($lat_s) && ! empty($lng_e) && ! empty($lng_w) ) {

	$results = $GLOBALS['db']->getResults( sprintf(
		"SELECT station.idImpianto, station.gestore, station.latitudine, station.longitudine FROM station WHERE " .
		"station.latitudine BETWEEN %f AND %f AND " .
		"station.longitudine BETWEEN %f AND %f",
		$lat_s,
		$lat_n,
		$lng_w,
		$lng_e
	) );

	$n_results = count( $results );

	if($n_results > 90) {
		$results->error = true;
	} else {
		$results->error = false;


		for($i=0; $i<$n_results; $i++) {
			$results[$i]->prezzi = $db->getResults( sprintf(
				"SELECT DISTINCT price.prezzo, price.isSelf, descCarburante " .
				"FROM price, station " .
				"WHERE price.idImpianto = %d AND price.idImpianto = station.idImpianto " .
				"ORDER BY price.prezzo"
				,
				$results[$i]->idImpianto
			) );
		}
	}

}

echo json_encode($results);
