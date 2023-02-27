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
		$('#kategori').select2({
			placeholder: "Pilih Kategori",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tahun').select2({
			placeholder: "Pilih Tahun Anggaran",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#tahap').select2({
			placeholder: "Pilih Tahapan APBD",
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
		$('#id_opd').select2({
			placeholder: "Pilih OPD",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#kategori_laporan').select2({
			placeholder: "Pilih Data Yang Akan Ditampilkan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#data_apbd').select2({
			placeholder: "Pilih jenis Data APBD Yang Akan Ditampilkan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#fisik_keuangan').select2({
			placeholder: "Pilih Data Realisasi Yang Akan Ditampilkan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#pilihan_batasan').select2({
			placeholder: "Pilih Jenis Batasan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#batasan').select2({
			placeholder: "Pilih Batasan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
	}

	$('#kategori_laporan').change(function(){
		var penampilan_data = $('#kategori_laporan').val();
		if (penampilan_data=='rfk_data_sumber_dana') {
			$('#f_kategori').hide();
			$('#f_bulan').hide();
		}else{
			$('#f_kategori').show();
			$('#f_bulan').show();

		}
	});

	function bulan() {
		$('#bulan').val('').trigger("change");
		$('#tampil_pdf').hide();
	}

	function show_laporan() {
		// Swal.showLoading();

		let bulan = $('#bulan').val();
		let id_opd = $('#id_opd').val();
		let tahun = $('#tahun').val();
		let tahap = $('#tahap').val();
		let kategori = $('#kategori').val();
		let kategori_laporan = $('#kategori_laporan').val();
		let pilihan_batasan = $('#pilihan_batasan').val();
		let batasan = $('#batasan').val();
		let data_apbd = $('#data_apbd').val();
		let fisik_keuangan = $('#fisik_keuangan').val();


		if (id_opd=='') {
			Swal.fire('Error','Harap Pilih OPD','error');
			return false;
		}
	
		else if (tahun=='') {
			Swal.fire('Error','Harap Pilih Tahun Anggaran','error');
			return false;
		}
		else if (tahap=='') {
			Swal.fire('Error','Harap Pilih Tahapan APBD','error');
			return false;
		}
		// 
		else if (kategori_laporan=='') {
			Swal.fire('Error','Harap Pilih Data Yang Ditampilkan','error');
			return false;
		}
		// 
		else{
			if (kategori_laporan=='rfk_akumulasi' || kategori_laporan=='rfk_berdasarakan_kelompok_jenis_belanja' ) {
				if (kategori=='') {
					Swal.fire('Error','Harap Pilih Kategori','error');
					return false;
				}
				else if (bulan=='') {
					Swal.fire('Error','Harap Pilih Bulan','error');
					return false;
				}
				else{
					$('#tampil_pdf').show();
					
					$('#tampil_pdf').attr('src', baseUrl('laporan/tabel_laporan_realisasi_akumulasi_batasan?id_opd=') + id_opd + '&kategori_penampilan_data=' + kategori_laporan +'&kategori=' + kategori + '&tahun=' + tahun + '&tahap=' + tahap + '&bulan=' + bulan + '&data_apbd=' + data_apbd + '&pilihan_batasan=' + pilihan_batasan + '&batasan=' + batasan +'&fisik_keuangan=' + fisik_keuangan + '#view=FitH');
				}
				
			}else{
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('laporan/tabel_laporan_realisasi_akumulasi_batasan?id_opd=') + id_opd + '&kategori_penampilan_data=' + kategori_laporan +'&kategori=' + kategori + '&tahun=' + tahun + '&tahap=' + tahap + '&bulan=' + bulan + '&data_apbd=' + data_apbd + '&pilihan_batasan=' + pilihan_batasan + '&batasan=' + batasan +'&fisik_keuangan=' + fisik_keuangan + '#view=FitH');
			}
			// Swal.hideLoading();
		}


	}
</script>