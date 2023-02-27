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
	$(document).ready(function() {
		$('.btn-open-options').hide();
		list_instansi();
		var id_instansi = $('#id_instansi_terpilih').val();
		console.log(id_instansi);
		show_table_swakelola(id_instansi);
		show_table_penyedia(id_instansi);
		show_table_belum_validasi(id_instansi);
		show_table_evidence_ditolak(id_instansi);

		show_statistika(id_instansi);
		info_validasi_skpd(id_instansi);
	});

	function pilih_instansi(id_group) {
		$('#modal-pilih-skpd').modal('show');
		show_list_instansi(id_group)
		
	}

	function show_list_instansi(id_group) {
		$('#table-skpd').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('validasi/dt_list_skpd/'),
				type: "POST",
				data: {
					id_group: id_group
				},
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



	function list_instansi() {
		$.ajax({
			url: baseUrl('validasi/get_instansi/'),
			type: "POST",
			dataType: "JSON",
			data: {},
			success: function(data) {
			if (data.status == true) {
					$('#list-instansi').html('');
					if(data.banyak_skpd==0){
						$('#list-instansi').append('<a href="javascript:void(0);" class="list-group-item lg-item">TIDAK ADA DATA</a>'
							);
					}else{

						$.each(data.data, function(k, v) {
							let badge = v.belum_validasi > 0 ? "badge badge-danger badge-pill" : "badge badge-success badge-pill";
							var warna = v.is_active=='0' ? 'style="color:red"' : ''
							$('#list-instansi').append('<a href="javascript:void(0);" onclick="tampil_paket(' + "'" + v.id_instansi + "','" + v.nama_instansi + "','" + v.belum_validasi_swa + "','" + v.belum_validasi_pen + "', this" + ')" class="list-group-item lg-item" id="list-group-item-' + (k + 1) + '"'+ warna+'>' +
								v.nama_instansi + ' ' +
								// '<span class="' + badge + '">' + v.belum_validasi + '</span>' +  original
								
								'</a>'
							);
						});
					}
					$('.lg-item').first().trigger('click');
				}else{
					$('#list-instansi').append('<a href="javascript:void(0);" class="list-group-item lg-item" style="color:red">TIDAK ADA DATA</a>'
							);
				}
			},
			error : function(){
		}
		});
	}

	function info_validasi_skpd(id_instansi){
		$.ajax({
			url: baseUrl('validasi/statistika/'),
			type: "POST",
			dataType: "JSON",
			data: {
				id_instansi: id_instansi
			},
			success: function(data) {
				console.log(data);
				$('#nama_skpd').html(data.data.nama_instansi);
				$('#nama_helpdesk').html(data.data.helpdesk +'<br>'+ data.data.nohp);
				$('#total_evidence_swakelola').html(data.data.total_paket_swakelola);
				$('#total_evidence_swakelola_belum_validasi').html(data.data.total_evidence_belum_validasi_swakelola);
				$('#total_evidence_penyedia').html(data.data.total_paket_penyedia);
				$('#total_evidence_penyedia_belum_validasi').html(data.data.total_evidence_belum_validasi_penyedia);
				$('#total_evidence_ditolak').html(data.data.total_evidence_reject);

				// $('#jumlah_program').html(data.data.total_program);
				// $('#jumlah_kegiatan').html(data.data.total_kegiatan);
				// $('#jumlah_sub_kegiatan').html(data.data.total_sub_kegiatan);
				$('#semua_paket_skpd').html(data.data.total_paket);
				$('#semua_paket_rutin_skpd').html(data.data.total_paket_swakelola);
				$('#semua_paket_swakelola_skpd').html(data.data.total_paket_penyedia);
				$('#semua_paket_penyedia_skpd').html(data.data.total_paket_rutin);
				$('#jumlah_evidence_diupload').html(data.data.total_evidence_diupload);
				$('#total_evidence_belum_validasi').html(data.data.total_evidence_belum_validasi);


				// $('#jumlah_evidence_belum_validasi').html(data.data.total_evidence_belum_validasi);
				$('#jumlah_evidence_belum_validasi_swakelola').html(data.data.total_evidence_belum_validasi_swakelola + " Swakelola");
				$('#jumlah_evidence_belum_validasi_penyedia').html(data.data.total_evidence_belum_validasi_penyedia + " Penyedia");
				$('#jumlah_evidence_approve').html(data.data.total_evidence_approve);
				$('#jumlah_evidence_reject').html(data.data.total_evidence_reject);


			}
		});
	}
	function identitas_paket(id_paket){
		$('#modal-identitas-paket').modal('show');
		$('#modal-identitas-paket').find('#data_evidence').html('');


		$.ajax({
			url: baseUrl('validasi/identitas_paket/'),
			type: "POST",
			dataType: "JSON",
			data: {
				id_paket: id_paket
			},
			success: function(data) {
				console.log(data);
				$('#modal-identitas-paket').find('#nama_program').html(data.data.nama_program);
				$('#modal-identitas-paket').find('#nama_kegiatan').html(data.data.nama_kegiatan);
				$('#modal-identitas-paket').find('#kode_sub_kegiatan').html(data.data.kode_sub_kegiatan);
				$('#modal-identitas-paket').find('#nama_sub_kegiatan').html(data.data.nama_sub_kegiatan);
				$('#modal-identitas-paket').find('#nama_pptk').html(data.data.nama_pptk);

				$('#modal-identitas-paket').find('#nama_paket').html(data.data.nama_paket);
				$('#modal-identitas-paket').find('#volume_paket').html(data.data.volume_paket);
				$('#modal-identitas-paket').find('#evidence_diupload').html(data.data.evidence_diupload);
				$('#modal-identitas-paket').find('#belum_diperiksa').html(data.data.belum_diperiksa);
				if (data.data.evidence_diupload>0) {

					$('#modal-identitas-paket').find('#table_evidence_paket').show();
					$('#modal-identitas-paket').find('#pesan_data_evidence').html(``);

				$.each(data.evidence, function(k, v) {
					if (v.status=="Sudah Validasi") {
						warna_background_evidence = "style='background: #dffecb '";
					}else if (v.status=="Belum Validasi") {
						warna_background_evidence = "style='background:#fef8cb'";
					}
					else{
						warna_background_evidence = "style='background: #fececb '";

					}
					if (data.data.id_group=='5') {
						var tombol_action = '<button class="btn btn-primary btn-xs" onclick="tampil_dokumen(' + "'" + v.file_dokumen + "','" + v.dokumen + "','" + v.id_realisasi_fisik + "','" + v.jenis_paket + "','" + v.id_metode + "','" + id_paket + "','" + v.pelaksanaan + "','" + v.nilai_pelaksanaan + "',this" + ')"><i class="fa fa-folder-open"></i></button>   <a href="' +baseUrl('realisasi/evidence/' + v.id_realisasi_fisik_enc)+'" class="btn btn-info btn-xs" data-toggle="tooltip" title="upload ulang evidence" target="_blank"><i class="metismenu-icon fas fa-file-signature"></i></a>';
					}else{
						var tombol_action = '<button class="btn btn-primary btn-xs" onclick="tampil_dokumen(' + "'" + v.file_dokumen + "','" + v.dokumen + "','" + v.id_realisasi_fisik + "','" + v.jenis_paket + "','" + v.id_metode + "','" + id_paket + "','" + v.pelaksanaan + "','" + v.nilai_pelaksanaan + "',this" + ')"><i class="fa fa-folder-open"></i></button>';
					}
						$('#data_evidence').append(
							'<tr>' +
							'<td>' + v.dokumen + ' '+v.pelaksanaan+'</td>' +
							
							'<td '+warna_background_evidence+'>' + v.status + '</td>' +
							'<td>' + v.nilai + '</td>' +
							'<td>' +tombol_action+'</td>' +
							'</tr>'
						);
					});
				$('#data_evidence').append(
							'<tr>' +
							'<td colspan="2">Total Nilai</td>' +
							'<td colspan="2">'+ data.data.nilai_paket+'</td>' +
							'</tr>'
						);
				}else{
					$('#modal-identitas-paket').find('#table_evidence_paket').hide();
					$('#modal-identitas-paket').find('#pesan_data_evidence').html(`
						<div class="alert alert-danger">Belum ada evidence yang di uploadkan</div>
						`);
				}
			},
			error : function(){
				console.log('error');
			}
		});
	}

	function tampil_paket(id_instansi, nama_instansi, swa, pen, prop) {
		console.log(id_instansi);
		
		let parent = $(prop).closest('.list-group-item').attr('id');
		$('.lg-item').removeClass('list-group-item-info');
		$('#' + parent).addClass('list-group-item-info');
		$('#nama_skpd').html(nama_instansi);

		$('#badge-swakelola').removeClass("badge badge-danger badge-pill")
			.removeClass("badge badge-success badge-pill")
			.addClass(swa > 0 ? "badge badge-danger badge-pill" : "badge badge-success badge-pill")
			.html(swa);
		$('#badge-penyedia').removeClass("badge badge-danger badge-pill")
			.removeClass("badge badge-success badge-pill")
			.addClass(pen > 0 ? "badge badge-danger badge-pill" : "badge badge-success badge-pill")
			.html(pen);
		$('.tables').show();
		show_table_swakelola(id_instansi);
		show_table_penyedia(id_instansi);
		show_statistika(id_instansi);

	}

	function show_table_swakelola(id_instansi) {
		$('#table-paket-swakelola').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('validasi/dt_paket_swakelola/'),
				type: "POST",
				data: {
					id_instansi: id_instansi
				},
			},
			columnDefs: [{
					targets: [0],
					orderable: true,
				},
				{
					width: "1%",
					targets: [0, 4,5],
				},
				{
					className: "dt-center",
					targets: [0,4],
				},
			],

		});
	}

	function show_table_penyedia(id_instansi) {
		$('#table-paket-penyedia').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('validasi/dt_paket_penyedia/'),
				type: "POST",
				data: {
					id_instansi: id_instansi
				},
			},
			columnDefs: [{
					targets: [0],
					orderable: true,
				},
				{
					width: "1px",
					targets: [0, 4,5],
				},
				{
					className: "dt-center",
					targets: [0,4],
				},
			],

		});
	}

	function show_table_belum_validasi(id_instansi) {
		$('#table-paket-belum-validasi').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('validasi/dt_paket_belum_validasi/'),
				type: "POST",
				data: {
					id_instansi: id_instansi
				},
			},
			columnDefs: [{
					targets: [0],
					orderable: true,
				},
				{
					width: "1px",
					targets: [0, 4,5],
				},
				{
					className: "dt-center",
					targets: [0,4],
				},
			],

		});
	}

	function show_table_evidence_ditolak(id_instansi) {
		$('#table-paket-evidence-ditolak').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('validasi/dt_paket_evidence_ditolak/'),
				type: "POST",
				data: {
					id_instansi: id_instansi
				},
			},
			columnDefs: [{
					targets: [0],
					orderable: true,
				},
				{
					width: "1px",
					targets: [0, 4,5],
				},
				{
					className: "dt-center",
					targets: [0,4],
				},
			],

		});
	}

	function show_statistika(id_instansi) {
		$.ajax({
			url: baseUrl('validasi/statistika/'),
			type: "POST",
			dataType: "JSON",
			data: {
				id_instansi: id_instansi
			},
			success: function(data) {
			$('#table-statistika').find('#nama_tahap').html(data.data.nama_tahap);
				$('#table-statistika').find('#nama_skpd').html(data.data.nama_instansi);
				$('#table-statistika').find('#helpdesk').html(data.data.helpdesk +'<br>'+ data.data.nohp);
				$('#table-statistika').find('#jumlah_program').html(data.data.total_program);
				$('#table-statistika').find('#jumlah_kegiatan').html(data.data.total_kegiatan);
				$('#table-statistika').find('#jumlah_sub_kegiatan').html(data.data.total_sub_kegiatan);
				$('#table-statistika').find('#jumlah_paket').html(data.data.total_paket);
				$('#table-statistika').find('#jumlah_evidence_diupload').html(data.data.total_evidence_diupload);
				// $('#table-statistika').find('#jumlah_evidence_belum_validasi').html(data.data.total_evidence_belum_validasi);
				$('#table-statistika').find('#jumlah_evidence_belum_validasi_swakelola').html(data.data.total_evidence_belum_validasi_swakelola + " Swakelola");
				$('#table-statistika').find('#jumlah_evidence_belum_validasi_penyedia').html(data.data.total_evidence_belum_validasi_penyedia + " Penyedia");
				$('#table-statistika').find('#jumlah_evidence_approve').html(data.data.total_evidence_approve);
				$('#table-statistika').find('#jumlah_evidence_reject').html(data.data.total_evidence_reject);
			}
		});
		
	}


	function tetapkan_skpd(id_instansi) {
		$('#id_instansi_terpilih').val(id_instansi);
		$('.tables').show();
		show_table_swakelola(id_instansi);
		show_table_penyedia(id_instansi);
		show_table_belum_validasi(id_instansi);
		show_table_evidence_ditolak(id_instansi);
		show_statistika(id_instansi);
		info_validasi_skpd(id_instansi);
		$('#modal-pilih-skpd').modal('hide');
		// show_list_instansi(id_group)
		
	}


	$('#table-paket-swakelola').on('click', '#detail-realisasi-fisik', function() {
		let table = $(this).parent().parent()[0];
		let id_paket = $(this).attr('id-paket-pekerjaan');
		let id_detail = 'list-realisasi-swakelola-' + id_paket;
		let status = $(this).attr('status');

		let id_instansi = $(this).attr('id-instansi');
		let kpa = $(this).attr('nama-kpa');
		let pptk = $(this).attr('nama-pptk');
		let program = $(this).attr('nama-program');
		let kegiatan = $(this).attr('nama-kegiatan');
		let nama_paket = $(this).attr('nama_paket');
		let vol = $(this).attr('vol');
		let banyak_evidence = $(this).attr('banyak_evidence');

		let tr_detail_swa = '';

		tr_detail_swa = '<tr  class="card-body" id="' + id_detail + '" rowspan="1">';
		tr_detail_swa += '<td rowspan="1" colspan="10">';
		tr_detail_swa += '<div id="informasi-realisasi-swakelola-detail">';
		tr_detail_swa += '<table class="mb-0 table table-sm">' +
			'<thead>' +
			'<tr>' +
			'<th>Dokumen</th>' +
			'<th width="1%"></th>' +
			'<th width="1%">Nilai</th>' +
			'<th width="10%">Status</th>' +
			'</tr>' +
			'</thead>' +
			'<tbody id="dok-realisasi-' + id_paket + '">' +
			'</tbody>' +
			'</table>';
		tr_detail_swa += '</div>';
		tr_detail_swa += '</td>';
		tr_detail_swa += '</tr>';
		if (banyak_evidence>0) {

			if (status == 'collapse') {
				$(this).attr('status', 'expand');
				$(this).html('<i class="fa fa-minus"></i>');
				$(table).after(tr_detail_swa);
				dok_realisasi(id_instansi, id_paket);
			} else {
				$(this).attr('status', 'collapse');
				$(this).html('<i class="fa fa-plus"></i>');
				$('#' + id_detail).remove();
			}
		}else{
			Swal.fire('Evidence belum di upload','Evidence Paket pekerjaan '+nama_paket+' belum diupload Operator','warning');
		}
	});

	$('#table-paket-penyedia').on('click', '#detail-realisasi-fisik', function() {
		let table = $(this).parent().parent()[0];
		let id_paket = $(this).attr('id-paket-pekerjaan');
		let id_detail = 'list-realisasi-penyedia-' + id_paket;
		let status = $(this).attr('status');

		let id_instansi = $(this).attr('id-instansi');
		let kpa = $(this).attr('nama-kpa');
		let pptk = $(this).attr('nama-pptk');
		let program = $(this).attr('nama-program');
		let kegiatan = $(this).attr('nama-kegiatan');
		let vol = $(this).attr('vol');
		let nama_paket = $(this).attr('nama_paket');
		let banyak_evidence = $(this).attr('banyak_evidence');

		let tr_detail_swa = '';

		tr_detail_swa = '<tr colspan="4" class="card-body" id="' + id_detail + '" rowspan="1">';
		tr_detail_swa += '<td rowspan="1" colspan="10">';
		tr_detail_swa += '<div id="informasi-realisasi-penyedia-detail">';
		tr_detail_swa += '<table class="mb-0 table table-sm">' +
			'<thead>' +
			'<tr>' +
			'<th>Dokumen</th>' +
			'<th width="1%"></th>' +
			'<th width="1%">Nilai</th>' +
			'<th width="1%">Status</th>' +
			'</tr>' +
			'</thead>' +
			'<tbody id="dok-realisasi-' + id_paket + '">' +
			'</tbody>' +
			'</table>';
		tr_detail_swa += '</div>';
		tr_detail_swa += '</td>';
		tr_detail_swa += '</tr>';
		if (banyak_evidence>0) {
			if (status == 'collapse') {
				$(this).attr('status', 'expand');
				$(this).html('<i class="fa fa-minus"></i>');
				$(table).after(tr_detail_swa);
				dok_realisasi(id_instansi, id_paket);
			} else {
				$(this).attr('status', 'collapse');
				$(this).html('<i class="fa fa-plus"></i>');
				$('#' + id_detail).remove();
			}
		}else{
			Swal.fire('Evidence belum di upload','Evidence Paket pekerjaan '+nama_paket+' belum diupload Operator','warning');
		}
	});

	function dok_realisasi(id_instansi, id_paket_pekerjaan) {
		$.ajax({
			url: baseUrl('validasi/get_dok_realisasi/'),
			type: "POST",
			dataType: "JSON",
			data: {
				id_instansi: id_instansi,
				id_paket_pekerjaan: id_paket_pekerjaan
			},
			success: function(data) {
				if (data.status == true) {
					$('#dok-realisasi-' + id_paket_pekerjaan).html('');
					$.each(data.data, function(k, v) {
						$('#dok-realisasi-' + id_paket_pekerjaan).append(
							'<tr>' +
							'<td>' + v.dokumen + ' '+v.pelaksanaan+'</td>' +
							'<td><button class="btn btn-primary btn-sm" onclick="tampil_dokumen(' + "'" + v.file_dokumen + "','" + v.dokumen + "','" + v.id_realisasi_fisik + "','" + v.jenis_paket + "','" + v.id_metode + "','" + id_paket_pekerjaan + "','" + v.pelaksanaan + "','" + v.nilai_pelaksanaan + "',this" + ')"><i class="fa fa-folder-open"></i></button></td>' +
							'<td>' + v.nilai + '</td>' +
							'<td>' + v.status + '</td>' +
							'</tr>'
						);
					});
				}
			}
		});
	}

	function tampil_dokumen(file_url, dokumen, id_realisasi_fisik, jenis_paket, id_metode, id_paket_pekerjaan, pelaksanaan, nilai_pelaksanaan, prop) {
		// let a = $(prop).closest('tr')[0].cells[2];
		// let b = $(a).text('12');
		// clog(a);
		showModal('modal-dokumen-realisasi', dokumen + '' + pelaksanaan);
		$('#id_paket_pekerjaan').val(id_paket_pekerjaan);
		$('#id_realisasi_fisik').val(id_realisasi_fisik);
		$('#jenis_paket').val(jenis_paket);
		$('#id_metode').val(id_metode);
		$('#dokumen').val(dokumen);
		$('#nilai_pelaksanaan').val(nilai_pelaksanaan);
		$('#status').val('Pilih Status').trigger('change');
		var parent = $('#modal-dokumen-realisasi').find('iframe').parent();
		var srcpdf = $('#modal-dokumen-realisasi').find('iframe');
		var newElement = '<iframe src="' + baseUrl(file_url) + '" width="100%" height="500px">';
		$(srcpdf).remove();
		parent.append(newElement);
		// let parent = $('#modal-dokumen-realisasi').find('iframe').parent();
		// let srcpdf = $('#modal-dokumen-realisasi').find('iframe');
		// let newElement = '<iframe src="' + baseUrl('pdfjs/web/viewer.html?file=..') + '/../' + file_url + '&' + Math.floor(Math.random() * 1011000) + '" width="100%" height="500px">';
		// $(srcpdf).remove();
		// parent.append(newElement);
	}

	function form_keterangan(value) {
		let dok = $('#dokumen').val();
		let nilai_pelaksanaan = $('#nilai_pelaksanaan').val();

		$('#form-keterangan').html('');
		if (value == 'Sudah Validasi') {
			if (dok == 'PELAKSANAAN') {
				$('#form-keterangan').append('<input type="text" id="nilai" name="nilai" class="form-control" placeholder="Input Nilai '+nilai_pelaksanaan+'" required="true" value="'+nilai_pelaksanaan+'">');
			}
		} else if (value == 'Ditolak') {
			$('#form-keterangan').append('<input type="text" id="masalah" name="masalah" class="form-control" placeholder="Input Masalah">' +
				'<input type="text" id="solusi" name="solusi" class="form-control" placeholder="Input Solusi">');

		} else {
			$('#form-keterangan').html('');
		}
	}

	function update_nilai() {
		let id_instansi = $('#id_instansi_terpilih').val();
		let id_paket_pekerjaan = $('#id_paket_pekerjaan').val();
		let id_realisasi_fisik = $('#id_realisasi_fisik').val();
		let jenis_paket = $('#jenis_paket').val();
		let id_metode = $('#id_metode').val();
		let dokumen = $('#dokumen').val();
		let status = $('#status').val();

		if (status != "Pilih Status") {
			$.ajax({
				url: baseUrl('validasi/update_nilai/'),
				type: "POST",
				dataType: "JSON",
				data: {
					id_realisasi_fisik: id_realisasi_fisik,
					id_paket_pekerjaan: id_paket_pekerjaan,
					jenis_paket: jenis_paket,
					id_metode: id_metode,
					dokumen: dokumen,
					status: status,
					masalah: status = 'Ditolak' ? $('#masalah').val() : '',
					solusi: status = 'Ditolak' ? $('#solusi').val() : '',
					nilai: status != 'Ditolak' && dokumen == 'PELAKSANAAN' ? $('#nilai').val() : ''
				},
				success: function(data) {
					console.log(data);
					if (data.status == true) {
						$('#form-keterangan').html('');
						$('#modal-dokumen-realisasi').modal('hide');
						 identitas_paket(id_paket_pekerjaan);
						 tetapkan_skpd(id_instansi);
						// list_instansi();
						// show_table_swakelola(data.data);
						$('#table-paket-swakelola').DataTable().ajax.reload(null, false);
						$('#table-paket-penyedia').DataTable().ajax.reload(null, false);
						$('#table-paket-swakelola').find('.view_evidence_' + id_paket_pekerjaan).click();
					}else{

					Swal.fire('Error',data.message,'error');
					}
				},
				error: function(){
					console.log('error');
				}
			});
		} else {
			Swal.fire('Error','Anda belum memilih status validasi','error');
		}
	}





function show_all_statistika() {
	$('#modal_all_statistika').modal('show');
	
		$('#tampil_pdf_all_statistika').show();
		$('#tampil_pdf_all_statistika').attr('src', baseUrl('validasi/pdf_rekap_statistika') +  '#view=FitH');
		
	}


</script>