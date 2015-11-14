var map;
var impianti = [];
var clickMarker = L.marker();
var roundMarkers = L.layerGroup();
var roundCircle;
var radiusExtra = 400;
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

		Overworld.$el.hide("fast", function() {
			Overworld.$action.show("fast", function() {
				Overworld.running = false;
			});
		});	
	},
	show: function() {
		if(Overworld.running) {
			return;
		}
		Overworld.running = true;

		Overworld.$el.find("input").val("");

		Overworld.$action.hide("fast", function() {
			Overworld.$el.show("fast", function() {
				Overworld.running = false;
			});
		});
	}
};

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {

	var $stationCounter = $(".station-counter");
	var count = parseInt( $stationCounter.text() );
	for(var i=count; i<10; i++) {
	}

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

fitDocument();

// create the tile layer with correct attribution
var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var osmAttrib='Map data Facile.it © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 17, attribution: osmAttrib});		
map.addLayer(osm);
map.addLayer(roundMarkers);

map.setView([42.5, 12.9], 7);

map.on("click", function(e) {
	var popLocation = e.latlng;
	getMarkers(
		popLocation,
		1000,
		function(latLng, radius, json) {
			if(json.length === 0) {
				return false;
			}
		},
		function(latLng, radius, json) {
			if(json.length > 0) {
				console.log(radius);
				map.setView(latLng, radius);
				enfatizeLatLng(latLng, radius);
			}
		}
	);
});

// On ready
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function getMarkers(popLocation, radius, preCallback, postCallback) {
	radius = radius || 900;

	$.getJSON(
		"/api/latlng.php", {
			lat: popLocation.lat,
			lng: popLocation.lng,
			radius: radius
		},
		function(json) {
			console.log(json);

			if(preCallback) {
				var r = preCallback(popLocation, radius, json);
				if(r === false) {
					return;
				}
			}

			for(var i=0; i<json.length; i++) {
				var txt = "<b>" + json[i].gestore + "</b><br />Prezzi: <br /><table class='prices'>";
				for(var j=0; j<json[i].prezzi.length; j++) {
					txt += "<tr>";
					if(j === 0) {
						txt += "<td><b class='green-text'>" + json[i].prezzi[j].prezzo + " €</b></td>";
					} else {
						txt += "<td>" + json[i].prezzi[j].prezzo + "</b> €</td>";
					}
					txt += "<td>per il <b>" + json[i].prezzi[j].descCarburante  + "</b></td>";
					txt += "<td>";
					if(json[i].prezzi[j].isSelf === "1") {
						txt += "<em>self-service</em>";
					} else {
						txt += "";
					}
					txt += "</td>";
					txt += "</tr>";	
				}
				txt += "</table>";

				txt += "<p><a href='#' class='add-favorites'>+ PREFERITI</a></p>";

				L.marker(
					[json[i].latitudine, json[i].longitudine],
					{ 
						bounceOnAdd: true, 
						bounceOnAddOptions: {duration: 500, height: 100}, 
						bounceOnAddCallback: function() {}
					}
				)
				.bindPopup(txt)
				.addTo(roundMarkers);

			}

			if(postCallback) {
				postCallback(popLocation, radius, json);
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
			// @TODO set result bounds
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
	setTimeout(fitDocument, 1000);
	setTimeout(fitDocument, 2000);
	setTimeout(fitDocument, 3000);
	setTimeout(fitDocument, 4000);
});

$(document).on("click", ".add-favorites", function() {
	Materialize.toast("Aggiunto ai tuoi preferiti!", 3000);
});
