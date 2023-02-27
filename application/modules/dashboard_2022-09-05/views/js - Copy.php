<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Chart -->
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<!-- Export -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
	var chart_fisik;
	var chart_keuangan;
	var chart_pagu;
	var chart_realisasi;
	var chart_pagu_dan_realisasi;

	$(document).on('ready', function() {
		$('.app-page-title').remove();
	});

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
	chart_pagu = new Highcharts.chart('pagu', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Grafik Anggaran '
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
    }
});


		chart_realisasi = new Highcharts.chart('terealisasi', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Grafik Realisasi '
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





	chart_pagu_dan_realisasi = new Highcharts.chart('perbandingan', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Grafik Perbandingan Pagu Dan Realisasi Berdasarkan Jenis Belanja'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: [
			'Belanja Pegawai',
			'Belanja Barang Jasa',
			'Belanja Subsidi',
			'Belanja Hibah',
			'Belanja Modal Tanah',
			'Belanja Modal Peralatan Dan mesin',
			'Belanja Modal Gedung Dan Bangunan',
			'Belanja Modal Jalan, Jaringan, Dan Irigasi',
			'Belanja Modal Dan Aset Tetap Lainnya',
			'Belanja Tidak Terduga',
			'Belanja Bagi Hasil',
			'Belanja Bantuan Keuangan',
        ],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Pagu',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Direalisasikan',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} mm',
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
        name: 'Rainfall',
        type: 'column',
        yAxis: 1,
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
        tooltip: {
            valueSuffix: ' mm'
        }

    }, {
        name: 'Temperature',
        type: 'spline',
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
        tooltip: {
            valueSuffix: '°C'
        }
    }]
});




	chart_pagu_dan_realisasi_kelompok = new Highcharts.chart('perbandingan_kelompok', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Grafik Perbandingan Pagu Dan Realisasi Per Kelompok Jenis Belanja'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: ['Belanja Operasi', 'Belanja Modal', 'Belanja Tidak Terduga', 'Belanja Transfer'],
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
            text: 'Temperature',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, 
    { // Secondary yAxis
        title: {
            text: 'Rainfall',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value}',
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
    series: [{
        name: 'Pagu',
        type: 'column',
        yAxis: 1,
        data: [
			<?php echo $persen_bo; ?>,
			<?php echo $persen_bm; ?>,
			<?php echo $persen_btt; ?>,
			<?php echo $persen_bt; ?>
		],
        tooltip: {
            valueSuffix: ' %'
        }

    }, {
        name: 'Direalisasikan',
        type: 'spline',
        data: [
			<?php echo $persen_rk_bo; ?>,
			<?php echo $persen_rk_bm; ?>,
			<?php echo $persen_rk_btt; ?>,
			<?php echo $persen_rk_bt; ?>
		],
        tooltip: {
            valueSuffix: '%'
        }
    }]
});








	chart_pagu_dan_realisasi = new Highcharts.chart('perbandingan', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Grafik Perbandingan Pagu Dan Realisasi Berdasarkan Jenis Belanja'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: [
			'Belanja Pegawai',
			'Belanja Barang Jasa',
			'Belanja Subsidi',
			'Belanja Hibah',
			'Belanja Modal Tanah',
			'Belanja Modal Peralatan Dan mesin',
			'Belanja Modal Gedung Dan Bangunan',
			'Belanja Modal Jalan, Jaringan, Dan Irigasi',
			'Belanja Modal Dan Aset Tetap Lainnya',
			'Belanja Tidak Terduga',
			'Belanja Bagi Hasil',
			'Belanja Bantuan Keuangan',
        ],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Pagu',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Direalisasikan',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} mm',
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
        name: 'Rainfall',
        type: 'column',
        yAxis: 1,
        data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
        tooltip: {
            valueSuffix: ' mm'
        }

    }, {
        name: 'Temperature',
        type: 'spline',
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
        tooltip: {
            valueSuffix: '°C'
        }
    }]
});






	chart_target_realisasi = new Highcharts.chart('target_realisasi', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Grafik Perbandingan Pagu Dan Realisasi Berdasarkan Jenis Belanja'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: [{
        categories: [
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'OKtober',
			'November',
			'Desember',
        ],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}°C',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Pagu',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: 'Direalisasikan',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} mm',
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
        data: [29,23,43,34,55,32,56,76,56,45,34,76],
        tooltip: {
            valueSuffix: '%'
        },
        color: '#9ff1fc'

    }, 
      {
        name: 'Target Keuangan',
        type: 'column',
        yAxis: 1,
        data: [43,56,54,66,77,66,77,88,99,10,70,67],
        tooltip: {
            valueSuffix: '%'
        },
        color: '#adfc9f'

    }, {
        name: 'Realisasi Fisik',
        type: 'spline',
        data: [43,56,54,66,77,66,77,88,99,10,70,67],
        tooltip: {
            valueSuffix: '%'
        },

        color: '#001fff'
    },
  {
        name: 'Realisasi Keuangan',
        type: 'spline',
        yAxis: 1,
        data: [29,23,43,34,55,32,56,76,56,45,34,76],
        tooltip: {
            valueSuffix: '%'
        },
        
        
        color: '#019228'
    }
]
});



	});

	function requestData() {
		var rf = [];
		var rk = [];
		var ba = <?php echo date('n'); ?>;
				console.log($('#id_instansi_grafik').val());
		$.ajax({
			url: '<?php echo base_url('dashboard/show_chart'); ?>',
			type: "GET",
			data : {
				id_instansi : $('#id_instansi_grafik').val(),
				id_group : '<?php echo $this->session->userdata('id_group') ?>'
			},
			dataType: "json",
			success: function(data) {
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
				chart_target_realisasi.addSeries({
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

	function sync(id_instansi) {
		$('#tombol_sync').text('Loading...').attr('disabled', true);
		$.ajax({
			url: baseUrl('synchronize/sync'),
			type: 'POST',
			dataType: 'JSON',
			data: {
				id_instansi: id_instansi
			},
			success: function(data) {
				console.log(data);
				if (data.status == true) {
					window.location.href = "<?php echo base_url(); ?>";
				}
			},
			error : function(){
				console.log('error');
				$('#tombol_sync').text('Reload Page').attr('disabled', false);
				$('#tombol_sync').attr('onclick', "reload()");
			}
		});
	}

	function reload(){
		window.location.href = "<?php echo base_url(); ?>";
	}



	let options = $.ajax({
		url: baseUrl('dashboard/simulasi'),
		dataType: 'JSON',
		async: false,
		success: function(data) {}
	});

	var exportUrl = 'https://export.highcharts.com/';

	// POST parameter for Highcharts export server
	var object = {
		options: JSON.stringify(options.responseJSON),
		type: 'image/jpeg',
		async: true
	};

	// Ajax request
	$.ajax({
		type: 'post',
		url: exportUrl,
		data: object,
		success: function(data) {
			clog(data);
		}
	});



	function ganti_password(){
		$('#modal_ganti_password').modal('show');
		$('#form_edit_password')[0].reset();
	}
	function simpan_perubahan_password(){
		var full_name = $('#full_name').val();
		var email = $('#email').val();
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('dashboard/saveedit_password'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_edit_password').serialize(),
			success: function (datanya)
			{
				if(datanya.success == true)
				{
					if(datanya.messages == "Password Lama Anda tidak cocok"){
						var value = '<p class="text-danger">' +datanya.messages + ". Silahkan coba kembali " + '</p>';
						var element = $('#pass_lama');
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					}else{
						$('#form_edit_password')[0].reset();
						$('#modal_ganti_password').modal('hide');
						Swal.fire('Berhasil','Password berhasil diubah','success');
					}
					
				}else{
					$.each(datanya.messages, function (key, value)
					{
						var element = $('#' + key);
						element.removeClass('is-invalid')
							.addClass(value.length > 0 ? 'is-invalid' : 'is-valid')
							.find('.text-danger')
							.remove();
						element.after(value);
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {

			}
		});
	}


	function edit_user(){
		$('#modal_edit_user').modal('show');
		$('#form_edit_user')[0].reset();
	}


	function simpan_edit_user(){
		var full_name = $('#full_name').val();
		var email = $('#email').val();

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();



		$.ajax(
        {
            url     : baseUrl('dashboard/saveedit_user/'),
            dataType: 'JSON',
            type    : 'POST',
            data: $('#form_edit_user').serialize(),
            success : function(data)
            {
                if(data.success == true)
                {
                	window.location.href="<?php echo base_url() ?>dashboard/my_profile"
                }
                else{
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
        });
	}
</script>