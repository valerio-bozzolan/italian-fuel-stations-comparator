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

require __DIR__ . '/../load.php';
require __DIR__ . '/import-mise-functions.php';

//query("TRUNCATE {$T('rel_provincia_comune')}");
//query("TRUNCATE {$T('provincia')}");
//query("TRUNCATE {$T('comune')}");
//query("TRUNCATE {$T('station')}");
//query("TRUNCATE {$T('stationowner')}");
//query("TRUNCATE {$T('fuelprovider')}");
//query("TRUNCATE {$T('fuel')}");
query("TRUNCATE {$T('price')}");

$comuni        = query_results("SELECT comune_ID, comune_uid FROM {$T('comune')}", 'Comune');
$comuni        = indexed_array($comuni, 'comune_uid', 'comune_ID');
$provincie     = query_results("SELECT provincia_ID, provincia_uid FROM {$T('provincia')}", 'Provincia');
$provincie     = indexed_array($provincie, 'provincia_uid', 'provincia_ID');
$fuels         = query_results("SELECT fuel_ID, fuel_uid FROM {$T('fuel')}", 'Fuel');
$fuels         = indexed_array($fuels, 'fuel_uid', 'fuel_ID');
$stations      = query_results("SELECT station_ID, station_miseID FROM {$T('station')}", 'Station');
$stations      = indexed_array($stations, 'station_miseID', 'station_ID');
$stationowners = query_results("SELECT stationowner_ID, stationowner_uid FROM {$T('stationowner')}", 'Stationowner');
$stationowners = indexed_array($stationowners, 'stationowner_uid', 'stationowner_ID');
$fuelproviders = query_results("SELECT fuelprovider_ID, fuelprovider_uid FROM {$T('fuelprovider')}", 'Fuelprovider');
$fuelproviders = indexed_array($fuelproviders, 'fuelprovider_uid', 'fuelprovider_ID');

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
		insert_row('price', [
			new DBCol('price_value', (float) $data[2],          'f'),
			new DBCol('price_self',  (int) $data[3],            'd'),
			new DBCol('price_date',  itdate2datetime($data[4]), 's'),
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
		_("Errore: %s."),
		$e->getMessage()
	);
	echo "\n";
	exit( $e->getCode() );
}
