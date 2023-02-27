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
        show_sub_kegiatan_apbd_instansi_gabungan();
    });

    function showAutoCurrency() {
        $('input.currency').number(true, 0);
    }



function show_sub_kegiatan_apbd_instansi_gabungan()
	{
		

		$('#table-sub-kegiatan-instansi-gabungan').DataTable(
		{
	        processing	: true,
	        serverSide	: true,
	        bDestroy	: true,
	        responsive	: true,
	        ajax		: {
				          	url 	: baseUrl('realisasi/sub_kegiatan_apbd_instansi_gabungan/'),
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



function input_realisasi(jenis, kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, kode_bidang_urusan, pagu, kategori)
	{	
		$('#modal-realisasi-keuangan').modal('show');
		$('.form-control').removeClass('is-valid')
						  .removeClass('is-invalid');
	 
        $('.text-danger').remove();
        
        if (jenis=='bo') {
            var jenis_belanja = 'Realisasi Belanja Operasi';
            var colspan =5;
            var rincian = '<th align="center">Belanja Pegawai</th>' + '<th align="center">Belanja Barang Jasa</th>' + '<th align="center">Belanja Subsidi</th>' + '<th align="center">Belanja Hibah</th>' +'<th>Total</th>';

        }
        else if (jenis=='bm') {
            var jenis_belanja = 'Realisasi Belanja Modal';
            var colspan =6;
            var rincian = '<th align="center">Belanja Modal Tanah</th>' +'<th align="center">Belanja Modal Peralatan Dan Mesin</th>' +'<th align="center">   Belanja Modal Gedung dan Bangunan</th>' +'<th align="center">Belanja Modal Jalan, Jaringan, dan Irigasi</th>' +'<th align="center">Belanja Modal dan Aset Tetap Lainnya</th>' +'<th>Total</th>';
            
        }
        else if (jenis=='btt') {
            var jenis_belanja = 'Realisasi Belanja Tidak Terduga';
            var colspan =2;
            var rincian = '<th align="center">Belanja Tidak Terduga</th>' +'<th>Total</th>' ;
            
        }
        else if (jenis=='bt') {
            var jenis_belanja = 'Realisasi Belanja Transfer';
            var colspan =3;
            var rincian = '<th align="center">Belanja Bagi Hasil</th>' + '<th align="center">Belanja Bagi Hasil</th>' +'<th>Total</th>' ;
            
        }
        var colspan_total = colspan + 1; 
		
        $('#modal-realisasi-keuangan').find('#jenis_belanja').html(jenis_belanja);
        $('#modal-realisasi-keuangan').find('#rincian_jenis_belanja').html(rincian);
        $('#modal-realisasi-keuangan').find('#jenis_belanja').attr('colspan', colspan);

        $('#modal-realisasi-keuangan').find('#label_total_realisasi').attr('colspan', colspan );


		$('#modal-realisasi-keuangan').find('#td_kode_sub_kegiatan').html(kode_rekening_sub_kegiatan);
        $('#modal-realisasi-keuangan').find('#kode_sub_kegiatan').val(kode_rekening_sub_kegiatan);

    	$('#modal-realisasi-keuangan').find('#kode_bidang_urusan').val(kode_bidang_urusan);
    	$('#modal-realisasi-keuangan').find('#kode_kegiatan').val(kode_kegiatan);
    	$('#modal-realisasi-keuangan').find('#kode_program').val(kode_program);
    	$('#modal-realisasi-keuangan').find('#pagu').val(pagu==''? 0: pagu);


		$.ajax(
        {
            url     : baseUrl('realisasi/get_realisasi_keuangan/'),
            dataType: 'JSON',
            type    : 'POST',
            data    : { 
            	kategori : kategori,
            	kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
            	kode_kegiatan : kode_kegiatan,
            	kode_program : kode_program,
            	kode_bidang_urusan : kode_bidang_urusan,
                jenis : jenis
            },
            success : function(data)
            {
		    	$('#modal-realisasi-keuangan').find('#pagu_sub_kegiatan').html(convert_to_rupiah(pagu==''? 0: pagu));
            	// $('#modal-realisasi-keuangan').find('#exampleModalLabel').html("Setting Target APBD");
            	$('#modal-realisasi-keuangan').find('#nama_sub_kegiatan').html(data.nama_sub_kegiatan);
            	$('#modal-realisasi-keuangan').find('#nama_tahapan').html(data.nama_tahapan);


                
            	
            	
					$('#data-realisasi-keuangan').html('');
	                if (data.status == true) {

                        
                        $('#info_target').hide();
                        $('#table-realisasi-keuangan').show();
                        var total_realisasi = 0;
						$.each(data.data, function(k, v) {

                            if (jenis=='bo') {

                                let bo_bp;
                                let bo_bbj;
                                let bo_bs;
                                let bo_bh;
                                var total = parseInt(v.bo_bp) + parseInt(v.bo_bbj) + parseInt(v.bo_bs) + parseInt(v.bo_bh);
                                bo_bp = `<a href="#" id="r-bo_bp" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bp)}</a>`;
                                bo_bbj = `<a href="#" id="r-bo_bbj" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bbj)}</a>`;
                                bo_bs = `<a href="#" id="r-bo_bs" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bs)}</a>`;
                                bo_bh = `<a href="#" id="r-bo_bh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bo_bh)}</a>`;

                                var show_bo_bp = v.pagu_bo_bp > 0 ? bo_bp : convert_to_rupiah(v.bo_bp);
                                var show_bo_bbj = v.pagu_bo_bbj > 0 ? bo_bbj : convert_to_rupiah(v.bo_bbj);
                                var show_bo_bs = v.pagu_bo_bs > 0 ? bo_bs : convert_to_rupiah(v.bo_bs);
                                var show_bo_bh = v.pagu_bo_bh > 0 ? bo_bh : convert_to_rupiah(v.bo_bh);
                                var realisasi = '<td>' + show_bo_bp + '</td>' + 
                                                '<td>' + show_bo_bbj + '</td>' + 
                                                '<td>' + show_bo_bs + '</td>' + 
                                                '<td>' + show_bo_bh + '</td>' +
                                                '<td>' + convert_to_rupiah(total) + '</td>' 
                                                ;
                            }
                            else if (jenis=='bm') {
                                let bm_bmt;
                                let bm_bmpm;
                                let bm_bmgb;
                                let bm_bmjji;
                                let bm_bmatl;
                                var total = parseInt(v.bm_bmt) + parseInt(v.bm_bmpm) + parseInt(v.bm_bmgb) + parseInt(v.bm_bmjji) + parseInt(v.bm_bmatl);

                                bm_bmt = `<a href="#" id="r-bm_bmt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmt)}</a>`;
                                bm_bmpm = `<a href="#" id="r-bm_bmpm" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmpm)}</a>`;
                                bm_bmgb = `<a href="#" id="r-bm_bmgb" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmgb)}</a>`;
                                bm_bmjji = `<a href="#" id="r-bm_bmjji" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmjji)}</a>`;
                                bm_bmatl = `<a href="#" id="r-bm_bmatl" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bm_bmatl)}</a>`;

                                var show_bm_bmt = v.pagu_bm_bmt > 0 ? bm_bmt : convert_to_rupiah(v.bm_bmt) 
                                var show_bm_bmpm = v.pagu_bm_bmpm > 0 ? bm_bmpm : convert_to_rupiah(v.bm_bmpm) 
                                var show_bm_bmgb = v.pagu_bm_bmgb > 0 ? bm_bmgb : convert_to_rupiah(v.bm_bmgb) 
                                var show_bm_bmjji = v.pagu_bm_bmjji > 0 ? bm_bmjji : convert_to_rupiah(v.bm_bmjji) 
                                var show_bm_bmatl = v.pagu_bm_bmatl > 0 ? bm_bmatl : convert_to_rupiah(v.bm_bmatl) 
                                 var realisasi = '<td align="right">' + show_bm_bmt + '</td>' + 
                                                '<td align="right">' + show_bm_bmpm + '</td>' + 
                                                '<td align="right">' + show_bm_bmgb + '</td>' + 
                                                '<td align="right">' + show_bm_bmjji + '</td>' + 
                                                '<td align="right">' + show_bm_bmatl + '</td>' +
                                                '<td align="right">' + convert_to_rupiah(total) + '</td>' ;
                            }
                            else if (jenis=='btt') {
                                 let btt;
                                var total = parseInt(v.btt);
                                 btt = `<a href="#" id="r-btt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.btt)}</a>`;
                                 var show_btt = v.pagu_btt > 0 ? btt : convert_to_rupiah(v.btt);
                                 var realisasi = '<td>' + show_btt + '</td>' + 
                                  '<td>' + convert_to_rupiah(total) + '</td>';
                            }
                            else if (jenis=='bt') {
                                let bt_bbh;
                                let bt_bbk;
 bt_bbh = `<a href="#" id="r-bt_bbh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbh)}</a>`;
 bt_bbk = `<a href="#" id="r-bt_bbk" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan})"> ${convert_to_rupiah(v.bt_bbk)}</a>`;
                                var total = parseInt(v.bt_bbh) + parseInt(v.bt_bbk) ;

                                 var show_bt_bbh = v.pagu_bt_bbh >0 ? bt_bbh : convert_to_rupiah(v.bt_bbh);    
                                 var show_bt_bbk = v.pagu_bt_bbk >0 ? bt_bbk : convert_to_rupiah(v.bt_bbk);    
                                 var realisasi = '<td>' +show_bt_bbh + '</td>' + 
                                                '<td>' +show_bt_bbk + '</td>' +
                                                '<td>' + convert_to_rupiah(total) + '</td>' ;
                            }
                            total_realisasi +=total
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
                    $('#total_realisasi').html('<td id="label_total_realisasi" colspan="'+colspan_total +'">Total Realisasi</td>' +
                                    '<td id="nilai_total_realisasi">'+ convert_to_rupiah(total_realisasi)+'</td>');
					}else{
						$('#table-realisasi-keuangan').hide();
						$('#info_target').show();
                        $('#info_target').html('<div class="alert alert-info">Belum ada  target APBD untuk Sub Kegiatan ini<br>Silahkan setting target dulu sebelum menginput realisasi</div>');
					}
	        }
        });


	}


    function edit_realisasi_keuangan(x, bulan) {
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-primary btn-sm editable-submit">OK</button>' +
            '<button type="button" class="btn btn-default btn-sm editable-cancel">Batal</button>';

        let id = $(x).attr('pk');
        let jenis= $(x).attr('jenis');
        let kategori= $(x).attr('kategori');
        let kode_rekening_sub_kegiatan= $(x).attr('kode_rekening_sub_kegiatan');
        let kode_kegiatan= $(x).attr('kode_kegiatan');
        let kode_program= $(x).attr('kode_program');
        let kode_bidang_urusan= $(x).attr('kode_bidang_urusan');
        let pagu= $(x).attr('pagu');
        $(x).editable({
            mode: 'inline',
            pk: id,
            savenochange: true,
            url: baseUrl('realisasi/update_realisasi_keuangan/' + kode_rekening_sub_kegiatan + '/' + bulan),
            success: function(c) {
                input_realisasi(jenis,kode_rekening_sub_kegiatan,kode_kegiatan,kode_program,kode_bidang_urusan,pagu, kategori);
                // show_sub_kegiatan_apbd_instansi_gabungan();
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