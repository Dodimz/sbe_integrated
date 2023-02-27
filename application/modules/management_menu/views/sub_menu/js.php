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
	   showSubMenu();
	   select2();
	});
	/**
	 *
	 * Master Menu
	 *
	 */

	/* Menampilkan Select2 */
	function select2()
	{
		showSelect2('idMenu','Pilih Menu');
	}
	/* Fungsi untuk mengedit Sub Menu */
	function editSubMenu(idSubMenu)
	{
		status = 'update';
		$('#modalSubMenu').modal('show');
		$('.modal-title').text('Edit Data');
		$('#formSubMenu')[0].reset();
	    $('.form-group').removeClass('has-error')
						.removeClass('has-success');
		$('.text-danger').remove();
	    $('.help-block').empty();
	    $('#idSubMenu').val(idSubMenu);

	    $.ajax({
	    	url 	 : baseUrl('management_menu/get_sub_menu/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : { idSubMenu : idSubMenu },
	    	success  : function(data)
	    	{
	    		if(data.success==true)
	    		{
	    			$('#idMenu').val(data.data.id_menu).trigger('change');
	    			$('#orderNumber').val(data.data.order_number);
	    			$('#subMenuName').val(data.data.sub_menu_name);
	    			$('#link').val(data.data.link);
	    			$('#title').val(data.data.title);
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
	/* Fungsi untuk menampilkan Sub Menu */
	function showSubMenu()
	{
		var table 		= 'table-sub-menu',
		    url   		= 'management_menu/dt_sub_menu/',
		    targetOrder = [ 0, -1 ],
		    targetClass = [ 0, 2, 6, 7 ],
		    targetWidth = [ 0, 2, 6 ];

		showDatatables(table,url, targetOrder, targetClass, targetWidth);
	}
	/* Fungsi untuk menampilkan modal add sub menu */
	function addSubMenu()
	{
		status = 'save';
	    var select2 = [ 'idMenu' ];
	    showModal('modalSubMenu','Add New Data');
	    resetForm('formSubMenu',select2);
	}
	/* Fungsi untuk menampilkan order number berdasarkan master menu */
	function showOrderNumber(idMenu)
	{
		if(status=='save')
		{
			if(idMenu)
			{
				$.get(baseUrl('management_menu/get_sub_menu_order_number'),{idMenu : idMenu}, function(data){
					$('#orderNumber').val(data);
				});
			}
		}
	}
	/* Fungsi untuk menyimpan/mengupdate sub menu */
	function saveSubMenu()
	{
		if(status=='save')
		{
			url_data = 'management_menu/save_sub_menu';
		}else{
			url_data = 'management_menu/update_sub_menu';
		}

        ajaxSave(url_data, 'POST', 'JSON', 'formSubMenu', 'btnSaveSubMenu', 'Save Change', 'modalSubMenu');
        showSubMenu();
	}
	/* Fungsi untuk menghapus Sub Menu */
	function deleteSubMenu(idSubMenu)
	{
		if(confirm('Yakin ?'))
	    {
	    	var data = { idSubMenu : idSubMenu };
	    	ajaxDelete('management_menu/delete_sub_menu/', 'POST', 'JSON', data);
	    	showSubMenu();
	        // $.ajax({
	        //     url 	 : baseUrl('management_menu/delete_sub_menu/'),
	        //     type 	 : "POST",
	        //     dataType : "JSON",
	        //     data 	 : { idSubMenu : idSubMenu },
	        //     success  : function(data)
	        //     {
	        //     	$(".notif").html('<div class="alert alert-success alert-dismissible">'+'<i class="fa fa-check"></i> '+data.messages)
		       //      $(".notif").fadeTo(1000,1000).slideUp(1000, function()
		       //      {
		       //        $(".notif").slideUp(1000);
		       //      });
	        //     	showSubMenu();
	        //     },
	        //     error: function (jqXHR, textStatus, errorThrown)
	        //     {
	        //         console.log('Error deleting data');
	        //     }
	        // });
	 
	    }
	}
</script>