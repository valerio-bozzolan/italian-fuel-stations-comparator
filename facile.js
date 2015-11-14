var map;
var clickMarker = L.marker();
var roundMarkers = L.layerGroup();
var radius = 1000;
var radiusExtra = 400;



$(document).ready(function() {

map = L.map('map');

var w = $("body").width();
var h = $("body").height();
$("#map").width( w ).height( h );

// create the tile layer with correct attribution
var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
var osmAttrib='Map data Facile.it © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 17, attribution: osmAttrib});		
map.addLayer(osm);
map.addLayer(roundMarkers);

// start the map in South-East England
map.setView([42.5, 12.9], 7);

map.on("click", function(e) {
	var popLocation= e.latlng;

	map.hasLayer(clickMarker) && map.removeLayer(clickMarker);

        /*
	clickMarker = L.marker(
		popLocation,
		{ 
			bounceOnAdd: true, 
			bounceOnAddOptions: {duration: 500, height: 100}, 
			bounceOnAddCallback: function() {
				console.log("done");
			}
		}
	).addTo(map);
        */

	$.getJSON(
		"/api/latlng.php", {
			lat: popLocation.lat,
			lng: popLocation.lng,
			radius: radius + radiusExtra
		},
		function(json) {
			console.log(json);

			map.setView(popLocation, 15);

			roundMarkers.clearLayers();

			for(var i=0; i<json.length; i++) {
				var txt = "<b>" + json[i].gestore + "</b><br />Prezzi: <br /><table class='prices'>";
				for(var j=0; j<json[i].prezzi.length; j++) {
					txt += "<tr>";
					txt += "<td>" + json[i].prezzi[j].prezzo + "</td>";
					txt += "<td>per il " + json[i].prezzi[j].descCarburante  + "</td>";
					txt += "</tr>";	
				}
				txt += "</table>";

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

			if(json.length > 0) {
				L.circle(popLocation, radius).addTo(roundMarkers);
			}
		}
	);
});

// On ready
});





function suggest_nominatim_addresses(query) {
	showProgressBar();

	$.ajax({
		url: "https://nominatim.openstreetmap.org/search",
		jsonp: "nominatimJsonp",
		dataType: "jsonp",
		data: {
			q: query,
			format: "json",
			json_callback: "nominatimJsonp"
		}
	})
	.always(hideProgressBar)
	.fail(toastForNetworkFail);
}

function nominatimJsonp(json) {
	if(! json) {
		toastForJSONFail();
		return false;
	}

	var $searchResults = $("#modal-search-addr-results");
	var $list = $searchResults.find("ol").empty();

	if(json.length > 0) {
		var h = get_hashtag_params();
		for(i=0; i<json.length; i++) {
			// @TODO set result bounds
			$list.append(
				$("<li>")
				.append(
					$('<a class="set-hashtag-params" href="#!">')
					.data("hashtag", {
						setView: {
							latLng: {lat: json[i].lat, lng: json[i].lon},
							zoom: ZOOM_OPENING_SEARCH_RESULT,
							enfatize: true
						}
					} )
					.text(json[i].display_name)
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
		$list.append( $("<li>").text( L10n.noAddressFound ) );
	}
	$searchResults.openModal();
}

