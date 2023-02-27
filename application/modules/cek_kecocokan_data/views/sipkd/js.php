<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<script>
	$(document).ready(function() {
		show_opd();
	});

	function show_opd() {
		$.ajax({
			url: baseUrl('web_services/get_opd'),
			type: 'POST',
			dataType: 'JSON',
			data: {},
			success: function(data) {
				if (data.status == true) {
					$('#aliran-kas-opd').html('');
					$.each(data.data, function(k, v) {
						$('#aliran-kas-opd').append('<tr>' +
							'<th scope="row">' + (k + 1) + '</th>' +
							'<td>' + v.kode_opd + '</td>' +
							'<td>' + v.nama_instansi + '</td>' +
							'<td style="text-align: center;">' +
							'<button class="btn btn-primary btn-sm tahap-2" id="tahap-2-' + v.id_instansi + '" onclick="aliran_kas(' + "'2','" + v.kode_opd + "','" + v.id_instansi + "'" + ')">' +
							'<i class="pe-7s-science btn-icon-wrapper"> </i>' +
							'</button>' +
							'</td>' +
							'<td style="text-align: center;">' +
							'<button class="btn btn-primary btn-sm tahap-4" id="tahap-4-' + v.id_instansi + '" onclick="aliran_kas(' + "'4','" + v.kode_opd + "','" + v.id_instansi + "'" + ')">' +
							'<i class="pe-7s-science btn-icon-wrapper"> </i>' +
							'</button>' +
							'</td>' +
							'<td style="text-align: center;">' +
							'<button class="btn btn-primary btn-sm akumulasi" id="akumulasi-' + v.id_instansi + '" onclick="akumulasi(' + "'" + v.id_instansi + "'" + ')">' +
							'<i class="pe-7s-science btn-icon-wrapper"> </i>' +
							'</button>' +
							'</td>' +
							'</tr>');
					});
				}
			}
		});
	}

	function aliran_kas(tahap, kode_opd, id_instansi) {
		$.ajax({
			url: baseUrl('web_services/aliran_kas'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				tahap: tahap,
				kode_opd: kode_opd
			},
			success: function(data) {
				if (data.status == true) {
					$('#tahap-' + tahap + '-' + id_instansi).attr('class', 'btn btn-sm btn-success');
					$('#tahap-' + tahap + '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');
				}
			}
		});
	}

	function akumulasi(id_instansi) {
		$.ajax({
			url: baseUrl('web_services/akumulasi/'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_instansi: id_instansi
			},
			success: function(data) {
				if (data.status == true) {
					$('#akumulasi-' + id_instansi).attr('class', 'btn btn-sm btn-success');
					$('#akumulasi-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');
				}
			}
		});
	}

	function all_tahap_2() {
		$('.tahap-2').trigger('click');
	}

	function all_tahap_4() {
		$('.tahap-4').trigger('click');
	}

	function all_akumulasi() {
		$('.akumulasi').trigger('click');
	}

	function sync(req) {
		$('#' + req).text('Loading...')
			.attr('disabled', true);
		$.ajax({
			url: baseUrl('web_services/sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				req: req
			},
			success: function(data) {
				$('#' + req).attr('class', 'mb-2 mr-2 btn-icon btn-icon-only btn btn-success');
				$('#' + req).html('<i class="pe-7s-science btn-icon-wrapper"> </i>');
				$('#' + req).attr('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	}

	function sync_tmp(req, tahap) {
		$('#' + req).text('Loading...')
			.attr('disabled', true);
		$.ajax({
			url: baseUrl('web_services/sync_tmp'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				req: req,
				tahap: tahap
			},
			success: function(data) {
				$('#' + req).attr('class', 'mb-2 mr-2 btn-icon btn-icon-only btn btn-success');
				$('#' + req).html('<i class="pe-7s-science btn-icon-wrapper"> </i>');
				$('#' + req).attr('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	}

	function multi_sync(req, tahap) {
		$('#' + req).text('Loading...')
			.attr('disabled', true);
		$.ajax({
			url: baseUrl('web_services/multi_sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				req: req,
				tahap: tahap
			},
			success: function(data) {
				$('#' + req).attr('class', 'mb-2 mr-2 btn-icon btn-icon-only btn btn-success');
				$('#' + req).html('<i class="pe-7s-science btn-icon-wrapper"> </i>');
				$('#' + req).attr('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	}

	function realisasi_sync(req) {
		$('#' + req).text('Loading...')
			.attr('disabled', true);
		$.ajax({
			url: baseUrl('web_services/realisasi_sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				req: req
			},
			success: function(data) {
				$('#' + req).attr('class', 'mb-2 mr-2 btn-icon btn-icon-only btn btn-success');
				$('#' + req).html('<i class="pe-7s-science btn-icon-wrapper"> </i>');
				$('#' + req).attr('disabled', false);
			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	}
</script>