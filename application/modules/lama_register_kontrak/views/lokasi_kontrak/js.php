
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnoGc_rhJUXXKFMx7jKcYmNzr0wUmDW3k&callback=initialize" async defer></script>
   

<script type="text/javascript">   
    var marker;
    function initialize(){
        // Variabel untuk menyimpan informasi lokasi
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel berisi properti tipe peta
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
        // Pembuatan peta
        var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);      
		// Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database MySQL
        <?php
		// Sesuaikan dengan konfigurasi koneksi Anda
			foreach($peta as $key => $row) {
                $year	= date('Y');
                $month = date('m');
				$lat  = $row["latitude"];
				$long = $row["longitude"];
                $detail = '<div id="content">' .
						    '<div id="siteNotice">' .
						    "</div>" .
						    '<h5 id="firstHeading" class="firstHeading">Detail Kontrak</h5>' .
						    '<div id="bodyContent">' .
						    '<table class="table">'.
								'<tr>' .
									'<td>PPTK</td>' .
									'<td>:</td>' .
									'<td>'.$row['nama_pptk'].'</td>' .
								'</tr>' .
								'<tr>' .
									'<td>Sub Kegiatan</td>' .
									'<td>:</td>' .
									'<td>'.$row['nama_sub_kegiatan'].'</td>' .
								'</tr>' .
								'<tr>' .
									'<td>Paket</td>' .
									'<td>:</td>' .
									'<td>'.$row['nama_paket'].'</td>' .
								'</tr>' .
								'<tr>' .
									'<td>Pagu Paket</td>' .
									'<td>:</td>' .
									'<td>'.number_format($row['pagu']).'</td>' .
								'</tr>' .
								'<tr>' .
									'<td>Nilai Kontrak</td>' .
									'<td>:</td>' .
									'<td>'.number_format($row['nilai_kontrak']).'</td>' .
								'</tr>' .
								'<tr>' .
									'<td>Penyedia Barang Dan Jasa</td>' .
									'<td>:</td>' .
									'<td>'.$row['pelaksana'].'</td>' .
								'</tr>' .
							
							'</table>'. 
							'<br>' .
							'<button class="btn btn-info btn-xs" onclick="lihat_progress_pekerjaan('.$row['id_paket_pekerjaan'].')">Lihat Progress</button>' .
						    "</div>" .
					    "</div>";
;
               
				
				echo "addMarker($lat, $long, '$detail');\n";
			}
        ?> 
        // Proses membuat marker 
        function addMarker(lat, lng, info){
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: peta,
                animation: google.maps.Animation.BOUNCE,
                position: lokasi
            });       
            peta.fitBounds(bounds);
            bindInfoWindow(marker, peta, infoWindow, info);
         }
        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, peta, infoWindow, html){
            google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(peta, marker);
          });
        }
    }


    function lihat_progress_pekerjaan(id_paket_pekerjaan){
    	$('#modal-progress-pekerjaan').modal('show');
    	$('#id_paket').val(id_paket_pekerjaan);

    }
    function tambah_progress(){
    	$('#modal-progress-pekerjaan').modal('hide');
    	$('#modal-tambah-progress-pekerjaan').modal('show');
    	var id_paket = $('#id_paket').val();
    	$('#id_paket_pekerjaan').val(id_paket);
    }

















	function get_file_name(prop) {
		let file = prop.value.split("\\");
		let result = file[file.length - 1];
		$(prop).next().text(result);
	}

	function simpan_progress_pekerjaan() {
		let form_data = new FormData(document.getElementById("form-update-evidence"));
		let file_data = $('#upload-file').prop('files')[0];
		let id_paket_pekerjaan = $('#id_paket_pekerjaan').val();
		let tgl = $('#tgl').val();
		let persen = $('#persen').val();
		let keterangan = $('#keterangan').val();
		form_data.append('file', file_data);
		form_data.append('id', 'upload_file');
		form_data.append('id_paket_pekerjaan', id_paket_pekerjaan);
		form_data.append('tgl', tgl);
		form_data.append('persen', persen);
		form_data.append('keterangan', keterangan);

		$.ajax({
			url: baseUrl('register_kontrak/simpan_progress/'),
			dataType: 'json',
			mimeType: "multipart/form-data",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
				if (data.status == true) {
					window.location.href = baseUrl('register_kontrak/lokasi_kontrak');
				}
			}
		});
	}
</script>



