<?php
# Italian petrol pumps comparator - Project born (and winner) at hackaton Facile.it 2015
# Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
# Copyright (C) 2022 Valerio Bozzolan
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

// this file should not be visited directly
if( !defined( 'URL' ) ) {
	exit;
}

// customizing suckless-php
define( 'INCLUDES', 'includes' );
define( 'IMAGES',   'images' );
define( 'MATERIALIZE', INCLUDES . _ . 'materialize' );
define( 'LEAFLET',     INCLUDES . _ . 'leaflet' );

$JQUERY_UI_PARTS = [
	'core',
];

$JQUERY_UI_WIDGETS = [
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
require ABSPATH . __ . INCLUDES . '/functions.php';
require ABSPATH . __ . INCLUDES . '/classes.php';
require ABSPATH . __ . INCLUDES . '/header.php';
require ABSPATH . __ . INCLUDES . '/footer.php';

// Choose language
switch( $lang = @$_GET['l'] ) {
	case 'en_US':
	case 'it_IT':
		apply_language( $lang );
		break;
	default:
		apply_language();
}

define('SITE_NAME',        __("Compara carburanti") );
define('SITE_DESCRIPTION', __("Confronta i prezzi dei carburanti") );

// libjs-jquery
register_js(
	'jquery',
	'/javascript/jquery/jquery.min.js'
);

// apt install libjs-jquery-ui
foreach( $JQUERY_UI_PARTS as $part ) {
	register_js(
		"jquery.ui.$part",
		"/javascript/jquery-ui/ui/$part.min.js"
	);
}

// apt install libjs-jquery-ui
foreach( $JQUERY_UI_WIDGETS as $part ) {
	register_js(
		"jquery.ui.$part",
		"/javascript/jquery-ui/ui/widgets/$part.min.js"
	);
}

register_js(
	'materialize',
	MATERIALIZE . '/js/materialize.min.js'
);

register_js(
	'leaflet',
	'/javascript/leaflet/leaflet.js'
);

register_js(
	'leaflet.bouncemarker',
	INCLUDES . '/leaflet.bouncemarker/bouncemarker.js'
);

register_js(
	'my-fuel-map.l10n',
	'api/L10n.scripts.js.php'
);

register_js(
	'my-fuel-map',
	INCLUDES . '/scripts.js'
);

register_css(
	'materialize',
	MATERIALIZE . '/css/materialize.min.css'
);

register_css(
	'leaflet',
	'/javascript/leaflet/leaflet.css'
);

register_css(
	'my-fuel-map',
	INCLUDES . '/style.css'
);

register_css(
	'materialize.icons',
	INCLUDES . '/googlefonts/material-icons.css'
);

add_menu_entries( [
	new MenuEntry( 'map',   '',          __("Mappa carburanti")               ),
	new MenuEntry( 'about', 'about.php', __("Informazioni sulla piattaforma") ),
] );
