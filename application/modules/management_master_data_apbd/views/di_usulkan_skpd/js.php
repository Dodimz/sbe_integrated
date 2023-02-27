<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
	// echo $controller;
?>

<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	let status_show_kegiatan 		= 'collapse';
	let status_show_kegiatan_all 		= 'collapse';
	
	$(document).ready(function()
	{
	   
	   	show_usulan_program();
	   	show_usulan_kegiatan();
	   	show_usulan_sub_kegiatan();
	  
	});



	function show_usulan_program() {
		$('#table-usulan-program').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_usulan_program/'),
				type: "POST",
				data: {
					
				}
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});

	}
	function show_usulan_kegiatan() {
		$('#table-usulan-kegiatan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_usulan_kegiatan/'),
				type: "POST",
				data: {
					
				},
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}
	function show_usulan_sub_kegiatan() {
		$('#table-usulan-sub-kegiatan').DataTable({
			processing: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_master_data_apbd/dt_usulan_sub_kegiatan/'),
				type: "POST",
				data: {
					
				},
				// success: function(data){
				// 	console.log(data);
				// }
			},
			columnDefs: [{
					targets: [0, -1],
					orderable: false,
				},
				{
					width: "1%",
					targets: [0, 2],
				},
				{
					className: "dt-center",
					targets: [-1],
				},
			],

		});
	}

	function reject_usulan_program(id_program)
	{
		status = 'update';
		$('#clodemodal_usulan_data_apbd').click();
		$('#modal_reject_master_program').modal('show').find('.modal-title').text('Tolak Usulan  Program');
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
                	$('#modal_reject_master_program').find('#id').val(data.data.id);
                	$('#modal_reject_master_program').find('#kode').val(data.data.kode);
                	$('#modal_reject_master_program').find('#nama').val(data.data.nama);
                }
            },
            error : function(){

            }
        });

		$('#btnSave_master_program').hide();
		$('#btnUpdate_master_program').show();
	}

function reject_usulan_master_program() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/reject_usulan_master_program'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_program').serialize(),
			success : function(data){
				if(data.success == true)
				{
					Swal.fire(
						      'DItolak!',
						      'Usulan program di tolak..!',
						      'success'
						    );
					$('#form_master_program')[0].reset();
					$('#clodemodalmodal_master_program').click();
					$('#table-usulan-program').DataTable().ajax.reload(null, false);
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




	function acc_usulan_program (id_program, nama_program, kode_program) {
		Swal.fire({
			  title: 'Setujui ?',
			  text: 'Setujui program  '+ nama_program+' dengan kode rekening '+kode_program+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Setujui',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/acc_usulan_program/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_program: id_program
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Disetujui!',
						      'Usulan Master Program Disetujui..!',
						      'success'
						    );
							
					$('#table-usulan-program').DataTable().ajax.reload(null, false);
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





	function reject_usulan_kegiatan(id_kegiatan)
	{
		status = 'update';
		$('#clodemodal_usulan_data_apbd').click();
		$('#modal_reject_master_kegiatan').modal('show').find('.modal-title').text('Tolak Usulan  kegiatan');
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
                	$('#modal_reject_master_kegiatan').find('#id').val(data.data.id);
                	$('#modal_reject_master_kegiatan').find('#kode').val(data.data.kode);
                	$('#modal_reject_master_kegiatan').find('#nama').val(data.data.nama);
                }
            },
            error : function(){

            }
        });

		$('#btnSave_master_kegiatan').hide();
		$('#btnUpdate_master_kegiatan').show();
	}

function reject_usulan_master_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/reject_usulan_master_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					Swal.fire(
						      'Ditolak!',
						      'Usulan kegiatan di tolak..!',
						      'success'
						    );
					$('#form_master_kegiatan')[0].reset();
					$('#clodemodalmodal_master_kegiatan').click();
					$('#table-usulan-kegiatan').DataTable().ajax.reload(null, false);
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




	function acc_usulan_kegiatan (id_kegiatan, nama_kegiatan, kode_kegiatan) {
		Swal.fire({
			  title: 'Setujui ?',
			  text: 'Setujui kegiatan  '+ nama_kegiatan+' dengan kode rekening '+kode_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Setujui',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/acc_usulan_kegiatan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_kegiatan: id_kegiatan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Disetujui!',
						      'Usulan Master kegiatan Disetujui..!',
						      'success'
						    );
							
					$('#table-usulan-kegiatan').DataTable().ajax.reload(null, false);
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





	function reject_usulan_sub_kegiatan(id_sub_kegiatan)
	{
		status = 'update';
		$('#clodemodal_usulan_data_apbd').click();
		$('#modal_reject_master_sub_kegiatan').modal('show').find('.modal-title').text('Tolak Usulan  sub_kegiatan');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax(
        {
            url     : baseUrl('management_master_data_apbd/get_sub_kegiatan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { id_sub_kegiatan : id_sub_kegiatan },
            success : function(data)
            {
                if(data.status == true)
                {
                	$('#modal_reject_master_sub_kegiatan').find('#id').val(data.data.id);
                	$('#modal_reject_master_sub_kegiatan').find('#kode').val(data.data.kode);
                	$('#modal_reject_master_sub_kegiatan').find('#nama').val(data.data.nama);
                }
            },
            error : function(){

            }
        });

		$('#btnSave_master_sub_kegiatan').hide();
		$('#btnUpdate_master_sub_kegiatan').show();
	}

function reject_usulan_master_sub_kegiatan() {
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();


		$.ajax({
			url: baseUrl('management_master_data_apbd/reject_usulan_master_sub_kegiatan'),
			type : "POST",
			dataType: 'JSON',
			data :$('#form_master_sub_kegiatan').serialize(),
			success : function(data){
				if(data.success == true)
				{
					Swal.fire(
						      'Sukses!',
						      'Usulan sub_kegiatan di tolak..!',
						      'success'
						    );
					$('#form_master_sub_kegiatan')[0].reset();
					$('#clodemodalmodal_master_sub_kegiatan').click();
					$('#table-usulan-sub-kegiatan').DataTable().ajax.reload(null, false);
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




	function acc_usulan_sub_kegiatan (id_sub_kegiatan, nama_sub_kegiatan, kode_sub_kegiatan) {
		Swal.fire({
			  title: 'Setujui ?',
			  text: 'Setujui sub_kegiatan  '+ nama_sub_kegiatan+' dengan kode rekening '+kode_sub_kegiatan+'.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Setujui',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  	$.ajax({
			  		url: baseUrl('management_master_data_apbd/acc_usulan_sub_kegiatan/'),
					dataType: 'JSON',
					type: 'POST',
					data: {
						id_sub_kegiatan: id_sub_kegiatan
					},
			  		success : function(data){
			  			if(data.status == true)
						{
							Swal.fire(
						      'Dihapus!',
						      'Master sub_kegiatan Dihapus..!',
						      'success'
						    );
							
					$('#table-usulan-sub-kegiatan').DataTable().ajax.reload(null, false);
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
