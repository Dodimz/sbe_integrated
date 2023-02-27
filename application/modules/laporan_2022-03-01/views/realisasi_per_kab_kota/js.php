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
		$('#bulan').select2({
			placeholder: "Pilih Bulan",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#provinsi').select2({
			placeholder: "Pilih Provinsi",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#kota').select2({
			placeholder: "Pilih Kota",
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
	}

	function bulan() {
		$('#bulan').val('').trigger("change");
		$('#tampil_pdf').hide();
	}

	function show_laporan(x) {
		// alert(x);
		let id_kota = $('#kota').val();
		let id_provinsi = $('#provinsi').val();
		let kategori = $('#kategori').val();
		let tahap = $('#tahap').val();
		$('#bulan').val('');
		if (id_kota) {
			if (x != 0) {
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_realisasi_per_kab_kota?id_provinsi=' + id_provinsi + '&tahap=' + tahap +  '&id_kota=' + id_kota + '&kategori=' + kategori + '&bulan=' + x + '#view=FitH') );
			}
		}
	}
</script>