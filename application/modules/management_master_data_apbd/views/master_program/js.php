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
		showMasterprogram();
		
	});
	/**
	 *
	 * Master User
	 *
	 */





function showMasterprogram() {
		
		$('#table-master-program').DataTable({
			processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_master_program/'),
				type: "POST",
				data: {
					//kode_rekening_program: kode_rekening_program
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
	function show_master_program_lama() {
		var table = 'table-master-user',
			url = 'management_users/dt_master_user/',
			targetOrder = [0, -1],
			targetClass = [0, -2],
			targetWidth = [0, 6, -2];

		showDatatables(table, url, targetOrder, targetClass, targetWidth);
	}
	/* Menampilkan Select2 */
	
	/* Fungsi untuk menampilkan modal add master user */
	function add_master_program() {
		status = 'save';
	    $('#modal_master_program').modal('show')
					  		  .find('.modal-title').text('Tambah Master Program');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_program')[0].reset();
		$('#btnSave_master_program').show();
		$('#btnUpdate_master_program').hide();
	}
	
	function save_master_program() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/save_master_program'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_program').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_program').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Program Disimpan..!',
						      'success'
						    );
					$('#form_master_program')[0].reset();
					$('#clodemodalmodal_master_program').click();
					
					$('#table-master-program').DataTable().ajax.reload(null, false);
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

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_program', 'btnSave_master_program', 'Save Change', 'modal_master_program');
		// show_master_program();
	}


	
	/* Fungsi untuk menyimpan/mengupdate master user */
	function update_master_program() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/saveedit_master_program'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_program').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_program').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Program Disimpan..!',
						      'success'
						    );
					$('#form_master_program')[0].reset();
					$('#clodemodalmodal_master_program').click();

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





	function edit_program(id_program)
	{
		status = 'update';
		$('#clodemodal_usulan_data_apbd').click();
		$('#modal_master_program').modal('show').find('.modal-title').text('Edit Program');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax(
        {
            url     : baseUrl('management_master_data_apbd/get_program/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_program : id_program },
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

		$('#btnSave_master_program').hide();
		$('#btnUpdate_master_program').show();
	}



	function delete_program(id_program, nama_program) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_program+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/delete_program/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_program: id_program
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master Program Dihapus..!',
						      'success'
						    );
							$('#table-master-program').DataTable().ajax.reload(null, false);
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
</script>