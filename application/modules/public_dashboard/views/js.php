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
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
	var chart_fisik;
	var chart_keuangan;

	function Arrays_calc(array1, array2, ope)
	{
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
		$.each(result, function (k, v) {
			hasil.push(v.toFixed(2));
		});

		return hasil;
	}

	$(document).ready(function()
	{
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
				text: 'Tahun 2019'
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				gridLineWidth:1
			},
			yAxis: {
				title: {
					text: 'Persentase (%)'
				},
				min:0,
				max:100,
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
				text: 'Tahun 2019'
			},
			xAxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				gridLineWidth:1
			},
			yAxis: {
				title: {
					text: 'Persentase (%)'
				},
				min:0,
				max:100,
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

	function requestData()
	{
		var rf = [];
		var rk = [];
		var ba = 12;
		$.ajax({
			url: '<?php echo base_url('public_dashboard/show_chart'); ?>',
			type: "GET",
			dataType: "json",
			success: function(data)
			{
				$.each(data.r_fis,function(x,y){
					if(x < parseInt(ba))
					{
						rf[x] = y;
					}
				});
				$.each(data.r_keu,function(k,v){
					if(k < parseInt(ba))
					{
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

				$('#tfisik').each(function(){
					$(this).append('<td>T</td>');
					for(var i=0; i<12;i++)
					{
						$(this).append('<td>'+data.fisik[i]+'</td>');
					}
				});

				$('#rfisik').each(function(){
					$(this).append('<td>R</td>');
					for(var i=0; i < ba;i++)
					{
						$(this).append('<td>'+data.r_fis[i]+'</td>');
					}
				});

				$('#tkeu').each(function(){
					$(this).append('<td>T</td>');
					for(var i=0; i<12;i++)
					{
						$(this).append('<td>'+data.keu[i]+'</td>');
					}
				});

				$('#rkeu').each(function(){
					$(this).append('<td>R</td>');
					for(var i=0; i < ba;i++)
					{
						$(this).append('<td>'+data.r_keu[i]+'</td>');
					}
				});

				var d_fis = Arrays_calc(rf,data.fisik,'-');
				var d_keu = Arrays_calc(rk,data.keu,'-');

				$('#dfisik').each(function(){
					$(this).append('<td>D</td>');
					for(var i=0; i < parseInt(ba);i++)
					{
						$(this).append('<td>'+d_fis[i]+'</td>');
					}
				});

				$('#dkeu').each(function(){
					$(this).append('<td>D</td>');
					for(var i=0; i < parseInt(ba);i++)
					{
						$(this).append('<td>'+d_keu[i]+'</td>');
					}
				});
			},
			cache: false
		});
	}


</script>