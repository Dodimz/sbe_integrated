<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- Function -->
<script>
	/* Global Variable */
	let status = 'save';
	let url_data;
	let button_title;

	$(document).ready(function()
	{
	   showCategoryMenu();
	});
	/* Fungsi untuk menyimpan Category Menu */
	$('#form-add-category-menu').on('submit', function(e)
	{
		e.preventDefault();
		let me = $(this);

		$('#btnSaveCategoryMenu').attr('disabled',true)
								 .html('Loading....');

		if(status=='save')
		{
			url_data 		= baseUrl('management_menu/save_category_menu/');
			button_title 	= "Save";
		}else{
			url_data 		= baseUrl('management_menu/update_category_menu/');
			button_title 	= "Update";
		}

		$.ajax({
			url 	 : url_data,
			type 	 : 'POST',
			data 	 : $(this).serialize(),
			dataType : 'JSON',
			cache 	 : false,
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
					$('#btnSaveCategoryMenu').removeAttr('disabled')
		            						 .html(button_title);
				}else{
					status = 'save';
					$(".notifikasi").html('<div class="alert alert-success alert-dismissible">'+'<i class="fa fa-check"></i> '+data.messages)
		            $(".notifikasi").fadeTo(1000,1000).slideUp(1000, function()
		            {
		              $(".notifikasi").slideUp(1000);
		            });
		            me[0].reset();
		            $('#orderNumber').val(data.order_number);
		            showCategoryMenu();
		            $('#formTitle').html("Add New Data");
		            $('#idCategoryMenu').remove();
		            $('#btnSaveCategoryMenu').removeAttr('disabled')
		            						 .html('Save');
				}
			}
		});
	});
	/* Fungsi untuk mengupdate Category Menu */
	function editCategoryMenu(idCategoryMenu)
	{
		status   		= "update";
		let form 		= $('#form-add-category-menu');
		let formGroup 	= form[0];
		$('#idCategoryMenu').remove();
		let hidden      = $(formGroup).append('<input type="hidden" id="idCategoryMenu" name="idCategoryMenu" value='+idCategoryMenu+'>');
		$('#formTitle').html("Edit Data");
		$('#orderNumber').removeAttr('readonly');
		$('#btnSaveCategoryMenu').attr('disabled',false)
								 .html('Update');
		$('.form-group').removeClass('has-error')
						.removeClass('has-success');
		$('.text-danger').remove();
	    $('.help-block').empty();
	    $.ajax({
	    	url 	 : baseUrl('management_menu/get_category_menu/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : { idCategoryMenu : idCategoryMenu },
	    	success  : function(data)
	    	{
	    		if(data.success==true)
	    		{
	    			$('#orderNumber').val(data.data.order_number);
	    			$('#categoryName').val(data.data.category_name);
	    			$('#categoryDescription').val(data.data.category_description);
	    			$('#active').val(data.data.is_active);
	    			$('.checkGroup').prop('checked',false);
					$.each(data.group, function(key, value)
	    			{
	    				$('#check'+value.id_group).prop('checked',true);
	    			});
	    		}
	    	}
	    });
	}
	/* Fungsi untuk menghapus Category Menu */
	function deleteCategoryMenu(idCategoryMenu)
	{
		if(confirm('Yakin ?'))
	    {
	        $.ajax({
	            url 	 : baseUrl('management_menu/delete_category_menu/'),
	            type 	 : "POST",
	            dataType : "JSON",
	            data 	 : { idCategoryMenu : idCategoryMenu },
	            success  : function(data)
	            {
	            	$(".notif").html('<div class="alert alert-success alert-dismissible">'+'<i class="fa fa-check"></i> '+data.messages)
		            $(".notif").fadeTo(1000,1000).slideUp(1000, function()
		            {
		              $(".notif").slideUp(1000);
		            });
		            $('#orderNumber').val(data.order_number);
	            	showCategoryMenu();
	            },
	            error: function (jqXHR, textStatus, errorThrown)
	            {
	                console.log('Error deleting data');
	            }
	        });
	 
	    }
	}
	/* Fungsi untuk menampilkan Category Menu */
	function showCategoryMenu()
	{
		$('#table-category-menu').DataTable({
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('management_menu/dt_category_menu/'),
				            type 	: "POST",
				          	data 	: {},
	        			  },
	        columnDefs  : [
						  	{ 
						    	targets	 	: [0,-1],
						    	orderable 	: false,
						    },
	        			  ],
 
    	});
	}
</script>