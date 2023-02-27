
<!-- Datatables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!-- Leaflet -->

<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/leaflet/leaflet.js"></script>
<script>
	// var fetch_method = '<?php echo $this->router->fetch_method() ?>';
	// if (fetch_method=='cek_import_sipedal') {
	// 	var id_opd = '<?php echo $id_instansi ?>';
	// 	var id_opd = '<?php echo $id_instansi ?>';
	// }
	// // alert(fetch_method);
    $('#datatable_1').DataTable();
		$('#id_opd').select2(
		{
			placeholder : "Pilih OPD",
			allowClear	: false,
			width 		: 'style',
			theme 		: 'bootstrap4'
		});


	 function get_data_integrasi_sipedal(){

	 	$('#searching_button').attr("disabled","disabled");
	 	$('#searching_button').html(`<i class="fa fa-cog fa-w-16 fa-spin"></i> Loading Data`);
		id_instansi =  $('#id_opd').val();
		tahun =  $('#tahun').val();
		tahap =  $('#tahap').val();
		kategori_data =  $('#kategori_data').val();
		$.ajax({
			url: baseUrl('integrasi_aplikasi/get_data_sipedal'),
			type: 'POST',
			// dataType: 'JSON',
			data: {
				id_instansi : id_instansi,
				tahun : tahun,
				tahap : tahap
			}	,
			success: function(data) {
				$('#show_data_sipd').html(data);
					$('#searching_button').removeAttr("disabled","disabled");
				 	$('#searching_button').html(`Searching`);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// alert('e');
			}
		});
	


 }

	 function import_sipedal_ke_sbe(link_api, belum_terimport, id_instansi, tahun, jenis){

		Swal.fire({
			  title: 'Warning',
			  html: 'Apakah anda akan melakukan import data di Sipedal ke Data Paket Pekerjaan, '+ belum_terimport+' data akan di importkan.?',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonHtml: 'Import',
			  cancelButtonText: 'Batal'
			}).then((result) => {
			  if (result.isConfirmed) {
					$('#progres_import').modal('show');
					
  					$.ajax({
						url: baseUrl('integrasi_aplikasi/import_sipedal_ke_sbe'),
						type: 'POST',
						dataType: 'JSON',
						data: {
							link : link_api,
							tahun : tahun,
							id_instansi : id_instansi,
							jenis : jenis
						},
						success: function(data) {
							Swal.fire(data.instruksi, data.message,data.swal_code);
							get_data_integrasi_sipedal();
							$('#progres_import').modal('hide');
							console.log(data);
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert('e');
						}
					});
			  }
			});




	


 }
	

</script>