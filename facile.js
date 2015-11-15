var map;
var euros = 40;
var errortooresults = true;
var trovalatuazona = true;
var nessunfornitore = true;
var impianti = [];
var ZOOM_OPENING_SEARCH_RESULT = 17;
var Overworld = {
	$el: undefined,
	$action: undefined,
	visible: true,
	running: false,
	hide: function() {
		if(Overworld.running) {
			return;
		}
		Overworld.running = true;

		Overworld.$el.hide("drop", {direction: "up"}, "slow", function() {
			Overworld.$action.show("drop", {direction: "up"}, "fast", function() {
				Overworld.running = false;
			});
		});	
	},
	show: function() {
		if(Overworld.running) {
			return;
		}
		Overworld.running = true;

		map.closePopup();

		Overworld.$el.find("input").val("");

		Overworld.$action.hide("drop", {direction: "up"}, "slow", function() {
			Overworld.$el.show("drop", {direction: "up"}, "fast", function() {
				Overworld.$el.find("input").focus();
				Overworld.running = false;
			});
		});
	}
};

$(document).ready(function() {

	Overworld.$action = $("#overworld-buttons");
	Overworld.$el	  = $("#overworld"); 
	Overworld.$action.hide().click(function() {
		Overworld.show();
	});

	$("form").submit(function(event) {
		suggest_nominatim_addresses(
			$("input[name=search_address]").val()
		);
		event.preventDefault();
	});

	map = L.map('map');

	// create the tile layer with correct attribution
	var osmUrl='http://{s}.tile.osm.org/{z}/{x}/{y}.png';
	var osmAttrib='Map data Facile.it © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 17, attribution: osmAttrib});		
	map.addLayer(osm);

	map.setView([42.5, 12.9], 7);

	map.on("moveend", function() {
		getMarkersInBounds();
		return true;
	});

	map.on("popupopen", function() {
		Overworld.hide();
	});

	fitDocument();

	map.locate({setView: true, enableHighAccuracy: true, maxZoom: 16});
	map.on("locationfound", function(e) {
		var radius = e.accuracy / 2;
		enfatizeLatLng(e.latlng, 2000);
	});
	map.on("locationerror", function(e) {
		Materialize.toast("Posizione non disponibile. Zomma!", 3000);
	});

	getMarkersInBounds();
});

function getMarkersInBounds(preCallback, postCallback) {

	var zoom = map.getZoom();

	if(zoom < 13) {
		trovalatuazona && Materialize.toast("Trova la tua zona, zomma!", 3000);
		trovalatuazona = false;
		return;
	}

	trovalatuazona = true;

	var bounds = map.getBounds();
	var data = {};
	data.lat_n = bounds.getNorth();
	data.lat_s = bounds.getSouth();
	data.lng_w = bounds.getWest();
	data.lng_e = bounds.getEast();

	$.getJSON(
		"/api/bounds.php", data,
		function(json) {
			if(json.error) {
				errortooresults && Materialize.toast("Vedo molte stazioni. Zomma per scoprirle!", 2000);
				errortooresults = false;
				return;
			}
			errortooresults = true;

			if(json.length === 0) {
				nessunfornitore && Materialize.toast("Nessun fornitore in questa zona", 2000);
				nessunfornitore = false;
				return;
			}
			nessunfornitore = true;

			if(json.length > 90) {
				Materialize.toast("Vedo " + json.length  + " risultati! Zooma per scoprirli", 2000);
				return;
			}

			if(preCallback) {
				var r = preCallback(bounds, json);
				if(r === false) {
					return;
				}
			}

			for(var i=0; i<json.length; i++) {
				if( impiantoExists( json[i].idImpianto ) ) {
					//console.log("Esiste già" + json[i].idImpianto);
					continue;
				} else {
					//console.log("Inserito" + json[i].idImpianto);
					impianti.push(json[i].idImpianto);
				}
				var txt = "Litri ogni " + euros + " € per <b>" + json[i].gestore  + "</b>: <br /><table class='prices'>";
				for(var j=0; j<json[i].prezzi.length; j++) {
					txt += "<tr>";
					var litres = (euros/json[i].prezzi[j].prezzo).toFixed(2);
					if(j === 0) {
						txt += "<td><b class='green-text'>" + litres + " L</b></td>";
					} else {
						txt += "<td>" + litres + "</b> L</td>";
					}
					txt += "<td>per il <b>" + json[i].prezzi[j].descCarburante  + "</b></td>";
					txt += "<td>";
					if(json[i].prezzi[j].isSelf === "1") {
						txt += "<em>(self)</em>";
					} else {
						txt += "";
					}
					txt += "</td>";
					txt += "</tr>";	
				}
				txt += "</table>";

				txt += "<p><a href='#' class='add-favorites'>+ PREFERITI</a>";
				txt += "<a href='#' style='float:right; color: red; font-size:0.8em' class='segnala-errore'>segnala errore</a></p>";

				L.marker(
					[json[i].latitudine, json[i].longitudine],
					{ 
						bounceOnAdd: true, 
						bounceOnAddOptions: {duration: 500, height: 100}, 
						bounceOnAddCallback: function() {}
					}
				)
				.bindPopup(txt)
				.addTo(map);

			}

			if(postCallback) {
				postCallback(bounds, json);
			}
		}
	);
}

