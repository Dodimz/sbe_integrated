
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

	var pesan_warning = `
    Anda berada pada penginputan data di <?php echo nama_tahapan().' '.tahun_anggaran() ?><br>
    Mohon periksa konfigurasi penginputan anda jika ingin mengubah tahapan APBD dan tahun anggaran <br>
    Data `;
  
    Swal.fire({
        html: pesan_warning ,
        title: 'Warning',
        icon: 'warning',
               
      // customClass: {
      //   popup: 'format-pre'
      // }
    });


	grafik('Akumulasi');
	function grafik(kategori){
		var sumber_data = requestData(kategori);
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
			$('#dfisik').append('<td>' + sumber_data.d_fisik[i] + '</td>');

			var deviasi_keuangan = sumber_data.r_keu[i] - sumber_data.keu[i];
			$('#tkeu').append('<td>' + sumber_data.keu[i] + '</td>');
			$('#rkeu').append('<td>' + sumber_data.r_keu[i] + '</td>');
			$('#dkeu').append('<td>' + sumber_data.d_keu[i] + '</td>');
		}
	
	}


pagu_realisasi();
	function pagu_realisasi(){
			Highcharts.chart('pagu', {
		    chart: {
		        type: 'pie'
		    },
		    title: {
		        text: 'Anggaran '
		    },
		    subtitle: {
		        text: 'Total Pagu : <?php echo number_format($anggaran_apbd); ?>'
		    },

		    accessibility: {
		        announceNewData: {
		            enabled: true
		        },
		        point: {
		            valueSuffix: '%'
		        }
		    },

		    plotOptions: {
		        series: {
		            dataLabels: {
		                enabled: true,
		                format: '{point.name} : {point.y:.1f}%'
		            }
		        }
		    },

		    tooltip: {
		        headerFormat: '',
		        pointFormat: '<span style="color:{point.color}">{point.name}: <b>{point.y:.2f}%</b><br/>Pagu : {point.z}</span>'
		    },

		    series: [
		        {
		            name: "Pagu",
		            colorByPoint: true,
		            data: [
		                {
		                    name: "Belanja Operasi",
		                    y: <?php echo $persen_bo; ?>,
		                    z: '<?php echo number_format($bo); ?>',
		                    drilldown: "bo"
		                },
		                {
		                    name: "Belanja Modal",
		                    y: <?php echo $persen_bm; ?>,
		                    z: '<?php echo number_format($bm); ?>',
		                    drilldown: "bm"
		                },
		                {
		                    name: "Belanja Tidak Terduga",
		                    y: <?php echo $persen_btt; ?>,
		                    z: '<?php echo number_format($btt); ?>',
		                    drilldown: "btt"
		                },
		                {
		                    name: "Belanja Transfer",
		                    y: <?php echo $persen_bt; ?>,
		                    z: '<?php echo number_format($bt); ?>',
		                    drilldown: "bt"
		                },
		              
		            ]
		        }
		    ],
		    drilldown: {
		        series: [
		            {
		                name: "Belanja Operasi",
		                id: "bo",
		                data: [
		                    {
			                    name: "Belanja Pegawai",
			                    y: <?php echo $persen_bo_bp; ?>,
			                    z: '<?php echo number_format($bo_bp); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Barang Jasa",
			                    y: <?php echo $persen_bo_bbj; ?>,
			                    z: '<?php echo number_format($bo_bbj); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Subsidi",
			                    y: <?php echo $persen_bo_bs; ?>,
			                    z: '<?php echo number_format($bo_bs); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Hibah",
			                    y: <?php echo $persen_bo_bh; ?>,
			                    z: '<?php echo number_format($bo_bh); ?>',
			                  
			                },
		                   
		                ]
		            },
		            {
		                name: "Belanja Modal",
		                id: "bm",
		                data: [
		                    {
			                    name: "Belanja Modal Tanah",
			                    y: <?php echo $persen_bm_bmt; ?>,
			                    z: '<?php echo number_format($bm_bmt); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Peralatan Dan Mesin",
			                    y: <?php echo $persen_bm_bmpm; ?>,
			                    z: '<?php echo number_format($bm_bmpm); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Gedung dan Bangunan",
			                    y: <?php echo $persen_bm_bmgb; ?>,
			                    z: '<?php echo number_format($bm_bmgb); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Jalan, Jaringan, dan Irigasi",
			                    y: <?php echo $persen_bm_bmjji; ?>,
			                    z: '<?php echo number_format($bm_bmjji); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal dan Aset Tetap Lainnya",
			                    y: <?php echo $persen_bm_bmatl; ?>,
			                    z: '<?php echo number_format($bm_bmatl); ?>',
			                  
			                },
		                   
		                ]
		            },

		            {
		                name: "Belanja Tidak Terduga",
		                id: "btt",
		                data: [
		                    {
			                    name: "Belanja Tidak Terduga",
			                    y: <?php echo $persen_btt; ?>,
			                    z: '<?php echo number_format($btt); ?>',
			                  
			                },
		                  
		                   
		                ]
		            },
		            {
		                name: "Belanja Transfer",
		                id: "bt",
		                data: [
		                    {
			                    name: "Belanja Bagi Hasil",
			                    y: <?php echo $persen_bt_bbh; ?>,
			                    z: '<?php echo number_format($bt_bbh); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Bantuan Keuangan",
			                    y: <?php echo $persen_bt_bbk; ?>,
			                    z: '<?php echo number_format($bt_bbk); ?>',
			                  
			                },
		                  
		                   
		                ]
		            },

		        ]
		    } //drildown
		});



		Highcharts.chart('terealisasi', {
		    chart: {
		        type: 'pie'
		    },
		    title: {
		        text: 'Realisasi '
		    },
		    subtitle: {
		        text: 'Total Direalisasikan : <?php echo number_format($rk_total)." (".$persen_rk_total."%)"; ?>'
		    },

		    accessibility: {
		        announceNewData: {
		            enabled: true
		        },
		        point: {
		            valueSuffix: '%'
		        }
		    },

		    plotOptions: {
		        series: {
		            dataLabels: {
		                enabled: true,
		                format: '{point.name} : {point.y:.1f}%'
		            }
		        }
		    },

		    tooltip: {
		        headerFormat: '',
		        pointFormat: '<span style="color:{point.color}">{point.name}: <b>{point.y:.2f}%</b><br/>Direalisasikan : {point.z}</span>'
		    },

		    series: [
		        {
		            name: "Direalisasikan",
		            colorByPoint: true,
		            data: [
		                {
		                    name: "Belanja Operasi",
		                    y: <?php echo $persen_rk_bo; ?>,
		                    z: '<?php echo number_format($rk_bo); ?>',
		                    drilldown: "bo"
		                },
		                {
		                    name: "Belanja Modal",
		                    y: <?php echo $persen_rk_bm; ?>,
		                    z: '<?php echo number_format($rk_bm); ?>',
		                    drilldown: "bm"
		                },
		                {
		                    name: "Belanja Tidak Terduga",
		                    y: <?php echo $persen_rk_btt; ?>,
		                    z: '<?php echo number_format($rk_btt); ?>',
		                    drilldown: "btt"
		                },
		                {
		                    name: "Belanja Transfer",
		                    y: <?php echo $persen_rk_bt; ?>,
		                    z: '<?php echo number_format($rk_bt); ?>',
		                    drilldown: "bt"
		                },
		              
		            ]
		        }
		    ],
		    drilldown: {
		        series: [
		            {
		                name: "Belanja Operasi",
		                id: "bo",
		                data: [
		                    {
			                    name: "Belanja Pegawai",
			                    y: <?php echo $persen_rk_bo_bp; ?>,
			                    z: '<?php echo number_format($rk_bo_bp); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Barang Jasa",
			                    y: <?php echo $persen_rk_bo_bbj; ?>,
			                    z: '<?php echo number_format($rk_bo_bbj); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Subsidi",
			                    y: <?php echo $persen_rk_bo_bs; ?>,
			                    z: '<?php echo number_format($rk_bo_bs); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Hibah",
			                    y: <?php echo $persen_rk_bo_bh; ?>,
			                    z: '<?php echo number_format($rk_bo_bh); ?>',
			                  
			                },
		                   
		                ]
		            },
		            {
		                name: "Belanja Modal",
		                id: "bm",
		                data: [
		                    {
			                    name: "Belanja Modal Tanah",
			                    y: <?php echo $persen_rk_bm_bmt; ?>,
			                    z: '<?php echo number_format($rk_bm_bmt); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Peralatan Dan Mesin",
			                    y: <?php echo $persen_rk_bm_bmpm; ?>,
			                    z: '<?php echo number_format($rk_bm_bmpm); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Gedung dan Bangunan",
			                    y: <?php echo $persen_rk_bm_bmgb; ?>,
			                    z: '<?php echo number_format($rk_bm_bmgb); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal Jalan, Jaringan, dan Irigasi",
			                    y: <?php echo $persen_rk_bm_bmjji; ?>,
			                    z: '<?php echo number_format($rk_bm_bmjji); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Modal dan Aset Tetap Lainnya",
			                    y: <?php echo $persen_rk_bm_bmatl; ?>,
			                    z: '<?php echo number_format($rk_bm_bmatl); ?>',
			                  
			                },
		                   
		                ]
		            },

		            {
		                name: "Belanja Tidak Terduga",
		                id: "btt",
		                data: [
		                    {
			                    name: "Belanja Tidak Terduga",
			                    y: <?php echo $persen_rk_btt; ?>,
			                    z: '<?php echo number_format($rk_btt); ?>',
			                  
			                },
		                  
		                   
		                ]
		            },
		            {
		                name: "Belanja Transfer",
		                id: "bt",
		                data: [
		                    {
			                    name: "Belanja Bagi Hasil",
			                    y: <?php echo $persen_rk_bt_bbh; ?>,
			                    z: '<?php echo number_format($rk_bt_bbh); ?>',
			                  
			                },
		                    {
			                    name: "Belanja Bantuan Keuangan",
			                    y: <?php echo $persen_rk_bt_bbk; ?>,
			                    z: '<?php echo number_format($rk_bt_bbk); ?>',
			                  
			                },
		                  
		                   
		                ]
		            },

		        ]
		    }
		});





	// grafik batang kelompok pagu jenis belaja
	
	// grafik batang kelompok pagu jenis belaja


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
				id_group : '<?php echo $this->session->userdata('id_group') ?>',
				kategori : kategori
			},
			dataType: "json",

            async: false,
			success: function(data) {
				// console.log(data);
				result = data;
				
			},
			// cache: false
		});

		return result;
	}



	function sync(id_instansi) {
		$('#tombol_sync').text('Loading...').attr('disabled', true);
		start_loading('Synchronize..');

		var tahapan_apbd = '<?php echo tahapan_apbd() ?>';
		var tahun = '<?php echo tahun_anggaran() ?>';

			if(tahun<=2022){

				$.ajax({
					url: baseUrl('synchronize/sync'),
					type: 'POST',
					dataType: 'JSON',
					data: {
						id_instansi: id_instansi,
						tahapan_apbd : tahapan_apbd
					},
					success: function(data) {
						console.log(data);
						if (data.status == true) {
							window.location.href = "<?php echo base_url(); ?>dashboard";
						}
					stop_loading();
				},
				error : function(){
					console.log('error');
					stop_loading();
					$('#tombol_sync').text('Reload Page').attr('disabled', false);
					$('#tombol_sync').attr('onclick', "reload()");
				}
			});
		}else{

			$.ajax({
					url: baseUrl('synchronize/synch_baru/' + tahun + '/' + tahapan_apbd + '/' + id_instansi),
				type: 'GET',
				dataType: 'JSON',
				data: {
					
				},
				success: function(data) {
					console.log(data);
						$('#tahap-2'+ '-' + id_instansi).find('i').attr('class', 'ion ion-checkmark');

						$('#tahap-2'+ '-' + id_instansi).attr('class', 'btn btn-sm btn-success selesai_sinkron');
						var selesai = $('.selesai_sinkron').length; 
						$('#banyak_selesai').html(selesai);

						// $('#cek_status_progress_' + id_instansi).attr('style','background:green-light');
					


					if (data.responcode == 200) {
						Swal.fire(data.synchronize, data.message,data.status)
						window.location.href = "<?php echo base_url(); ?>dashboard";
					}
					else{
						stop_loading();
						Swal.fire(data.synchronize, data.message,data.status);
						$('#tombol_sync').text('Reload Page').attr('disabled', false);
						$('#tombol_sync').attr('onclick', "reload()");
					}

				},
				error : function(){
					stop_loading();
						Swal.fire('Error', 'Terjadi Kesalahan','error');
						$('#tombol_sync').text('Reload Page').attr('disabled', false);
						$('#tombol_sync').attr('onclick', "reload()");
					
				}
			});

		}
}

	function reload(){
		window.location.href = "<?php echo base_url(); ?>dashboard";
	}
</script>