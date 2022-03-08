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

/*
 * The map
 */

require 'load.php';

enqueue_css('leaflet');
enqueue_css('my-fuel-map');

foreach($JQUERY_UI_PARTS as $part) {
	enqueue_js("jquery.ui.$part");
}

enqueue_js('leaflet');
enqueue_js('leaflet.bouncemarker');

enqueue_js('my-fuel-map.l10n');
enqueue_js('my-fuel-map');

get_header('map');

$last_price_rfc3339 = last_price_date(DateTime::RFC3339);
$last_price_text    = last_price_date();
?>
<div id="overworld">
	<div class="card-panel">
		<h1 class="hide-on-small-only"><?= HTML::a( ROOT . _, SITE_NAME, SITE_DESCRIPTION, 'orange-text') ?></h1>
		<h5 class="hide-on-med-and-up"><?= HTML::a( ROOT . _, SITE_NAME, SITE_DESCRIPTION, 'orange-text') ?></h5>
		<noscript>
			<p><?= __("È necessario abilitare JavaScript. Tranquillo, viene utilizzato escusivamente software libero.") ?></p>
		</noscript>
		<p><?php printf(
			_("Quant'è la quantità di carburante che ottieni spendendo %2\$s euro? Confronta velocemente %s stazioni di rifornimento."),
			HTML::tag(
				'b',
				// TODO: avoid full table scan
				query_value(
					"SELECT COUNT(*) as count FROM {$T('station')}",
					'count'
				),
				HTML::property('class', 'station-counter')
			),
			'<b>40</b>'
		) ?></p>
		<p class="last-update"><?php printf(
			_("Ultimo aggiornamento: %s."),
			"<time datetime=\"$last_price_rfc3339\">$last_price_text</time>"
		) ?></p>
		<div class="divider"></div>
		<div class="section">
			<a class="btn blue waves-effect waves-white" href="<?= ROOT ?>/about.php" title="<?= esc_attr( __("Maggiori informazioni") ) ?>"> <?= __("Maggiori info") . mdi_icon('info', 'right') ?></a>
			<button class="btn orange close-overworld waves-effect waves-white"> <?= __("Socchiudi scheda") . mdi_icon('close', 'right') ?></button>
		</div>
		<div class="divider"></div>
		<form action="#" method="get">
			<div class="input-field">
				<i class="material-icons prefix">navigation</i>
				<input type="text" name="search_address" placeholder="<?= esc_attr( __("Cerca un indirizzo") ) ?>" />
			</div>
		</form>
	</div>
</div>
<div id="overworld-buttons">
	<a class="btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">navigation</i></a>
</div>
<div id="map"></div>
<div id="modal-search-addr-results" class="modal">
	<div class="modal-content container">
		<h4><?= __("Risultati ricerca") ?></h4>
		<ol></ol>
	</div>
</div>
<?php
get_footer();
