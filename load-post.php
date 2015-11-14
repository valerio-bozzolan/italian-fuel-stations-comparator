<?php
/*
 * Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Lasciate questo file intonso per ora
define('INCLUDES', 'includes');
define('MATERIALIZE', INCLUDES . _ . 'materialize');
define('JQUERY', INCLUDES . _ . 'jquery');
define('SITE_NAME', 'Facile.it');

register_js(
	'jquery',
	URL . _ . JQUERY . '/jquery-2.1.4.min.js'
);

register_js(
	'materialize',
	URL . _ . MATERIALIZE . '/js/materialize.min.js'
);

register_css(
	'materialize',
	URL . _ . MATERIALIZE . '/css/materialize.min.css'
);

add_menu_entries([
	new MenuEntry(
			'home',
			URL,
			_("Home"),
			null, [
				'title' => sprintf(
					_("%s carburante"),
					SITE_NAME
				),
				'desc' => _("Confronta e scegli il miglior prezzo")
			]
	)
]);

require ABSPATH . _ . INCLUDES . _ . '/header.php';
require ABSPATH . _ . INCLUDES . _ . '/footer.php';
