<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 */
?>
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- X-editable -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
	$(document).ready(function() {
		$("#kode_rekening_program").select2({
			theme: "bootstrap4",
			placeholder: "Pilih Program"
		});

		showKegiatanApbd();
		showAutoCurrency();
	});

	function showAutoCurrency() {
		$('input.currency').number(true, 0);
	}

	function convert_to_rupiah(angka) {
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for (var i = 0; i < angkarev.length; i++)
			if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
		return rupiah.split('', rupiah.length - 1).reverse().join('');
	}

	/* Fungsi untuk menampilkan Kegiatan APBD */
	function showKegiatanApbd(kode_rekening_program = '') {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-kegiatan-apbd').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('kegiatan_apbd/dt_kegiatan_apbd/'),
				type: "POST",
				data: {
					kode_rekening_program: kode_rekening_program
				},
			},
			columnDefs: [{
					targets: [0, -1, -2],
					orderable: false,
				},
				{
					width: "1%",
					targets: [-1, -2],
				},
				{
					className: "dt-center",
					targets: [-1, -2],
				},
				{
					className: "dt-right",
					targets: [2, 3, 4, 5],
				},
			],

		});
	}

	$('#table-kegiatan-apbd').on('click', '#target', function() {
		let kode_rekening_kegiatan = $(this).attr('kode-rekening-kegiatan');
		let kode_urusan = $(this).attr('kode-urusan');
		let pagu = $(this).attr('pagu');
		$('#modal-target').modal('show');
		$('#modal-target').find('.modal-title').text(kode_rekening_kegiatan);
		$('#pagu').val(convert_to_rupiah(pagu));
		get_target(kode_rekening_kegiatan, kode_urusan, pagu);
	});

	$('#table-kegiatan-apbd').on('click', '#sumber-dana', function() {
		let kode_rekening_kegiatan = $(this).attr('kode-rekening-kegiatan');
		let kode_urusan = $(this).attr('kode-urusan');
		let anggaran = $(this).attr('pagu');
		$('#modal-sumber-dana').modal('show');
		$('#modal-sumber-dana').find('.modal-title').text(kode_rekening_kegiatan);
		$('#form-sumber-dana')[0].reset();
		$('#kode_rekening_kegiatan').val(kode_rekening_kegiatan);
		$('#kode_urusan').val(kode_urusan);
		$('#anggaran').val(anggaran);
		cek_sumber_dana(kode_rekening_kegiatan, kode_urusan);
	});

	function cek_sumber_dana(kode_rekening_kegiatan, kode_urusan) {
		$.ajax({
			url: baseUrl('kegiatan_apbd/cek_sumber_dana/'),
			type: "POST",
			dataType: "JSON",
			data: {
				kode_rekening_kegiatan: kode_rekening_kegiatan,
				kode_urusan: kode_urusan
			},
			success: function(data) {
				if (data.status == true) {
					$('#dau').val(data.data.dau);
					$('#dak').val(data.data.dak);
					$('#dbh').val(data.data.dbh);
					$('#lainnya').val(data.data.lainnya);
				} else {
					$('#status').val('insert');
				}
			}
		});
	}

	function save_sumber_dana() {
		$.ajax({
			url: baseUrl('kegiatan_apbd/save_sumber_dana/'),
			type: "POST",
			dataType: "JSON",
			data: $('#form-sumber-dana').serialize(),
			success: function(data) {
				if (data.status == true) {
					$('#modal-sumber-dana').modal('hide');
				}
			}
		});
	}

	function bulan(x) {
		let bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		return bulan[x];
	}

	function get_target(kode_rekening_kegiatan, kode_urusan, pagu) {
		$.ajax({
			url: baseUrl('kegiatan_apbd/get_target/'),
			type: "POST",
			dataType: "JSON",
			data: {
				kode_rekening_kegiatan: kode_rekening_kegiatan,
				kode_urusan: kode_urusan
			},
			success: function(data) {
				if (data.status == true) {
					$('#target-apbd').html('');
					$.each(data.data, function(k, v) {
						$('#target-apbd').append(
							'<tr>' +
							'<td>' + (k + 1) + '</td>' +
							'<td>' + bulan(v.bulan) + '</td>' +
							'<td><a href="#" id="target-fisik" rekening="' + kode_rekening_kegiatan + '" kode-urusan="' + kode_urusan + '" pagu="' + pagu + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</a></td>' +
							'<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
							'<td style="text-align: right;">' + convert_to_rupiah(v.t_keuangan) + '</td>' +
							'</tr>'
						);
					});
				}
			}
		});
	}

	function edit_target_fisik(x) {
		$.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
			'<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

		let id = $(x).attr('pk');
		let rekening = $(x).attr('rekening');
		let kode_urusan = $(x).attr('kode-urusan');
		let pagu = $(x).attr('pagu');
		$(x).editable({
			mode: 'inline',
			pk: id,
			savenochange: true,
			url: baseUrl('kegiatan_apbd/update_target_fisik/' + rekening),
			success: function(c) {
				get_target(rekening, kode_urusan, pagu);
			},
		});
	}
</script>