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
 * The map
 */

require 'load.php';

expect('db');

enqueue_css('leaflet');
enqueue_css('my-fuel-map');
enqueue_js('jquery.ui');
enqueue_js('leaflet');
enqueue_js('leaflet.bouncemarker');
enqueue_js('my-fuel-map');

get_header('map');

$last_price_rfc3339 = last_price_date(DateTime::RFC3339);
$last_price_text    = last_price_date();
?>
<div id="overworld">
	<div class="card-panel">
		<h1 class="hide-on-small-only"><?php echo HTML::a(
			URL,
			SITE_NAME,
			SITE_DESCRIPTION,
			'orange-text'
		) ?></h1>
		<h5 class="hide-on-med-and-up"><?php echo HTML::a(
			URL,
			SITE_NAME,
			SITE_DESCRIPTION,
			'orange-text'
		) ?></h5>
		<p><?php printf(
			_("Confronta velocemente i prezzi fra %s stazioni di rifornimento."),
			HTML::tag(
				'b',
				$db->getValue(
					"SELECT COUNT(*) as count FROM {$db->getTable('station')}",
					'count'
				),
				HTML::property('class', 'station-counter')
			)
		) ?></p>
		<p class="last-update"><?php printf(
			_("Ultimo aggiornamento: %s."),
			"<time datetime=\"$last_price_rfc3339\">$last_price_text</time>"
		) ?></p>
		<form action="#" method="get">
			<div class="input-field">
				<i class="material-icons prefix">navigation</i>
				<input type="text" name="search_address" placeholder="<?php _esc_attr( _("Cerca un indirizzo") ) ?>" />
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
		<h4><?php _e("Risultati ricerca") ?></h4>
		<ol></ol>
	</div>
</div>
<script type="text/javascript">
var L10N = {
	errorSent: "<?php _esc_attr( _("La tua segnalazione è preziosa. Per ora però sara ignorata <_<") ) ?>",
	addedToFavorites: "<?php _esc_attr( _("Aggiunta ai preferiti... Se funzionassero <_<") ) ?>",
	noLocation: "<?php _esc_attr( _("Posizione non disponibile.") ) ?>",
	pleaseZoomIn: "<?php _esc_attr( _("Trova la tua zona, zomma!") ) ?>",
	errorTooStations: "<?php _esc_attr( _("Vedo molte stazioni. Fai zoom per scoprirle") ) ?>",
	noStations: "<?php _esc_attr( _("Nessuna pompa di benzina in questa zona") ) ?>",
	tooStations: "<?php _esc_attr( _("Fai zoom! Qui ci sono {n} stazioni") ) ?>",
	litersEuros: "<?php _esc_attr( _("Litri ogni {euro} € per {station}") ) ?>",
	actionFavorites: "<?php _esc_attr( _("Preferiti") ) ?>",
	actionError: "<?php _esc_attr( _("Segnala errore") ) ?>",
	noAddressFound: "<?php _esc_attr( _("Nessun indirizzo trovato. Riprova con parole più semplici.") ) ?>"
};
</script>
<?php
get_footer();
