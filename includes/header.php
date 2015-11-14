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

function get_header($uid, $args = array()) {
	$args = merge_args_defaults(
		$args,
		[
			'theme' => 'default'
		]
	);

	switch($args['theme']) {
		case 'default':
			enqueue_css('materialize');
			enqueue_css('leaflet');
			enqueue_css('my-facile');
			enqueue_js('jquery');
			enqueue_js('leaflet');
			enqueue_js('leaflet.bouncemarker');
			enqueue_js('materialize');
			enqueue_js('my-facile');
			break;
	}

	$menuEntry = get_menu_entry($uid);
	$menuEntry || error( sprintf(
		_("Il menu '%s' non esiste"),
		$uid
	) );

	$title = $menuEntry->extra['title'];
	$desc = $menuEntry->extra['desc'];

	header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo SITE_NAME ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /><?php load_module('theme-header') ?>

</head>
<body>
<div id="overworld">
	<div class="card-panel">
		<h1><?php echo HTML::a(
			$menuEntry->url,
			$title,
			$desc
		) ?></h1>
	</div>
</div>
<?php
}
