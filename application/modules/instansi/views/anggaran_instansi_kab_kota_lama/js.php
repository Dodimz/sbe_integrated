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
	   	anggaran_instansi_kab_kota();
	   	show_select2();
	   	showAutoCurrency();
	});

	function showAutoCurrency(){
		$('input.currency').number( true, 0 );
	}


	function show_select2() {
		
		$('#status').select2({
			placeholder: "Pilih Status",
			allowClear: false,
			width: 'style',
			theme: 'bootstrap4'
		});
		
	}




function anggaran_instansi_kab_kota()
	{
		
		

		$('#table-instansi').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('instansi/data_anggaran_instansi_kab_kota/'),
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












	function input_pagu_instansi(id_instansi, tahap, )
	{
		$('#modal_input_anggaran').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	  $('#form_anggaran_sub_kegiatan')[0].reset();
        $('.text-danger').remove();
        $('#pesan_mnodal_paket').html('');
		$('#form_anggaran_sub_kegiatan').attr('style', '');
    	$('#tahap').val(tahap);
    	$('#id_instansi').val(id_instansi);

    	// $('#rea_bo').removeAttr('checked');
    	// $('#rea_bm').removeAttr('checked');
    	// $('#rea_btt').removeAttr('checked');
    	// $('#rea_bt').removeAttr('checked');
		$.ajax(
        {
            url     : baseUrl('instansi/get_anggaran_instansi_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	
            	id_instansi : id_instansi,
            	tahap : tahap
            },
            success : function(data)
            {
            	console.log(data);
            	
            	$('#modal_input_anggaran').find('.instansi').html(data.data.nama_instansi);
            
                if(data.status == true)
                {
                	
                	
                	$('#bo_bp').val(data.data. bo_bp);
                	$('#bo_bbj').val(data.data.bo_bbj);
                	$('#bo_bs').val(data.data.bo_bs);
                	$('#bo_bh').val(data.data.bo_bh);
                	$('#bo_bbs').val(data.data.bo_bbs);
                	$('#bm_bmt').val(data.data.bm_bmt);
                	$('#bm_bmpm').val(data.data.bm_bmpm);
                	$('#bm_bmgb').val(data.data.bm_bmgb);
                	$('#bm_bmjji').val(data.data.bm_bmjji);
                	$('#bm_bmatl').val(data.data.bm_bmatl);
                	$('#bm_bmatb').val(data.data.bm_bmatb);
                	$('#btt').val(data.data.btt);
                	$('#bt_bbh').val(data.data.bt_bbh);
                	$('#bt_bbk').val(data.data.bt_bbk);
                }
                
                	data.data.rea_bo ==1 ? $('#rea_bo').attr('checked','checked') : $('#rea_bo').removeAttr('checked');
                	data.data.rea_bm ==1 ? $('#rea_bm').attr('checked','checked') : $('#rea_bm').removeAttr('checked');
                	data.data.rea_btt ==1 ? $('#rea_btt').attr('checked','checked') : $('#rea_btt').removeAttr('checked');
                	data.data.rea_bt ==1 ? $('#rea_bt').attr('checked','checked') : $('#rea_bt').removeAttr('checked');
            },
            error : function(){
            	console.log('error');
            }
        });


	}





	function copy_pagu_instansi(id_instansi, tahap, skpd)
	{

		Swal.fire({
			  title: 'Warning',
			  text: 'Apakah anda akan mencopy data pagu APBD AWAL pada SKPD ' + skpd,
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Copy',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
			  		




			  		$.ajax(
			        {
			            url     : baseUrl('instansi/copy_anggaran_instansi_kab_kota/'),
			            dataType: 'JSON',
			            type    : 'POST',
			            data    : { 
			            	
			            	id_instansi : id_instansi,
			            	tahap : tahap,
			            	skpd : skpd,
			            },
			            success : function(data)
			            {
			            	console.log(data);
			            	if (data.status==true) {
				            	Swal.fire('Di Copy',data.messages, 'success');
			            	}else{
				            	Swal.fire('Tidak ada data',data.messages, 'error');

			            	}
			            	$('#table-instansi').DataTable().ajax.reload(null, false);
			            	
			            	
			            },
			            error : function(){
			            	console.log('error');
			            }
			        });
			

			  
			  }
			});








		


	}




	function save_anggaran_instansi_kab_kota()
	{
		let id_pptk 	= $('#id_pptk').val();
		//let id_table 	= $('#kode_rekening_kegiatan').val().split('.').join('-');

		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
        $('.text-danger').remove();

		$.ajax({
			url: baseUrl('instansi/save_anggaran_instansi_kab_kota'),
			type: 'POST',
			dataType: 'JSON',
			data: $('#form_anggaran_sub_kegiatan').serialize(),
			success: function (datanya)
			{
				console.log(datanya);
				if(datanya.success == true)
				{
					
						$('#form_anggaran_sub_kegiatan')[0].reset();
						$('#modal_input_anggaran').modal('hide');

						$('#table-instansi').DataTable().ajax.reload(null, false);

				}else{
					$.each(datanya.messages, function (key, value)
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
				console.log('errort');
			}
		});
	}


			
			

function ceklis_realisasi(id){
	$("#" + id).change(function(){

	  if ($(this).is('checked')) {
	      var nilai = 1;
	  } else {
	      var nilai = 0;
	  }       
	
	});
	
}

</script>