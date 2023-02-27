<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<!-- Function -->
<script>
	/* Global Variable */
	let url_data;
	let button_title;
	let status;

	$(document).ready(function()
	{
	   showMasterModule();
	});
	/**
	 *
	 * Master Module
	 *
	 */

	/* Fungsi untuk mengedit Master Module */
	function editMasterModule(idModule)
	{
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
	    	url 	 : baseUrl('management_modules/get_master_module/'),
	    	type 	 : "GET",
	    	dataType : "JSON",
	    	data 	 : { idModule : idModule },
	    	success  : function(data)
	    	{
	    		if(data.success==true)
	    		{
	    			$('#idModule').val(idModule);
	    			$('#moduleName').val(data.data.module_name);
	    			$('#moduleDescription').val(data.data.module_description);
	    			$('.checkGroup').prop('checked',false);
					$.each(data.group, function(key, value)
	    			{
	    				$('#check'+value.id_group).prop('checked',true);
	    			});
					$('#isActive').val(data.data.is_active);
					$('#readonly').val(data.data.readonly);
	    		}
	    	}
	    });
	}
	/* Fungsi untuk menampilkan Master Module */
	function showMasterModule()
	{
		var table 		= 'table-master-module',
		    url   		= 'management_modules/dt_master_module/',
		    targetOrder = [ 0 -1],
		    targetClass = [ 0, 5, 6 ],
		    targetWidth = [ 0, 6 ];

		showDatatables(table,url, targetOrder, targetClass, targetWidth);
	}
	/* Fungsi untuk menampilkan modal add master module */
	function addMasterModule()
	{
		status = 'save';
	    var select2 = [];
	    showModal('modalMasterModule','Add New Data');
	    resetForm('formMasterModule',select2);
	}
	/* Fungsi untuk menyimpan/mengupdate master module */
	function saveMasterModule()
	{
		if(status=='save')
		{
			url_data = 'management_modules/save_master_module';
		}else{
			url_data = 'management_modules/update_master_module';
		}

        ajaxSave(url_data, 'POST', 'JSON', 'formMasterModule', 'btnSaveMasterModule', 'Save Change', 'modalMasterModule');
        showMasterModule();
	}
	/* Fungsi untuk menghapus master module */
	function deleteMasterModule(idModule)
	{
		if(confirm('Are you sure ?'))
	    {
	    	var data = { idModule : idModule };
	    	ajaxDelete('management_modules/delete_master_module/', 'POST', 'JSON', data);
	    	showMasterModule();
	    }
	}
</script>