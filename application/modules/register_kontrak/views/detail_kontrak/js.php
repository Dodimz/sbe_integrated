<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
	let id_kontrak = '<?php echo $id_kontrak ?>';
	$(document).ready(function() {
		
		tampil_register_kontrak(id_kontrak);
		


























	});

function convert_to_rupiah(angka) {
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for (var i = 0; i < angkarev.length; i++)
			if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
		return rupiah.split('', rupiah.length - 1).reverse().join('');
	}


function data_progress_pekerjaan(id_paket_pekerjaan)
	{
		$('#progress-pekerjaan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('register_kontrak/dt_progress_pekerjaan/'),
				            type 	: "POST",
				          	data 	: {
				          		id_paket_pekerjaan : id_paket_pekerjaan
				          	},
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0 ],
							},
							{
								className	: "dt-center",
								targets		: [ -1 ],
							},
	        			  ],

    	});
	}

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




	function kab_kota(id_kota) {
		$('#kab_kota').append('<option value="">' + "--Pilih Kecamatan--" + '</option>');
		$.ajax({
			url: baseUrl('register_kontrak/kab_kota/'),
			dataType: 'JSON',
			type: 'POST',
			data: {},
			success: function(data) {
				if (data.status == true) {
					$.each(data.data, function(k, v) {

						var selected_kota = v.id_kota==id_kota ? 'selected' : '';
						$('#kab_kota').append('<option value="' + v.id_kota + '" '+selected_kota+'>' + v.nama_kota + '</option>');
					});
				}
			}
		});
	}

	function kecamatan(id_kota, id_kecamatan) {
		$('#kecamatan').append('<option value="">' + "--Pilih Kecamatan--" + '</option>');
		var selected;
		$.ajax({
			url: baseUrl('register_kontrak/kecamatan/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_kota: id_kota
			},
			success: function(data) {
				console.log(data);
				if (data.status == true) {
					$.each(data.data, function(k, v) { 
						selected = v.id_kecamatan==id_kecamatan ? 'selected': ''
						$('#kecamatan').append('<option value="' + v.id_kecamatan + '" '+selected+'>' + v.nama_kecamatan + '</option>');
					});
				}
			}, 
			error : function (){
				alert('err')
			}
		});
	}





	function show_koordinat(lat, long) {
		$('#preview_maps').attr('style', '');
		$('#show_maps').html('<iframe src="' +baseUrl('register_kontrak/tampilkan_koordinat_terpilih/') + lat +'/'+ long + '" frameborder="0" width="100%" height="600px"></iframe>');
	}



