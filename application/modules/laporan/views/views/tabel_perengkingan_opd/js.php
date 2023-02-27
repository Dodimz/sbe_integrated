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
		$('#tahap').select2({
			placeholder: "Pilih Tahapan APBD",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tahun').select2({
			placeholder: "Pilih Rahun Anggaran",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
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
		$('#kategori_laporan').select2({
			placeholder: "Pilih Kategori Penampilan Data",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#kategori').select2({
			placeholder: "Pilih Kategori Laporan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#perhitungan').select2({
			placeholder: "Pilih Bentuk Perhitungan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}


	function show_laporan() {
		let asisten = $('#asisten').val();
		let realisasi = $('#realisasi').val();
		let nomenklatur = $('#nomenklatur').val();
		let kategori_laporan = $('#kategori_laporan').val();
		let bulan = $('#bulan').val();
		let tahap = $('#tahap').val();
		let tahun = $('#tahun').val();
		
		let kategori = $('#kategori').val();
		let perhitungan = $('#perhitungan').val();
		if (nomenklatur=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten','error');
		}
		else if (asisten=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten','error');
		}
		else if (realisasi=='') {
			Swal.fire('Error','Anda belum memilih jenis perengkingan','error');
		}
		else if (realisasi=='' && asisten=='') {
			Swal.fire('Error','Anda belum memilih Kelompok Asisten dan jenis perengkingan','error');
		}
		else if (bulan=='') {
			Swal.fire('Error','Anda belum memilih bulan','error');
		}
		else{
			$('#tampil_pdf').show();
			$('#tampil_pdf').attr('src', baseUrl('laporan/tabel_perengkingan_rfk_opd?filter=' + asisten + '&realisasi=' + realisasi + '&bulan=' + bulan +'&tahun=' + tahun +'&kategori_penampilan_data=' + kategori_laporan +'&tahap=' + tahap + '&nomenklatur=' + nomenklatur + '&kategori=' + kategori + '&perhitungan=' + perhitungan));
		}
		
	}
</script>


