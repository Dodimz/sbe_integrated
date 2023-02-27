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
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Function -->
<script>
	/* Global Variable */
	let url_data;
	let button_title;
	let status;

	$(document).ready(function() {
		showMasterkegiatan();
		
	});
	/**
	 *
	 * Master User
	 *
	 */





function showMasterkegiatan() {
		
		$('#table-master-kegiatan').DataTable({
			processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_master_kegiatan/'),
				type: "POST",
				data: {
					//kode_rekening_kegiatan: kode_rekening_kegiatan
				},
			},
			  columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0 ],
							},
							{
								className	: "dt-left",
								targets		: [ -1 ],
							},
	        			  ],

		});
	}



	/* Fungsi untuk menampilkan Master User */
	function show_master_kegiatan_lama() {
		var table = 'table-master-user',
			url = 'management_users/dt_master_user/',
			targetOrder = [0, -1],
			targetClass = [0, -2],
			targetWidth = [0, 6, -2];

		showDatatables(table, url, targetOrder, targetClass, targetWidth);
	}
	/* Menampilkan Select2 */
	
	/* Fungsi untuk menampilkan modal add master user */
	function add_master_kegiatan() {
		status = 'save';
	    $('#modal_master_kegiatan').modal('show')
					  		  .find('.modal-title').text('Tambah Master Kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_kegiatan')[0].reset();
		$('#btnSave_master_kegiatan').show();
		$('#btnUpdate_master_kegiatan').hide();
	}
	
	function save_master_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/save_master_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_kegiatan')[0].reset();
					$('#clodemodalmodal_master_kegiatan').click();
					
							$('#table-master-kegiatan').DataTable().ajax.reload(null, false);
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
		// if (status == 'save') {
		// 	url_data = 'management_users/save_master_user';
		// } else {
		// 	url_data = 'management_users/update_master_user';
		// }

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_kegiatan', 'btnSave_master_kegiatan', 'Save Change', 'modal_master_kegiatan');
		// show_master_kegiatan();
	}


	
	/* Fungsi untuk menyimpan/mengupdate master user */
	function update_master_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/saveedit_master_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_kegiatan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Kegiatan Disimpan..!',
						      'success'
						    );
					$('#form_master_kegiatan')[0].reset();
					$('#clodemodalmodal_master_kegiatan').click();
					
							$('#table-master-kegiatan').DataTable().ajax.reload(null, false);
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





	function edit_kegiatan(id_kegiatan)
	{
		status = 'update';
		$('#modal_master_kegiatan').modal('show').find('.modal-title').text('Edit User');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$.ajax(
        {
            url     : baseUrl('management_master_data_apbd/get_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_kegiatan : id_kegiatan },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#id').val(data.data.id);
                	$('#kode').val(data.data.kode);
                	$('#nama').val(data.data.nama);
                }
            },
            error : function(){
            }
        });

		$('#btnSave_master_kegiatan').hide();
		$('#btnUpdate_master_kegiatan').show();
	}



	function delete_kegiatan(id_kegiatan, nama_kegiatan) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/delete_kegiatan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_kegiatan: id_kegiatan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master kegiatan Dihapus..!',
						      'success'
						    );
							
							$('#table-master-kegiatan').DataTable().ajax.reload(null, false);
						}
			  		},
			  		error : function (){
			  			 Swal.fire(
					      'Error!',
					      'Error',
					      'error'
					    )
			  		}
			  	});

			  
			  }
			});
	}



function export_master_kegiatan()
	{
		$('#modal_export_mk').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  

	}
</script>