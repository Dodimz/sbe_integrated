<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Script -->
<script>
	$(document).ready(function() {
		show_select2();
	});

	function show_select2() {
		$('#nomenklatur').select2({
			placeholder: "Pilih Nomenklatur yang akan ditampilkan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#asisten').select2({
			placeholder: "Pilih Kelompok Asisten",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#bulan').select2({
			placeholder: "Pilih Bulan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#realisasi').select2({
			placeholder: "Pilih Jenis Realisasi",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}


	function show_laporan(x) {
		let asisten = $('#asisten').val();
		let realisasi = $('#realisasi').val();
		let nomenklatur = $('#nomenklatur').val();
		let bulan = $('#bulan').val();
		let tahap = $('#tahap').val();
		let tahun = $('#tahun').val();
		if (nomenklatur=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten','error');
		}
		if (asisten=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten','error');
		}
		if (realisasi=='') {
			Swal.fire('Error','Anda belum memilih jenis perengkingan','error');
		}
		if (realisasi=='' && asisten=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten dan jenis perengkingan','error');
		}
		
		console.log(x);
		if (asisten!='' && realisasi!='' && nomenklatur!='') {
			if (x != 0) {
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_ratarata_realisasi?filter=' + asisten + '&realisasi=' + realisasi + '&bulan=' + bulan +'&tahun=' + tahun +'&tahap=' + tahap + '&nomenklatur=' + nomenklatur));
			}
		}
	}
</script>


