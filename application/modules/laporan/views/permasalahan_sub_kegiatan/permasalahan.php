<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?> - <?php echo $this->template->settings('app_name'); ?></title>
    <!-- Favico -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/sbe/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="author" content="Alfikri" />
    <meta name="description" content="SIMBANGDA Based Evidence, simbangda based evidence, SIMBANGDA berbasis pembuktian, simbangda berbasis pembuktian, SIMBANGDA SUMBAR, simbangda sumbar, Sistem Informasi Manajemen Pembangunan Daerah, Sistem Informasi Manajemen Pembangunan Daerah Sumbar, Sumatera Barat" />
    <meta name="keywords" content="Simbangda based evidence, Sistem Informasi Manajemen Pembangunan Daerah, simbangda berbasis pembuktian, simbangda sumbar, Sumbar, Sumatera Barat, Pemprov Sumbar, Pemerintah Provinsi Sumatera Barat, Alfikri, Al, Fikri, alfikri, alfikri, alfikridotname" />
    <meta name="msapplication-tap-highlight" content="no">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Architectui HTML FREE -->
    <link href="<?php echo base_url() ?>assets/architectui-html-pro/main.87c0748b313a1dda75f5.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>assets/fontawesome/css/all.css" rel="stylesheet">

    <script src="<?php echo base_url() ?>assets/sweetalert/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/sweetalert/dist/sweetalert2.min.css">
    <?php echo $extra_css; ?>
</head>
<div style="margin:15px">
    
    <div class="row">
        <div class="col-md-6 col-lg-12">
            <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-success border-success card">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content">
                        <?php 
                            if ($id_instansi=='semua_opd') {
                                $tampil_nama_instansi = 'Semua SKPD';
                            }else if ($id_instansi=='204' || $id_instansi=='205' || $id_instansi=='206') {
                                $linkup_asisten = [
                                    '204'=>'Pemerintahan dan Kesra',
                                    '205'=>'Pembangunan Dan Perekonomian',
                                    '206'=>'Administrasi Umum',
                                ];
                               $tampil_nama_instansi = 'SKPD lingkup Asisten '.$linkup_asisten[$id_instansi];
                            }else{
                               $tampil_nama_instansi = $nama_instansi;

                            }
                         ?>
                        <div class="widget-title opacity-5 text-uppercase"><?php echo $tampil_nama_instansi ?> </div>
                        <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                            <div class="widget-chart-flex align-items-center">
                                <div>


                                    <?php 
                                    $captipn_lrfk = $tahun == tahun_anggaran() ?  bulan_global(bulan_aktif()).' '.$tahun : bulan_global(12).' '.$tahun;
                                     ?>
                                    <input type="hidden" name="id_instansi" id="id_instansi" value="<?php echo sbe_crypt($id_instansi, 'E'); ?>">
                                    <input type="hidden" name="tahun" id="tahun" value="<?php echo $tahun ?>">
                                    <input type="hidden" name="tahap" id="tahap" value="<?php echo $tahap ?>">
                                    <?php if ($id_instansi=='204' || $id_instansi=='205' || $id_instansi=='206' || $id_instansi=='semua_opd'){ ?>
                                          <button class="btn btn-info" onclick="print_rekap_permasalahan_skpd()" data-toggle="tooltip" title="Print semua data permasalahan pada pelaksanaan Sub Kegiatan">Print rekap permasalahan <?php echo $tampil_nama_instansi ?></button>
                                    <?php }else{  ?>
                                       <button class="btn btn-info" onclick="show_laporan_realisasi_akumulasi('<?php echo sbe_crypt($id_instansi, 'E'); ?>')" data-toggle="tooltip" title="Permasalahan pada pelaksanaan Sub Kegiatan">Lihat laporan realisasi akumulasi hingga bulan <?php echo  $captipn_lrfk  ?></button>
                                       <button class="btn btn-info" onclick="print_permasalahan_skpd()" data-toggle="tooltip" title="Print semua data permasalahan pada pelaksanaan Sub Kegiatan">Print data permasalahan</button>
                                   <?php } ?>
                                  
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <?php if ($id_instansi=='204' || $id_instansi=='205' || $id_instansi=='206' || $id_instansi=='semua_opd'){
        $hidden = 'style="display:none"';
     }else{
        $hidden = '';

     } ?>
    <div class="mb-3 card" <?php echo $hidden ?>>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="table-permasalahan-sub-kegiatan-instansi" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" width="1%">No</th>
                                   
                                    <th style="text-align: center;">Sub Kegiatan</th>
                                    <th style="text-align: center;">Permasalahan</th>
                                    <th style="text-align: center;">Usulan Solusi</th>
                                  
                                    <th style="text-align: center;"  width="10%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/architectui-html-pro/assets/scripts/main.87c0748b313a1dda75f5.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/jquery-ajax-progress/jquery.ajax-progress.js"></script>
    <script>
        function baseUrl(link = '') {
            let alamat = "<?php echo base_url(); ?>" + link;
            return alamat;
        }
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/sbe/fungsi.js"></script>
    <script src="<?php echo base_url(); ?>assets/jquery_number/jquery.number.js"></script>
    <?php echo $extra_js; ?>
    <?php echo $extra_js_tambahan; ?>
    <?php echo $modal; ?>

<script type="text/javascript">
        function show_laporan_realisasi_akumulasi(x) {
            $('#modal_laporan').modal('show');
        let id_opd = x;
        let tahun = <?php echo $tahun ?>;
        let tahap = <?php echo $tahap ?>;//$('#tahap').val();
        let kategori = 'akumulasi';
        let kategori_laporan = 'rfk_akumulasi';
        let bulan = <?php echo $tahun == tahun_anggaran() ? bulan_aktif() : 12 ?>;
        
                $('#tampil_pdf').show();
                $('#tampil_pdf').attr('src', baseUrl('laporan/pdf_laporan_realisasi_akumulasi?id_opd=') + id_opd + '&kategori_penampilan_data=' + kategori_laporan +'&kategori=' + kategori + '&tahun=' + tahun + '&tahap=' + tahap + '&bulan=' + bulan + '#view=FitH');
            
    }


    function print_permasalahan_skpd() {
         let id_instansi = $('#id_instansi').val();
        let tahun = $('#tahun').val();
        let tahap = $('#tahap').val();
    $('#modal_laporan_semua_permasalahan').modal('show');
        $('#tampil_pdf_print_permasalahan').show();
         $('#tampil_pdf_print_permasalahan').attr('src', baseUrl('laporan/pdf_rekap_laporan_permasalahan_sub_kegiatan?id_opd=') + id_instansi +  '&tahun=' + tahun + '&tahap=' + tahap + '#view=FitH');
        
    }

    function print_rekap_permasalahan_skpd() {
         let id_instansi = $('#id_instansi').val();
        let tahun = $('#tahun').val();
        let tahap = $('#tahap').val();
    $('#modal_laporan_semua_permasalahan').modal('show');
        $('#tampil_pdf_print_permasalahan').show();
         $('#tampil_pdf_print_permasalahan').attr('src', baseUrl('laporan/pdf_rekap_laporan_permasalahan_sub_kegiatan_error?id_opd=') + id_instansi +  '&tahun=' + tahun + '&tahap=' + tahap + '#view=FitH');
        
    }
</script>