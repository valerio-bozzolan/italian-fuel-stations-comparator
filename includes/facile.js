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

var map;
var EUROS = 40;
var errorTooStations = true;
var pleaseZoomIn = true;
var noStations = true;
var Stations = {
	all: [],
	exists: function(id) {
		var i = 0;
		while(i < this.all.length && this.all[i++] !== id);
		return this.all[i-1] === id;
	},
	alreadyAdded: function(id) {
		if( this.exists(id) ) {
			return true;
		}
		this.all.push(id);
		return false;
	}

};
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
	var osmAttrib='© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
	var osm = new L.TileLayer(osmUrl, {maxZoom: 17, attribution: osmAttrib});		
	map.addLayer(osm);

	map.setView([41.49, 13.11], 6);

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

		Overworld.hide();
	});
	map.on("locationerror", function(e) {
		toast( L10n.noLocation );
	});

	getMarkersInBounds();
});

function toast(s) {
	Materialize.toast(s, 3000);
}

function getMarkersInBounds(preCallback, postCallback) {
	if(map.getZoom() < 13) {
		pleaseZoomIn && toast( L10N.pleaseZoomIn );
		pleaseZoomIn = false;
		return;
	}
	pleaseZoomIn = true;

	var bounds = map.getBounds();
	var data = {
		lat_n: bounds.getNorth(),
		lat_s: bounds.getSouth(),
		lng_w: bounds.getWest(),
		lng_e: bounds.getEast()
	};

	$.getJSON("/api/bounds.php", data, function(json) {
		if(json.error) {
			errorTooStations && toast( L10N.errorTooStations );
			errorTooStations = false;
			return;
		}
		errorTooStations = true;

		if(json.length === 0) {
			noStations && toast( L10N.noStations );
			noStations = false;
			return;
		}
		noStations = true;

		if(json.length > 90) {
			toast( L10N.tooStations.formatUnicorn({n: json.length}) );
			return;
		}

		if(preCallback && preCallback(bounds, json) === false ) {
			return;
		}

		var minPriceId = 0;
		var minPrice = 999.0;
		for(var i=0; i<json.length; i++) {
			if( Stations.alreadyAdded( json[i].station_ID ) ) {
				continue;
			}

			var txt = L10N.litersEuros.formatUnicorn({euro: EUROS, station: json[i].stationowner_name});
			txt += "</b>: <br /><table class='prices'>";
			for(var j=0; j<json[i].prices.length; j++) {
				if(json[i].prices[j].price_value < minPrice) {
					minPrice = json[i].prices[j].price_value;
					minPriceId = j;
				}

				txt += "<tr>";
				var litres = (EUROS/json[i].prices[j].price_value).toFixed(2);
				if(j === 0) {
					txt += "<td><b class='green-text'>" + litres + " L</b></td>";
				} else {
					txt += "<td>" + litres + "</b> L</td>";
				}
				txt += "<td>per il <b>" + json[i].prices[j].fuel_name  + "</b></td>";
				txt += "<td>";
				if(json[i].prices[j].price_self) {
					txt += "<em>(self)</em>";
				} else {
					txt += "";
				}
				txt += "</td>";
				txt += "</tr>";	
			}
			txt += "</table>";

			txt += "<p><a href='#' class='add-favorites'>+ " + L10N.actionFavorites + "</a>";
			txt += "<a href='#' style='float:right; color: red; font-size:0.8em' class='segnala-errore'>segnala errore</a></p>";

			var m = L.marker([json[i].station_lat, json[i].station_lon], { 
				bounceOnAdd: true, 
				bounceOnAddOptions: {duration: 500, height: 100}, 
				bounceOnAddCallback: function() {}
			})
			 .bindPopup(txt)
			 .addTo(map)
			 .options;

			m.station_ID = json[i].station_ID;
		}

		postCallback && postCallback(bounds, json);
	});
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
		$list.append( $("<li>").text( L10N.noAddressFound ) );
	}
	$searchResults.openModal();
}

function enfatizeLatLng(latLng, duration, radius) {
	duration = duration || 2000;
	radius = radius || 100;
	var circle  = L.circle(latLng, radius).addTo(map);
	window.setTimeout(function () {
		map.removeLayer(circle);
	}, duration);
}

function fitDocument() {
	var w = $("body").width();
	var h = $("body").height();
	$("#map").width( w ).height( h );
}

// http://stackoverflow.com/questions/610406/javascript-equivalent-to-printf-string-format
String.prototype.formatUnicorn = function() {
	var str = this.toString();
	if(!arguments.length) {
		return str;
	}
	var args = typeof arguments[0],
	args = (("string" == args || "number" == args) ? arguments : arguments[0]);
        for(var arg in args) {
		str = str.replace(RegExp("\\{" + arg + "\\}", "gi"), args[arg]);
	}
	return str;
}

$(window).resize(function() {
	// jQuery's windowResize is a bit crazy
	setTimeout(fitDocument, 500);
	setTimeout(fitDocument, 2000);
	setTimeout(fitDocument, 4000);
});

$(document).on("click", ".add-favorites", function() {
	toast( L10N.addedToFavorites );
});

$(document).on("click", ".segnala-errore", function() {
	toast( L10N.errorSent );
});
