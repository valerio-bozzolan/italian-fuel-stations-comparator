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
 * It does what it's written.
 *
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
	return HTML::a($url, mdi_icon('perm_contact_calendar') . __("Entra in contatto"), sprintf( __("Mettiti in contatto con %s"), $who ), 'waves-effect waves-teal btn');
}

function legal_notes($url, $license, $project) {
	return HTML::a($url, $license, sprintf( __("Informazioni legali su %s"), $project ) );
}

/**
 * Material Design Icon
 */
function mdi_icon($uid, $class = 'left') {
	return "<i class=\"material-icons $class\">$uid</i>";
}

/**
 * Get the last update price.
 *
 * Has a cache.
 *
 * @param string $format DateTime format.
 * @return string Formatted date.
 */
function last_price_date($format = 'd/m/Y H:i') {
	static $lastdate = false;

	if($lastdate === false) {
		$lastdate = query_value(
			"SELECT MAX(price_date) AS lastdate FROM {$GLOBALS[T]('price')}",
			'lastdate'
		);
	}

	if( !$lastdate ) {
		return 'errore ( il ministero ha spaccato il dataset? https://gitpull.it/T755 )';
	}

	$d = DateTime::createFromFormat('Y-m-d H:i:s', $lastdate);
	return $d->format($format);
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = '//www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&amp;d=$d&amp;r=$r";
	if($img) {
		$url = '<img src="' . $url . '"';
		foreach($atts as $key => $val) {
			$url .= ' ' . $key . '="' . $val . '"';
		}
		$url .= ' />';
	}
	return $url;
}
