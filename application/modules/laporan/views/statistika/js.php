<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		statistika(<?php echo tahun_anggaran() ?>,<?php echo tahapan_apbd() ?>);
		select2();
	});

	function select2()
	{
		$('#modal-ganti-periode').find('#tahun').select2(
		{
			placeholder : "Pilih Tahun Anggaran",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
		$('#modal-ganti-periode').find('#tahap').select2(
		{
			placeholder : "Pilih Tahapan APBD",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});
	}

	function statistika(tahun, tahap) {
			$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_statistika/' + tahun + '/' + tahap));
	}

	function ganti_periode() {

		$('#modal-ganti-periode').modal('show');
	}
	function hasil_ganti_periode() {

		$('#modal-ganti-periode').modal('hide');
		var tahun = $('#modal-ganti-periode').find('#tahun').val();
		var tahap = $('#modal-ganti-periode').find('#tahap').val();
		statistika(tahun, tahap)
	}




</script>