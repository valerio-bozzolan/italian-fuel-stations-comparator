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

function get_header($uid, $args = array()) {
	$args = merge_args_defaults($args, [
		'theme' => 'default'
	] );

	switch($args['theme']) {
		case 'default':
			enqueue_css('materialize');
			enqueue_css('materialize.icons');
			enqueue_js('jquery');
			enqueue_js('materialize');
			break;
	}

	header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo SITE_NAME ?> - <?php echo get_menu_entry($uid)->name ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="icon" type="image/jpeg" href="<?php echo URL . _ . IMAGES . '/fuel-64px.png' ?>" /><?php load_module('theme-header') ?>

</head>
<!--
 This website is
  _____                                          _             _____                            _
 |  ___|  _ __    ___    ___      __ _   ___    (_)  _ __     |  ___|  _ __    ___    ___    __| |   ___    _ __ ___
 | |_    | '__|  / _ \  / _ \    / _` | / __|   | | | '_ \    | |_    | '__|  / _ \  / _ \  / _` |  / _ \  | '_ ` _ \
 |  _|   | |    |  __/ |  __/   | (_| | \__ \   | | | | | |   |  _|   | |    |  __/ |  __/ | (_| | | (_) | | | | | | |
 |_|     |_|     \___|  \___|    \__,_| |___/   |_| |_| |_|   |_|     |_|     \___|  \___|  \__,_|  \___/  |_| |_| |_|

 Learn more from:

 http://www.gnu.org

-->
<body>
<?php
}

function print_title($uid) {
	$menuEntry = get_menu_entry($uid);
	echo "<h1>" . HTML::a(
		$menuEntry->url,
		$menuEntry->name,
		$menuEntry->get('description')
	) . "</h1>\n";
}
