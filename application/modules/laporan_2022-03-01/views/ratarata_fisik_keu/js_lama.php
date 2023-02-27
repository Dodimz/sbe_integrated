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
		data_fisik_keu();
		// show_data_skpd();
	});

	


	function data_fisik_keu() {
		$.ajax({
			url: baseUrl('laporan/data_ratarata_fisik_keu'),
			type: 'POST',
			dataType: 'JSON',
			data: {},
			success: function(data) {
				if (data.status == true) {
					$('#data_fisik_keu').html('');
					$.each(data.data, function(k, v) {
						$('#data_fisik_keu').append('<tr>' +
							'<th scope="row">' + (k + 1) + '</th>' +
					
							'<td>' + v.nama_instansi + '</td>' +
							'<td align="right">' + v.pagu_anggaran + '</td>' +
							'<td>' + v.target_fisik + '</td>' +
							'<td>' + v.realisasi_fisik + '</td>' +
							'<td>' + v.deviasi_fisik + '</td>' +

							'<td>' + v.target_keuangan + '</td>' +
							'<td>' + v.realisasi_keuangan + '</td>' +
							'<td>' + v.deviasi_keuangan + '</td>' +
							
							
							'</tr>');
					});

					// $('#data_jumlah_aktivitas').append('<tr>' +
					// 	'<th scope="row" colspan=2>Total</th>' +
					// 	'<td align="right">' + data.total_anggaran + '</td>' +
					// 	'<td>' + 'Dalam proses' + '</td>' +
					// 	'<td>' + 'Dalam proses' + '</td>' +
					// 	'<td>' + data.total_paket_rutin + '</td>' +
					// 	'<td>' + data.total_paket_swakelola + '</td>' +
					// 	'<td>' + data.total_paket_penyedia + '</td>' +
					
					
						
						
					// 	'</tr>');
				}
			}
		});
	}


	function urutkan_berdasarkan(kategori) {
		if (kategori=='keuangan') {
			$('#realisasi_aktif').html('Keuangan');
		}else{
			$('#realisasi_aktif').html('Fisik');
		}
			// $('#urutkan_' + kategori).attr('disable');


		$.ajax({
			url: baseUrl('laporan/data_ratarata_fisik_keu/' + kategori),
			type: 'POST',
			dataType: 'JSON',
			data: {},
			success: function(data) {
				if (data.status == true) {
					$('#data_fisik_keu').html('');
					$.each(data.data, function(k, v) {
						$('#data_fisik_keu').append('<tr>' +
							'<th scope="row">' + (k + 1) + '</th>' +
					
							'<td>' + v.nama_instansi + '</td>' +
							'<td align="right">' + v.pagu_anggaran + '</td>' +
							'<td>' + v.target_fisik + '</td>' +
							'<td>' + v.realisasi_fisik + '</td>' +
							'<td>' + v.deviasi_fisik + '</td>' +

							'<td>' + v.target_keuangan + '</td>' +
							'<td>' + v.realisasi_keuangan + '</td>' +
							'<td>' + v.deviasi_keuangan + '</td>' +
							
							
							'</tr>');
					});

					// $('#data_jumlah_aktivitas').append('<tr>' +
					// 	'<th scope="row" colspan=2>Total</th>' +
					// 	'<td align="right">' + data.total_anggaran + '</td>' +
					// 	'<td>' + 'Dalam proses' + '</td>' +
					// 	'<td>' + 'Dalam proses' + '</td>' +
					// 	'<td>' + data.total_paket_rutin + '</td>' +
					// 	'<td>' + data.total_paket_swakelola + '</td>' +
					// 	'<td>' + data.total_paket_penyedia + '</td>' +
					
					
						
						
					// 	'</tr>');
				}
			}
		});
	}


	
</script>