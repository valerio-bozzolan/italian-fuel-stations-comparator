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

// Customizing Boz PHP - Another PHP framework

define('INCLUDES', 'includes');
define('MATERIALIZE', INCLUDES . _ . 'materialize');
define('JQUERY', INCLUDES . _ . 'jquery');
define('LEAFLET', INCLUDES . _ . 'leaflet');

// Load functions
require ABSPATH . _ . INCLUDES . '/functions.php';
require ABSPATH . _ . INCLUDES . '/header.php';
require ABSPATH . _ . INCLUDES . '/footer.php';

// Choose language
switch( $lang = @ $_GET['l'] ) {
	case 'en_US':
	case 'it_IT':
		gettext_rocks($lang);
		break;
	default:
		// Choose from browser settings
		switch( substr(@$_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) ) {
			case 'it':
				gettext_rocks('it_IT');
				break;
			default:
				gettext_rocks('en_US');
		}
}

define('SITE_NAME', _("Compara carburanti") );
define('SITE_DESCRIPTION', _("Confronta i prezzi dei carburanti") );

register_js(
	'jquery',
	URL . _ . JQUERY . '/jquery-2.1.4.min.js'
);

register_js(
	'jquery.ui',
	URL . _ . INCLUDES . '/jquery-ui/jquery-ui.min.js'
);

register_js(
	'materialize',
	URL . _ . MATERIALIZE . '/js/materialize.min.js'
);

register_js(
	'leaflet',
	URL . _ . LEAFLET . '/leaflet.js'
);

register_js(
	'leaflet.bouncemarker',
	URL . _ . INCLUDES . '/leaflet.bouncemarker/bouncemarker.js'
);

register_js(
	'my-facile',
	URL . _ . INCLUDES . '/facile.js'
);

register_css(
	'materialize',
	URL . _ . MATERIALIZE . '/css/materialize.min.css'
);

register_css(
	'leaflet',
	URL . _ . LEAFLET . '/leaflet.css'
);

register_css(
	'my-facile',
	URL . _ . INCLUDES . '/facile.css'
);

register_css(
	'materialize.icons',
	'https://fonts.googleapis.com/icon?family=Material+Icons'
);

add_menu_entries([
	new MenuEntry(
			'map',
			URL,
			_("La mappa")
	),
	new MenuEntry(
			'about',
			URL . '/about.php',
			_("Informazioni sulla piattaforma")
	)
]);
