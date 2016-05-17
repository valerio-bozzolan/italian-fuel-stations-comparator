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

require '../load.php';

header('Content-Type: application/javascript');

?>
/* Localized using GNU Gettext. Help translate using Poedit: <?php echo URL ?>/l10n/ */
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
