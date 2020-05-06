a_locations = [];

function initClusterer( map )
{
	var a_params = {
		maxZoom: 				16,
		minimumClusterSize: 	5,
		styles: [{
			width: 				55,
			height: 			56,
			textColor: 			"#F15C2D",
			textSize: 			16,
			url: 				"/" + s_theme + "/img/map_clusters/m1.svg",
		}],
	};
	var markerCluster = new MarkerClusterer(map, a_locations, a_params);
}
function initMap( el )
{
	var markers = []; //el.find('.marker');

	// TODO: refactor and make a common component
	var mapArgs = {
		zoom:		el.data('zoom') || 11,
		mapTypeId:	google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map( el[0], mapArgs );
	map.markers = [];

	// get list of markers for map
	// async'ly so that
	// visitors don't have to wait loooooog while page loads
	// with all the data pre-inserted to the page
	// also notify about errors
	$.ajax({
		'type': 'get',
		'url': s_route_list,
		data: {
			length: 10000,
			filters: { published: 1 },
		},
		success: (data, status, xhr) => {
			if (xhr.readyState == 4 && xhr.status == 200)
				try {
					// Do JSON handling here
					tmp = JSON.parse(xhr.responseText);
//console.log(tmp.data.length);
					for (var i = 0; i < tmp.data.length; i++)
					{
//console.log(i, typeof tmp.data[i].rating_info, tmp.data[i].rating_info);
						initMarkerFromJSON(tmp.data[i], map);
					}
				} catch(e) {
					//JSON parse error, this is not json (or JSON isn't in the browser)
					notify(s_servererror_info, 'danger', 3000);
				}
			else
				notify(s_servererror_info, 'danger', 3000);
			initClusterer(map);
		},
		'error': (xhr) => {
			notify(s_servererror_info, 'danger', 3000);
		}
	});

	centerMap( map, el.data('lat'), el.data('lng') );

	$('#findme_btn').bind('click', function() {
		findMe(map);
	});
	var styles = [
		{
			"featureType": "administrative",
			"elementType": "geometry",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "poi",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "transit",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		}
	];
	map.setOptions({styles: styles});
	return map;
}

function getColor( i_percent )
{
	s_color = 'black';
	if (i_percent > 70)
	{
		s_color = 'green';
	}
	else if (i_percent > 35)
	{
		s_color = 'chocolate';
	}
	else if (i_percent > -1)
	{
		s_color = 'red';
	}
	return s_color;
}

function initMarkerFromJSON( data, map )
{
	var lat			= data.lat;
	var lng			= data.lng;
	var a_lat_lng	= {
		lat: parseFloat( lat ),
		lng: parseFloat( lng )
	};

	var s_rating	= '';
	var i_overall	= -1;
	var s_overall	= '';
	var s_latest	= '';
	var s_details	= '';
	if (typeof data.rating_info != "string")
		return 0;

//console.log(data.rating_info);

	try {
		// Do JSON handling here
		o_rating = JSON.parse(data.rating_info);
	} catch(e) {
		console.log('err parsing id=' + data.id);
		//JSON parse error, this is not json (or JSON isn't in the browser)
	}
//console.log(typeof o_rating);
	i_overall		= data.rating_all;

	if (typeof o_rating == 'object')
	{
		if (typeof o_rating.overall.description == "string")
			s_overall	= o_rating.overall.description;
		if (typeof o_rating.overall.details == "string")
			s_details	= o_rating.overall.details;
		if (typeof o_rating.overall.latest_opinion == "string")
			s_latest	= o_rating.overall.latest_opinion;

		for(i = 0; i < o_rating.element.length; i++)
		{
			i_percent	= o_rating['element'][i]['percent'];
			s_color		= getColor(i_percent);
			s_rating		= s_rating
							+ '<p style="color: ' + s_color + ';">'
							+ o_rating['element'][i]['description']
							+ '</p>'
						;
		}
	}

	var s_color		= getColor(i_overall);

	var s_marker_icon = '/' + s_theme + '/img/map_markers/map_marker_bank_' + s_color + '.png';

	var marker		= new google.maps.Marker({
		position: a_lat_lng,
		map: map,
		icon: s_marker_icon,
		title: data.title,
	});

	a_locations.push(marker);

	marker.addListener('click', function() {

			a_params = {
				reverseButtons:		true,
				showCloseButton:	true,
				html: 				''
						+ '<p class="place_title">' + data.title + '</p>'
						+ '<p class="place_latest_opinion">' + s_latest + '</p>'
						+ '<hr>'
						+ '<p class="place_address">' + data.address + '</p>'
						+ '<p class="place_description">' + data.description + '</p>'
						+ '<p class="rating_overall" style="color: ' + s_color + ';">' + s_overall + '</p>'
						+ '<p class="rating_details" style="color: ' + s_color + ';">' + s_details + '</p>'
						,
				footer:				s_rating,
			};
			a_routes = {};

			if (s_text_secondary != '')
			{
				a_params.cancelButtonText	= s_text_secondary;
				a_params.showCancelButton	= true;
				s_route_secondary = s_route_secondary.replace(':type', 'place').replace(':id', data.id);
			}

			if (s_text_extra != '')
			{
				if (typeof data.url !== 'undefined')
					s_route_extra = data.url;
				a_params.footer = '<a href="' + s_route_extra + '">' + s_text_extra + '</a>';
			}
			if (s_text_primary != '')
			{
				a_params.confirmButtonText = s_text_primary;
				s_route_primary = s_route_primary.replace(':type', 'place').replace(':id', data.id);
			}

			// we need colourful footer here so have to use another type of sweetalert2
			Swal.fire(
				a_params
			).then((result) => {
				if (result.value) {
					if (s_route_primary != '')
						window.location.href = s_route_primary;
					else
						resetForm(form);
				} else if (result.dismiss === Swal.DismissReason.cancel) {
					if (s_route_secondary != '')
						window.location.href = s_route_secondary;
					else
						resetForm(form);
				}
			})
			;

	});
	map.markers.push( marker );
}

function centerMap( map, f_lat, f_lng )
{
	var o_lat_lng = new google.maps.LatLng(f_lat, f_lng);
	map.setCenter(o_lat_lng);
}

function findMe( map )
{
	findMeMarker = new google.maps.InfoWindow;
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			findMeMarker.setPosition(pos);
			findMeMarker.setContent('<div class="myplacemarker"><span class="ov1"></span><span class="ov2"></span><span class="ov3"></span><span class="ov4"></span></div>');
			findMeMarker.open(map);
			map.setCenter(pos);
		}, function() {
			alert('Error: The Geolocation service failed.');
		});
	} else {
		alert('Error: Your browser doesn\'t support geolocation.');
	}
}

$(document).ready(function()
{
	 var map = initMap( $('#main_map') );
});