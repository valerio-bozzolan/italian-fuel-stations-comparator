<?php
/*
 * Italian petrol pumps comparator - Project born (and winner) at hackaton Facile.it 2015
 * Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Manually download data from Ministero dello Sviluppo Economico
 * http://www.sviluppoeconomico.gov.it/index.php/it/open-data/elenco-dataset/2032336-carburanti-prezzi-praticati-e-anagrafica-degli-impianti
 *
 * Files:
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/prezzo_alle_8.csv
 * http://www.sviluppoeconomico.gov.it/images/exportCSV/anagrafica_impianti_attivi.csv
 *
 * The files are licensed under the terms of the Italian Open Data License v2.0
 * http://www.dati.gov.it/iodl/2.0/
 */

require '../load.php';
require 'import-functions.php';

//$db->query("TRUNCATE {$db->getTable('rel_provincia_comune')}");
//$db->query("TRUNCATE {$db->getTable('provincia')}");
//$db->query("TRUNCATE {$db->getTable('comune')}");
//$db->query("TRUNCATE {$db->getTable('station')}");
//$db->query("TRUNCATE {$db->getTable('stationowner')}");
//$db->query("TRUNCATE {$db->getTable('fuelprovider')}");
//$db->query("TRUNCATE {$db->getTable('fuel')}");
$db->query("TRUNCATE {$db->getTable('price')}");

$comuni = $db->getResults(
	"SELECT comune_ID, comune_uid FROM {$db->getTable('comune')} ORDER BY comune_uid",
	'Comune'
);
$provincie = $db->getResults(
	"SELECT provincia_ID, provincia_uid FROM {$db->getTable('provincia')} ORDER BY provincia_uid",
	'Provincia'
);
$fuels = $db->getResults(
	"SELECT fuel_ID, fuel_uid FROM {$db->getTable('fuel')} ORDER BY fuel_uid",
	'Fuel'
);
$stations = $db->getResults(
	"SELECT station_ID, station_miseID FROM {$db->getTable('station')} ORDER BY station_miseID",
	'Station'
);
$stationowners = $db->getResults(
	"SELECT stationowner_ID, stationowner_uid FROM {$db->getTable('stationowner')} ORDER BY stationowner_uid",
	'Stationowner'
);
$fuelproviders = $db->getResults(
	"SELECT fuelprovider_ID, fuelprovider_uid FROM {$db->getTable('fuelprovider')} ORDER BY fuelprovider_uid",
	'Fuelprovider'
);

try {
	if( ! isset( $argv[1], $argv[2] ) ) {
		throw new Exception(
			sprintf(
				_("Utilizzo: %s FILE_STAZIONI.csv PREZZI_ALLE_8.csv"),
				esc_html( $argv[0] )
			),
			1
		);
	}

	define('FILENAME_STATIONS', $argv[1]);
	define('FILENAME_PRICES', $argv[2]);

	if( ! file_exists(FILENAME_STATIONS) ) {
		throw new Exception( _("File delle stazioni non trovato"), 2 );
	}

	if( ! $handle = fopen(FILENAME_STATIONS, 'r') ) {
		throw new Exception( _("Impossibile aprire il file delle stazioni"), 3 );
	}

	// Waste first 2 lines
	fgetcsv($handle);
	fgetcsv($handle);
	while( $data = fgetcsv($handle, 512, ';') ) {
		get_station_ID(
			(int) $data[0] /*$station_miseID*/,
			$data[4] /*$station_name*/,
			$data[3] /*$station_type*/,
			$data[5] /*$station_address*/,
			(float) $data[8] /*$station_lat*/,
			(float) $data[9] /*$station_lon*/,
			get_comune_ID(
				generate_slug( $data[6] ) /*$comune_uid*/,
				$data[6] /*$comune_name*/,
				$data[7] /*$provincia_name*/
			),
			get_stationowner_ID(
				generate_slug( $data[1] ) /*$stationowner_uid*/,
				$data[1] /*$stationowner_name*/
			),
			get_fuelprovider_ID(
				generate_slug( $data[2] ) /*$fuelprovider_uid*/,
				$data[2] /*$fuelprovider_name*/
			)
		);
	}
	fclose($handle);

	// Prices
	if( ! file_exists(FILENAME_PRICES) ) {
		throw new Exception( _("File dei prezzi non trovato"), 4 );
	}

	if( ! $handle = fopen(FILENAME_PRICES, 'r') ) {
		throw new Exception( _("Impossibile aprire il file dei prezzi"), 5 );
	}

	// Waste first 2 lines
	fgetcsv($handle);
	fgetcsv($handle);

	while( $data = fgetcsv($handle, 255, ';') ) {
		$db->insertRow('price', [
			new DBCol('price_value', (float) $data[2], 'f'),
			new DBCol('price_self',  (int) $data[3],   'd'),
			new DBCol('price_date',  $data[4],         's'),
			new DBCol(
				'fuel_ID',
				get_fuel_ID(
					generate_slug($data[1]) /*$fuel_uid*/,
					$data[1] /*$fuel_name*/
				),
				'd'
			),
			new DBCol('station_ID', get_station_ID( (int) $data[0] ), 'd')
		] );
	}

	fclose($handle);

} catch(Exception $e) {
	printf(
		_("Errore:\n\t%s.\n"),
		$e->getMessage()
	);
	exit( $e->getCode() );
}
