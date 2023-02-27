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
<script>
	let status_show_pptk = 'collapse';
	$(document).ready(function() {
		show_pengumuman();
	});

	/* Fungsi untuk menampilkan KPA */
	function show_pengumuman() {
		$('#table-pengumuman').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('informasi/dt_pengumuman/'),
				type: "POST",
				data: {},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}

	
	function tambah_pengumuman(){
		$('#modal-tambah-pengumuman').modal('show');
	}

	function edit_pengumuman(id_pengumuman){
		$('#modal-edit-pengumuman').modal('show');
		$.ajax(
						{
							url     : baseUrl('informasi/detail_pengumuman/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_pengumuman : id_pengumuman,
								
								
							},
							success : function(data)
							{
								console.log(data);
								$('#modal-edit-pengumuman').find('#id_pengumuman').val(data.data.id_pengumuman);
								$('#modal-edit-pengumuman').find('#judul').val(data.data.judul);
								$('#modal-edit-pengumuman').find('#keterangan').html(data.data.edit_keterangan);
								$('#modal-edit-pengumuman').find('#tgl').val(data.data.tgl_pelaksanaan);
								$('#modal-edit-pengumuman').find('#jam').val(data.data.jam_pelaksanaan);
								$('#modal-edit-pengumuman').find('#filelama').val(data.data.filelama);
								if(data.success == true)
								{
									
									$('#table-pengumuman').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								alert('err');
							}
						});
	}

	function detail_pengumuman(id_pengumuman){
		$('#modal-detail-pengumuman').modal('show');
		$.ajax(
						{
							url     : baseUrl('informasi/detail_pengumuman/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_pengumuman : id_pengumuman,
								
								
							},
							success : function(data)
							{
								console.log(data);
								$('#modal-detail-pengumuman').find('#judul').html(data.data.judul);
								$('#modal-detail-pengumuman').find('#keterangan').html(data.data.keterangan);
								$('#modal-detail-pengumuman').find('#waktu').html(data.data.tgl_pelaksanaan + "<br>"+ data.data.jam_pelaksanaan);
								if(data.data.filelama != '')
								{
									$('#modal-detail-pengumuman').find('#show_file_pengumuman').show();
									var parent = $('#modal-detail-pengumuman').find('iframe').parent();
									var srcpdf = $('#modal-detail-pengumuman').find('iframe');
									var newElement = '<iframe src="' + baseUrl(data.data.lokasi_file) + '" width="100%" height="500px">';
									$(srcpdf).remove();
									parent.append(newElement);
								}else{
									$('#modal-detail-pengumuman').find('#show_file_pengumuman').hide();

								}
							},
							error : function(){
								alert('err');
							}
						});
	}



	function simpan_pengumuman()
	{
		
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
		$.ajax({
			url: baseUrl('informasi/simpan_pengumuman'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_tambah_pengumuman').serialize(),
			success: function (data)
			{

				if(data.success == true)
				{
					$('#form_tambah_pengumuman')[0].reset();
					Swal.fire(
				      'Disimpan!',
				      'pengumuman anda sudah di sampaikan',
				      'success'
				    );
					$('#clodemodal_add_pengumuman').click();
					showpengumuman();
				}else{
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
			},
			error: function (jqXHR, textStatus, errorThrown) {

			}
		});
	}



	function hapus_pengumuman(id_pengumuman, judul_pengumuman,file)
	{
		
		Swal.fire({
			  title: 'Warning',
			  text: 'Hapus pengumuman '+judul_pengumuman+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  			$.ajax(
						{
							url     : baseUrl('informasi/hapus_pengumuman/'),
							dataType: 'JSON',
							type    : 'POST',
							data    : { 
								id_pengumuman : id_pengumuman,
								judul_pengumuman : judul_pengumuman,
								file : file,
								
							},
							success : function(data)
							{
								console.log(data);
								if(data.success == true)
								{
									Swal.fire(
								      'Duhapus!',
								      'Pengumuman '+judul_pengumuman+'dihapus',
								      'success'
								    );
									$('#table-pengumuman').DataTable().ajax.reload(null, false);
								}
							},
							error : function(){
								alert('err');
							}
						});
			

			  
			  }
			});	
	}
</script>