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
<script>
	let status_show_pptk = 'collapse';
	$(document).ready(function() {
		showKpa();
	});

	/* Fungsi untuk menampilkan KPA */
	function showKpa() {
		$('#table-kpa').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('realisasi/dt_kpa/'),
				type: "POST",
				data: {},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}

	$('#table-kpa').on('click', '#show-pptk', function() {
		let id_user = $(this).attr('id-user');
		let table = $(this).parent().parent()[0];
		var id_detail = 'list-pptk-' + $(this).attr('id-user');
		let tr_detail_pptk = '';

		tr_detail_pptk = '<tr colspan="6" class="card-body formulir" id="' + id_detail + '" rowspan="1">';
		tr_detail_pptk += '<td rowspan="1" colspan="6">';
		tr_detail_pptk += '<table class="table table-sm">' +
			'<thead>' +
			'<tr>' +
			'<th width="1%"></th>' +
			'<th></th>' +
			'<th></th>' +
			'<th></th>' +
			'</tr>' +
			'</thead>' +
			'<tbody id="list-pptk' + id_user + '">' +
			'</tbody>' +
			'</table>';
		tr_detail_pptk += '</td>';
		tr_detail_pptk += '</tr>';

		if (status_show_pptk == 'collapse') {
			status_show_pptk = 'expand';
			$(this).html('<i class="fa fa-minus"></i>');
			$(table).after(tr_detail_pptk);
			listPptk(id_user);
		} else {
			status_show_pptk = 'collapse';
			$(this).html('<i class="fa fa-plus"></i>');
			$('#' + id_detail).remove();
		}
	});

	$('#table-kpa').on('click', '#list-sub-kegiatan', function() {
		let id_user = $(this).attr('id-user');
		let table = $(this).parent().parent()[0];
		var id_detail = 'list-sub-kegiatan-' + $(this).attr('id-user');
		let status_kegiatan = $(this).attr('status');
		let tr_detail_kegiatan = '';

		tr_detail_kegiatan  = '<tr colspan="6" class="card-body formuliri" id="'+ id_detail +'" rowspan="1">';
		tr_detail_kegiatan +=     '<td rowspan="1" colspan="6">';
	    tr_detail_kegiatan +=   	'<table class="table table-sm">' +
		    							'<thead>' +
				                    		'<tr>' +
				                    			'<th width="1%">Action</th>' +
				                        		'<th width="1%">Kode Rekening</th>' +
				                            	'<th>Sub Kegiatan</th>' +
				                            	'<th>Pagu</th>' +
				                            	'<th>Total Paket</th>' +
				                        	'</tr>' +
				                    	'</thead>' +
			                            '<tbody id="list-sub-kegiatan-pptk-'+ id_user +'">' +

			                            '</tbody>' +
			                        '</table>';
		tr_detail_kegiatan +=     '</td>';
        tr_detail_kegiatan += '</tr>';

		if (status_kegiatan == 'collapse') {
			$(this).attr('status', 'expand');
			$(this).html('-');
			$(table).after(tr_detail_kegiatan);
			listKegiatan(id_user);
		} else {
			$(this).attr('status', 'collapse');
			$(this).html('+');
			$('#' + id_detail).remove();
		}
	});

	$('#table-kpa').on('click', '#list-paket', function() {
		let id_pptk = $(this).attr('id-pptk');
		let table = $(this).parent().parent()[0];
		let kode_sub_kegiatan   = $(this).attr('kode-sub-kegiatan');
		let kode_kegiatan   = $(this).attr('kode-kegiatan');
		let kode_program   = $(this).attr('kode-program');
		let kode_bidang_urusan   = $(this).attr('kode-bidang-urusan');
		let id_table 		= kode_sub_kegiatan.split('.').join("-");
		var id_detail = 'list-paket-' + id_table;
		let status_paket = $(this).attr('status');
		let kedudukan = $(this).attr('kedudukan');
		let tr_detail_paket = '';

		tr_detail_paket = '<tr colspan="6" class="card-body formulira" id="' + id_detail + '" rowspan="1">';
		tr_detail_paket += '<td rowspan="1" colspan="6">';
		tr_detail_paket += '<div class="mb-3 card">' +
			'<div class="card-body">' +
			'<table id="table-paket-' + id_table + '" class="display" style="width:100%">' +
			'<thead>' +
			'<tr>' +
			'<th width="1%">No</th>' +
			'<th>Paket</th>' +
			'<th>Jenis</th>' +
			'<th>Metode</th>' +
			'<th style="text-align:center;">Lokasi</th>' +
			'<th style="text-align:center;">Vol</th>' +
			'<th>Pagu</th>' +
			'<th></th>' +
			'<th></th>';
		tr_detail_paket += kedudukan == 'PPTK' ? '<th style="text-align:center;">Detail</th>' : '';
		tr_detail_paket += '</tr>';
		tr_detail_paket += '</thead>';
		tr_detail_paket += '</table>';
		tr_detail_paket += '</div>';
		tr_detail_paket += '</div>';
		tr_detail_paket += '</td>';
		tr_detail_paket += '</tr>';

		if (status_paket == 'collapse') {
			$(this).attr('status', 'expand');
			$(this).html('-');
			$(table).after(tr_detail_paket);
			showPaket(id_table, id_pptk);
		} else {
			$(this).attr('status', 'collapse');
			$(this).html('+');
			$('#' + id_detail).remove();
		}

	});

	function listPptk(id_user_top_parent = '') {
		$.ajax({
			url: baseUrl('realisasi/list_pptk/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_user_top_parent: id_user_top_parent
			},
			success: function(data) {
				if (data.status == true) {
					$.each(data.data, function(k, v) {
						$('#list-pptk' + id_user_top_parent).append('<tr>' +
							'<th scope="row"><button class="btn btn-info btn-xs" id="list-sub-kegiatan" status="collapse" id-user="' + v.id_user + '">+</button></th>' +
							'<td><strong>' + v.sub_instansi + '</strong> [ ' + v.nama + ' ]</td>' +
							'<td>' + v.jml_keg + ' Kegiatan </td>' +
							'<td>' + v.jml_paket + ' Paket </td>' +
							'</tr>');
					});
				}
			}
		});
	}

	function listKegiatan(id_user = '') {
		$.ajax({
			url: baseUrl('realisasi/list_sub_kegiatan/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_user: id_user
			},
			success: function(data) {
				if (data.status == true) {
					$.each(data.data, function(k, v) {

						$('#list-sub-kegiatan-pptk-'+ id_user).append('<tr>' +
                								'<td><button id="list-paket" status="collapse" id-pptk="'+ v.id_pptk +'" kode-sub-kegiatan="'+ v.kode_sub_kegiatan +'" kode-kegiatan="'+ v.kode_kegiatan +'" kode-program="'+ v.kode_program +'" kode-bidang-urusan="'+ v.kode_bidang_urusan +'" class="btn btn-info btn-xs">+</button></td>' +
				                                '<td>'+ v.kode_sub_kegiatan +'</td>' +
				                                '<td>'+ v.sub_kegiatan +'</td>' +
				                                '<td align="right">'+ v.pagu +'</td>' +
				                                '<td>'+ v.jml_paket +' Paket</td>' +
				                            '</tr>');



						// $('#list-kegiatan-pptk' + id_user).append('<tr>' +
						// 	'<td><button id="list-paket" class="btn btn-info btn-xs" kedudukan="' + data.kedudukan + '" status="collapse" id-pptk="' + v.id_pptk + '" kode-rekening="' + v.rekening + '">+</button></td>' +
						// 	'<td>' + v.rekening + '</td>' +
						// 	'<td>' + v.kegiatan + '</td>' +
						// 	'<td>' + v.jml_paket + ' Paket</td>' +
						// 	'</tr>');
					});
				}
			}
		});
	}

	function showPaket(id_table, id_pptk) {
		let kode_rekening = id_table.split('-').join('.');

		$('#table-paket-' + id_table).DataTable({
			processing: false,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('realisasi/dt_paket/'),
				type: "POST",
				data: {
					kode_rekening: kode_rekening,
					id_pptk: id_pptk
				},
			},
			columnDefs: [

							{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ -1, 0, 5 ],
							},
							{
								className	: "text-nowrap",
								targets		: [ -1, 2 ],
							},
							{
								className	: "dt-center",
								targets		: [ 0 ],
							},
			],

		});
	}

	/* Fungsi untuk menampilkan modal upload dokumen realisasi fisik */
	function upload_dokumen(id_instansi, id_kpa, id_pptk, id_paket_pekerjaan, kode_rekening_sub_kegiatan, nama_paket, jenis_paket, id_metode) {
		$('#modal-upload-dokumen').modal('show')
			.find('.modal-title').text(nama_paket);
		list_dokumen(id_instansi, id_kpa, id_pptk, id_paket_pekerjaan, kode_rekening_sub_kegiatan, jenis_paket, id_metode);
	}

	function list_dokumen(id_instansi, id_kpa, id_pptk, id_paket_pekerjaan, kode_rekening_sub_kegiatan, jenis_paket, id_metode) {
		let id = kode_rekening_sub_kegiatan.split('.').join("-");
		$.ajax({
			url: baseUrl('realisasi/list_dokumen/'),
			dataType: 'JSON',
			type: 'POST',
			data: {
				id_instansi: id_instansi,
				id_kpa: id_kpa,
				id_pptk: id_pptk,
				id_paket_pekerjaan: id_paket_pekerjaan,
				kode_rekening_sub_kegiatan: kode_rekening_sub_kegiatan,
				jenis_paket: jenis_paket,
				id_metode: id_metode
			},
			success: function(data) {
				if (data.status == true) {

					$('#form-upload-dokumen').html('');
					$('#form-upload-dokumen').append('<input type="hidden" id="id_intansi" name="id_instansi" value="' + id_instansi + '">')
						.append('<input type="hidden" id="id_kpa" name="id_kpa" value="' + id_kpa + '">')
						.append('<input type="hidden" id="id_pptk" name="id_pptk" value="' + id_pptk + '">')
						.append('<input type="hidden" id="id_paket_pekerjaan" name="id_paket_pekerjaan" value="' + id_paket_pekerjaan + '">')
						.append('<input type="hidden" id="jenis_paket" name="jenis_paket" value="' + jenis_paket + '">')
						.append('<input type="hidden" id="kode_rekening_sub_kegiatan" name="kode_rekening_sub_kegiatan" value="' + kode_rekening_sub_kegiatan + '">')
						.append('<input type="hidden" id="id_metode" name="id_metode" value="' + id_metode + '">');
					$.each(data.cek, function(k, v) {
						let a = v.split("_");
						let b = a.length > 1 ? a[1] : a[0];
						let id_dok = a[0].replace(/\s/g, '');

						let pecah_id_dan_nama = v.split("___");
						let id_volume = pecah_id_dan_nama[1] != null ? pecah_id_dan_nama[1] : '' ;
						let nama_volume =  pecah_id_dan_nama[0];



					//	$('#form-upload-dokumen').append('<input type="text" id="id_vol" name="id_vol" value="'+ "???"+'">');





						$('#form-upload-dokumen').append('<div class="position-relative form-group" id="upload-' + id_dok + '-' + id + '">' +
							'<input type="hidden" id="id_volume" name="id_volume" value="'+ id_volume+'">' +
							'<div class="form-row">' +
							'<div class="col-md-12">' +
							'<label for="">File Scan ' + b + '</label>' +
							'<div class="input-group">' +
							'<div class="custom-file">' +
							'<input type="file" class="custom-file-input" id="' + id_dok + '-' + id + '" name="' + id_dok + '-' + id + '" aria-describedby="inputGroupFileAddon04" onchange="get_file_name(this)">' +
							'<label class="custom-file-label" id="label-' + id_dok + '-' + id + '" for="' + id_dok + '-' + id + '">Choose File</label>' +
							'</div>' +
							'<div class="input-group-append">' +
							'<button class="btn btn-info" type="button" id="btn-upload-' + id_dok + '-' + id + '" onclick="upload_file(this,' + "'" + id_dok + '-' + id + "'" + ',' + "'" + v + "'" + ')">Upload</button>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>' +
							'</div>');
					});

					$.each(data.cek, function(k, v) {
						let a = v.split("_");
						let b = a.length > 1 ? a[1] : a[0];
						let id_dok = a[0].replace(/\s/g, '');
						if (k != 0) {
							$('#' + id_dok + '-' + id).prop('disabled', true);
							$('#btn-upload-' + id_dok + '-' + id).prop('disabled', true);
						}
					});
				}
			}
		});
	}


	function lokasi(id_paket_pekerjaan, nama_paket)
	{
		$('#modal-lokasi-paket').modal('show');
		$('#id_paket').val(id_paket_pekerjaan);
		$('#nama_paket_lokasi').html("Lokasi Paket Pekerjaan <br>"+nama_paket);
		
		table_lokasi(id_paket_pekerjaan);
	  	
	}

