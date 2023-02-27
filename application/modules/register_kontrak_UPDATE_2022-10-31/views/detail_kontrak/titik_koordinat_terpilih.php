
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnoGc_rhJUXXKFMx7jKcYmNzr0wUmDW3k&callback=initialize" async defer></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-body" style="width:100%; height:500px" id="googleMap"></div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">   
    var marker;
    var lat = <?php echo $latitude ?>;
    var long = <?php echo $longitude ?>;
    var tengahmap = { lat : <?php echo $latitude ?>, lng: <?php echo $longitude ?>}
    function initialize(){
        // Variabel untuk menyimpan informasi lokasi
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel berisi properti tipe peta
        var mapOptions = {
            zoom : 14,
            center : tengahmap
        } 
        // Pembuatan peta
        var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);      
		// Variabel untuk menyimpan batas kordinat
        //var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database MySQL

            addMarker(lat, long ,  '????');
        // Proses membuat marker 
        function addMarker(lat, lng, info){
           var lokasi = new google.maps.LatLng(lat, lng);
          //  bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: peta,
                // animation: google.maps.Animation.BOUNCE,
                position: lokasi
            });       
          //  peta.fitBounds(bounds);
           // bindInfoWindow(marker, peta, infoWindow, info);
         }
       
    }
</script>



