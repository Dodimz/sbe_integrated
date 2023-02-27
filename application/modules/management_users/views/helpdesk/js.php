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

	$(document).ready(function()
	{

	   select2();
	   data_opd();
	   data_helpdesk_fisik();
	   data_helpdesk_progul();
	   data_helpdesk_penyedia();
	   data_helpdesk_keuangan();
	   statistika_helpdesk();
	});




function data_helpdesk_fisik() {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-helpdesk-fisik').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_users/dt_helpdesk/'),
				type: "POST",
				data: {
					id_group : 4
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
function data_helpdesk_progul() {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-helpdesk-progul').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_users/dt_helpdesk_progul/'),
				type: "POST",
				data: {
					id_group : 8
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
					targets: [2, 3, 4],
				},
			],

		});
	}
function data_helpdesk_penyedia() {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-helpdesk-penyedia').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_users/dt_helpdesk_progul/'),
				type: "POST",
				data: {
					id_group : 9
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
					targets: [2, 3, 4],
				},
			],

		});
	}	
function data_helpdesk_keuangan() {
		// $("#table-kegiatan-apbd").hide();
		// $("#table-kegiatan-apbd").slideUp( 1 ).delay( 1 ).fadeIn( 1 );
		$('#table-helpdesk-keuangan').DataTable({
			// processing	: true,
			serverSide: true,
			bDestroy: true,
			responsive: true,
			ajax: {
				url: baseUrl('management_users/dt_helpdesk_progul/'),
				type: "POST",
				data: {
					id_group : 10
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
					targets: [2, 3, 4],
				},
			],

		});
	}	




	function statistika_helpdesk()
	{
		$.ajax({
	    	url 	 : baseUrl('management_users/statistika_helpdesk/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : {},
	    	success  : function(data)
	    	{
				$.each(data.data, function(k, v){
				console.log(v.jml_data);
						$('#helpdesk_' + v.id_group).html(v.jml_data);
					});
	    	}
	    });
	}

	function data_opd()
	{
		$.ajax({
	    	url 	 : baseUrl('management_users/get_opd/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : {},
	    	success  : function(data)
	    	{
				if(data.status == true)
				{
					$('#id_instansi').html('');
					$('#id_instansi').append('<option value=""></option>');

					$.each(data.data, function(k, v){
						$('#id_instansi').append('<option value="'+ v.id_instansi +'">'+ v.nama_instansi +'</option>');
					});
				}
			}
		});
	}

	function tampil_opd(id_user,prop)
	{
		console.log(id_user);
		let parent  = $(prop).closest('.list-group-item').attr('id');
		
		$('.lg-item').removeClass('list-group-item-info');
		$('#'+ parent).addClass('list-group-item-info');

		$('#id_user').val(id_user);
		id_user ? $('#data-instansi').show() : $('#data-instansi').hide();
		$('#table-opd').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('management_users/dt_opd/'),
				            type 	: "POST",
				          	data 	: { id_user : id_user },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0, 2 ],
							},
							{
								className	: "dt-center",
								targets		: [ -1 ],
							},
	        			  ],

    	});
	}

	function show_opd(id_user)
	{
		console.log(id_user);
		$('#modal_helpdesk_skpd').modal('show');
		$('#modal_helpdesk_skpd').find('#id_user').val(id_user);

		$.ajax({
	    	url 	 : baseUrl('management_users/identitas_user/'),
	    	type 	 : "POST",
	    	dataType : "JSON",
	    	data 	 : { id_user : id_user},
	    	success  : function(data)
	    	{
				$('#modal_helpdesk_skpd').find('.nama_helpdesk').html(data.data.full_name);
				$('#modal_helpdesk_skpd').find('.username').html(data.data.username);
	    		console	.log(data.data.full_name);
				if(data.status == true)
				{
					data_opd();
					tampil_opd(id_user);
				}
			}
		});

		$('#table-opd').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('management_users/dt_opd/'),
				            type 	: "POST",
				          	data 	: { id_user : id_user },
	        			  },
	        columnDefs  : [
						  	{
						    	targets	 	: [ 0, -1 ],
						    	orderable 	: false,
						    },
						    {
								width		: "1%",
								targets		: [ 0, 2 ],
							},
							{
								className	: "dt-center",
								targets		: [ -1 ],
							},
	        			  ],

    	});
	}

	function select2()
	{
		showSelect2('id_instansi','Pilih Instansi');
	}

	function tambah()
	{
		let id_user 	= $('#modal_helpdesk_skpd').find('#id_user').val();
		let id_instansi	= $('#modal_helpdesk_skpd').find('#id_instansi').val();
	

		if (id_instansi==null || id_instansi=='') {
			Swal.fire('Error','Harap Pilih Instansi','error');
		}else{
		
			$.ajax({
		    	url 	 : baseUrl('management_users/save/'),
		    	type 	 : "POST",
		    	dataType : "JSON",
		    	data 	 : { id_user : id_user, id_instansi : id_instansi },
		    	success  : function(data)
		    	{
					if(data.status == true)
					{
						data_opd();
						// statistika_helpdesk();
						$('#table-helpdesk-fisik').DataTable().ajax.reload(null, false);
						$('#table-opd').DataTable().ajax.reload(null, false);
						let id_instansi	= $('#modal_helpdesk_skpd').find('#id_instansi').val('').change();
						// tampil_opd(id_user);
					}
				}
			});
		}
	}

	function hapus_opd(id_helpdesk_instansi, id_user)
	{
		$.ajax({
	    	url 	 : baseUrl('management_users/delete_helpdesk_instansi/'),
	    	type 	 : "POST",
	    	dataType : "JSON",
	    	data 	 : { id_helpdesk_instansi : id_helpdesk_instansi },
	    	success  : function(data)
	    	{
				if(data.status == true)
				{
					data_opd();
					$('#table-helpdesk-fisik').DataTable().ajax.reload(null, false);
					$('#table-opd').DataTable().ajax.reload(null, false);
				}
			}
		});
	}
</script>
