<?php
// die("Not now");

define('FILENAME_STATIONS', 'anagrafica_impianti_attivi.csv');
define('FILENAME_PRICES', 'prezzo_alle_8.csv');

require '../load.php';

http_json_header();

$db->query("TRUNCATE {$db->getTable('price')}");
$db->query("TRUNCATE {$db->getTable('station')}");

$error_code = null;
$error_message = null;

$comuni = $db->getResults("SELECT * FROM {$db->getTable('comune')}");
$provincie = $db->getResults("SELECT * FROM {$db->getTable('provincia')}");

function get_comune_ID($comune_uid, $comune_name, $provincia_name) {
	global $db, $comuni;

	$n = count($comuni);
	$i = 0;
	while($i<$n && $comuni[$i++]->comune_uid !== $comune_uid);
	$i--;
	if($i>=0 && $i<$n && $comuni[$i]->comune_uid === $comune_uid) {
		return $comuni[$i]->comune_ID;
	}

	$db->insertRow('comune', [
		new DBCol('comune_uid', $comune_uid, 's'),
		new DBCol('comune_name', $comune_name, 's')
	] );

	$comuni[] = $db->getRow( sprintf(
		"SELECT * FROM {$db->getTable('comune')} WHERE comune_ID = '%d'",
		$db->getLastInsertedID()
	) );

	$db->insertRow('rel_provincia_comune', [
		new DBCol(
			'provincia_ID',
			get_provincia_ID(
				generate_slug($provincia_name),
				$provincia_name
			),
			'd'
		),
		new DBCol('comune_ID', $comuni[$n]->comune_ID, 'd')
	] );

	return $comuni[$n]->comune_ID;
}

function get_provincia_ID($provincia_uid, $provincia_name) {
	global $db, $provincie;

	$n = count($provincie);
	$i = 0;
	while($i<$n && $provincie[$i++]->provincia_uid !== $provincia_uid);
	$i--;
	if($i>=0 && $i<$n && $provincie[$i]->provincia_uid === $provincia_uid) {
		return $provincie[$i]->provincia_ID;
	}

	$db->insertRow('provincia', [
		new DBCol('provincia_uid', $provincia_uid, 's'),
		new DBCol('provincia_name', $provincia_name, 's')
	] );

	$provincie[] = $db->getRow( sprintf(
		"SELECT * FROM {$db->getTable('provincia')} WHERE provincia_ID = '%d'",
		$db->getLastInsertedID()
	) );

	return $provincie[$n]->provincia_ID;
}

try {
	if( ! file_exists(FILENAME_STATIONS) ) {
		throw new Exception( _("File delle stazioni non trovato"), 1 );
	}

	if( ! $handle = fopen(FILENAME_STATIONS, 'r') ) {
		throw new Exception( _("Impossibile aprire il file delle stazioni"), 2 );
	}

	// Waste first 2 lines
	fgetcsv($handle);
	fgetcsv($handle);
	while( $data = fgetcsv($handle, 512, ';') ) {
		$db->insertRow('station', [
			new DBCol('idImpianto', intval($data[0]), 'd'),
			new DBCol('gestore', $data[1], 's'),
			new DBCol('bandiera', $data[2], 's'),
			new DBCol('tipoImpianto', $data[3], 's'),
			new DBCol('nomeImpianto', $data[4], 's'),
			new DBCol('indirizzo', $data[5], 's'),
			new DBCol('latitudine', floatval($data[8]), 'f'),
			new DBCol('longitudine', floatval($data[9]), 'f'),
			new DBCol(
				'comune_ID',
				get_comune_ID(
					generate_slug($data[6]),
					$data[6],
					$data[7]
				),
				'd'
			)
		] );
	}
	fclose($handle);

	// Prices
	if( ! file_exists(FILENAME_PRICES) ) {
		throw new Exception( _("File dei prezzi non trovato"), 3 );
	}

	if( ! $handle = fopen(FILENAME_PRICES, 'r') ) {
		throw new Exception( _("Impossibile aprire il file dei prezzi"), 4 );
	}

	// Waste first 2 lines
	fgetcsv($handle);
	fgetcsv($handle);

	while( $data = fgetcsv($handle, 255, ';') ) {
		$db->insertRow('price', [
			new DBCol('idImpianto', intval($data[0]), 'd'),
			new DBCol('descCarburante', $data[1], 's'),
			new DBCol('prezzo', floatval($data[2]), 'f'),
			new DBCol('isSelf', intval($data[3]), 'd'),
			new DBCol('dtComu', $data[4], 's')
		] );
	}

	fclose($handle);

} catch(Exception $e) {
	$error_code = $e->getCode();
	$error_message = $e->getMessage();
}

echo json_encode( [
	'error' => $error_code,
	'errorMessage' => $error_message
] );
