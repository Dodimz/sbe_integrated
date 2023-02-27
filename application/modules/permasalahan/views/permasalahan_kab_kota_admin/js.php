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
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	
	$(document).ready(function()
	{
	   	show_select2();
	   	master_instansi_kab_kota();
	});



	function show_select2() {
		
		$('#kota').select2({
			placeholder: "Pilih Kab / Kota",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}





	function show_laporan(x) {
		let id_kota = $('#kota').val();
		let kategori = $('#kategori').val();
		$('#bulan').val('');
		if (id_kota) {
			if (x != 0) {
				$('#tampil_pdf').show();
				$('#tampil_pdf').attr('src', baseUrl('permasalahan/show_permasalahan_skpd_kab_kota?id_kota=') + id_kota);
			}
		}
	}


function master_instansi_kab_kota()
	{
		
		

		$('#table-instansi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('permasalahan/data_instansi_kab_kota/'),
				            type 	: "POST",
				          	data 	: {}
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
								className	: "dt-center",
								targets		: [ -1 ],
							},
	        			  ],
	    
	     //    fnRowCallback : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		    //    var index = iDisplayIndex +1;
		    //    $('td:eq(0)',nRow).html(index);
		    //    return nRow;
		    // }

    	});
	}



</script>