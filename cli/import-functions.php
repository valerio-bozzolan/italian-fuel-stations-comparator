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

/**
 * Fu**ing increase performance
 */
function dichotomic_property_in_array($heystack, $needle, $compare_field, $return_existing_field = null, & $i) {
	if( $return_existing_field === null ) {
		$return_existing_field = $compare_field;
	}

	$i = 0;
	$inf = 0;
	$n = count($heystack);
	$sup = $n - 1;
	$val = null;

	while($inf <= $sup) {
		$i = (int) ( ($inf + $sup) / 2 );
		$val = $heystack[$i]->{$compare_field};

		if( $val === $needle ) {
			return $heystack[$i]->{$return_existing_field};
		} elseif($needle > $val) {
			$inf = $i + 1;
		} else {
			$sup = $i - 1;
		}
	}

	if($val !== null && $needle > $val) {
		// Please insert after this
		$i++;
	}

	return false;
}

/*
 * Insert an element in an array maintaining ordered indexes
 * Assuming 0 < $here < count($heystack)
 */
function insert_here(& $heystack, $insert, $here) {
	$n = count($heystack);
	for($i=$n; $i>$here; $i--) {
		$heystack[$i] = $heystack[$i-1];
	}
	$heystack[ $here ] = $insert;
}

function get_station_ID($station_miseID, $station_name = null, $station_type = null, $station_address = null, $station_lat = null, $station_lon = null, $comune_ID = null, $stationowner_ID = null, $fuelprovider_ID = null) {
	global $db, $stations;

	$station_ID = dichotomic_property_in_array($stations, $station_miseID, 'station_miseID', 'station_ID', $here);
	if($station_ID !== false) {
		return $station_ID;
	}

	if( $station_name === null ) {
		throw new Exception( _("La stazione miseID %d doveva essere già stata inserita"), $station_miseID );
	}

	if($station_type ===  'Altro') {
		$station_type = 'ALTRO';
	} elseif($station_type === 'Strada Statale') {
		$station_type = 'STRADA_STATALE';
	} elseif($station_type === 'Autostradale') {
		 $station_type = 'AUTOSTRADALE';
	} else {
		throw new Exception( sprintf( "Tipo di stazione non prevista: %s", esc_html( $station_type ) ) );
	}

	$db->insertRow('station', [
		new DBCol('station_miseID',  $station_miseID,  'd'),
		new DBCol('station_name',    $station_name,    's'),
		new DBCol('station_type',    $station_type,    's'),
		new DBCol('station_address', $station_address, 's'),
		new DBCol('station_lat',     $station_lat,     'f'),
		new DBCol('station_lon',     $station_lon,     'f'),
		new DBCol('comune_ID',       $comune_ID,       'd'),
		new DBCol('stationowner_ID', $stationowner_ID, 'd'),
		new DBCol('fuelprovider_ID', $fuelprovider_ID, 'd')
	] );

	$station = $db->getRow(
		sprintf(
			"SELECT station_ID, station_miseID " .
			"FROM {$db->getTable('station')} " .
			"WHERE station_ID = %d",
			$db->getLastInsertedID()
		),
		'Station'
	);

	insert_here($stations, $station, $here);

	return $station->station_ID;
}

function get_comune_ID($comune_uid, $comune_name, $provincia_name) {
	global $db, $comuni;

	$comune_ID = dichotomic_property_in_array($comuni, $comune_uid, 'comune_uid', 'comune_ID', $here);
	if($comune_ID !== false) {
		return $comune_ID;
	}

	$db->insertRow('comune', [
		new DBCol('comune_uid',  $comune_uid,  's'),
		new DBCol('comune_name', $comune_name, 's')
	] );

	$comune = $db->getRow(
		sprintf(
			"SELECT comune_ID, comune_uid " .
			"FROM {$db->getTable('comune')} " .
			"WHERE comune_ID = %d",
			$db->getLastInsertedID()
		),
		'Comune'
	);

	insert_here($comuni, $comune, $here);

	$db->insertRow('rel_provincia_comune', [
		new DBCol(
			'provincia_ID',
			get_provincia_ID(
				generate_slug($provincia_name),
				$provincia_name
			),
			'd'
		),
		new DBCol('comune_ID', $comune->comune_ID, 'd')
	] );

	return $comune->comune_ID;
}