$('#kab_kota').change(function(){
		$('#kecamatan').html('');
		var id_kota = $('#kab_kota').val();

		$.ajax({
			url: baseUrl('register_kontrak/kecamatan/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_kota: id_kota
			},
			success: function(data) {
				console.log(data);
				if (data.status == true) {
					$.each(data.data, function(k, v) {
						$('#kecamatan').append('<option value="' + v.id_kecamatan + '">' + v.nama_kecamatan + '</option>');
					});
				}
			}, 
			error : function (){
				alert('err');
			}
		});
	});



	function tampil_register_kontrak(id_kontrak) {
		$('.register-kontrak').show();
		$('#caption').attr('style','display:none');
		$('#id_kontrak').val(id_kontrak);
		$('#jenis_kontrak').val('').change();
		$('#kab_kota').val('').change();
		$('#kecamatan').val('').change();
		$.ajax({
				url: baseUrl('register_kontrak/get_detail_kontrak/'),
				dataType: 'JSON',
				type: 'GET',
				data: {
					id_kontrak: id_kontrak
				},
				success: function(data) {
					console.log(data);
					if (data.status == true) {
						$('#id_kontrak').html(data.data.id_kontrak);
						$('#nama_pptk').html(data.data.nama_pptk);
						$('#nama_kegiatan').html(data.data.nama_kegiatan);
						$('#nama_kegiatan_master').html(data.data.nama_kegiatan_master);
						$('#nama_program').html(data.data.nama_program);
						$('#pagu_kegiatan').html(convert_to_rupiah(data.data.pagu_kegiatan));
						$('#jenis_kontrak').html(data.data.jenis_kontrak);
						$('#pagu_paket').html(convert_to_rupiah(data.data.pagu_paket));
						$('#nama_paket').html(data.data.nama_paket);
						$('#jenis_paket').html(data.data.jenis_paket);
						$('#metode').html(data.data.metode);
						$('#tgl_awal_pelaksanaan').html(data.data.tgl_awal_pelaksanaan);
						$('#tgl_akhir_pelaksanaan').html(data.data.tgl_akhir_pelaksanaan);
						$('#nilai_kontrak').html(convert_to_rupiah(data.data.nilai_kontrak));
						// $('#latitude_ok').html(data.data.latitude_ok);
						// $('#longitude_ok').html(data.data.longitude_ok);
						$('#no_register_kontrak').html(data.data.no_register_kontrak);
						$('#pelaksana').html(data.data.pelaksana);
						$('#domisili').html(data.data.domisili);
						kab_kota(data.data.id_kota);
						kecamatan(data.data.id_kota, data.data.id_kecamatan);
						if (data.data.latitude_ok!='') {
							show_koordinat(data.data.latitude_ok, data.data.longitude_ok)

						}
						data_progress_pekerjaan(data.data.id_paket_pekerjaan);

					
					}
				},
				error : function(){
					console.log('e');
				}
			});
	}



	function hapus_progress(id_progress, foto, id_paket_pekerjaan)
	{


		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus Progress pekerjaan.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
				$.ajax(
				{
					url     : baseUrl('register_kontrak/hapus_progress/'),
					dataType: 'JSON',
					type    : 'POST',
					data    : { 
						id_progress : id_progress, 
						id_paket_pekerjaan : id_paket_pekerjaan, 
						foto : foto },
					success : function(data)
					{
						if(data.status == true)
						{
							
						$('#progress-pekerjaan').DataTable().ajax.reload(null, false);
						}
					},
					error : function (){
					}
				});
			

			  
			  }
			});
	}



	function get_file_name(prop) {
		let file = prop.value.split("\\");
		let result = file[file.length - 1];
		$(prop).next().text(result);
	}

	function simpan_progress_pekerjaan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		let form_data = new FormData(document.getElementById("form_add_progress"));
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
			url: baseUrl('register_kontrak/simpan_progress_pekerjaan/'),
			dataType: 'json',
			mimeType: "multipart/form-data",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
				if (data.status == true) {
						Swal.fire('Disimpan','Progress Pekerjaan Disimpan','success');
						$('#progress-pekerjaan').DataTable().ajax.reload(null, false);
						$("#modal-tambah-progress-pekerjaan").modal('hide');
					// lihat_progress_pekerjaan(id_paket_pekerjaan);
				}else{
					if (data.error==1) {
						var element = $('#upload-file');
						var value = data.message;
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					}else{
						$.each(data.messages, function (key, value)
						{
							var element = $('#' + key);
							element.removeClass('is-invalid')
								.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
								.find('.text-danger')
								.remove();
							element.after(value);
						});
					}

				}
			}
		});
	}


 function tambah_progress(id_paket){
    	$('#modal-progress-pekerjaan').modal('hide');
    	$('#modal-tambah-progress-pekerjaan').modal('show');
    	
    	$('#id_paket_pekerjaan').val(id_paket);
        $('#modal-tambah-progress-pekerjaan').find('#persen').html('');
        $('#modal-tambah-progress-pekerjaan').find('#tgl').val('');
        $('#modal-tambah-progress-pekerjaan').find('#upload-file').val('');
        $('#modal-tambah-progress-pekerjaan').find('#keterangan').val('');
		$.ajax({
			url: baseUrl('register_kontrak/persen_max_progress_pekerjaan/'),
			dataType: 'json',
			data: {
				id_paket_pekerjaan : id_paket
			},
			type: 'POST',
			success: function(data) {
		        $('#modal-tambah-progress-pekerjaan').find('.nama_paket_pekerjaan').html(data.paket);
				var count = parseInt(data.persentasi) +1;
				
				for (x = 1/*count*/ ; x <= 100; x++) {
			        $('#modal-tambah-progress-pekerjaan').find('#persen').append(`
			        	<option value="`+x+`">`+x+`%</option>
			        	`);
			    }
			}
		});
    }
	// function progress_pekerjaan(id_paket_pekerjaan) {
	// 	$.ajax({
	// 		url: baseUrl('register_kontrak/data_progress_pekerjaan/'),
	// 		dataType : 'json',
	// 		data: {
	// 			id_paket_pekerjaan:id_paket_pekerjaan
	// 		},
	// 		type: 'POST',
	// 		success: function(data) {
	// 	    	console.log(data);
	// 			if (data.status == true) {
	// 				$.each(data.data, function(k, v) {
	// 					var gambar = '<img src="'+ v.gambar+'" width="400px">';
	// 					$('#progress-pekerjaan').append('<tr>' +
	// 						'<td valign="top">' + (k + 1) + '</td>' +
	// 						'<td valign="top">' + v.progress + '%</td>' +
	// 						'<td valign="top">' + v.keterangan + '</td>' +
	// 						'<td>' + v.tanggal + '</td>' +
	// 						'<td>' + gambar + '</td>' +
	// 						'<td valign="top">' + v.action + '</td>' +
							
	// 						'</tr>'
	// 					);
	// 				});
	// 			}
	// 		}
	// 	});
	// }









































































</script>