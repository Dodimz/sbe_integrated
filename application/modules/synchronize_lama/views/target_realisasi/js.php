<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<!-- Export -->
<script src="https://code.highcharts.com/modules/exporting.js"></script>
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
				console.log(data)
				if (data.status == true) {
					$('#aliran-kas-opd').html('');
					$.each(data.data, function(k, v) {
						$('#aliran-kas-opd').append('<tr>' +
							'<th scope="row">' + (k + 1) + '</th>' +
							'<td>' + v.kode_opd + '</td>' +
							'<td>' + v.nama_instansi + '</td>' +
							'<td>' + v.bulan_mulai_realisasi + '</td>' +
							'<td>' + v.bulan_akhir_realisasi + '</td>' +
							'<td>' + v.status + '</td>' +
							'<td style="text-align: center;">' +
							'<button class="btn btn-info btn-sm" onclick="view_grafik(' + "'" + v.id_instansi + "'" + ',' + "'" + v.nama_instansi + "'" + ')" data-toggle="tooltip" title="Lihat grafik '+v.nama_instansi+'">' +
							'<i class="fa fa-signal"></i>' +
							'</button> ' +
							'<button class="btn btn-primary btn-sm tahap-2" id="tahap-2-' + v.id_instansi + '" onclick="sync(' + "'" + v.id_instansi + "'" + ')" data-toggle="tooltip" title="synchronize grafik '+v.nama_instansi+'">' +
							'<i class="pe-7s-science btn-icon-wrapper"> </i>' +
							'</button>' +
							'</td>' +
							'</tr>');
					});
				}
			}
		});
	}


	function sync_all() {
		$('.tahap-2').trigger('click');
		$('#tombol_sync_all').html("Loading....<br> [Selesai <span id='banyak_selesai'>0</span>]").attr('disabled', true);
	}

	function sync(id_instansi) {
		console.log(id_instansi);
		$('#tahap-2'+ '-' + id_instansi).html('<i class="fa fa-cog fa-w-3 fa-spin"></i>').attr('disabled', true);
		$.ajax({
			url: baseUrl('synchronize/sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_instansi : id_instansi
			},
			success: function(data) {
				if (data.status == true) {
					$('#tahap-2'+ '-' + id_instansi).attr('class', 'btn btn-sm btn-success');
					$('#tahap-2'+ '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');
				}
			},
			error : function(){
				var selesai = parseInt($('#banyak_selesai').html()) + 1;

				$('#tahap-2'+ '-' + id_instansi).attr('class', 'btn btn-sm btn-success');
				$('#tahap-2'+ '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');

				$('#banyak_selesai').html(selesai);
				if (selesai==total_instansi()) {
					$('#tombol_sync_all').html('Synchronize semua SKPD Selesai');
					$('#tombol_sync_all').attr('class','btn btn-success');
				}
			}
		});
	}

	
	function total_instansi() {
		$.ajax({
			url: baseUrl('synchronize/semua_instansi'),
			type: 'POST',
			dataType: 'JSON',
			data: {},
            async: false,
			success: function(data) {
				instansi = data;
			},
			error : function(){
				
			}
		});
		return instansi;
	}






	function Arrays_calc(array1, array2, ope) {
		var result = [];
		var ctr = 0;
		var x = 0;

		if (array1.length === 0)
			return "array1 is empty";
		if (array2.length === 0)
			return "array2 is empty";

		while (ctr < array1.length && ctr < array2.length) {
			switch (ope) {
				case '-':
					result.push(array1[ctr] - array2[ctr]);
					break;
				case '+':
					result.push(array1[ctr] + array2[ctr]);
			}
			ctr++;
		}

		if (ctr === array1.length) {
			for (x = ctr; x < array2.length; x++) {
				result.push(array2[x]);
			}
		} else {
			for (x = ctr; x < array1.length; x++) {
				result.push(array1[x]);
			}
		}

		var hasil = [];
		$.each(result, function(k, v) {
			hasil.push(v.toFixed(2));
		});

		return hasil;
	}




	function view_grafik(id_instansi, nama_instansi) {
		$('#modal_grafik_skpd').modal('show');
		$('#modal_grafik_skpd').find('#id_instansi_grafik').val(id_instansi);
		$('#modal_grafik_skpd').find('#nama_skpd').html('<br>'+nama_instansi);

		




		$(document).ready(function() {
		chart_fisik = new Highcharts.chart('fisik', {
			chart: {
				type: 'line',
				events: {
					load: requestData
				}
			},
			title: {
				text: ''
			},
			subtitle: {
				text: 'Tahun 2021'
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				gridLineWidth: 1
			},
			yAxis: {
				title: {
					text: 'Persentase (%)'
				},
				min: 0,
				max: 100,
				tickInterval: 10,
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: true
				},
			},
		});

		chart_keuangan = new Highcharts.chart('keuangan', {
			chart: {
				type: 'line'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: 'Tahun 2021'
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				gridLineWidth: 1
			},
			yAxis: {
				title: {
					text: 'Persentase (%)'
				},
				min: 0,
				max: 100,
				tickInterval: 10,
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: true
				},
			},

		});
	});




	}









	function requestData(id_instansi) {
		var rf = [];
		var rk = [];
		var ba = <?php echo date('n'); ?>;
		$.ajax({
			url: '<?php echo base_url('dashboard/show_chart'); ?>',
			type: "GET",
			data : {
				id_instansi : $('#id_instansi_grafik').val(),
				id_group : '5'
			},
			dataType: "json",
			success: function(data) {
				console.log(data);
				$.each(data.r_fis, function(x, y) {
					if (x < parseInt(ba)) {
						rf[x] = y;
					}
				});
				$.each(data.r_keu, function(k, v) {
					if (k < parseInt(ba)) {
						rk[k] = v;
					}

				});
				chart_fisik.addSeries({
					name: "Target Fisik",
					data: data.fisik
				});
				chart_fisik.addSeries({
					name: "Realisasi Fisik",
					data: rf
				});
				chart_keuangan.addSeries({
					name: "Target Keuangan",
					data: data.keu
				});
				chart_keuangan.addSeries({
					name: "Realisasi Keuangan",
					data: rk
				});

				$('#tfisik').html('');
				$('#rfisik').html('');
				$('#dfisik').html('');
				$('#tkeu').html('');
				$('#rkeu').html('');
				$('#dkeu').html('');

				$('#tfisik').each(function() {
					$(this).append('<td>T</td>');
					for (var i = 0; i < 12; i++) {
						$(this).append('<td>' + data.fisik[i] + '</td>');
					}
				});

				$('#rfisik').each(function() {
					$(this).append('<td>R</td>');
					for (var i = 0; i < ba; i++) {
						$(this).append('<td>' + data.r_fis[i] + '</td>');
					}
				});

				$('#tkeu').each(function() {
					$(this).append('<td>T</td>');
					for (var i = 0; i < 12; i++) {
						$(this).append('<td>' + data.keu[i] + '</td>');
					}
				});

				$('#rkeu').each(function() {
					$(this).append('<td>R</td>');
					for (var i = 0; i < ba; i++) {
						$(this).append('<td>' + data.r_keu[i] + '</td>');
					}
				});

				var d_fis = Arrays_calc(rf, data.fisik, '-');
				var d_keu = Arrays_calc(rk, data.keu, '-');

				$('#dfisik').each(function() {
					$(this).append('<td>D</td>');
					for (var i = 0; i < parseInt(ba); i++) {
						$(this).append('<td>' + d_fis[i] + '</td>');
					}
				});

				$('#dkeu').each(function() {
					$(this).append('<td>D</td>');
					for (var i = 0; i < parseInt(ba); i++) {
						$(this).append('<td>' + d_keu[i] + '</td>');
					}
				});
			},
			cache: false
		});
	}



</script>