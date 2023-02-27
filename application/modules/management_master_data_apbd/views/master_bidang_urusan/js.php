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
		showMasterbidang_urusan();
		
	});
	/**
	 *
	 * Master User
	 *
	 */





function showMasterbidang_urusan() {
		
		$('#table-master-bidang_urusan').DataTable({
			processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_master_bidang_urusan/'),
				type: "POST",
				data: {
					//kode_rekening_bidang_urusan: kode_rekening_bidang_urusan
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
	function show_master_bidang_urusan_lama() {
		var table = 'table-master-user',
			url = 'management_users/dt_master_user/',
			targetOrder = [0, -1],
			targetClass = [0, -2],
			targetWidth = [0, 6, -2];

		showDatatables(table, url, targetOrder, targetClass, targetWidth);
	}
	/* Menampilkan Select2 */
	
	/* Fungsi untuk menampilkan modal add master user */
	function add_master_bidang_urusan() {
		status = 'save';
	    $('#modal_master_bidang_urusan').modal('show')
					  		  .find('.modal-title').text('Add User');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$('#form_master_bidang_urusan')[0].reset();
		$('#btnSave_master_bidang_urusan').show();
		$('#btnUpdate_master_bidang_urusan').hide();
	}
	
	function save_master_bidang_urusan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/save_master_bidang_urusan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_bidang_urusan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_bidang_urusan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Bidang Urusan Disimpan..!',
						      'success'
						    );
					$('#form_master_bidang_urusan')[0].reset();
					$('#clodemodalmodal_master_bidang_urusan').click();
					showMasterbidang_urusan();
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
				console.log('error');
			}
		 });
		// if (status == 'save') {
		// 	url_data = 'management_users/save_master_user';
		// } else {
		// 	url_data = 'management_users/update_master_user';
		// }

		// ajaxSave(url_data, 'POST', 'JSON', 'form_master_bidang_urusan', 'btnSave_master_bidang_urusan', 'Save Change', 'modal_master_bidang_urusan');
		// show_master_bidang_urusan();
	}


	
	/* Fungsi untuk menyimpan/mengupdate master user */
	function update_master_bidang_urusan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/saveedit_master_bidang_urusan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_bidang_urusan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					$('#btnSave_master_bidang_urusan').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master Bidang Urusan Disimpan..!',
						      'success'
						    );
					$('#form_master_bidang_urusan')[0].reset();
					$('#clodemodalmodal_master_bidang_urusan').click();
					showMasterbidang_urusan();
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
				console.log('error');
			}
		 });

	}





	function edit_bidang_urusan(id_bidang_urusan)
	{
		status = 'update';
		$('#modal_master_bidang_urusan').modal('show').find('.modal-title').text('Edit User');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        console.log(id_bidang_urusan);
		$.ajax(
        {
            url     : baseUrl('management_master_data_apbd/get_bidang_urusan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_bidang_urusan : id_bidang_urusan },
            success : function(data)
            {
            	console.log(data);
                if(data.status == true)
                {
                	$('#id').val(data.data.id);
                	$('#kode').val(data.data.kode);
                	$('#nama').val(data.data.nama);
                }
            },
            error : function(){
            	console.log('error')
            }
        });

		$('#btnSave_master_bidang_urusan').hide();
		$('#btnUpdate_master_bidang_urusan').show();
	}



	function delete_bidang_urusan(id_bidang_urusan, nama_bidang_urusan) {
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus '+ nama_bidang_urusan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/delete_bidang_urusan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_bidang_urusan: id_bidang_urusan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master bidang_urusan Dihapus..!',
						      'success'
						    );
							showMasterbidang_urusan();
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