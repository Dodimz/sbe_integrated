<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
ec
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
							'<button class="btn btn-info btn-sm hitung_intansi" onclick="view_grafik(' + "'" + v.id_instansi + "'" + ',' + "'" + v.nama_instansi + "'" + ')" data-toggle="tooltip" title="Lihat grafik '+v.nama_instansi+'">' +
							'<i class="fa fa-signal"></i>' +
							'</button> ' +
							'<button class="btn btn-primary btn-sm synch" id="synch-' + v.id_instansi + '" onclick="sync(' + "'" + v.id_instansi + "'" + ')" data-toggle="tooltip" title="synchronize grafik '+v.nama_instansi+'">' +
							'<i class="fa fa-fw" aria-hidden="true"></i>' +
							'</button>' +
							'</td>' +
							'</tr>');
					});
				}
			}
		});
	}


	function sync_all() {
		$('.synch').trigger('click');
		$('#tombol_sync_all').html("Loading....<br> [Selesai <span id='banyak_selesai'>0</span>]").attr('disabled', true);
	}

	function sync(id_instansi) {
		var banyak_instansi = $('.hitung_intansi').length; 
		$('#synch'+ '-' + id_instansi).html('<i class="fa fa-cog fa-w-3 fa-spin"></i>').attr('disabled', true);
		$.ajax({
			url: baseUrl('synchronize/sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_instansi : id_instansi
			},
			success: function(data) {
				if (data.status == true) {
					$('#synch'+ '-' + id_instansi).attr('class', 'btn btn-sm btn-success selesai_sinkron');
					$('#synch'+ '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');
					var selesai = $('.selesai_sinkron').length; 
					$('#banyak_selesai').html(selesai);
					if (selesai==banyak_instansi) {
						$('#tombol_sync_all').html("Selesai Sinkronisasi ["+selesai+"]").attr('class', 'btn btn-success btn-sm');
					}
				}
			},
			error : function(){

				$('#synch'+ '-' + id_instansi).attr('class', 'btn btn-sm btn-success selesai_sinkron');
				$('#synch'+ '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');
				var selesai = $('.selesai_sinkron').length; 
				$('#banyak_selesai').html(selesai);
				if (selesai==banyak_instansi) {
						$('#tombol_sync_all').html("Selesai Sinkronisasi ["+selesai+"]").attr('class', 'btn btn-success btn-sm');
					}

				
			}
		});


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
		$('#modal_grafik_skpd').find('#tfisik').html('<td rowspan="3" align="center">Fisik</td>');
		$('#modal_grafik_skpd').find('#tkeu').html('<td rowspan="3" align="center">Keuangan</td>');
		$('#modal_grafik_skpd').find('#rfisik').html('');
		$('#modal_grafik_skpd').find('#dfisik').html('');
		$('#modal_grafik_skpd').find('#rkeu').html('');
		$('#modal_grafik_skpd').find('#dkeu').html('');

		grafik('Akumulasi', id_instansi);








	}



function grafik(kategori, id_instansi){
		var sumber_data = requestData(kategori,id_instansi);
		Highcharts.chart('grafik_realisasi_skpd', {
		  chart: {
		    zoomType: 'xy'
		  },
		  title: {
		    text: 'Perncapaian Total SKPD'
		  },
		  subtitle: {
		    text: 'Berdasarkan ' + kategori
		  },
		  xAxis: [{
		    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		    crosshair: true
		  }],
		  yAxis: [{ // Primary yAxis
		    labels: {
		      format: '{value}%',
		      style: {
		        color: Highcharts.getOptions().colors[1]
		      }
		    },
		    title: {
		      text: 'Target',
		      style: {
		        color: Highcharts.getOptions().colors[1]
		      }
		    }
		  }, { // Secondary yAxis
		    title: {
		      text: 'Realisasi',
		      style: {
		        color: Highcharts.getOptions().colors[0]
		      }
		    },
		    labels: {
		      format: '{value}%',
		      style: {
		        color: Highcharts.getOptions().colors[0]
		      }
		    },
		    opposite: true
		  }],
		  tooltip: {
		    shared: true
		  },
		  legend: {
		    layout: 'vertical',
		    align: 'left',
		    x: 120,
		    verticalAlign: 'top',
		    y: 100,
		    floating: true,
		    backgroundColor:
		      Highcharts.defaultOptions.legend.backgroundColor || // theme
		      'rgba(255,255,255,0.25)'
		  },
		  series: [
			  {
			    name: 'Target Fisik',
			    type: 'column',
			    yAxis: 1,
			    data: sumber_data.fisik,
			    tooltip: {
			      valueSuffix: '%'
			    }
			  }, 
			  {
			    name: 'Realisasi Fisik',
			    type: 'line',
			    data: sumber_data.r_fis,
				// color: '#caf3d5',
			    tooltip: {
			      valueSuffix: '%'
			    }
			  },
			  {
			    name: 'Target Keuangan',
			    type: 'column',
			    yAxis: 1,
			    data: sumber_data.keu,
			    tooltip: {
			      valueSuffix: '%'
			    }
			  }, 
			  {
			    name: 'Realisasi Keuangan',
			    type: 'line',
			    data: sumber_data.r_keu,
				// color: '#caf3d5',
			    tooltip: {
			      valueSuffix: '%'
			    }
			  }
		  ]
		});


		$('#tfisik').html('<td rowspan="3" align="center">Fisik</td>');
		$('#rfisik').html('');
		$('#dfisik').html('');
		$('#tkeu').html('<td rowspan="3" align="center">Keuangan</td>');
		$('#rkeu').html('');
		$('#dkeu').html('');

		$('#tfisik').append('<td>Target</td>');
		$('#rfisik').append('<td>Realisasi</td>');
		$('#dfisik').append('<td>Deviasi</td>');
		$('#tkeu').append('<td>Target</td>');
		$('#rkeu').append('<td>Realisasi</td>');
		$('#dkeu').append('<td>Deviasi</td>');
		for (var i = 0; i < 12; i++) {
			var deviasi_fisik = sumber_data.r_fis[i] - sumber_data.fisik[i];
			$('#tfisik').append('<td>' + sumber_data.fisik[i] + '</td>');
			$('#rfisik').append('<td>' + sumber_data.r_fis[i] + '</td>');
			$('#dfisik').append('<td>' + deviasi_fisik.toFixed(2) + '</td>');

			var deviasi_keuangan = sumber_data.r_keu[i] - sumber_data.keu[i];
			$('#tkeu').append('<td>' + sumber_data.keu[i] + '</td>');
			$('#rkeu').append('<td>' + sumber_data.r_keu[i] + '</td>');
			$('#dkeu').append('<td>' + deviasi_keuangan.toFixed(2) + '</td>');
		}
	
	}




	function requestData(kategori) {
		var rf = [];
		var rk = [];
		var ba = <?php echo bulan_aktif(); ?>;
				// console.log($('#id_instansi_grafik').val());
		$.ajax({
			url: '<?php echo base_url('dashboard/show_chart'); ?>',
			type: "GET",
			data : {
				id_instansi : $('#id_instansi_grafik').val(),
				id_group : '5',
				kategori : kategori
			},
			dataType: "json",

            async: false,
			success: function(data) {
				console.log($('#id_instansi_grafik').val());
				result = data;
				
			},
			error: function() {
			
				result = Swal.fire('Error','Tidak dapat enampilkan data, Silahkan di synchronesasi dulu untuk meluhat data','error');
				
			},
			// cache: false
		});

		return result;
	}




</script>