function suggest_nominatim_addresses(query) {
	$.ajax({
		url: "https://nominatim.openstreetmap.org/search",
		jsonp: "nominatimJsonp",
		dataType: "jsonp",
		data: {
			q: query,
			format: "json",
			json_callback: "nominatimJsonp"
		}
	});
}

function nominatimJsonp(json) {
	var $searchResults = $("#modal-search-addr-results");
	var $list = $searchResults.find("ol").empty();

	if(json.length > 0) {
		for(i=0; i<json.length; i++) {
			$list.append(
				$("<li>")
				.append(
					$('<a href="#!">')
					.text(json[i].display_name)
					.data("latLng", {lat: json[i].lat, lng: json[i].lon})
					.data("bounds", json[i].boundingbox)
					.click(function(event) {
						$searchResults.closeModal();
						var latLng = $(this).data("latLng");
						var bounds = $(this).data("bounds");

						var adaptedBounds = [
							[bounds[0], bounds[3]],
							[bounds[1], bounds[2]]
						];

						map.fitBounds(
							adaptedBounds
						);

						getMarkersInBounds();

						Overworld.hide();

						event.preventDefault();
					})
				)
				.append(
					$("<br />")
				)
				.append(
					$("<small>")
					.text(json[i].licence)
				)
			);
		}
		// Result links
		$searchResults.find("a").click(function() {
			$searchResults.closeModal();
		});
	} else {
		$list.append( $("<li>").text( "Nessun indirizzo trovato" ) );
	}
	$searchResults.openModal();
}

function enfatizeLatLng(latLng, duration) {
	duration = duration || 2000;
	var circle  = L.circle(latLng, 100).addTo(map);
	window.setTimeout(function () {
		map.removeLayer(circle);
	}, duration);
}

function fitDocument() {
	var w = $("body").width();
	var h = $("body").height();
	$("#map").width( w ).height( h );
}

$(window).resize(function() {
	setTimeout(fitDocument, 500);
	setTimeout(fitDocument, 2000);
	setTimeout(fitDocument, 4000);
});

$(document).on("click", ".add-favorites", function() {
	Materialize.toast("Aggiunto ai tuoi preferiti. Facile!", 3000);
});

$(document).on("click", ".segnala-errore", function() {
	Materialize.toast("La tua segnalazione è preziosa. Grazie!", 3000);
});

function impiantoExists(idImpianto) {
	for(var i=0; i<impianti.length; i++) {
		if(impianti[i] === idImpianto) {
			return true;
		}
	}
	return false;
}
