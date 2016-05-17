<?php
# Italian petrol pumps comparator - Project born (and winner) at hackaton Facile.it 2015
# Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

// Customizing Boz PHP - Another PHP framework
expect('menu');

define('INCLUDES', 'includes');
define('IMAGES', 'images');
define('MATERIALIZE', INCLUDES . _ . 'materialize');
define('LEAFLET', INCLUDES . _ . 'leaflet');

$JQUERY_UI_PARTS = [
	'core',
	'widget',
	'mouse',
	'position',
	'autocomplete',
	'button',
	'dialog',
	'effect',
	'effect-drop'
];

// Load functions
require ABSPATH . _ . INCLUDES . '/functions.php';
require ABSPATH . _ . INCLUDES . '/classes.php';
require ABSPATH . _ . INCLUDES . '/header.php';
require ABSPATH . _ . INCLUDES . '/footer.php';

// Choose language
switch( $lang = @$_GET['l'] ) {
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
			case 'en':
				gettext_rocks('en_US');
				break;
			default:
				gettext_rocks('en_US');
		}
}

define('SITE_NAME', _("Compara carburanti") );
define('SITE_DESCRIPTION', _("Confronta i prezzi dei carburanti") );

// libjs-jquery
register_js(
	'jquery',
	ROOT . '/javascript/jquery/jquery.min.js'
);

// libjs-jquery-ui
foreach($JQUERY_UI_PARTS as $part) {
	register_js(
		"jquery.ui.$part",
		ROOT . "/javascript/jquery-ui/ui/jquery.ui.$part.min.js"
	);
}

register_js(
	'materialize',
	ROOT . _ . MATERIALIZE . '/js/materialize.min.js'
);

register_js(
	'leaflet',
	ROOT . _ . LEAFLET . '/leaflet.js'
);

register_js(
	'leaflet.bouncemarker',
	ROOT . _ . INCLUDES . '/leaflet.bouncemarker/bouncemarker.js'
);

register_js(
	'my-fuel-map',
	ROOT . _ . INCLUDES . '/scripts.js'
);

register_css(
	'materialize',
	ROOT . _ . MATERIALIZE . '/css/materialize.min.css'
);

register_css(
	'leaflet',
	ROOT . _ . LEAFLET . '/leaflet.css'
);

register_css(
	'my-fuel-map',
	ROOT . _ . INCLUDES . '/style.css'
);

register_css(
	'materialize.icons',
	ROOT . _ . INCLUDES . '/googlefonts/material-icons.css'
);

add_menu_entries([
	new MenuEntry('map',   URL,                _("Mappa carburanti") ),
	new MenuEntry('about', URL . '/about.php', _("Informazioni sulla piattaforma") )
]);
