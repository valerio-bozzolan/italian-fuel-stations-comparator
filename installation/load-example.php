<?php
# Italian petrol pumps comparator - Project born (and winner) at hackaton Facile.it 2015
# Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
# Copyright (C) 2022 Valerio Bozzolan
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

// database info
$database = 'databasename';
$username = 'username';
$password = 'super strong password very long please';
$location = 'localhost';

// Database table prefix
$prefix = '';

// set the ROOT to the URL pointing to this project
// example: if your URL to reach this project is http://example/project set "/project"
// example: if your URL to reach this project is http://example/        set ""
define( 'ROOT', '' );

// set the ABSPATH to the filesystem directory containing the file 'load.php'
// example: "/var/www/project"
define( 'ABSPATH', __DIR__);

// Remove these comments if you want to debug things:
// define( 'DEBUG', true );
// define( 'DEBUG_QUERIES', true );

// Load the suckless-php framework
// if this is missing run this command:
//    git clone https://gitpull.it/source/suckless-php/
require './suckless-php/load.php';
