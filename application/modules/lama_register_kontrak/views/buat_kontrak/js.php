<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Bootstrap Datepicker -->
<script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Leaflet -->
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
<script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
<script>
	let map;
	$(document).ready(function() {
		show_select2();
		get_paket_pekerjaan();
		$('input.currency').number(true, 0)
			.css('text-align', 'right');
		show_date_picker();
























$(document).on('click','#clearmap',clearmap);
    var map;
    var markers = [];


    var latitude_ok = $('#latitude_ok').val();
    var longitude_ok = $('#longitude_ok').val();
    function initialize() {
        var mapOptions = {
        zoom: 8,
        center: new google.maps.LatLng(-0.7682504, 100.4866192)
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        // Add a listener for the click event
        google.maps.event.addListener(map, 'rightclick', addLatLng);
        google.maps.event.addListener(map, "rightclick", function(event) {
          var lat = event.latLng.lat();
          var lng = event.latLng.lng();       
          $('#latitude').val(lat);
          $('#longitude').val(lng);
          //alert(lat +" dan "+lng);
        });




    }
    /**
     * Handles click events on a map, and adds a new point to the marker.
     * @param {google.maps.MouseEvent} event
     */
    function addLatLng(event) {
        var marker = new google.maps.Marker({
        position: event.latLng,
        title: 'Simple GIS',
        map: map
        });
        markers.push(marker);
    }
    //membersihkan peta dari marker
    function clearmap(e){
        e.preventDefault();
        $('#latitude').val('');
        $('#longitude').val('');
        setMapOnAll(null);
    }
    //buat hapus marker
    function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
      markers = [];
    }
    //end buat hapus marker
    // Menampilkan marker lokasi jembatan
    function addMarker(nama,location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title : nama
        });
        markers.push(marker);
    } google.maps.event.addDomListener(window, 'load', initialize);







	});

	function get_paket_pekerjaan() {
		$.ajax({
			url: baseUrl('register_kontrak/get_paket_pekerjaan/'),
			dataType: 'JSON',
			type: 'POST',
			data: {},
			success: function(data) {
				if (data.status == true) {
					$('#id_paket_pekerjaan').html('');
					$('#id_paket_pekerjaan').append('<option></option>');
					$.each(data.data, function(k, v) {
						$('#id_paket_pekerjaan').append('<option value="' + v.id_paket_pekerjaan + '">' + v.nama_paket + '</option>');
					});
				}
			}
		});
	}



	function tetapkan_koordinat_terpilih() {
		var latitude = $('#modal-maps-mode-select').find('#latitude').val();
		var longitude = $('#modal-maps-mode-select').find('#longitude').val();
		$('#latitude_ok').val(latitude);
		$('#longitude_ok').val(longitude);
		show_koordinat(latitude, longitude);
	}
	function tetapkan_koordinat_diinput() {
		var latitude = $('#modal-maps-mode-input').find('#input_latitude').val();
		var longitude = $('#modal-maps-mode-input').find('#input_longitude').val();
		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah titik koordinat yang anda inputkan sudah benar.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Tetapkan Koordinat',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
				$('#latitude_ok').val(latitude);
				$('#longitude_ok').val(longitude);	

				show_koordinat(latitude, longitude);
				$('.closemodal').click();

			  }
			});	
		
	}



	function show_koordinat(lat, long) {
		$('#preview_maps').attr('style', '');
		$('#show_maps').html('<iframe src="' +baseUrl('register_kontrak/tampilkan_koordinat_terpilih/') + lat +'/'+ long + '" frameborder="0" width="100%" height="600px"></iframe>');
	}

	function show_select2() {
		$('#id_paket_pekerjaan').select2({
			placeholder: "Pilih Paket Pekerjaan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}

	function show_date_picker() {
		$("#tgl_awal_pelaksanaan").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		});
		$("#tgl_akhir_pelaksanaan").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	}

	$("#tgl_awal_pelaksanaan").on('changeDate', function(selected) {
		var startDate = new Date(selected.date.valueOf());
		$("#tgl_akhir_pelaksanaan").datepicker('setStartDate', startDate);

		if ($("#tgl_awal_pelaksanaan").val() > $("#tgl_akhir_pelaksanaan").val()) {
			$("#tgl_akhir_pelaksanaan").val($("#tgl_awal_pelaksanaan").val());
		}
	});

	function tampil_register_kontrak(id_paket_pekerjaan = '') {
		$('.register-kontrak').show();

		if (id_paket_pekerjaan) {
			$.ajax({
				url: baseUrl('register_kontrak/get_detail_paket/'),
				dataType: 'JSON',
				type: 'GET',
				data: {
					id_paket_pekerjaan: id_paket_pekerjaan
				},
				success: function(data) {
					if (data.status == true) {
						$('#id_pptk').val(data.data.id_pptk);
						$('#nama_pptk').val(data.data.nama_pptk);
						$('#nama_kegiatan').val(data.data.nama_kegiatan);
						$('#pagu_kegiatan').val(data.data.pagu_kegiatan);
						$('#pagu_paket').val(data.data.pagu_paket);
						$('#status_lokasi').val(data.status_lok);

						$('#lokasi-paket-pekerjaan').html('');
						$.each(data.lokasi, function(k, v) {
							$('#lokasi-paket-pekerjaan').append('<tr>' +
								'<td>' + (k + 1) + '</td>' +
								'<td>' + v.kab_kota + '</td>' +
								'<td align="center">' + v.latitude + '</td>' +
								'<td align="center">' + v.longitude + '</td>' +
								'<td><button type="button" onclick="tampil_map(' + "'" + v.id_lokasi + "'" + ')" class="btn btn-primary btn-sm">Get</button</td>' +
								'</tr>'
							);
						});
					}
				}
			});
		}
	}


	function save_register_kontrak() {
		$('#notifikasi').html('');
		$.ajax({
			url: baseUrl('register_kontrak/save_register_kontrak/'),
			dataType: 'JSON',
			type: 'POST',
			data: $('#form-register-kontrak').serialize(),
			beforeSend: function() {
				button_loading('btn-register-kontrak', true);
			},
			success: function(data) {
				$('#preview_maps').attr('style', 'display:none');
				if (data.status == true) {
					$('#notifikasi').append('<div class="alert alert-info fade show" role="alert">' +
						'<i class="fas fa-check"></i> ' +
						data.messages[0] +
						'</div>');
					resetForm('form-register-kontrak', ['id_paket_pekerjaan']);
					remove_notif_validation();
					get_paket_pekerjaan();
					$('.register-kontrak').hide();
					button_loading('btn-register-kontrak', false, 'Register Kontrak');
				} else {
					notif_validation(data.messages);

					

					button_loading('btn-register-kontrak', false, 'Register Kontrak');
				}
			}
		});
	}

	function update_koordinat(id_lokasi, lat, lng) {
		$.ajax({
			url: baseUrl('register_kontrak/update_koordinat/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_lokasi: id_lokasi,
				lat: lat,
				lng: lng
			},
			success: function(data) {
				if (data.status == true) {
					$('#modal-maps').modal('hide');
					tampil_register_kontrak($('#id_paket_pekerjaan').val());
				}
			}
		});
	}














	function input_lokasi(mode) {
		var target_modal;
		if (mode=='input') {
			target_modal = 'modal-maps-mode-input';
		}else{
			target_modal = 'modal-maps-mode-select';

		}
		$('#' + target_modal).modal('show');
		
		

















	}






























































</script>