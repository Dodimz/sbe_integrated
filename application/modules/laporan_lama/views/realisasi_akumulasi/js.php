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
		$('#id_opd').select2({
			placeholder: "Pilih OPD",
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
		let id_opd = $('#id_opd').val();
		let kategori = $('#kategori').val();
		$('#bulan').val('');
		if (id_opd) {
			if (x != 0) {
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('laporan/realisasi_akumulasi?id_opd=') + id_opd + '&kategori=' + kategori + '&bulan=' + x + '#view=FitH');
			}
		}
	}
</script>