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
 * PHP Traits and classes.
 */

trait FuelTrait {
	public static function prepareFuel(& $fuel) {
		if( @$fuel->fuel_ID ) {
			$fuel->fuel_ID = (int) $fuel->fuel_ID;
		}
	}
}

trait ComuneTrait {
	public static function prepareComune(& $comune) {
		if( @$comune->comune_ID ) {
			$comune->comune_ID = (int) $comune->comune_ID;
		}
	}
}

trait FuelproviderTrait {
	public static function prepareFuelprovider(& $fuelprovider) {
		if( @$fuelprovider->fuelprovider_ID ) {
			$fuelprovider->fuelprovider_ID = (int) $fuelprovider->fuelprovider_ID;
		}
	}
}

trait PriceTrait {
	public static function preparePrice(& $price) {
		if( @$price->price_ID ) {
			$price->price_ID = (int) $price->price_ID;
		}

		if( @$price->price_value ) {
			$price->price_value = (float) $price->price_value;
		}

		if( @$price->price_self ) {
			$price->price_self = (bool) $price->price_self;
		}
	}
}

trait ProvinciaTrait {
	public static function prepareProvincia(& $provincia) {
		if( @$provincia->provincia_ID ) {
			$provincia->provincia_ID = (int) $provincia->provincia_ID;
		}
	}
}

trait StationTrait {
	public static function prepareStation(& $station) {
		if( @$station->station_ID ) {
			$station->station_ID = (int) $station->station_ID;
		}

		if( @$station->station_miseID ) {
			$station->station_miseID = (int) $station->station_miseID;
		}

		if( @$station->station_lat ) {
			$station->station_lat = (float) $station->station_lat;
		}

		if( @$station->station_lon ) {
			$station->station_lon = (float) $station->station_lon;
		}
	}
}

trait StationownerTrait {
	public static function prepareStationowner(& $stationowner) {
		if( @$stationowner->stationowner_ID ) {
			$stationowner->stationowner_ID = (int) $stationowner->stationowner_ID;
		}
	}
}

class Comune {
	use ComuneTrait;

	function __construct() {
		self::prepareComune($this);
	}
}

class Fuelprovider {
	use FuelproviderTrait;

	function __Construct() {
		self::prepareFuelprovider($this);
	}
}

class Fuel {
	use FuelTrait;

	function __construct() {
		self::prepareFuel($this);
	}
}

class Price {
	use PriceTrait;

	function __construct() {
		self::preparePrice($this);
	}
}

class Provincia {
	use ProvinciaTrait;

	function __construct() {
		self::prepareProvincia($this);
	}
}

class Station {
	use StationTrait;

	function __construct() {
		self::prepareStation($this);
	}
}

class Stationowner {
	use StationownerTrait;

	function __construct() {
		self::prepareStationowner($this);
	}
}
