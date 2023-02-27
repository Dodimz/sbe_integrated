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
		showMasterUser();
		select2();
	});
	/**
	 *
	 * Master User
	 *
	 */





function showMasterUser() {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-master-user').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_users/dt_master_user/'),
				type: "POST",
				data: {
					//kode_rekening_program: kode_rekening_program
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



	/* Fungsi untuk menampilkan Master User */
	function showMasterUser_lama() {
		var table = 'table-master-user',
			url = 'management_users/dt_master_user/',
			targetOrder = [0, -1],
			targetClass = [0, -2],
			targetWidth = [0, 6, -2];

		showDatatables(table, url, targetOrder, targetClass, targetWidth);
	}
	/* Menampilkan Select2 */
	// function select2() {
	// 	showSelect2('idParent', 'Pilih Parent');
	// 	showSelect2('idInstansi', 'Pilih Instansi');
	// }


	function select2() {
		$('#idInstansi').select2({
			placeholder: "Pilih OPD",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}

	/* Fungsi untuk menampilkan modal add master user */
	function addMasterUser() {
		var group = <?php echo $id_group ?>;
		var id_instansi = "<?php echo encrypt($id_instansi) ?>";
		status = 'save';
	    $('#modalMasterUser').modal('show')
					  		  .find('.modal-title').text('Add User');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        if (group==5) {
			$('#idInstansi').val(id_instansi);

        }else{
			$('#idInstansi').val('').change();

        }
		$('#formMasterUser')[0].reset();
		$('#btnSaveMasterUser').show();
		$('#btnUpdateMasterUser').hide();
	}
	/* Fungsi untuk menampilkan user */
	function showUser(idInstansi) {
		$.ajax({
			url: baseUrl('management_users/get_master_user/'),
			type: "GET",
			dataType: "JSON",
			data: {
				idInstansi: idInstansi
			},
			success: function(data) {
				if (data.messages == 'Success') {
					$('#idParent').html('');
					$('#idParent').append('<option value=""></option>');
					$.each(data.data, function(index, row) {
						$('#idParent').append('<option value=' + row.id_user + '>' + row.full_name + '</option>');
					});
				} else {
					$('#idParent').html('');
					$('#idParent').append('<option value=""></option>');
					$.each(data.data, function(index, row) {
						$('#idParent').append('<option value=' + row.id_user + '>' + row.full_name + '</option>');
					});
				}
			}
		});
	}
	/* Fungsi untuk menampilkan Group berdasarkan level User Parent */
	function showGroup(idUser) {
		$.ajax({
			url: baseUrl('management_users/get_user_group/'),
			type: "GET",
			dataType: "JSON",
			data: {
				idUser: idUser
			},
			success: function(data) {
				$('#group').html('');
				$.each(data.data, function(index, row) {
					$('#group').append('<div class="form-check">' +
						'<label class="form-check-label" for="check' + row.id_group + '">' +
						'<input type="checkbox" class="form-check-input checkGroup" id="check' + row.id_group + '" name="group[' + row.id_group + ']" value="' + row.id_group + '">' +
						row.group_name +
						'</label>' +
						'</div>');
				});
			}
		});
	}
	/* Fungsi untuk mengedit Master Module */
	function editMasterModule(idModule) {
		status = 'update';
		$('#modalMasterModule').modal('show');
		$('.modal-title').text('Edit Data');
		$('#formMasterModule')[0].reset();
		$('.form-group').removeClass('has-error')
			.removeClass('has-success');
		$('.text-danger').remove();
		$('.help-block').empty();
		$('#idModule').val(idModule);

		$.ajax({
			url: baseUrl('management_modules/get_master_module/'),
			type: "GET",
			dataType: "JSON",
			data: {
				idModule: idModule
			},
			success: function(data) {
				if (data.success == true) {
					$('#idModule').val(idModule);
					$('#moduleName').val(data.data.module_name);
					$('#moduleDescription').val(data.data.module_description);
					$('.checkGroup').prop('checked', false);
					$.each(data.group, function(key, value) {
						$('#check' + value.id_group).prop('checked', true);
					});
					$('#isActive').val(data.data.is_active);
					$('#readonly').val(data.data.readonly);
				}
			}
		});
	}
	/* Fungsi untuk menyimpan/mengupdate master user */
	function saveMasterUser() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
        $('#btnSaveMasterUser').html('Loading...');


		$.ajax({
			url: baseUrl('management_users/save_master_user'),
			type : "POST",
			dataType: 'JSON',
			data :$('#formMasterUser').serialize(),
			success : function(data){
				console.log('sukses')
				if(data.success == true)
				{
					$('#btnSaveMasterUser').html('Save changes');
					Swal.fire(
						      'Sukses!',
						      'Master User Disimpan..!',
						      'success'
						    );
					$('#formMasterUser')[0].reset();
					$('#clodemodalmodalMasterUser').click();
					console.log('sukses cuy');
						$('#table-master-user').DataTable().ajax.reload(null, false);
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

		// ajaxSave(url_data, 'POST', 'JSON', 'formMasterUser', 'btnSaveMasterUser', 'Save Change', 'modalMasterUser');
		// showMasterUser();
	}
	/* Fungsi untuk menghapus master module */





	function edit_master_user(id_user)
	{
		status = 'update';
		$('#modalMasterUser').modal('show').find('.modal-title').text('Edit User');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();
		$.ajax(
        {
            url     : baseUrl('management_users/get_user/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_user : id_user },
            success : function(data)
            {
            	
                if(data.status == true)
                {
                	$('#idUser').val(data.data.id_user);
                	$('#fullName').val(data.data.full_name);
                	$('#username').val(data.data.username);
                	$('#email').val(data.data.email);
                	$('#nohp').val(data.data.nohp);
                
                	$('#group').val(data.data.group).trigger('change');
                	$('#idInstansi').val(data.data.id_instansi).trigger('change');
                	$('#isActive').val(data.data.is_active);
                
                }
            },
            error : function(){
            	console.log('error')
            }
        });

		$('#btnSaveMasterUser').hide();
		$('#btnUpdateMasterUser').show();
	}


	function updateMasterUser() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_users/saveedit_master_user'),
			type : "POST",
			dataType: 'JSON',
			data :$('#formMasterUser').serialize(),
			success : function(data){
				console.log(data);
				if(data.success == true)
				{
					Swal.fire(
						      'Sukses!',
						      'Master User Disimpan..!',
						      'success'
						    );
					$('#formMasterUser')[0].reset();
					$('#clodemodalmodalMasterUser').click();
					$('#table-master-user').DataTable().ajax.reload(null, false);
					// showMasterUser();
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

		// ajaxSave(url_data, 'POST', 'JSON', 'formMasterUser', 'btnSaveMasterUser', 'Save Change', 'modalMasterUser');
		// showMasterUser();
	}
	function deleteMasterModule(idModule) {
		if (confirm('Are you sure ?')) {
			var data = {
				idModule: idModule
			};
			ajaxDelete('management_modules/delete_master_module/', 'POST', 'JSON', data);
			showMasterModule();
		}
	}
	/* Fungsi untuk menghapus master user */
	function deleteUser(id_user) {
		console.log(id_user	);
		Swal.fire({
			  title: 'Hapus ?',
			  text: 'Hapus User.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_users/delete_user/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_user: id_user
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master User Dihapus..!',
						      'success'
						    );
							
						$('#table-master-user').DataTable().ajax.reload(null, false);
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