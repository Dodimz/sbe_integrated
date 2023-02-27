<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Integrasi_aplikasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sumber_data = "Sumber Data : ???";
        $this->sumber_data_kab_kota = "???";
        $this->load->model('android/android_model', 'android_model');

        $this->load->model([
   //          'model_versi' => 'mversi',
   //          'dashboard/dashboard_model'       => 'dashboard_model',
           
			// 'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
			'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
			// 'Laporan/rekap_asisten_model'					=> 'rekap_asisten_model',
			// 'Laporan/ratarata_fisik_keuangan'					=> 'ratarata_fisik_keuangan',
			// 'Laporan/rekap_realisasi_total_model'	=> 'rekap_realisasi_total_model',
			// 'Laporan/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
			// 'Laporan/rekap_kegiatan_kab_kota'	=> 'rekap_kegiatan_kab_kota',
			// 'Laporan/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
			// 'Laporan/realisasi_per_kab_kota'	=> 'realisasi_per_kab_kota',
			// 'Laporan/realisasi_gabungan_per_kab_kota'	=> 'realisasi_gabungan_per_kab_kota',
			// 'Laporan/target_realisasi_model'	=> 'target_realisasi_model',
			// 'Laporan/rekap_permasalahan_model'	=> 'rekap_permasalahan_model',
			// 'config/config_model' => 'config_model',

            'sumbarsiap/target_realisasi_model'     => 'target_realisasi_model',
			'sumbarsiap/sumbarsiap_model'      => 'sumbarsiap_model',
            'integrasi_sakatoplan/integrasi_sakatoplan_model'      => 'integrasi_sakatoplan_model',
            'integrasi_aplikasi/integrasi_sipedal_model'      => 'integrasi_sipedal_model',
            
        ]);
    }

    public function index()
    {
        
    }


    public function sipd(){
      
        $url = "http://localhost/siap_sumbar_sbe_2022/android/daftar_skpd";
        $tahun = $this->input->post('tahun');
        $id_instansi = $this->input->post('id_instansi');
        $id_instansi = sbe_crypt($id_instansi, 'D');
        $tahap = $this->input->post('tahap');
        $token = "";
        $data       = file_get_contents($url);

        $decode = json_decode($data);

        $nama_instansi = nama_instansi($id_instansi);


        $kumpul_data = [];
        $no=0;
        echo "
        <table class='table table-striped table-bordered' style='margin-top:10px'>
            <tr>
                <th>No</th>
                <th>SKPD</th>
                <th>Tahun</th>
                <th>Tahapan APBD</th>
                <th>Kode Sub Kegiatan</th>
                <th>Kategori</th>
                <th>Kategori</th>
                <th>Keterangan</th>
            </tr>
        ";
        foreach ($decode->data as $key => $value) {
            $no++;

            echo "  
            <tr>
                <td>".$no."</td>
                <td>".$nama_instansi."</td>
                <td>".$tahun."</td>
                <td>".pilihan_nama_tahapan($tahap)."</td>
                <td>????</td>
                <td>????</td>
                <td>????</td>
                <td>????</td>
            
            </tr>";
            $insert_sql = [
                'id_instansi'=>$value->id_instansi,
                'kode_tahap'=>2,
            ];
            array_push($kumpul_data, $insert_sql);
           // var_dump($value->id_instansi);
        }
        echo '</table>';

        echo '
        <div class="col-md-12">
                <div class="form-group">
                    <button class="btn btn-info btn-block" onclick="swal.fire(`Belum Aktif`,`Fitur ini belum aktif \N Cara kerjanya adalah menyalin semua di method ini dan memasukannya ke database`,`error`)" type="button">Kelola integrasi</button>
                </div>
            </div>

            ';
       
        // return $kumpul_data;   
     }  




    public function sipedal()
    {
        $breadcrumbs     = $this->breadcrumbs;
        // $master_paket   = $this->master_paket_model;

        $integrasi_sipedal    = $this->integrasi_sipedal_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Integrasi Sipedal - Paket Pekerjaan', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $data['input_by']                      = "";

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = tahun_anggaran();

        $id_group = $this->session->userdata('id_group');
        $data['opd']                    = $integrasi_sipedal->get_skpd($id_group);
        $data['konfigurasi']                 = $this->db->get('config')->result_array();

        //  $data['dropdown_option']                      = [
            
            
        //      ['tipe'=>'link', 'caption'=>'Kembali', 'fa'=>'fa fa-arrow-left', 'onclick'=>'paket_pekerjaan/'.$method, 'elemen_tambahan'=>'data-toggle="tooltip" title="Kembali"'],
        // ];
        $data['title']                      = "Integrasi Aplikasi - SIPEDAL";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Mengambil data dari aplikasi SIPDEAL - Biro Pengadaan Barang Dan Jasa Setda Provinsi Sumatera Barat untuk ditampilkan dan disalin ke dalam aplikasi Simbangda Based Evidence     ";
        $data['breadcrumbs']                = $breadcrumbs->render();
      

        $page                               = 'integrasi_aplikasi/sipedal/index';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('integrasi_aplikasi/sipedal/css', $data, true);
        $data['extra_js']                   = $this->load->view('integrasi_aplikasi/sipedal/js', $data, true);
        $data['modal']                      = $this->load->view('integrasi_aplikasi/sipedal/modal', $data, true);


       
        $this->template->load('backend_template', $page, $data);
    }



    public function cek_import_sipedal()
    {
        $breadcrumbs     = $this->breadcrumbs;
        // $master_paket   = $this->master_paket_model;

        $integrasi_sipedal    = $this->integrasi_sipedal_model;
        $id_opd = sbe_crypt($this->input->get('id_opd'),'D');
        $tahun = $this->input->get('tahun');

        $url = "https://sipedal.sumbarprov.go.id/api/v1/isb/rup_paket_penyedia?tahun=$tahun&instansi_id=D462&idsatker=$id_opd&order_col=namasatker&order_dir=desc";
        $data       = file_get_contents($url);
            $decode = json_decode($data);
            $jumlah_data_sipedal  = count($decode->data);
        $konversi_instansi = $this->db->query("SELECT id_instansi, nama_instansi from master_instansi where integrasi_sipedal_id_instansi='$id_opd'")->row_array();

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Integrasi Sipedal - Paket Pekerjaan', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        // $data['input_by']                      = "";
        $id_group = $this->session->userdata('id_group');

        $id_instansi = $konversi_instansi['id_instansi'];

        $data['kode_tahap']                = tahapan_apbd();
        $data['tahun']                = $tahun;
        $data['jumlah_data_sipedal']                = $jumlah_data_sipedal;

        $data['id_instansi']                    = $konversi_instansi['id_instansi'];
        $data['nama_instansi']                    = $konversi_instansi['nama_instansi'];
       
        $data['title']                      = "Integrasi Aplikasi - SIPEDAL - Cek Import Sipedal";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Mencek hasil import sipedal ke dalam aplikasi Simbangda";
        $data['breadcrumbs']                = $breadcrumbs->render();
            
        $data_paket_import = $integrasi_sipedal->cek_paket_sbe_import_sipedal($id_instansi, $tahun)->result_array();
        $data['data_paket_import']                = $data_paket_import;

        $page                               = 'integrasi_aplikasi/sipedal/cek_import_sipedal';
        $data['link']                       = $this->router->fetch_method();
        $data['fetch_method']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('integrasi_aplikasi/sipedal/css', $data, true);
        $data['extra_js']                   = $this->load->view('integrasi_aplikasi/sipedal/js', $data, true);
        $data['modal']                      = $this->load->view('integrasi_aplikasi/sipedal/modal', $data, true);


       
        $this->template->load('backend_template', $page, $data);
    }





    public function get_data_sipedal(){
        

        $integrasi_sipedal    = $this->integrasi_sipedal_model;
        $tahun = $this->input->post('tahun');
        $id_instansi = $this->input->post('id_instansi');
        $tahap = $this->input->post('tahap');
        $jenis = "PENYEDIA";//$this->input->post('jenis');
        $order = "desc";
        $coloumn_order = "namasatker";

        if ($id_instansi=='semua_opd') {
             $url = "https://sipedal.sumbarprov.go.id/api/v1/isb/rup_paket_penyedia?tahun=$tahun&instansi_id=D462";
            $data       = file_get_contents($url);
            $decode = json_decode($data);

             $paket_sbe = $integrasi_sipedal->list_paket_sbe_semua($tahun, $jenis);
                $data_paket_tersimpan = [];
                foreach ($paket_sbe->result_array() as $k => $v) {
                   array_push($data_paket_tersimpan, $v['integrasi_sipedal_id_rup']);
                }   



        }else{
            $id_instansi = sbe_crypt($id_instansi, 'D');
            $url = "https://sipedal.sumbarprov.go.id/api/v1/isb/rup_paket_penyedia?tahun=$tahun&instansi_id=D462&idsatker=$id_instansi&order_col=$coloumn_order&order_dir=$order";
            $data       = file_get_contents($url);
            $decode = json_decode($data);





             $konversi_id_instansi_sipedal_sbe = $integrasi_sipedal->konversi_sipedal_sbe($id_instansi);
            if ($konversi_id_instansi_sipedal_sbe['id_instansi']=='') {
                $konversi_id_instansi_sbe = 'Tidak Ditemukan';
                $data_paket_tersimpan = [];
            }else{
                $konversi_id_instansi_sbe = $konversi_id_instansi_sipedal_sbe['id_instansi'];
                $paket_sbe = $integrasi_sipedal->list_paket_sbe($konversi_id_instansi_sbe, $tahun, $jenis);
                $data_paket_tersimpan = [];
                foreach ($paket_sbe->result_array() as $k => $v) {
                   array_push($data_paket_tersimpan, $v['integrasi_sipedal_id_rup']);
                }   


            }



        }



       



        // echo $id_instansi;
        $kumpul_data = [];

        $pagedata['data_paket_sbe']=$data_paket_tersimpan;
        $pagedata['data_sipedal']=$decode;
        $pagedata['integrasi_sipedal']=$integrasi_sipedal;
        $pagedata['id_instansi']=$this->input->post('id_instansi');
        $pagedata['tahun']=$tahun;
        $pagedata['jenis_paket']=$jenis;
        $pagedata['link_api']=$url;

                $page                               = 'integrasi_aplikasi/sipedal/api_sipedal_result';
        // $data['link']                       = $this->router->fetch_method();
        // $data['menu']                       = $this->load->view('layout/menu', $data, true);
        // $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $pagedata['extra_js']                   = $this->load->view('integrasi_aplikasi/sipedal/js', $data, true);
        // $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->load->view($page, $pagedata);





        // $this->load->view('integrasi_aplikasi/sipedal/index', $pagedata);
        // echo "
        // <table class='table table-striped table-bordered' style='margin-top:10px'>
        //     <tr>
        //         <th>No</th>
        //         <th>SKPD</th>
        //         <th>Sub Kegiatan</th>
        //         <th>Tahapan APBD</th>
        //         <th>Paket Pekerjaan</th>
        //         <th>Jenis Paket</th>
        //         <th>Pagu Paket</th>
        //         <th>Metode Paket</th>
        //         <th>Keterangan</th>
        //     </tr>
        // ";
       
        // echo '</table>';

        // echo '
        // <div class="col-md-12">
        //         <div class="form-group">
        //             <button class="btn btn-info btn-block" onclick="swal.fire(`Belum Aktif`,`Fitur ini belum aktif \N Cara kerjanya adalah menyalin semua di method ini dan memasukannya ke database`,`error`)" type="button">Import Ke Dalam Simbangda</button>
        //         </div>
        //     </div>

        //     ';
       
        // return $kumpul_data;   
     }  

    public function import_sipedal_ke_sbe(){


        $integrasi_sipedal    = $this->integrasi_sipedal_model;

        $result     = [
                'success'   => false,
                'messages'  => '',
                'swal_code'  => '',
                'instruksi'  => ''
            ];

        $url = $this->input->post('link');
        $tahun = $this->input->post('tahun');
        $jenis = $this->input->post('jenis');
        $id_instansi = $this->input->post('id_instansi');
        $data       = file_get_contents($url);
        $decode = json_decode($data);
        $jumlah_data_sipedal =  count((array)$decode->data);






        $kumpul_data_insert=[];
        if ($id_instansi=='semua_opd') {
             $paket_sbe = $integrasi_sipedal->list_paket_sbe_semua($tahun, $jenis);
                $data_paket_tersimpan = [];
                foreach ($paket_sbe->result_array() as $k => $v) {
                   array_push($data_paket_tersimpan, $v['integrasi_sipedal_id_rup']);
                }   
        }else{




            $id_instansi = sbe_crypt($id_instansi, 'D');
          
             $konversi_id_instansi_sipedal_sbe = $integrasi_sipedal->konversi_sipedal_sbe($id_instansi);
            if ($konversi_id_instansi_sipedal_sbe['id_instansi']=='') {
                $konversi_id_instansi_sbe = 'Tidak Ditemukan';
                $id_instansi_dikonversikan = '';
                $data_paket_tersimpan = [];
            }else{
                $konversi_id_instansi_sbe = $konversi_id_instansi_sipedal_sbe['id_instansi'];
                $paket_sbe = $integrasi_sipedal->list_paket_sbe($konversi_id_instansi_sbe, $tahun, $jenis);
                $data_paket_tersimpan = [];
                foreach ($paket_sbe->result_array() as $k => $v) {
                   array_push($data_paket_tersimpan, $v['integrasi_sipedal_id_rup']);
                }   


            }




            foreach ($decode->data as $k => $v) {
                    $id_rup = $v->id_rup;

                    if ($v->sumberdana=='APBD') {
                        $tahapan_apbd='2';
                    }else if ($v->sumberdana=='APBDP') {
                        $tahapan_apbd='4';
                    }else{
                        $tahapan_apbd='0';
                    }
                 if (in_array($id_rup, $data_paket_tersimpan)) {
                       $data_insert = '';
                    }else{
                        $data_insert = [
                            'id_instansi'=>$konversi_id_instansi_sbe,
                            // 'kode_bidang_urusan'=>$v->id_rup,
                            'kode_rekening_program'=>$v->kode_programs,
                            'kode_rekening_kegiatan'=>$v->kode_kegiatans,
                            'kode_rekening_sub_kegiatan'=>$v->kode_subkegiatans,
                            'kode_tahap'=>$tahapan_apbd,
                            'tahun'=>$v->tahun,
                            'nama_paket'=>$v->namapaket,
                            'jenis_paket'=>'PENYEDIA',
                            'kategori'=>'NON KONTRUKSI',
                            'id_metode'=>'222',
                            'pagu'=>$v->jumlahpagu,
                            'created_on'=>timestamp(),
                            'created_by'=>id_user(),
                            'input_by'=>"Integrasi Sipedal",
                            'status '=>1,



                            'integrasi_sipedal_id_rup'=>$v->id_rup,
                            'integrasi_sipedal_id_satker'=>$v->idsatker,
                            'integrasi_sipedal_tahapan_apbd'=>$v->sumberdana,
                        ];
                        array_push($kumpul_data_insert, $data_insert);


                    }


            }


            $paket_sbe_import_sipedal = $integrasi_sipedal->list_paket_sbe_import_sipedal($konversi_id_instansi_sbe, $tahun, $jenis)->num_rows();
            if ($paket_sbe_import_sipedal!=$jumlah_data_sipedal) {
                $this->db->trans_begin();
                $this->db->insert_batch('paket_pekerjaan', $kumpul_data_insert);
                if ($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $result['success'] = false ; 
                    $result['message'] = 'Terjadi kesalahan';
                    $result['swal_code'] = 'error';
                    $result['instruksi'] = 'Error Import Dta';
                }
                else
                {
                    $this->db->trans_commit();
                    $result['success'] = true ; 
                    $result['message'] = 'Data Berhasil Di Import';
                    $result['swal_code'] = 'success';
                    $result['instruksi'] = 'Di Import';
                }
            }else{
                    $result['success'] = false ; 
                    $result['message'] = 'Data Sudah Di Pernah Di Import';
                    $result['swal_code'] = 'warning';
                    $result['instruksi'] = 'Gagal Import';

            }




        }





        echo json_encode($result);
     }  
}
