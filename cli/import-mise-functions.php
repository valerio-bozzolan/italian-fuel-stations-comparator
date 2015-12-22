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

function indexed_array($rows, $property_index, $property_return) {
	$indexed = [];
	foreach($rows as $row) {
		$indexed[ $row->{$property_index} ] = $row->{$property_return};
	}
	return $indexed;
}

function get_station_ID($station_miseID, $station_name = null, $station_type = null, $station_address = null, $station_lat = null, $station_lon = null, $comune_ID = null, $stationowner_ID = null, $fuelprovider_ID = null) {
	global $db, $stations;

	if( isset( $stations[ $station_miseID ] ) ) {
		return $stations[ $station_miseID ];
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

	return $stations[ $station->station_miseID ] = $station->station_ID;
}

function get_comune_ID($comune_uid, $comune_name, $provincia_name) {
	global $db, $comuni;

	if( isset( $comuni[ $comune_uid ] ) ) {
		return $comuni[ $comune_uid ];
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

	return $comuni[ $comune->comune_uid ] = $comune->comune_ID;
}

function get_fuelprovider_ID($fuelprovider_uid, $fuelprovider_name) {
	global $db, $fuelproviders;

	if( isset( $fuelproviders[ $fuelprovider_uid ] ) ) {
		return $fuelproviders[ $fuelprovider_uid ];
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

	return $fuelproviders[ $fuelprovider->fuelprovider_uid ] = $fuelprovider->fuelprovider_ID;
}

function get_stationowner_ID($stationowner_uid, $stationowner_name) {
	global $db, $stationowners;

	if( isset( $stationowners[ $stationowner_uid ] ) ) {
		return $stationowners[ $stationowner_uid ];
	}

	// Lol
	if( ($pos = strpos($stationowner_name, ' IL REGISTRO IMPRESE NON GARANTISCE') )  !== false )  {
		$stationowner_name = substr($stationowner_name, 0, $pos);
		$stationowner_uid = generate_slug( $stationowner_name );
		$stationowner_note = substr($stationowner_name, $pos);
	} else {
		$stationowner_note = null;
	}

	// Another check
	if( isset( $stationowners[ $stationowner_uid ] ) ) {
		return $stationowners[ $stationowner_uid ];
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

	return $stationowners[ $stationowner->stationowner_uid ] = $stationowner->stationowner_ID;;
}

function get_fuel_ID($fuel_uid, $fuel_name) {
	global $db, $fuels;

	if( isset( $fuels[ $fuel_uid ] ) ) {
		return $fuels[ $fuel_uid ];
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

	return $fuels[ $fuel->fuel_uid ] = $fuel->fuel_ID;
}

function get_provincia_ID($provincia_uid, $provincia_name) {
	global $db, $provincie;

	if( isset( $provincie[ $provincia_uid ] ) ) {
		return $provincie[ $provincia_uid ];
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

	return $provincie[ $provincia->provincia_uid ] = $provincia->provincia_ID;
}
