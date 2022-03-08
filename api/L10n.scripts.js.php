<?php
# Italian petrol pumps comparator - Project born (and winner) at hackaton Facile.it 2015
# Copyright (C) 2015 Valerio Bozzolan, Marcelino Franchini, Fabio Mottan, Alexander Bustamente, Cesare de Cal, Edoardo de Cal
# Copyright (c) 2022 Valerio Bozzolan
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

require '../load.php';

// TODO: convert this page into a simple register_js_var()
header('Content-Type: application/javascript');

?>
/* Localized using GNU Gettext. Help translate using Poedit: <?= URL ?>/l10n/ */
var L10N = <?= json_encode( [
	'errorSent'        => __("La tua segnalazione è preziosa. Per ora però sara ignorata <_<"),
	'addedToFavorites' => __("Aggiunta ai preferiti... Se funzionassero <_<"),
	'noLocation'       => __("Posizione non disponibile."),
	'pleaseZoomIn'     => __("Avvicinati al suolo"),
	'errorTooStations' => __("Vedo molte stazioni. Fai zoom per scoprirle"),
	'noStations'       => __("Nessuna pompa di benzina in questa zona"),
	'tooStations'      => __("Fai zoom! Qui ci sono {n} stazioni"),
	'litersEuros'      => __("Litri ogni {euro} € per {station}"),
	'actionFavorites'  => __("Preferiti"),
	'actionError'      => __("Segnala errore"),
	'noAddressFound'   => __("Nessun indirizzo trovato. Riprova con parole più semplici."),
] ); ?>;
