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
		$('.tables').hide();
	});

	function list_instansi() {
		$.ajax({
			url: baseUrl('validasi/get_instansi/'),
			type: "POST",
			dataType: "JSON",
			data: {},
			success: function(data) {
				if (data.status == true) {
					$('#list-instansi').html('');
					$.each(data.data, function(k, v) {
						let badge = v.belum_validasi > 0 ? "badge badge-danger badge-pill" : "badge badge-success badge-pill";

						$('#list-instansi').append('<a href="javascript:void(0);" onclick="tampil_paket(' + "'" + v.id_instansi + "','" + v.belum_validasi_swa + "','" + v.belum_validasi_pen + "', this" + ')" class="list-group-item lg-item" id="list-group-item-' + (k + 1) + '">' +
							v.nama_instansi + ' ' +
							'<span class="' + badge + '">' + v.belum_validasi + '</span>' +
							'</a>'
						);
					});
					$('.lg-item').first().trigger('click');
				}
			}
		});
	}

	function tampil_paket(id_instansi, swa, pen, prop) {
		let parent = $(prop).closest('.list-group-item').attr('id');
		$('.lg-item').removeClass('list-group-item-info');
		$('#' + parent).addClass('list-group-item-info');

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
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
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
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
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
		let vol = $(this).attr('vol');

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
							'<td>' + v.dokumen + '</td>' +
							'<td><button class="btn btn-primary btn-sm" onclick="tampil_dokumen(' + "'" + v.file_dokumen + "','" + v.dokumen + "','" + v.id_realisasi_fisik + "','" + v.jenis_paket + "','" + v.id_metode + "','" + id_paket_pekerjaan + "',this" + ')">View</button></td>' +
							'<td>' + v.nilai + '</td>' +
							'<td>' + v.status + '</td>' +
							'</tr>'
						);
					});
				}
			}
		});
	}

	function tampil_dokumen(file_url, dokumen, id_realisasi_fisik, jenis_paket, id_metode, id_paket_pekerjaan, prop) {
		// let a = $(prop).closest('tr')[0].cells[2];
		// let b = $(a).text('12');
		// clog(a);
		showModal('modal-dokumen-realisasi', dokumen);
		$('#id_paket_pekerjaan').val(id_paket_pekerjaan);
		$('#id_realisasi_fisik').val(id_realisasi_fisik);
		$('#jenis_paket').val(jenis_paket);
		$('#id_metode').val(id_metode);
		$('#dokumen').val(dokumen);
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

		$('#form-keterangan').html('');
		if (value == 'Sudah Validasi') {
			if (dok == 'PELAKSANAAN') {
				$('#form-keterangan').append('<input type="text" id="nilai" name="nilai" class="form-control" placeholder="Input Nilai" required="true">');
			}
		} else if (value == 'Ditolak') {
			$('#form-keterangan').append('<input type="text" id="masalah" name="masalah" class="form-control" placeholder="Input Masalah">' +
				'<input type="text" id="solusi" name="solusi" class="form-control" placeholder="Input Solusi">');

		} else {
			$('#form-keterangan').html('');
		}
	}

	function update_nilai() {
		let id_paket_pekerjaan = $('#id_paket_pekerjaan').val();
		let id_realisasi_fisik = $('#id_realisasi_fisik').val();
		let jenis_paket = $('#jenis_paket').val();
		let id_metode = $('#id_metode').val();
		let dokumen = $('#dokumen').val();
		let status = $('#status').val();

		if (status != "") {
			$.ajax({
				url: baseUrl('validasi/update_nilai/'),
				type: "POST",
				dataType: "JSON",
				data: {
					id_realisasi_fisik: id_realisasi_fisik,
					jenis_paket: jenis_paket,
					id_metode: id_metode,
					dokumen: dokumen,
					status: status,
					masalah: status = 'Ditolak' ? $('#masalah').val() : '',
					solusi: status = 'Ditolak' ? $('#solusi').val() : '',
					nilai: status != 'Ditolak' && dokumen == 'PELAKSANAAN' ? $('#nilai').val() : ''
				},
				success: function(data) {
					if (data.status == true) {
						$('#form-keterangan').html('');
						$('#modal-dokumen-realisasi').modal('hide');
						// list_instansi();
						// show_table_swakelola(data.data);
						$('#table-paket-swakelola').DataTable().ajax.reload(null, false);
						$('#table-paket-penyedia').DataTable().ajax.reload(null, false);
					}
				}
			});
		} else {
			alert('Pilih Status !');
		}
	}
</script>