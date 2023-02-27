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

	$(document).ready(function()
	{
	   showMasterMenu();
	   showSelect2();
	});
	/**
	 *
	 * Master Menu
	 *
	 */

	 /* Menampilkan Select2 */
	function showSelect2()
	{
		$('#idCategoryMenu').select2({
			placeholder: 'Pilih Category Menu',
			allowClear: false,
			theme: 'bootstrap4',
		});
	}
	/* Fungsi untuk mengedit Menu */
	function editMasterMenu(idMenu)
	{
		status = 'update';
		$('#modalMasterMenu').modal('show');
		$('.modal-title').text('Edit Data');
		$('#formMasterMenu')[0].reset();
	    $('.form-group').removeClass('has-error')
						.removeClass('has-success');
		$('.text-danger').remove();
	    $('.help-block').empty();
	    $('#idMenu').val(idMenu);

	    $.ajax({
	    	url 	 : baseUrl('management_menu/get_master_menu/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : { idMenu : idMenu },
	    	success  : function(data)
	    	{
	    		if(data.success==true)
	    		{
	    			$('#idCategoryMenu').val(data.data.id_category_menu).trigger('change');
	    			$('#orderNumber').val(data.data.order_number);
	    			$('#menuName').val(data.data.menu_name);
	    			$('#icon').val(data.data.icon);
	    			$('#link').val(data.data.link);
	    			$('#isParent').val(data.data.is_parent);
	    			$('#isActive').val(data.data.is_active);
	    			$('.checkGroup').prop('checked',false);
					$.each(data.group, function(key, value)
	    			{
	    				$('#check'+value.id_group).prop('checked',true);
	    			});
	    		}
	    	}
	    });
	}
	/* Fungsi untuk menampilkan Master Menu */
	function showMasterMenu()
	{
		$('#table-master-menu').DataTable({
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        autoWidth 	: true,
	        ajax		: {
				          	url 	: baseUrl('management_menu/dt_master_menu/'),
				            type 	: "POST",
				          	data 	: {},
	        			  },
	        columnDefs  : [
						  	{ 
						    	targets	 	: [0, -1],
						    	orderable 	: false,
						    },
						    {
						    	className 	: "dt-center",
						    	targets 	: [0, 5, 6, 7],
						    },
						    {
						    	width 		: "1%",
						    	targets 	: [0, 3, 4, 5, 6], 
						    },
	        			  ],
 
    	});
	}
	/* Fungsi untuk menampilkan modal add master menu */
	function addMasterMenu()
	{
		status = 'save';
		$('#modalMasterMenu').modal('show');
		$('.modal-title').text('Add New Data');
		$('#formMasterMenu')[0].reset();
		$('#idCategoryMenu').val('').trigger('change');
	    $('.form-group').removeClass('has-error')
						.removeClass('has-success');
		$('.text-danger').remove();
	    $('.help-block').empty();
	}
	/* Fungsi untuk menampilkan order number berdasarkan category menu */
	function showOrderNumber(idCategoryMenu)
	{
		if(status=='save')
		{
			if(idCategoryMenu)
			{
				$.get(baseUrl('management_menu/get_master_menu_order_number'),{idCategoryMenu : idCategoryMenu}, function(data){
					$('#orderNumber').val(data);
				});
			}
		}
	}
	/* Fungsi untuk menyimpan/mengupdate master menu */
	function saveMasterMenu()
	{
		if(status=='save')
		{
			url_data = baseUrl('management_menu/save_master_menu');
		}else{
			url_data = baseUrl('management_menu/update_master_menu');
		}

		$('#btnSaveMasterMenu').text('Loading...')
							   .attr('disabled',true);
        $.ajax({
        	url 	 : url_data,
        	type 	 : "POST",
        	dataType : "JSON",
        	data 	 : $('#formMasterMenu').serialize(),
        	success  : function(data)
        	{
        		if(data.success==false)
				{
					$.each(data.messages, function(key, value)
					{
							var element = $('#' + key);
							element.closest('div.form-group')
								   .removeClass('has-error')
								   .addClass(value.length > 0 ? 'has-error' : 'has-success')
							       .find('.text-danger')
							       .remove();
							element.after(value);
					});
					$('#btnSaveMasterMenu').removeAttr('disabled')
		            						 .html('Save Changes');
				}else{
					$(".notifikasi").html('<div class="alert alert-success alert-dismissible">'+'<i class="fa fa-check"></i> '+data.messages)
		            $(".notifikasi").fadeTo(1000,1000).slideUp(1000, function()
		            {
		              $(".notifikasi").slideUp(1000);
		            });
		            $('#formMasterMenu')[0].reset();
		            $('#modalMasterMenu').modal('hide');
		            showMasterMenu();
		            $('#btnSaveMasterMenu').removeAttr('disabled')
		            					   .html('Save Changes');
				}
        	},
        	error: function(jqXHR, textStatus, errorThrown)
        	{

        	}
        });
	}
	/* Fungsi untuk menghapus Master Menu */
	function deleteMasterMenu(idMenu)
	{
		if(confirm('Yakin ?'))
	    {
	        $.ajax({
	            url 	 : baseUrl('management_menu/delete_master_menu/'),
	            type 	 : "POST",
	            dataType : "JSON",
	            data 	 : { idMenu : idMenu },
	            success  : function(data)
	            {
	            	$(".notif").html('<div class="alert alert-success alert-dismissible">'+'<i class="fa fa-check"></i> '+data.messages)
		            $(".notif").fadeTo(1000,1000).slideUp(1000, function()
		            {
		              $(".notif").slideUp(1000);
		            });
	            	showMasterMenu();
	            },
	            error: function (jqXHR, textStatus, errorThrown)
	            {
	                console.log('Error deleting data');
	            }
	        });
	 
	    }
	}
</script>