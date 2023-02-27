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



function input_realisasi(jenis, kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, kode_bidang_urusan, pagu, kategori, tahap, tahun)
    {   
        
        var izin_input = <?php echo jadwal_rfk()['aktif'] ?>;

        var bulan_realisasi_config = <?php echo jadwal_rfk()['bulan_aktif'] ?>;
        console.log(kode_rekening_sub_kegiatan);
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
                pagu : pagu,
                kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
                kode_kegiatan : kode_kegiatan,
                kode_program : kode_program,
                kode_bidang_urusan : kode_bidang_urusan,
                jenis : jenis,
                tahap : tahap,
                tahun : tahun,
            },
            success : function(data)
            {
                console.log(data);
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
                            var bulan_realisasi = k+1;
                            if (jenis=='bo') {

                                let bo_bp;
                                let bo_bbj;
                                let bo_bs;
                                let bo_bh;
                                var total = parseInt(v.bo_bp) + parseInt(v.bo_bbj) + parseInt(v.bo_bs) + parseInt(v.bo_bh);

                                   if (izin_input==0) {
                                    bo_bp = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</button>`;
                                    bo_bbj = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</button>`;
                                    bo_bs = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</button>`;
                                    bo_bh = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</button>`;
                                }
                                else if (izin_input==2) {



                                bo_bp = `<button class="tombol"  id="r-bo_bp" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bp)}</button>`;
                                bo_bbj = `<button class="tombol"  id="r-bo_bbj" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bbj)}</button>`;
                                bo_bs = `<button class="tombol"  id="r-bo_bs" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bs)}</button>`;
                                bo_bh = `<button class="tombol"  id="r-bo_bh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bh)}</button>`;
                                }else{
                                    // if (bulan_realisasi == bulan_realisasi_config) {
                                        bo_bp = `<button class="tombol"  id="r-bo_bp" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bp)}</button>`;
                                        bo_bbj = `<button class="tombol"  id="r-bo_bbj" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bbj)}</button>`;
                                        bo_bs = `<button class="tombol"  id="r-bo_bs" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bs)}</button>`;
                                        bo_bh = `<button class="tombol"  id="r-bo_bh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bo_bh)}</button>`;
                                    // }else{
                                    //     bo_bp = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bp)}</button>`;
                                    //     bo_bbj = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bbj)}</button>`;
                                    //     bo_bs = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bs)}</button>`;
                                    //     bo_bh = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bo_bh)}</button>`;
                                    // }
                                }

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
                                if (izin_input==0) {
                                    bm_bmt = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmt)}</button>`;
                                    bm_bmpm = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmpm)}</button>`;
                                    bm_bmgb = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmgb)}</button>`;
                                    bm_bmjji = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmjji)}</button>`;
                                    bm_bmatl = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatl)}</button>`;
                                }
                                else if (izin_input==2) {


                                bm_bmt = `<button class="tombol"  id="r-bm_bmt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmt)}</button>`;
                                bm_bmpm = `<button class="tombol"  id="r-bm_bmpm" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmpm)}</button>`;
                                bm_bmgb = `<button class="tombol"  id="r-bm_bmgb" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmgb)}</button>`;
                                bm_bmjji = `<button class="tombol"  id="r-bm_bmjji" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmjji)}</button>`;
                                bm_bmatl = `<button class="tombol"  id="r-bm_bmatl" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmatl)}</button>`;
                                }else{
                                    // if (bulan_realisasi == bulan_realisasi_config) {
                                        bm_bmt = `<button class="tombol"  id="r-bm_bmt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmt)}</button>`;
                                        bm_bmpm = `<button class="tombol"  id="r-bm_bmpm" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmpm)}</button>`;
                                        bm_bmgb = `<button class="tombol"  id="r-bm_bmgb" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmgb)}</button>`;
                                        bm_bmjji = `<button class="tombol"  id="r-bm_bmjji" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmjji)}</button>`;
                                        bm_bmatl = `<button class="tombol"  id="r-bm_bmatl" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bm_bmatl)}</button>`;
                                    // }else{
                                    //     bm_bmt = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmt)}</button>`;
                                    //     bm_bmpm = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmpm)}</button>`;
                                    //     bm_bmgb = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmgb)}</button>`;
                                    //     bm_bmjji = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmjji)}</button>`;
                                    //     bm_bmatl = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bm_bmatl)}</button>`;
                                    // }
                                }

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
                                if (izin_input==0) {
                                    btt = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</button>`;
                                  
                                }
                                else if (izin_input==2) {
                                 btt = `<button class="tombol"  id="r-btt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.btt)}</button>`;
                                 }else{
                                    // if (bulan_realisasi == bulan_realisasi_config) {
                                       btt = `<button class="tombol"  id="r-btt" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.btt)}</button>`;
                                    // }else{
                                    //    btt = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.btt)}</button>`;
                                    // }
                                }


                                 var show_btt = v.pagu_btt > 0 ? btt : convert_to_rupiah(v.btt);
                                 var realisasi = '<td>' + show_btt + '</td>' + 
                                  '<td>' + convert_to_rupiah(total) + '</td>';
                            }
                            else if (jenis=='bt') {
                                let bt_bbh;
                                let bt_bbk;
                                var total = parseInt(v.bt_bbh) + parseInt(v.bt_bbk) ;
                                if (izin_input==0) {
                                    bt_bbh = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</button>`;
                                    bt_bbk = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</button>`;
                                  
                                }
                                else if (izin_input==2) {
                                 bt_bbh = `<button class="tombol"  id="r-bt_bbh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bt_bbh)}</button>`;
                                 bt_bbk = `<button class="tombol"  id="r-bt_bbk" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bt_bbk)}</button>`;
                                }else{
                                    // if (bulan_realisasi == bulan_realisasi_config) {
                                       bt_bbh = `<button class="tombol"  id="r-bt_bbh" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bt_bbh)}</button>`;
                                 bt_bbk = `<button class="tombol"  id="r-bt_bbk" jenis="${jenis}" kategori="${kategori}" kode_rekening_sub_kegiatan="${kode_rekening_sub_kegiatan}" kode_kegiatan="${kode_kegiatan}" kode_program="${kode_program}" kode_bidang_urusan="${kode_bidang_urusan}" pagu="${pagu}" pk="${v.id_realisasi}" class="edit tombol" data-type="text" onclick="edit_realisasi_keuangan(this, ${v.bulan}, ${tahap}, ${tahun})"> ${convert_to_rupiah(v.bt_bbk)}</button>`;
                                    // }else{
                                    //     bt_bbh = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbh)}</button>`;
                                    //     bt_bbk = `<button class="tombol"  onclick="input_rfk_berakhir()" style="color:red"> ${convert_to_rupiah(v.bt_bbk)}</button>`;
                                    // }
                                }
                                 var show_bt_bbh = v.pagu_bt_bbh >0 ? bt_bbh : convert_to_rupiah(v.bt_bbh);    
                                 var show_bt_bbk = v.pagu_bt_bbk >0 ? bt_bbk : convert_to_rupiah(v.bt_bbk);    
                                 var realisasi = '<td>' +show_bt_bbh + '</td>' + 
                                                '<td>' +show_bt_bbk + '</td>' +
                                                '<td>' + convert_to_rupiah(total) + '</td>' ;
                            }

                             var onclick_hapus_realisasi_bulanan = `
                             hapus_realisasi_k_sub_kegiatan('`+kode_rekening_sub_kegiatan+`','`+kode_kegiatan+`', '`+kode_program+`','<?php echo tahapan_apbd() ?>','`+kode_bidang_urusan+`','`+data.nama_sub_kegiatan+`','`+v.bulan+`')`;
                             tombol_hapus = '<br><button class="btn btn-danger btn-xs"  title="Hapus realisasi keuangan sub kegiatan '+data.nama_sub_kegiatan+' pada bulan '+bulan(v.bulan)+'"  onclick="'+onclick_hapus_realisasi_bulanan+'">Hapus</button> ';
                            var hapus_realisasi = v.warna=='' ? '' : tombol_hapus ;


                            total_realisasi +=total
                            $('#data-realisasi-keuangan').append(
                                '<tr ' +v.warna+'>' +
                                '<td>' + (k + 1) + '</td>' +
                                '<td>' + bulan(v.bulan) /*+ hapus_realisasi+ */ +'</td>' +
                                realisasi + 
                        
                                // '<td><button  id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit tombol" data-type="text" onclick="edit_target_fisik(this)">' + v.t_fisik + '</button></td>' +
                                // '<td>' + ((v.t_keuangan / pagu) * 100).toFixed(2) + '</td>' +
                                // '<td style="text-align: right;">' + '<button  id="target-fisik" kode_sub_kegiatan="' + kode_rekening_sub_kegiatan + '" kode_bidang_urusan="' + kode_bidang_urusan + '" kode_program="' + kode_program + '" kode_kegiatan="' + kode_kegiatan + '" pagu="' + pagu + '"  tahap="' + tahap + '" pk="' + v.id + '" class="edit tombol" data-type="text" onclick="edit_target_keuangan(this)">' + convert_to_rupiah(v.t_keuangan) + '</button>'  + '</td>' +
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


    function edit_realisasi_keuangan(x, bulan, tahap, tahun) {
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
        console.log(pagu);
        $(x).editable({
            mode: 'inline',
            pk: id,
            savenochange: true,
            url: baseUrl('realisasi/update_realisasi_keuangan/' + kode_rekening_sub_kegiatan + '/' + bulan + '/' + pagu + '/' + tahap + '/' + tahun),
            success: function(c) {
                input_realisasi(jenis,kode_rekening_sub_kegiatan,kode_kegiatan,kode_program,kode_bidang_urusan,pagu, kategori, tahap, tahun);
                $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
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





function copy_realisasi_k_sub_kegiatan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, nama_sub_kegiatan)
    {   
        Swal.fire({
              title: 'Warning',
              text: 'Copy Realisasi Keuangan pada APBD Awal sub kegiatan ' + nama_sub_kegiatan +' ke APBD Perubahan.??',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Lanjutkan',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                        $.ajax(
                        {
                            url     : baseUrl('realisasi/copy_r_keu_sub_kegiatan_tahap2/'),
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
                                if (data.count>0) {
                                        Swal.fire(
                                      'Sukses!',
                                       'Copy Pagu, target, sumber dana pada APBD Awal sub kegiatan ' + nama_sub_kegiatan +' ke APBD Perubahan berhasil',
                                      'success'
                                    );
                                }else{
                                      Swal.fire(
                                      'Gagal!',
                                       'Tidak ada data realisasi keuangan pada sub kegiatan  ' + nama_sub_kegiatan +'.!',
                                      'error'
                                    );

                                }
                                    $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                            },
                            error : function(){

                                console.log('eror');
                            }
                        });
              }
            }); 
    }



function hapus_realisasi_k_sub_kegiatan(kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, tahap, kode_bidang_urusan, nama_sub_kegiatan, bulan_ke)
    {   
        console.log(bulan_ke);
        if (bulan_ke=='semua') {
            var bulan_hapus = '';
        }else{
            var bulan_hapus = 'pada bulan ' + bulan(bulan_ke);
        }
        Swal.fire({
              title: 'Warning',
              text: 'Hapus Realisasi Keuangan pada <?php echo nama_tahapan(tahapan_apbd()) ?>  sub kegiatan ' + nama_sub_kegiatan + bulan_hapus + ' .??',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Lanjutkan',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                        $.ajax(
                        {
                            url     : baseUrl('realisasi/hapus_r_keu_sub_kegiatan/'),
                            dataType: 'JSON',
                            type    : 'POST',
                            data    : { 
                                kode_rekening_sub_kegiatan : kode_rekening_sub_kegiatan,
                                kode_kegiatan : kode_kegiatan,
                                kode_program : kode_program,
                                kode_bidang_urusan : kode_bidang_urusan,
                                tahap : tahap,
                                bulan : bulan_ke
                            },
                            success : function(data)
                            {
                                console.log(data);
                                if (data.success==true) {
                                        Swal.fire(
                                      'Sukses!',
                                       'Data realisasi keuangan  <?php echo nama_tahapan(tahapan_apbd()) ?> sub kegiatan ' + nama_sub_kegiatan + bulan_hapus + ' dihapus',
                                      'success'
                                    );
                                }
                                    // input_realisasi(jenis, kode_rekening_sub_kegiatan, kode_kegiatan, kode_program, kode_bidang_urusan, pagu, kategori)
                                    $('#table-sub-kegiatan-instansi-gabungan').DataTable().ajax.reload(null, false);
                            },
                            error : function(){

                                console.log('eror');
                            }
                        });
              }
            }); 
    }


