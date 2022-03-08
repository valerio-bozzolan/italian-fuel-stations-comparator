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

require 'load.php';

get_header('about');
?>
<div class="container">
	<?php print_title('about') ?>
	<div class="section">
		<h2><?= __("Il team “Il Cloud non esiste”") ?></h2>
		<p class="flow-text"><?= __("“Il Cloud non esiste” è il team che in 24 ore ha realizzato il progetto vincitore dell'Hackaton di Facile.it 2015 presentando un comparatore di prezzi dei carburanti basato su OpenStreetMap ed Open Data ministeriali.") ?></p>
		<div class="row">
			<div class="col s12 m6">
				<p><?= HTML::a(
					'http://web.archive.org/web/20171002220250/http://www.impresamia.com/assicurazioni-il-cloud-non-esiste-vince-facilehack-il-primo-hackathon-dedicato-allinnovazione-tecnologica/',
					mdi_icon('grade') . sprintf( __("Articolo su %s"), "Impresa Mia" ),
					sprintf( __("Leggi l'articolo su %s"), "Impresa Mia" ),
					'btn orange waves-effect waves-white',
					'target="_blank"'
				) ?></p>
			</div>
			<div class="col s12 m6">
				<p><?= HTML::a(
					'https://web.archive.org/web/20151116162409/https://www.lastampa.it/2015/11/16/tecnologia/tra-polizze-e-benzina-a-milano-il-primo-hackathon-dedicato-alle-assicurazioni-337uUvCxr5uAfjLdbdIYYL/pagina.html',
					mdi_icon('grade') . sprintf( __("Articolo su %s"), "La Stampa" ),
					sprintf( __("Leggi l'articolo su %s"), "La Stampa" ),
					'btn orange waves-effect waves-white',
					'target="_blank"'
				) ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Valerio Bozzolan</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('boz@reyboz.it') ?>" alt="Valerio Bozzolan" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("No-sleep Lead Developer") ?></strong><br />
								<?= __("Sviluppo del frontend in PHP, MySQL e JavaScript.") ?>
							</p>
						</div>
					</div>
					<p><?= get_in_touch('https://boz.reyboz.it', "Valerio Bozzolan") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Fabio Bottan</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('fabio bottan') ?>" alt="Fabio Bottan" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("Developer - DBA & Marketing Specialist") ?></strong><br />
								<?= __("Sviluppo dell'importatore-bridge in PHP, MySQL fra i dati dello Sviluppo Economico. Presentatore del progetto.") ?>
							</p>
						</div>
					</div>
					<p><?= get_in_touch('https://it.linkedin.com/in/fabio-bottan-7a15b05a', "Fabio Bottan") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Marcelino Franchini</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('marcelino@franchini.email') ?>" alt="Marcelino Franchini" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("Tactical Banana") ?></strong><br />
								<?= __("«Valerio per favore scrivi qui qualcosa di divertente». -Fatto-") ?>
							</p>
						</div>
					</div>
					<p><?= get_in_touch('https://marcelino.franchini.email', "Marcelino Franchini") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Alexander Busta</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('asd') ?>" alt="Alexander Busta" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("Offensive Security Entusiast") ?></strong>
							</p>
						</div>
					</div>
				<!-- <p><?= get_in_touch('#', "Alexander Busta") ?></p> -->
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Cesare de Cal</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('cesare.decal@gmail.com') ?>" alt="Cesare de Cal" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("Junior Hackathon hacker") ?></strong><br />
								<?= __("Smartphone & web developer.") ?>
							</p>
						</div>
					</div>
				<p><?= get_in_touch('http://cesare.io', "Cesare de Cal") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Edoardo de Cal</h3>
					<div class="row valign-wrapper">
						<div class="col s3">
							<img class="responsive-img circle" src="<?= get_gravatar('edoardofrancescodecal@gmail.com') ?>" alt="Edoardo de Cal" />
						</div>
						<div class="col s9">
							<p>
								<strong><?= __("Very Junior Hackathon hacker") ?></strong><br />
								<?= __("Smartphone & web developer.") ?>
							</p>
						</div>
					</div>
				<p><?= get_in_touch('https://github.com/jimbopower', "Edoardo de Cal") ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<h2><?= __("Tecnologie utilizzate") ?></h2>
		<table>
			<thead>
				<tr>
					<th><?= __("Nome tecnologia") ?></th>
					<th><?= __("Ruolo") ?></th>
					<th><?= __("Licenza di software libero") ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Apache</td>
					<td><?= __("Server web") ?></td>
					<td><?= legal_notes('https://www.apache.org/licenses/LICENSE-2.0.html', "Apache 2.0", "Apache") ?></td>
				</tr>
				<tr>
					<td>Boz PHP - Another PHP Framework</td>
					<td><?= __("Framework casereccio in PHP") ?></td>
					<td><?= legal_notes('https://launchpad.net/boz-php-another-php-framework', "GNU AGPL", "Boz PHP - Another PHP Framework") ?></td>
				</tr>
				<tr>
					<td>Debian GNU/Linux</td>
					<td><?= __("Ambiente server GNU/Linux") ?></td>
					<td><?= legal_notes('https://www.debian.org/legal/licenses/', "GNU GPL, GNU LGPL, ..", "Debian GNU/Linux") ?></td>
				</tr>
				<tr>
					<td>jQuery + jQuery UI</td>
					<td><?= __("Libreria JavaScript per l'attraversamento, manipolazione e animazioni del DOM") ?></td>
					<td><?= legal_notes('https://jquery.org/license/', "Licenza jQuery", "jQuery") ?></td>
				</tr>
				<tr>
					<td>Leaflet</td>
					<td><?= __("Libreria JavaScript per mappe interattive") ?></td>
					<td><?= legal_notes('http://leafletjs.com', "Licenza Leaflet", "Leaflet") ?></td>
				</tr>
				<tr>
					<td>Materialize</td>
					<td><?= __("Framework responsivo ispirato al Material Design") ?></td>
					<td><?= legal_notes('http://materializecss.com', "Licenza MIT", "Materialize") ?></td>
				</tr>
				<tr>
					<td>Material Design Icons</td>
					<td><?= __("Set di icone Material Design") ?></td>
					<td><?= legal_notes('https://github.com/google/material-design-icons', "CC By", "Material Design Icons") ?></td>
				</tr>
				<tr>
					<td>MariaDB</td>
					<td><?= __("Sistema di gestione di database relazionali (fork di MySQL)") ?></td>
					<td><?= legal_notes('https://mariadb.org/about/', "GNU GPL", "MariaDB") ?></td>
				</tr>
				<tr>
					<td>Open Data MISE</td>
					<td><?= __("Prezzi praticati e anagrafica degli impianti di carburante dal Ministero dello Sviluppo Economico italiano.") ?></td>
					<td><?= legal_notes('http://www.sviluppoeconomico.gov.it/index.php/it/open-data/elenco-dataset/2032336-carburanti-prezzi-praticati-e-anagrafica-degli-impianti', "Italian Open Data License v2.0",  __("Carburanti - Prezzi praticati e anagrafica degli impianti") ) ?></td>
				</tr>
				<tr>
					<td>OpenStreetMap</td>
					<td><?= __("Mappa collaborativa globale") ?></td>
					<td><?= legal_notes('http://www.openstreetmap.org/copyright', "CC-By-Sa", "OpenStreetMap") ?></td>
				</tr>
				<tr>
					<td>OpenClipArt</td>
					<td><?= __("Logo e favicon") ?></td>
					<td><?= legal_notes('https://openclipart.org/detail/204479/jerrican', __("Pubblico dominio"), "OpenClipArt") ?></td>
				</tr>
				<tr>
					<td>PHP</td>
					<td><?= __("Pre-processore di ipertesti") ?></td>
					<td><?= legal_notes('http://www.php.net/license/', __("Licenza PHP"), "PHP") ?></td>
				</tr>
				<tr>
					<td>Reveal.JS</td>
					<td><?= __("Software di presentazione HTML utilizzato per presentare il progetto all'hackaton") ?></td>
					<td><?= legal_notes('http://lab.hakim.se/reveal-js/', __("Licenza Reveal.JS"), "Reveal.JS") ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col s12 m6">
			<p><?= HTML::a(URL, mdi_icon('location_on') . __("Torna alla mappa"), __("Torna a %s", SITE_NAME), 'btn orange waves-effect waves-white' ) ?></p>
		</div>
		<div class="col s12 m6">
			<p><?= HTML::a('https://launchpad.net/it-fuel-stations-comparator', mdi_icon('share') . __("Clona il codice"), __("Clona"), 'btn red waves-effect waves-white' ) ?></p>
		</div>
	</div>
</div>
<?php get_footer();