function table_lokasi(id_paket_pekerjaan)
	{
		
		$('#table-lokasi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('paket_pekerjaan/dt_lokasi/'),
				            type 	: "POST",
				          	data 	: { id_paket_pekerjaan : id_paket_pekerjaan },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0, -1 ],
							},
							{
								className	: "dt-center",
								targets		: [ 0 ],
							},
	        			  ],

    	});
	}

	function get_file_name(prop) {
		let file = prop.value.split("\\");
		let result = file[file.length - 1];
		$(prop).next().text(result);
	}

	function upload_file(prop, id, dokumen) {
		let btn = $(prop).attr('id');
		let id_instansi = $('#id_instansi').val();
		let id_kpa = $('#id_kpa').val();
		let id_pptk = $('#id_pptk').val();
		let kode_rekening_kegiatan = $('#kode_rekening_kegiatan').val();
		let id_paket_pekerjaan = $('#id_paket_pekerjaan').val();
		let jenis_paket = $('#jenis_paket').val();
		let id_metode = $('#id_metode').val();
		let id_volume = $('#id_volume').val();
		let form_data = new FormData(document.getElementById("form-upload-dokumen"));
		let file_data = $('#' + id).prop('files')[0];
		let form_data_to_append = ['id_instansi', 'id_kpa', 'id_pptk', 'id_paket_pekerjaan', 'jenis_paket', 'kode_rekening_sub_kegiatan'];

		form_data.append('file', file_data);
		$.each(form_data_to_append, function(k, v) {
			form_data.append('"' + v + '"', v);
		});

		let split = dokumen.split('_');
		let dok_key = split[1];
		form_data.append('id', id);
		form_data.append('dokumen', dokumen);
		form_data.append('id_volume', id_volume);
		form_data.append('dokumen_key', dok_key == undefined ? dokumen : dok_key);

		$('#bar').show();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener('progress', function(e) {
					if (e.lengthComputable) {
						// console.log('Bytes Loaded : ' + e.loaded);
						// console.log('Total Size : ' + e.total);
						// console.log('Persen : ' + (e.loaded / e.total));
						var percent = Math.round((e.loaded / e.total) * 100);

						$('#progress').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
						// $('#progress').text(percentComplete + '%');
						// $('#progress').width(percentComplete + '%');

						if (percent === 100) {
							$("#bar").fadeOut(1000);
						}
					}
				});
				return xhr;
			},
			url: baseUrl('realisasi/upload_file/'),
			dataType: 'json',
			mimeType: "multipart/form-data",
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'POST',
			success: function(data) {
				if (data.status == true) {
					$('.progress-bar').text('0%');
					$('.progress-bar').width('0%');
					$('#' + btn).removeClass('btn btn-info')
						.addClass('btn btn-success')
						.text('Success');
					var idx = $('#upload-' + id).next().children().children().children(0).children(0).children(0).attr('id');
					$('#' + idx).prop('disabled', false);
					$('#btn-upload-' + idx).prop('disabled', false);
					$('#upload-' + id).remove();
					let idxz = kode_rekening_kegiatan.split('.').join("-");
					showPaket(idxz, id_pptk);
				}
			}
		});
	}

	function daftar_dokumen(id_paket_pekerjaan) {
		$('#modal-daftar-dokumen').modal('show');

		$.ajax({
			url: baseUrl('realisasi/dokumen_realisasi/'),
			dataType: 'JSON',
			type: 'GET',
			data: {
				id_paket_pekerjaan: id_paket_pekerjaan
			},
			success: function(data) {
				$('#daftar-dokumen-fisik').html('');
				$('#total-nilai-fisik').html('');
				$('#caption-daftar-dokumen').html('');
				
				if (data.jumlah_evidence == 0 ) {
					$('#caption-daftar-dokumen').html(data.caption);
					$('#modal-daftar-dokumen').find('.modal-title').text(data.nama_paket);
					$('#table-list-evidence').attr('style', 'display:none');
					$('#warning_hapus_evidence').attr('style', 'display:none');
				}else{
					$('#table-list-evidence').attr('style', '');
					$('#warning_hapus_evidence').attr('style', '');
					$('#caption-daftar-dokumen').html('');
					$.each(data.data, function(k, v) {
						$('#daftar-dokumen-fisik').append('<tr>' +
							'<td>' + (k + 1) + '</td>' +
							'<td style="white-space: nowrap;">' + v.dokumen + '</td>' +
							'<td>' + v.file + '</td>' +
							'<td style="text-align: center;">' + v.nilai + '</td></tr>'
						);
					});

					if (data.nilai != null) {

					$('#daftar-dokumen-fisik').append('<tr>' +
							'<td colspan="3">' + "Total Nilai" + '</td>' +
							'<td style="text-align: center;"> <button class="btn btn-info btn-sm btn-block">' + data.nilai + '</button></td>'
							
						);
					}
				//	$('#modal-daftar-dokumen').find('#warning_hapus_evidence').text(data.id_paket_pekerjaan);
					$('#modal-daftar-dokumen').find('.modal-title').text(data.nama_paket	);
					$('#warning_hapus_evidence').attr('id-paket', data.id_paket_pekerjaan)
					$('#warning_hapus_evidence').attr('nama-paket', data.nama_paket)
				}
			}
		});

		$('#warning_hapus_evidence').click(function(){
			var id_paket = $(this).attr('id-paket')
			var nama_paket = $(this).attr('nama-paket')
			
			Swal.fire({
			  title: 'Hapus Evidence ?',
			  text: nama_paket,
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('realisasi/hapus_evidence/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_paket_pekerjaan: id_paket
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Evidence paket ' + nama_paket + ' Dihapus..!',
						      'success'
						    );
						    $('#close_modal_daftar_dokumen').click()
							let id_table 	= data.rekening.split('.').join('-');
							showPaket(id_table,data.id_pptk);
						}
			  		},
			  		error : function (){
			  			 Swal.fire(
					      'Error!',
					      'Error',
					      'error'
					    )
			  		}
			  	});

			  
			  }
			})
		});
	}

	function upload_berakhir(){
		Swal.fire({
		  icon: 'error',
		  title: 'Gagal',
		  text: 'Waktu upload evidende sudah berakhir.!',
		})
	}
	function volume_0(){
		Swal.fire({
		  icon: 'error',
		  title: 'Gagal',
		  text: 'Volume Pelaksanaan 0. Silahkan lengkapi dulu volume pelaksanaan.!',
		})
	}
	function metode_null(){
		Swal.fire({
		  icon: 'error',
		  title: 'Gagal',
		  text: 'Anda belum memilih metode. Silahkan edit paket dan tambahkan metode',
		})
	}
</script>