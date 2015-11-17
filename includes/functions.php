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
 * It do what it's written.
 * @param float $latitude1
 * @param float $longitude1
 * @param float $latitude2
 * @param float $longitude2
 * @return float Meters
 */
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

function get_in_touch($url, $who) {
	return HTML::a($url, mdi_icon('perm_contact_calendar') . _("Entra in contatto"), sprintf( _("Mettiti in contatto con %s"), $who ), 'waves-effect waves-teal btn');
}

function legal_notes($url, $license, $project) {
	return HTML::a($url, $license, sprintf( _("Informazioni legali su %s"), $project ), 'waves-effect waves-teal btn-flat' );
}

function mdi_icon($uid, $class = 'left') {
	return "<i class=\"material-icons $class\">$uid</i>";
}
