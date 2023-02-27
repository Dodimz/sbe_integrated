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
<!-- X-editable -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
    $(document).ready(function() {
        data_opd_kb_kota();
    });

    function showAutoCurrency() {
        $('input.currency').number(true, 0);
    }



function data_opd_kb_kota()
	{
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('realisasi/data_instansi_kab_kota/'),
				            type 	: "POST",
				          	data 	: {},
                            // success : function(data){
                            //     console.log(data);
                            // }
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



function input_realisasi(jenis,id_instansi,pagu)
	{	
        var izin_input = <?php echo jadwal_rfk_kab_kota()['aktif'] ?>;
        var bulan_realisasi_config = <?php echo jadwal_rfk_kab_kota()['bulan_aktif'] ?>;
        $('#modal-realisasi-keuangan').find('#id_instansi').val(id_instansi);
        $('#modal-realisasi-keuangan').find('#jenis').val(jenis);
		$('#modal-realisasi-keuangan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
        if (jenis=='bo') {
            var jenis_belanja = 'Belanja Operasi';
            var colspan =6;
            var rincian = '<th align="center">Belanja Pegawai</th>' + '<th align="center">Belanja Barang Jasa</th>' + '<th align="center">Belanja Subsidi</th>' + '<th align="center">Belanja Hibah</th>'  + '<th align="center">Belanja Bantuan Sosial</th>' +'<th>Total</th>';

        }
        else if (jenis=='bm') {
            var jenis_belanja = 'Belanja Modal';
            var colspan =7;
            var rincian = '<th align="center">Belanja Modal Tanah</th>' +'<th align="center">Belanja Modal Peralatan Dan Mesin</th>' +'<th align="center">   Belanja Modal Gedung dan Bangunan</th>' +'<th align="center">Belanja Modal Jalan, Jaringan, dan Irigasi</th>' +'<th align="center">Belanja Modal Aset Tidak Berwujud</th>' +'<th align="center">Belanja Modal dan Aset Tetap Lainnya</th>' +'<th>Total</th>';
            
        }
        else if (jenis=='btt') {
            var jenis_belanja = ' Belanja Tidak Terduga';
            var colspan =2;
            var rincian = '<th align="center">Belanja Tidak Terduga</th>' +'<th>Total</th>' ;
            
        }
        else if (jenis=='bt') {
            var jenis_belanja = 'Belanja Transfer';
            var colspan =3;
            var rincian = '<th align="center">Belanja Bagi Hasil</th>' + '<th align="center">Belanja Bantuan Keuangan</th>' +'<th>Total</th>' ;
            
        }
        else if (jenis=='fisik') {
            var jenis_belanja = '';
            var colspan =1;
            var rincian = '' ;
            
        }
        else {
            var jenis_belanja = '';
            var colspan =15;
            var rincian = '<th align="center">BO-BP</th>' + 
            '<th align="center">BO-BBJ</th>' +
            '<th align="center">BO-BS</th>' +
            '<th align="center">BO-BH</th>' +
            '<th align="center">BO-BBS</th>' +

            '<th align="center">BM-BMT</th>' +
            '<th align="center">BM-BMPM</th>' +
            '<th align="center">BM-BMGB</th>' +
            '<th align="center">BM-BMJJI</th>' +
            '<th align="center">BM-BMATB</th>' +
            '<th align="center">BM-BMATL</th>' +
            
            '<th align="center">BTT</th>' +
            '<th align="center">BT-BBH</th>' +
            '<th align="center">BT-BBK</th>' +
            '<th align="center">Total</th>' 
             ;
            
        }
        var colspan_total = colspan + 1; 
		
        $('#modal-realisasi-keuangan').find('#jenis_belanja').attr('colspan', colspan);
        // $('#modal-realisasi-keuangan').find('.nama_jenis_belanja').html(jenis_belanja);
        $('#modal-realisasi-keuangan').find('#rincian_jenis_belanja').html(rincian);

        $('#modal-realisasi-keuangan').find('#label_total_realisasi').attr('colspan', colspan );


    	$('#modal-realisasi-keuangan').find('#pagu').val(pagu==''? 0: pagu);

        $.ajax(
        {
            url     : baseUrl('realisasi/get_anggaran_instansi_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
                id_instansi : id_instansi,
                jenis : jenis
            },
            success : function(data)
            {
                if (data.tahap=="4" && data.j_direalisasikan==0) {
                    $('#modal-realisasi-keuangan').find('#tombol_copy_realisasi').attr('style','');
                }else{
                    $('#modal-realisasi-keuangan').find('#tombol_copy_realisasi').attr('style','display:none');

                }
                var show_pagu;
                if (jenis=='bo') {
                     show_pagu = data.bo;
                }
                else if (jenis=='bm') {
                     show_pagu = data.bm;
                }
                else if (jenis=='btt') {
                     show_pagu = data.btt;
                }
                else if (jenis=='bt') {
                     show_pagu = data.bt;
                }
                else {
                     show_pagu = data.total;
                }
                $('#modal-realisasi-keuangan').find('#td_nama_instansi').html(data.nama_instansi);
                $('#modal-realisasi-keuangan').find('#pagu_jenis_belanja').html(show_pagu);
                $('#modal-realisasi-keuangan').find('#pagu_total').html(data.total);
            },
            error : function(){

            }
        });
		$.ajax(
        {
            url     : baseUrl('realisasi/get_realisasi_keuangan_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	pagu : pagu,
            	id_instansi : id_instansi,
                jenis : jenis
            },
            success : function(data)
            {
		    	// $('#modal-realisasi-keuangan').find('#exampleModalLabel').html("Setting Target APBD");
            	
            	$('#modal-realisasi-keuangan').find('#nama_tahapan').html(data.nama_tahapan);


                
            	
            	
					$('#data-realisasi-keuangan').html('');
	                if (data.status == true) {

                        
                        $('#info_target').hide();
                        $('#table-realisasi-keuangan').show();
                        var total_realisasi = 0;
                        var total_realisasi_fisik = 0;
						$.each(data.data, function(k, v) {
                            var bulan_realisasi = k+1;

                            if (jenis=='bo') {

                                let bo_bp;
                                let bo_bbj;
                                let bo_bs;
                                let bo_bh;
                                let bo_bbs;
                                let bo_rf;
                                var total = parseInt(v.bo_bp) + parseInt(v.bo_bbj) + parseInt(v.bo_bs) + parseInt(v.bo_bh) +  parseInt(v.bo_bbs);
                                var total_fisik = parseFloat(v.rf_total);
                                if (izin_input==0) {
                                    bo_bp = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                    bo_bbj = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                    bo_bs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                    bo_bh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                    bo_bbs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                    bo_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                }
                                else if (izin_input==2) {
                                   
                                        bo_bp = `<a href="#" id="r-bo_bp" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                        bo_bbj = `<a href="#" id="r-bo_bbj" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                        bo_bs = `<a href="#" id="r-bo_bs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                        bo_bh = `<a href="#" id="r-bo_bh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                        bo_bbs = `<a href="#" id="r-bo_bbs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                        bo_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                }else{
                                    if (bulan_realisasi == bulan_realisasi_config) {

                                        bo_bp = `<a href="#" id="r-bo_bp" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                        bo_bbj = `<a href="#" id="r-bo_bbj" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                        bo_bs = `<a href="#" id="r-bo_bs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                        bo_bh = `<a href="#" id="r-bo_bh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                        bo_bbs = `<a href="#" id="r-bo_bbs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                        bo_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                    }else{
                                         bo_bp = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                        bo_bbj = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                        bo_bs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                        bo_bh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                        bo_bbs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                        bo_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                    }
                                }

                                var show_bo_bp = v.pagu_bo_bp > 0 ? bo_bp : convert_to_rupiah(v.bo_bp);
                                var show_bo_bbj = v.pagu_bo_bbj > 0 ? bo_bbj : convert_to_rupiah(v.bo_bbj);
                                var show_bo_bs = v.pagu_bo_bs > 0 ? bo_bs : convert_to_rupiah(v.bo_bs);
                                var show_bo_bh = v.pagu_bo_bh > 0 ? bo_bh : convert_to_rupiah(v.bo_bh);
                                var show_bo_bbs = v.pagu_bo_bbs > 0 ? bo_bbs : convert_to_rupiah(v.bo_bbs);
                                var show_bo_rf =  bo_rf ;
                                var realisasi = '<td>' + show_bo_bp + '</td>' + 
                                                '<td>' + show_bo_bbj + '</td>' + 
                                                '<td>' + show_bo_bs + '</td>' + 
                                                '<td>' + show_bo_bh + '</td>' +
                                                '<td>' + show_bo_bbs + '</td>' +
                                                '<td>' + convert_to_rupiah(total) + '</td>' +
                                                '<td>' + show_bo_rf + '%</td>' 
                                               // '<td>' + '??' + '</td>'
                                                ;
                            }
                            else if (jenis=='bm') {
                                let bm_bmt;
                                let bm_bmpm;
                                let bm_bmgb;
                                let bm_bmjji;
                                let bm_bmatl;
                                let bm_bmatb;
                                var total = parseInt(v.bm_bmt) + parseInt(v.bm_bmpm) + parseInt(v.bm_bmgb) + parseInt(v.bm_bmjji) + parseInt(v.bm_bmatl) + parseInt(v.bm_bmatb);
                                var total_fisik = parseFloat(v.rf_total);

                                 if (izin_input==0) {    
                                bm_bmt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                bm_bmpm = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                bm_bmgb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                bm_bmjji = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                bm_bmatl = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                bm_bmatb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                  bm_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${v.rf_total} </a>`;
                                 }
                                 else if (izin_input==2) { 
                                    bm_bmt = `<a href="#" id="r-bm_bmt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                    bm_bmpm = `<a href="#" id="r-bm_bmpm" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                    bm_bmgb = `<a href="#" id="r-bm_bmgb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                    bm_bmjji = `<a href="#" id="r-bm_bmjji" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                    bm_bmatl = `<a href="#" id="r-bm_bmatl" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                    bm_bmatb = `<a href="#" id="r-bm_bmatb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                    bm_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                 }else{
                                     if (bulan_realisasi == bulan_realisasi_config) {
                                        bm_bmt = `<a href="#" id="r-bm_bmt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                        bm_bmpm = `<a href="#" id="r-bm_bmpm" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                        bm_bmgb = `<a href="#" id="r-bm_bmgb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                        bm_bmjji = `<a href="#" id="r-bm_bmjji" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                        bm_bmatl = `<a href="#" id="r-bm_bmatl" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                        bm_bmatb = `<a href="#" id="r-bm_bmatb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                        bm_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                      }else{
                                            bm_bmt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                            bm_bmpm = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                            bm_bmgb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                            bm_bmjji = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                            bm_bmatl = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                            bm_bmatb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                            bm_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red">  ${v.rf_total} </a>`;
                                      }
                                 }

                                var show_bm_bmt = v.pagu_bm_bmt > 0 ? bm_bmt : convert_to_rupiah(v.bm_bmt) 
                                var show_bm_bmpm = v.pagu_bm_bmpm > 0 ? bm_bmpm : convert_to_rupiah(v.bm_bmpm) 
                                var show_bm_bmgb = v.pagu_bm_bmgb > 0 ? bm_bmgb : convert_to_rupiah(v.bm_bmgb) 
                                var show_bm_bmjji = v.pagu_bm_bmjji > 0 ? bm_bmjji : convert_to_rupiah(v.bm_bmjji) 
                                var show_bm_bmatl = v.pagu_bm_bmatl > 0 ? bm_bmatl : convert_to_rupiah(v.bm_bmatl)
                                var show_bm_bmatb = v.pagu_bm_bmatb > 0 ? bm_bmatb : convert_to_rupiah(v.bm_bmatb)
                                var show_bm_rf =  bm_rf ;
                                 var realisasi = '<td align="right">' + show_bm_bmt + '</td>' + 
                                                '<td align="right">' + show_bm_bmpm + '</td>' + 
                                                '<td align="right">' + show_bm_bmgb + '</td>' + 
                                                '<td align="right">' + show_bm_bmjji + '</td>' + 
                                                '<td align="right">' + show_bm_bmatb + '</td>' +
                                                '<td align="right">' + show_bm_bmatl + '</td>' +
                                                '<td align="right">' + convert_to_rupiah(total) + '</td>' +
                                                '<td style="color:blue">' + show_bm_rf + '%</td>'  
                                                 ;
                            }
                            else if (jenis=='btt') {
                                let btt;
                                var total = parseInt(v.btt);
                                var total_fisik = parseFloat(v.rf_total);
                                if (izin_input==0) {  
                                btt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</a>`;
                                btt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                }
                                else  if (izin_input==2) {  
                                    btt = `<a href="#" id="r-btt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.btt)}</a>`;
                                    btt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                }else{
                                    if (bulan_realisasi == bulan_realisasi_config) {
                                        btt = `<a href="#" id="r-btt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.btt)}</a>`;
                                        btt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                    }
                                    else{
                                        btt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</a>`;
                                        btt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                    }
                                }
                                var show_btt = v.pagu_btt > 0 ? btt : convert_to_rupiah(v.btt);
                                var show_btt_rf =  btt_rf ;
                                var realisasi = '<td>' + show_btt + '</td>' + 
                                '<td>' + convert_to_rupiah(total) + '</td>' +
                                '<td style="color:blue">' + show_btt_rf + '%</td>'  ;
                            }
                            else if (jenis=='bt') {
                                let bt_bbh;
                                let bt_bbk;
                                 if (izin_input==0) {  
                                 bt_bbh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                bt_bbk = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                bt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                }
                                else if (izin_input==2) { 
                                      bt_bbh = `<a href="#" id="r-bt_bbh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                        bt_bbk = `<a href="#" id="r-bt_bbk" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                        bt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                }
                                else{
                                    if (bulan_realisasi == bulan_realisasi_config) {
                                        bt_bbh = `<a href="#" id="r-bt_bbh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                        bt_bbk = `<a href="#" id="r-bt_bbk" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                        bt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                    }else{
                                        bt_bbh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                        bt_bbk = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                        bt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                    }
                                }
                                var total = parseInt(v.bt_bbh) + parseInt(v.bt_bbk) ;
                                var total_fisik = parseFloat(v.bt_rf);
                                var show_bt_bbh = v.pagu_bt_bbh >0 ? bt_bbh : convert_to_rupiah(v.bt_bbh);    
                                var show_bt_bbk = v.pagu_bt_bbk >0 ? bt_bbk : convert_to_rupiah(v.bt_bbk); 
                                var show_bt_rf =  bt_rf ;

                                var realisasi = '<td>' +show_bt_bbh + '</td>' + 
                                '<td>' +show_bt_bbk + '</td>' +
                                '<td>' + convert_to_rupiah(total) + '</td>' +
                                '<td style="color:blue">' + show_bt_rf + '%</td>'  ;  
                            }
                            else if (jenis=='fisik') {
                                let bt_rf;
                                 if (izin_input==0) {  
                                bt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                }
                                else if (izin_input==2) { 
                                      
                                        bt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                }
                                else{
                                    if (bulan_realisasi == bulan_realisasi_config) {
                                        bt_rf = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                    }else{
                                        bt_rf = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${v.rf_total} </a>`;
                                    }
                                }
                                 var total = parseInt(v.bo_bp) +  parseInt(v.bo_bbj) +  parseInt(v.bo_bs) +  parseInt(v.bo_bh) +  parseInt(v.bo_bbs) +  parseInt(v.bm_bmt) +  parseInt(v.bm_bmpm) +  parseInt(v.bm_bmgb) +  parseInt(v.bm_bmjji) +  parseInt(v.bm_bmatl) +  parseInt(v.bm_bmatb) +  parseInt(v.btt) +  parseInt(v.bt_bbh) +  parseInt(v.bt_bbk) ;
                                var total_fisik = parseFloat(v.rf_total);
                                var show_bt_rf =  bt_rf ;

                                var realisasi ='<td>' + convert_to_rupiah(total) + '</td>' +
                                '<td style="color:blue">' + show_bt_rf + '%</td>'  ;  
                            }
                            else {
                                let bo_bp;
                                let bo_bbj;
                                let bo_bs;
                                let bo_bh;
                                let bo_bbs;
                                let bm_bmt;
                                let bm_bmpm;
                                let bm_bmgb;
                                let bm_bmjji;
                                let bm_bmatl;
                                let bm_bmatb;
                                let btt;
                                let bt_bbh;
                                let bt_bbk;
                                 if (izin_input==0) {  
                                    bo_bp = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                    bo_bbj = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                    bo_bs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                    bo_bh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                    bo_bbs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                    bm_bmt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                    bm_bmpm = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                    bm_bmgb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                    bm_bmjji = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                    bm_bmatl = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                    bm_bmatb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                    btt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</a>`;
                                    bt_bbh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                    bt_bbk = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                    rf_total = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${(v.rf_total)}</a>`;
                                }
                                else if (izin_input==2) { 
                                    bo_bp = `<a href="#" id="r-bo_bp" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                    bo_bbj = `<a href="#" id="r-bo_bbj" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                    bo_bs = `<a href="#" id="r-bo_bs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                    bo_bh = `<a href="#" id="r-bo_bh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                    bo_bbs = `<a href="#" id="r-bo_bbs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                    bm_bmt = `<a href="#" id="r-bm_bmt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                    bm_bmpm = `<a href="#" id="r-bm_bmpm" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                    bm_bmgb = `<a href="#" id="r-bm_bmgb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                    bm_bmjji = `<a href="#" id="r-bm_bmjji" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                    bm_bmatl = `<a href="#" id="r-bm_bmatl" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                    bm_bmatb = `<a href="#" id="r-bm_bmatb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                    btt = `<a href="#" id="r-btt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.btt)}</a>`;
                                    bt_bbh = `<a href="#" id="r-bt_bbh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                    bt_bbk = `<a href="#" id="r-bt_bbk" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                        rf_total = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                }
                                else{
                                    if (bulan_realisasi == bulan_realisasi_config) {
                                        bo_bp = `<a href="#" id="r-bo_bp" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                    bo_bbj = `<a href="#" id="r-bo_bbj" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                    bo_bs = `<a href="#" id="r-bo_bs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                    bo_bh = `<a href="#" id="r-bo_bh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                    bo_bbs = `<a href="#" id="r-bo_bbs" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                    bm_bmt = `<a href="#" id="r-bm_bmt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                    bm_bmpm = `<a href="#" id="r-bm_bmpm" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                    bm_bmgb = `<a href="#" id="r-bm_bmgb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                    bm_bmjji = `<a href="#" id="r-bm_bmjji" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                    bm_bmatl = `<a href="#" id="r-bm_bmatl" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                    bm_bmatb = `<a href="#" id="r-bm_bmatb" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                    btt = `<a href="#" id="r-btt" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.btt)}</a>`;
                                    bt_bbh = `<a href="#" id="r-bt_bbh" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                    bt_bbk = `<a href="#" id="r-bt_bbk" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                        rf_total = `<a href="#" id="r-rf_semua" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${v.rf_total} </a>`;
                                    }else{
                                        bo_bp = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                    bo_bbj = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                    bo_bs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                    bo_bh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</a>`;
                                    bo_bbs = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbs)}</a>`;
                                    bm_bmt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                    bm_bmpm = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                    bm_bmgb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                    bm_bmjji = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                    bm_bmatl = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;
                                    bm_bmatb = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatb)}</a>`;
                                    btt = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</a>`;
                                    bt_bbh = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
                                    bt_bbk = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                    rf_total = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${(v.rf_total)}</a>`;
                                    }
                                }
                                var total = parseInt(v.bo_bp) +  parseInt(v.bo_bbj) +  parseInt(v.bo_bs) +  parseInt(v.bo_bh) +  parseInt(v.bo_bbs) +  parseInt(v.bm_bmt) +  parseInt(v.bm_bmpm) +  parseInt(v.bm_bmgb) +  parseInt(v.bm_bmjji) +  parseInt(v.bm_bmatl) +  parseInt(v.bm_bmatb) +  parseInt(v.btt) +  parseInt(v.bt_bbh) +  parseInt(v.bt_bbk) ;
                                var total_fisik = parseFloat(v.rf_total);
                                var show_bo_bp = v.pagu_bo_bp >0 ? bo_bp : convert_to_rupiah(v.bo_bp);    
                                var show_bo_bbj = v.pagu_bo_bbj >0 ? bo_bbj : convert_to_rupiah(v.bo_bbj); 
                                var show_bo_bs = v.pagu_bo_bs >0 ? bo_bs : convert_to_rupiah(v.bo_bs); 
                                var show_bo_bh = v.pagu_bo_bh >0 ? bo_bh : convert_to_rupiah(v.bo_bh); 
                                var show_bo_bbs = v.pagu_bo_bbs >0 ? bo_bbs : convert_to_rupiah(v.bo_bbs); 
                                var show_bm_bmt = v.pagu_bm_bmt >0 ? bm_bmt : convert_to_rupiah(v.bm_bmt); 
                                var show_bm_bmpm = v.pagu_bm_bmpm >0 ? bm_bmpm : convert_to_rupiah(v.bm_bmpm); 
                                var show_bm_bmgb = v.pagu_bm_bmgb >0 ? bm_bmgb : convert_to_rupiah(v.bm_bmgb); 
                                var show_bm_bmjji = v.pagu_bm_bmjji >0 ? bm_bmjji : convert_to_rupiah(v.bm_bmjji); 
                                var show_bm_bmatl = v.pagu_bm_bmatl >0 ? bm_bmatl : convert_to_rupiah(v.bm_bmatl); 
                                var show_bm_bmatb = v.pagu_bm_bmatb >0 ? bm_bmatb : convert_to_rupiah(v.bm_bmatb); 
                                var show_btt = v.pagu_btt >0 ? btt : convert_to_rupiah(v.btt); 
                                var show_bt_bbh = v.pagu_bt_bbh >0 ? bt_bbh : convert_to_rupiah(v.bt_bbh); 
                                var show_bt_bbk = v.pagu_bt_bbk >0 ? bt_bbk : convert_to_rupiah(v.bt_bbk); 
                                var show_rf_total =  rf_total ;



                                var realisasi =  '<td align="right">' +show_bo_bp + '</td>' +
                                '<td align="right">' +show_bo_bbj + '</td>' +
                                '<td align="right">' +show_bo_bs + '</td>' +
                                '<td align="right">' +show_bo_bh + '</td>' +
                                '<td align="right">' +show_bo_bbs + '</td>' +
                                '<td align="right">' +show_bm_bmt + '</td>' +
                                '<td align="right">' +show_bm_bmpm + '</td>' +
                                '<td align="right">' +show_bm_bmgb + '</td>' +
                                '<td align="right">' +show_bm_bmjji + '</td>' +
                                '<td align="right">' +show_bm_bmatl + '</td>' +
                                '<td align="right">' +show_bm_bmatb + '</td>' +
                                '<td align="right">' +show_btt + '</td>' +
                                '<td align="right">' +show_bt_bbh + '</td>' +
                                '<td align="right">' +show_bt_bbk + '</td>' +
                                '<td align="right">' + convert_to_rupiah(total) + '</td>' +
                                '<td style="color:blue" align="right">' + show_rf_total + '%</td>'  ;  
                            }
                            total_realisasi +=total
                            total_realisasi_fisik +=total_fisik
							$('#data-realisasi-keuangan').append(
								'<tr>' +
								'<td>' + (k + 1) + '</td>' +
								'<td>' + bulan(v.bulan) + '</td>' +
								realisasi + 
						
								// '<td><a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</a></td>' +
								// '<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
								// '<td style="text-align: right;">' + '<a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan) + '</a>'  + '</td>' +
								'</tr>'
							);
						});
                    $('#total_realisasi').html('<td id="label_total_realisasi" colspan="'+colspan_total +'">Total</td>' +
                                    '<td id="nilai_total_realisasi">'+ convert_to_rupiah(total_realisasi)+'</td>' +
                                    '<td id="nilai_total_realisasi">'+ total_realisasi_fisik +'</td>'
                                    );
					}else{
						$('#table-realisasi-keuangan').hide();
						$('#info_target').show();
                        $('#info_target').html('<div class="alert alert-info">Belum ada  target APBD untuk Sub Kegiatan ini<br>Silahkan setting target dulu sebelum menginput realisasi</div>');
					}
	        },
            error : function(){
            }
        });


	}



function input_lra(jenis,id_instansi,pagu)
    {   
        var izin_input = <?php echo jadwal_rfk_kab_kota()['aktif'] ?>;
        var bulan_realisasi_config = <?php echo jadwal_rfk_kab_kota()['bulan_aktif'] ?>;
        $('#modal-realisasi-lra').find('#id_instansi').val(id_instansi);
        $('#modal-realisasi-lra').find('#jenis').val(jenis);
        $('#modal-realisasi-lra').modal('show');
        $('.form-control').removeClass('is-valid')
                          .removeClass('is-invalid');
     
        $('.text-danger').remove();
        
        
            var jenis_belanja = 'Belanja Operasi';
            var colspan =1;
            var rincian = '<th align="center">Rp</th>';

        
        var colspan_total = colspan + 1; 
        
        $('#modal-realisasi-lra').find('#jenis_belanja').attr('colspan', colspan);
        // $('#modal-realisasi-lra').find('.nama_jenis_belanja').html(jenis_belanja);
        $('#modal-realisasi-lra').find('#rincian_jenis_belanja').html(rincian);

        $('#modal-realisasi-lra').find('#label_total_realisasi').attr('colspan', colspan );


        $('#modal-realisasi-lra').find('#pagu').val(pagu==''? 0: pagu);

        $.ajax(
        {
            url     : baseUrl('realisasi/get_anggaran_instansi_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
                id_instansi : id_instansi,
                jenis : jenis
            },
            success : function(data)
            {
               
                var show_pagu;
                show_pagu = data.total;
                $('#modal-realisasi-lra').find('#td_nama_instansi').html(data.nama_instansi);
                $('#modal-realisasi-lra').find('#pagu_jenis_belanja').html(show_pagu);
                $('#modal-realisasi-lra').find('#pagu_total').html(data.total);
            },
            error : function(){

            }
        });
        $.ajax(
        {
            url     : baseUrl('realisasi/get_realisasi_keuangan_kab_kota/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
                pagu : pagu,
                id_instansi : id_instansi,
                jenis : jenis
            },
            success : function(data)
            {
                // $('#modal-realisasi-lra').find('#exampleModalLabel').html("Setting Target APBD");
                
                $('#modal-realisasi-lra').find('#nama_tahapan').html(data.nama_tahapan);


                
                
                    $('#modal-realisasi-lra').find('#data-realisasi-keuangan').html('');
                    if (data.status == true) {

                        
                        $('#modal-realisasi-lra').find('#info_target').hide();
                        $('#modal-realisasi-lra').find('#table-realisasi-keuangan').show();
                        var total_realisasi = 0;
                        var total_realisasi_fisik = 0;
                        $.each(data.data, function(k, v) {
                
                            var bulan_realisasi = k+1;
                            console.log(v);

                                var total = parseInt(v.lra) ;
                                if (izin_input==0) {
                                    lra = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.lra)}</a>`;
                                   
                                }
                                else if (izin_input==2) {
                                   
                                        lra = `<a href="#" id="r-lra" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi_lra}" class="edit" data-type="text" onclick="edit_realisasi_lra(this, ${v.bulan})"> ${convert_to_rupiah(v.lra)}</a>`;
                                }else{
                                    if (bulan_realisasi == bulan_realisasi_config) {

                                        lra = `<a href="#" id="r-lra" jenis="${jenis}"  id_instansi="${id_instansi}" pagu="${pagu}" pk="${v.id_realisasi_lra}" class="edit" data-type="text" onclick="edit_realisasi_lra(this, ${v.bulan})"> ${convert_to_rupiah(v.lra)}</a>`;
                                    }else{
                                         lra = `<a href="#" onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.lra)}</a>`;
                                      
                                    }
                                }

                                var show_lra =  lra;
                               
                                var realisasi = 
                                                '<td>' + show_lra + '</td>' 
                                                ;
                            
                            
                            total_realisasi +=total
                            $('#modal-realisasi-lra').find('#data-realisasi-keuangan').append(
                                '<tr>' +
                                '<td>' + (k + 1) + '</td>' +
                                '<td>' + bulan(v.bulan) + '</td>' +
                                realisasi + 
                        
                                // '<td><a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</a></td>' +
                                // '<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
                                // '<td style="text-align: right;">' + '<a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan) + '</a>'  + '</td>' +
                                '</tr>'
                            );
                        });
                    $('#modal-realisasi-lra').find('#total_realisasi').html('<td id="label_total_realisasi" colspan="'+colspan_total +'">Total</td>' +
                                    '<td id="nilai_total_realisasi">'+ convert_to_rupiah(total_realisasi)+'</td>' 
                                    );
                    }else{
                        $('#table-realisasi-keuangan').hide();
                        $('#info_target').show();
                        $('#info_target').html('<div class="alert alert-info">Belum ada  target APBD untuk Sub Kegiatan ini<br>Silahkan setting target dulu sebelum menginput realisasi</div>');
                    }
            },
            error : function(){
                console.log('error');
            }
        });


    }


function copy_realisasi_apbd_awal_kab_kota(id_instansi, tahap, nama_instansi)
    {      
        var skpd = nama_instansi 

            Swal.fire({
              title: 'Warning',
              text: 'Apakah anda akan mencopy data realisasi fiik dan keuangan  APBD AWAL pada SKPD ' + skpd,
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
                        url     : baseUrl('realisasi/copy_realisasi_apbd_awal_kab_kota/'),
                        dataType: 'JSON',
                        type    : 'POST',
                        data    : { 
                            
                            id_instansi : id_instansi,
                            tahap : tahap,
                            skpd : skpd,
                        },
                        success : function(data)
                        {
                            if (data.status==true) {
                                Swal.fire('Di Copy',data.messages, 'success');
                            }else{
                                Swal.fire('Tidak ada data',data.messages, 'error');

                            }
                            $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                            
                            
                        },
                        error : function(){
                        }
                    });
            

              
              }
            });





        // $.ajax(
        // {
        //     url     : baseUrl('realisasi/copy_realisasi_apbd_awal_kab_kota/'),
        //     dataType: 'JSON',
        //     type    : 'POST',
        //     data    : { 
        //         id_instansi : id_instansi,
        //         jenis : jenis
        //     },
        //     success : function(data)
        //     {
               
        //     },
        //     error : function(){
        //     }
        // });


    }

function hapus_rfk_kab_kota(id_instansi, tahap, nama_instansi, tahap)
    {      
        var skpd = nama_instansi ;
        var nama_tahap = ["","","APBD AWAL","","APBD PERUBAHAN"];
        var tahap_aktif = nama_tahap[tahap];

            Swal.fire({
              title: 'Warning',
              text: 'Apakah anda akan menghapus data realisasi fiik dan keuangan  '+tahap_aktif+' pada SKPD ' + skpd,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Hapus',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                    




                    $.ajax(
                    {
                        url     : baseUrl('realisasi/hapus_rfk_kab_kota/'),
                        dataType: 'JSON',
                        type    : 'POST',
                        data    : { 
                            
                            id_instansi : id_instansi,
                            tahap : tahap,
                            skpd : skpd,
                        },
                        success : function(data)
                        {
                            if (data.status==true) {
                                Swal.fire('Di Hapus',data.messages, 'success');
                            }else{
                                Swal.fire('Tidak ada data',data.messages, 'error');

                            }
                            $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                            
                            
                        },
                        error : function(){
                        }
                    });
            

              
              }
            });





        // $.ajax(
        // {
        //     url     : baseUrl('realisasi/copy_realisasi_apbd_awal_kab_kota/'),
        //     dataType: 'JSON',
        //     type    : 'POST',
        //     data    : { 
        //         id_instansi : id_instansi,
        //         jenis : jenis
        //     },
        //     success : function(data)
        //     {
               
        //     },
        //     error : function(){
        //     }
        // });


    }


    function edit_realisasi_keuangan(x, bulan) {
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
            '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

        let id = $(x).attr('pk');
        let jenis= $(x).attr('jenis');
        let id_instansi= $(x).attr('id_instansi');
       
        let pagu= $(x).attr('pagu');
        $(x).editable({
            mode: 'inline',
            pk: id,
            savenochange: true,
            url: baseUrl('realisasi/update_realisasi_keuangan_kab_kota/' + id_instansi + '/' + bulan),
            success: function(c) {
               input_realisasi(jenis,id_instansi,pagu);
               $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                // data_opd_kb_kota();
            },
        });
    }


    function edit_realisasi_lra(x, bulan) {
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
            '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

        let id = $(x).attr('pk');
        let jenis= $(x).attr('jenis');
        let id_instansi= $(x).attr('id_instansi');
       
        let pagu= $(x).attr('pagu');
        $(x).editable({
            mode: 'inline',
            pk: id,
            savenochange: true,
            url: baseUrl('realisasi/update_realisasi_lra_kab_kota/' + id_instansi + '/' + bulan),
            success: function(c) {
               input_lra(jenis,id_instansi,pagu);
               $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                // data_opd_kb_kota();
            },
        });
    }



function get_realisasi(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, pagu)
    {   
        $('#modal-realisasi-keuangan').modal('show');
        $('.form-control').removeClass('is-valid')
                          .removeClass('is-invalid');
     
        $('.text-danger').remove();
        
        

        $('#modal-realisasi-keuangan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);
        $('#modal-realisasi-keuangan').find('#tahap').val(tahap);
        $('#modal-realisasi-keuangan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
        $('#modal-realisasi-keuangan').find('#kode_kegiatan').val(kode_kegiatan);
        $('#modal-realisasi-keuangan').find('#kode_program').val(kode_program);
        $('#modal-realisasi-keuangan').find('#pagu').val(pagu==''? 0: pagu);

        var tahap = "<?php echo tahapan_apbd() ?>";
        if (tahap=='4') {
            $('#modal-realisasi-keuangan').find('#btn_copy_target_awal').show();
        }else{
            $('#modal-realisasi-keuangan').find('#btn_copy_target_awal').hide();
        }
        $.ajax(
        {
            url     : baseUrl('realisasi/get_realisasi_keuangan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
                kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
                kode_kegiatan : kode_kegiatan,
                kode_program : kode_program,
                kode_bidang_urusan : kode_bidang_urusan,
                tahap : tahap
            },
            success : function(data)
            {
                $('#modal-realisasi-keuangan').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu==''? 0: pagu));
                $('#modal-realisasi-keuangan').find('#exampleModalLabel').html("Setting Target APBD");
                $('#modal-realisasi-keuangan').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
                $('#modal-realisasi-keuangan').find('#kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
                $('#modal-realisasi-keuangan').find('#nama_tahapan').html(data.nama_tahapan);
                
                
                    $('#data-realisasi-keuangan').html('');
                    if (data.status == true) {
                        $.each(data.data, function(k, v) {
                            $('#data-realisasi-keuangan').append(
                                '<tr>' +
                                '<td>' + (k + 1) + '</td>' +
                                '<td>' + bulan(v.bulan) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                '<td>' + convert_to_rupiah(999999999999) + '</td>' +
                                // '<td><a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</a></td>' +
                                // '<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
                                // '<td style="text-align: right;">' + '<a href="#" id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan) + '</a>'  + '</td>' +
                                '</tr>'
                            );
                        });
                    }else{
                        $('#data-realisasi-keuangan').hide();
                        $('#info_target').html('<div class="alert alert-info>Belum ada  target APBD untuk kegiatan ini<br>Silahkan setting target dulu</div>');
                    }
            }
        });


    }


function input_rfk_berakhir(){
    Swal.fire('Gagal','<?php echo jadwal_rfk_kab_kota()['pesan'] ?>','warning')
}
    function showKegiatanApbd(kode_rekening_program = '') {
        $('#table-realisasi-keuangan').DataTable({
            serverSide: true,
            bDestroy: true,
            responsive: true,
            ajax: {
                url: baseUrl('realisasi/dt_realisasi_keuangan/'),
                type: "POST",
                data: {
                    kode_rekening_program: kode_rekening_program
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
                    targets: [-1],
                },
                {
                    className: "dt-right",
                    targets: [2, 3, 4, 5],
                },
            ],

        });
    }



    $('#table-realisasi-keuangan').on('click', '#realisasi-keuangan', function() {
        let kode_rekening_kegiatan = $(this).attr('kode-rekening-kegiatan');
        let pagu = $(this).attr('pagu');
        $('#modal-realisasi-keuangan').modal('show');
        $('#modal-realisasi-keuangan').find('.modal-title').text(kode_rekening_kegiatan);
        $('#pagu').val(convert_to_rupiah(pagu));
        get_realisasi_keuangan(kode_rekening_kegiatan, pagu);
    });

    function get_realisasi_keuangan(kode_rekening_kegiatan) {
        $.ajax({
            url: baseUrl('realisasi/get_realisasi_keuangan/'),
            type: "POST",
            dataType: "JSON",
            data: {
                kode_rekening_kegiatan: kode_rekening_kegiatan
            },
            success: function(data) {
                if (data.status == true) {
                    $('#data-realisasi-keuangan').html('');
                    $.each(data.data, function(k, v) {
                        let bp;
                        let bb;
                        let bm;

                        // if (data.opd == 'Bagian') {
                            bp = `<a href="#" id="r-bp" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_pegawai)}</a>`;
                            bb = `<a href="#" id="r-bb" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_barang_jasa)}</a>`;
                            bm = `<a href="#" id="r-bm" rekening="${kode_rekening_kegiatan}" pk="${v.id}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this)"> ${convert_to_rupiah(v.belanja_modal)}</a>`;
                        // } else {
                        //     bp = convert_to_rupiah(v.belanja_pegawai);
                        //     bb = convert_to_rupiah(v.belanja_barang_jasa);
                        //     bm = convert_to_rupiah(v.belanja_modal);
                        // }
                        $('#data-realisasi-keuangan').append(
                            `<tr>
                                <td>${k+1}</td>
                                <td>${bulan(v.bulan)}</td>
                                <td align="right">
                                    ${bp}
                                </td>
                                <td align="right">
                                    ${bb}
                                </td>
                                <td align="right">
                                    ${bm}
                                </td>
                                <td align="right">
                                    ${convert_to_rupiah(v.total)}
                                </td>
                            </tr>`
                        );
                    });
                }
            }
        });
    }

    function convert_to_rupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    function bulan(x) {
        let bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return bulan[x];
    }
</script>