function get_fuelprovider_ID($fuelprovider_uid, $fuelprovider_name) {
	global $db, $fuelproviders;

	$fuelprovider_ID = dichotomic_property_in_array($fuelproviders, $fuelprovider_uid, 'fuelprovider_uid', 'fuelprovider_ID', $here);
	if($fuelprovider_ID !== false) {
		return $fuelprovider_ID;
	}

	$db->insertRow('fuelprovider', [
		new DBCol('fuelprovider_uid',  $fuelprovider_uid,  's'),
		new DBCol('fuelprovider_name', $fuelprovider_name, 's')
	] );

	$fuelprovider = $db->getRow(
		sprintf(
			"SELECT fuelprovider_ID, fuelprovider_uid " .
			"FROM {$db->getTable('fuelprovider')} " .
			"WHERE fuelprovider_ID = %d",
			$db->getLastInsertedID()
		),
		'Fuelprovider'
	);

	insert_here($fuelproviders, $fuelprovider, $here);

	return $fuelprovider->fuelprovider_ID;
}
function get_stationowner_ID($stationowner_uid, $stationowner_name) {
	global $db, $stationowners;

	// Lol
	if( ($pos = strpos($stationowner_name, ' IL REGISTRO IMPRESE NON GARANTISCE') )  !== false )  {
		$stationowner_name = substr($stationowner_name, 0, $pos);
		$stationowner_uid = generate_slug( $stationowner_name );
		$stationowner_note = substr($stationowner_name, $pos);
	} else {
		$stationowner_note = null;
	}

	$stationowner_ID = dichotomic_property_in_array($stationowners, $stationowner_uid, 'stationowner_uid', 'stationowner_ID', $here);
	if($stationowner_ID !== false) {
		return $stationowner_ID;
	}

	$db->insertRow('stationowner', [
		new DBCol('stationowner_uid',  $stationowner_uid,  's'),
		new DBCol('stationowner_name', $stationowner_name, 's'),
		new DBCol('stationowner_note', $stationowner_note, 'snull')
	] );

	$stationowner = $db->getRow(
		sprintf(
			"SELECT stationowner_ID, stationowner_uid " .
			"FROM {$db->getTable('stationowner')} " .
			"WHERE stationowner_ID = %d",
			$db->getLastInsertedID()
		),
		'Stationowner'
	);

	insert_here($stationowners, $stationowner, $here);

	return $stationowner->stationowner_ID;
}

function get_fuel_ID($fuel_uid, $fuel_name) {
	global $db, $fuels;

	$fuel_ID = dichotomic_property_in_array($fuels, $fuel_uid, 'fuel_uid', 'fuel_ID', $here);
	if($fuel_ID !== false) {
		return $fuel_ID;
	}

	$db->insertRow('fuel', [
		new DBCol('fuel_uid',  $fuel_uid,  's'),
		new DBCol('fuel_name', $fuel_name, 's')
	] );

	$fuel = $db->getRow(
		sprintf(
			"SELECT fuel_ID, fuel_uid " .
			"FROM {$db->getTable('fuel')} " .
			"WHERE fuel_ID = %d",
			$db->getLastInsertedID()
		),
		'Fuel'
	);

	insert_here($fuels, $fuel, $here);

	return $fuel->fuel_ID;
}

function get_provincia_ID($provincia_uid, $provincia_name) {
	global $db, $provincie;

	$provincia_ID = dichotomic_property_in_array($provincie, $provincia_uid, 'provincia_uid', 'provincia_ID', $here);
	if($provincia_ID !== false) {
		return $provincia_ID;
	}

	$db->insertRow('provincia', [
		new DBCol('provincia_uid',  $provincia_uid,  's'),
		new DBCol('provincia_name', $provincia_name, 's')
	] );

	$provincia = $db->getRow(
		sprintf(
			"SELECT provincia_ID, provincia_uid " .
			"FROM {$db->getTable('provincia')} " .
			"WHERE provincia_ID = %d",
			$db->getLastInsertedID()
		),
		'Provincia'
	);

	insert_here($provincie, $provincia, $here);

	return $provincia->provincia_ID;
}
