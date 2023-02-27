<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	var map = L.map('mapid').setView([-0.9377094,100.3613245], 11);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	var myFeatureGroup 	= L.featureGroup().addTo(map).on("click", groupClick);
	var myMarker;

	$.getJSON(baseUrl('gis/get_project'), function(data){
		$.each(data, function(i, field)
		{
			var v_lat  = parseFloat(data[i].latitude);
			var v_long = parseFloat(data[i].logitude);

			var iconMarker = L.icon({
				iconUrl  : baseUrl('assets/marker/default_marker.png'),
				iconSize : [ 30, 30]
			});

			myMarker    = L.marker([v_lat,v_long],{icon : iconMarker})
							.addTo(myFeatureGroup)
						 	.bindPopup(data[i].project_name)
			myMarker.id = data[i].id_project;
		});
	});

	function onMapClick(e) {
	    alert("You clicked the map at " + e.latlng);
	}

	map.on('click', onMapClick);

	function groupClick(event)
	{
		console.log("Clicked on marker" + event.layer.id);
		getLocation();
	}

	function getLocation() {
	   var geolocation = navigator.geolocation;
	   geolocation.getCurrentPosition(showLocation, errorHandler);
	}

	function showLocation( position ) {
	   var latitude = position.coords.latitude;
	   var longitude = position.coords.longitude;

	   console.log(latitude);
	   console.log(longitude);
	}

	function errorHandler( err )
	{
	   if (err.code == 1) {
	   }
	}

</script>