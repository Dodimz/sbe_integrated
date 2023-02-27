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
		$('#tahun').select2({
			placeholder: "Pilih tahun",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		$('#penampilan').select2({
			placeholder: "Pilih Penampilan Data",
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

	function show_laporan() {
		// alert(x);
		let id_kota = $('#kota').val();
		let kategori = $('#kategori').val();
		let tahap = $('#tahap').val();
		let tahun = $('#tahun').val();
		let bulan = $('#bulan').val();
		let penampilan = $('#penampilan').val();
		
		if (id_kota=='') {
			Swal.fire('Error','Ada belum memilih Kabupaten / Kota','error');
		}
		else if (kategori=='') {
			Swal.fire('Error','Anda belum memilih kategori','error');
		}
		else if (tahap=='') {
			Swal.fire('Error','Anda belum memilih Tahapan APBD','error');
		}
		else if (tahun=='') {
			Swal.fire('Error','Anda belum memilih Tahun Anggaran','error');
		}
		else if (bulan=='') {
			Swal.fire('Error','Anda belum memilih Bulan ','error');
		}
		else if (penampilan=='') {
			Swal.fire('Error','Anda belum memilih Penampilan Data','error');
		}
		else{
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_realisasi_per_kab_kota?tahap=' + tahap +  '&tahun=' + tahun +  '&id_kota=' + id_kota + '&kategori=' + kategori + '&bulan=' + bulan +  '&penampilan=' + penampilan + '#view=FitH') );
		}
			
	}
</script>