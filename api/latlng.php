<?php
//define('SHOW_EVERY_SQL', true);

require '../load.php';

http_json_header();

if(empty($_GET['lat']) || empty($_GET['lng']) || empty($_GET['radius']) ) {
	$result = array();
} else {
	$result = get_pois_in_radius(
		$_GET['lat'],
		$_GET['lng'],
		$_GET['radius']
	);

	$n_results = count( $result );
	for($i=0; $i<$n_results; $i++) {
		$result[$i]->prezzi = $db->getResults( sprintf(
			"SELECT DISTINCT price.prezzo, price.isSelf, descCarburante " .
			"FROM price, station " .
			"WHERE price.idImpianto = %d AND price.idImpianto = station.idImpianto " .
			"ORDER BY price.prezzo"
			,
			$result[$i]->idImpianto
		) );
	}
}

http_json_header();

echo json_encode(
	$result
	, JSON_PRETTY_PRINT
);