function input_rfk_berakhir(){
    Swal.fire('Gagal','<?php echo jadwal_rfk()['pesan'] ?>','warning')
}















<?php if (jadwal_rfk()['penginputan']==1) {?>
var countDownDate = new Date("<?php echo jadwal_rfk()['tanggal_terkunci'] ?> <?php echo jadwal_rfk()['waktu_terkunci'] ?>").getTime();

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

  // Untuk mendapatkan tanggal dan waktu hari ini
  var now = new Date().getTime();
    
  // Temukan jarak antara sekarang dan tanggal hitung mundur
  var distance = countDownDate - now;
    
  // Perhitungan waktu untuk hari, jam, menit dan detik
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Keluarkan hasil dalam elemen dengan id = "demo"
  $('.timer_kunci_lrfk').html("Penginputan Realisasi Keuangan Tersisa " +days + " Hari " + hours + ":"
  + minutes + ":" + seconds + "");
  $('.pesan_penginputan').html("<?php echo jadwal_rfk()['pesan'] ?>");
  // document.getElementById("timer_kunci_lrfk").innerHTML = "Penginputan Realisasi Keuangan Tersisa " +days + " Hari " + hours + ":"
  // + minutes + ":" + seconds + "";
  //   document.getElementById("pesan_penginputan").innerHTML = "<?php echo jadwal_rfk()['pesan'] ?>";
    
  // Jika hitungan mundur selesai, tulis beberapa teks 
  if (distance < 0) {
    clearInterval(x);
    $('.timer_kunci_lrfk').html("Penginputan Realisasi Keuangan Terkunci");
  $('.pesan_penginputan').html("<?php echo jadwal_rfk()['pesan'] ?>");
    // document.getElementById("timer_kunci_lrfk").innerHTML = "Penginputan Realisasi Keuangan Terkunci";
    // document.getElementById("pesan_penginputan").innerHTML = "<?php echo jadwal_rfk()['pesan'] ?>";
    // Swal.fire('rrror','érr','error');
  }
}, 1000);
<?php }
else{ ?>
    $('.timer_kunci_lrfk').html("Penginputan Realisasi Keuangan");
      $('.pesan_penginputan').html("<?php echo jadwal_rfk()['pesan'] ?>");
<?php } ?>
</script>