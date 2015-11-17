<?php
require 'load.php';

get_header('about');
?>
<div class="container">
	<?php print_title('about') ?>
	<div class="section">
		<h2><?php _e("Il Team «Il Cloud non esiste»") ?></h2>
		<p class="flow-text"><?php _e("«Il Cloud non esiste» è il team che in 24 ore ha realizzato il progetto vincitore dell'Hackaton di Facile.it 2015 presentando un comparatore di prezzi dei carburanti.") ?></p>
		<div class="row">
			<div class="col s12 m6">
				<p><?php echo HTML::a(
					'http://www.impresamia.com/assicurazioni-il-cloud-non-esiste-vince-facilehack-il-primo-hackathon-dedicato-allinnovazione-tecnologica/',
					mdi_icon('grade') . sprintf( _("Articolo su %s"), "Impresa Mia" ),
					sprintf( _("Leggi l'articolo su %s"), "Impresa Mia" ),
					'btn orange waves-effect waves-white',
					'target="_blank"'
				) ?></p>
			</div>
			<div class="col s12 m6">
				<p><?php echo HTML::a(
					'https://www.lastampa.it/2015/11/16/tecnologia/tra-polizze-e-benzina-a-milano-il-primo-hackathon-dedicato-alle-assicurazioni-337uUvCxr5uAfjLdbdIYYL/pagina.html',
					mdi_icon('grade') . sprintf( _("Articolo su %s"), "La Stampa" ),
					sprintf( _("Leggi l'articolo su %s"), "La Stampa" ),
					'btn orange waves-effect waves-white',
					'target="_blank"'
				) ?></p>
			</div>
		</div>
		<div class="row">
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Alexander Busta</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('asd') ?>" alt="Alexander Busta" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("Offensive Security Entusiast") ?></strong>
							</p>
						</div>
					</div>
				<p><?php echo get_in_touch('http://cesare.io', "Cesare de Cal") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Cesare de Cal</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('cesare.decal@gmail.com') ?>" alt="Cesare de Cal" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("Junior Hackathon hacker") ?></strong><br />
								<?php _e("Smartphone & web developer.") ?>
							</p>
						</div>
					</div>
				<p><?php echo get_in_touch('http://cesare.io', "Cesare de Cal") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Edoardo de Cal</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('edoardofrancescodecal@gmail.com') ?>" alt="Edoardo de Cal" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("Very Junior Hackathon hacker") ?></strong><br />
								<?php _e("Smartphone & web developer.") ?>
							</p>
						</div>
					</div>
				<p><?php echo get_in_touch('https://github.com/jimbopower', "Edoardo de Cal") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Fabio Bottan</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('fabio bottan') ?>" alt="Fabio Bottan" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("Developer - DBA & Marketing Specialist") ?></strong><br />
								<?php _e("Sviluppo dell'importatore-bridge in PHP, MySQL fra i dati dello Sviluppo Economico. Presentatore del progetto.") ?>
							</p>
						</div>
					</div>
					<p><?php echo get_in_touch('https://it.linkedin.com/in/fabio-bottan-7a15b05a', "Fabio Bottan") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Marcelino Franchini</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('marcelino@franchini.email') ?>" alt="Marcelino Franchini" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("Tactical Banana") ?></strong><br />
								<?php _e("«Valerio per favore scrivi qui qualcosa di divertente». -Fatto-") ?>
							</p>
						</div>
					</div>
					<p><?php echo get_in_touch('https://marcelino.franchini.email', "Marcelino Franchini") ?></p>
				</div>
			</div>
			<div class="col s12 m6 l4">
				<div class="card-panel">
					<h3>Valerio Bozzolan</h3>
					<div class="row">
						<div class="col s3">
							<img class="responsive-img circle" src="<?php echo get_gravatar('boz@reyboz.it') ?>" alt="Valerio Bozzolan" />
						</div>
						<div class="col s9">
							<p>
								<strong><?php _e("No-sleep Tech Orchestrator") ?></strong><br />
								<?php _e("Sviluppo del frontend in PHP, MySQL e JavaScript.") ?>
							</p>
						</div>
					</div>
					<p><?php echo get_in_touch('http://boz.reyboz.it', "Valerio Bozzolan") ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="section">
		<h2><?php _e("Tecnologie utilizzate") ?></h2>
		<table>
			<thead>
				<tr>
					<th><?php _e("Nome tecnologia") ?></th>
					<th><?php _e("Ruolo") ?></th>
					<th><?php _e("Licenza di software libero") ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Apache</td>
					<td><?php _e("Server web") ?></td>
					<td><?php echo legal_notes('https://www.apache.org/licenses/LICENSE-2.0.html', "Apache 2.0", "Apache") ?></td>
				</tr>
				<tr>
					<td>Boz PHP - Another PHP Framework</td>
					<td><?php _e("Framework casereccio in PHP") ?></td>
					<td><?php echo legal_notes('https://launchpad.net/boz-php-another-php-framework', "GNU AGPL", "Boz PHP - Another PHP Framework") ?></td>
				</tr>
				<tr>
					<td>Debian GNU/Linux</td>
					<td><?php _e("Ambiente server GNU/Linux") ?></td>
					<td><?php echo legal_notes('https://www.debian.org/legal/licenses/', "GNU GPL, GNU LGPL, ..", "Debian GNU/Linux") ?></td>
				</tr>
				<tr>
					<td>jQuery + jQuery UI</td>
					<td><?php _e("Libreria JavaScript per l'attraversamento, manipolazione e animazioni del DOM") ?></td>
					<td><?php echo legal_notes('https://jquery.org/license/', "Licenza jQuery", "jQuery") ?></td>
				</tr>
				<tr>
					<td>Leaflet</td>
					<td><?php _e("Libreria JavaScript per mappe interattive") ?></td>
					<td><?php echo legal_notes('http://leafletjs.com', "Licenza Leaflet", "Leaflet") ?></td>
				</tr>
				<tr>
					<td>Materialize</td>
					<td><?php _e("Framework responsivo ispirato al Material Design") ?></td>
					<td><?php echo legal_notes('http://materializecss.com', "Licenza MIT", "Materialize") ?></td>
				</tr>
				<tr>
					<td>Material Design Icons</td>
					<td><?php _e("Set di icone Material Design") ?></td>
					<td><?php echo legal_notes('https://github.com/google/material-design-icons', "CC By", "Material Design Icons") ?></td>
				</tr>
				<tr>
					<td>MySQL</td>
					<td>Relational database management system</td>
					<td><?php echo legal_notes('https://www.mysql.com/products/community/', "GNU GPL", "MySQL") ?></td>
				</tr>
				<tr>
					<td>Open Data MISE</td>
					<td><?php _e("Prezzi praticati e anagrafica degli impianti di carburante dal Ministero dello Sviluppo Economico italiano.") ?></td>
					<td><?php echo legal_notes('http://www.sviluppoeconomico.gov.it/index.php/it/open-data/elenco-dataset/2032336-carburanti-prezzi-praticati-e-anagrafica-degli-impianti', "Italian Open Data License v2.0",  _("Carburanti - Prezzi praticati e anagrafica degli impianti") ) ?></td>
				</tr>
				<tr>
					<td>OpenStreetMap</td>
					<td><?php _e("Mappa collaborativa globale") ?></td>
					<td><?php echo legal_notes('http://www.openstreetmap.org/copyright', "CC-By-Sa", "OpenStreetMap") ?></td>
				</tr>
				<tr>
					<td>OpenClipArt</td>
					<td><?php _e("Logo e favicon") ?></td>
					<td><?php echo legal_notes('https://openclipart.org/detail/204479/jerrican', _("Pubblico dominio"), "OpenClipArt") ?></td>
				</tr>
				<tr>
					<td>PHP</td>
					<td><?php _e("Pre-processore di ipertesti") ?></td>
					<td><?php echo legal_notes('http://www.php.net/license/', _("Licenza PHP"), "PHP") ?></td>
				</tr>
				<tr>
					<td>Reveal.JS</td>
					<td><?php _e("Software di presentazione HTML utilizzato per presentare il progetto all'hackaton") ?></td>
					<td><?php echo legal_notes('http://lab.hakim.se/reveal-js/', _("Licenza Reveal.JS"), "Reveal.JS") ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php get_footer();
