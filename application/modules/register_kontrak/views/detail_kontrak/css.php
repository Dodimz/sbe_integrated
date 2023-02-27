<?php
/**
	* Author     : Alfikri, M.Kom
	* Created By : Alfikri, M.Kom
	* E-Mail     : alfikri.name@gmail.com
	* No HP      : 081277337405
*/
?>
<!-- Bootstrap Datepicker -->
<link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Leaflet -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/leaflet/leaflet.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
<style>
	#mapid{
		height: 500px;
		z-index: 1;
	}
	#mapSearchContainers{
		position:fixed;
	  	top:20px;
	  	right: 40px;
	  	height:30px;
	  	width:180px;
	  	z-index:110;
	  	font-size:10pt;
	  	color:#5d5d5d;
	  	border:solid 1px #bbb;
	  	background-color:#f8f8f8;
	}
</style>