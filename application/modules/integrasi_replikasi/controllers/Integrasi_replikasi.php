<?php

/**
 * androidor     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : android.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class integrasi_replikasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->sumber_data = "Sumber Data : ???";
        $this->identitas = $this->db->query('SELECT * from identitas')->row_array();
        $this->sumber_data_kab_kota = "???";
        $this->load->model('android/android_model', 'android_model');

        $this->load->model([
            'Laporan/realisasi_akumulasi_model'     => 'realisasi_akumulasi_model',
            'Laporan/rekap_asisten_model'                   => 'rekap_asisten_model',
            'data_apbd/data_apbd_model'      => 'data_apbd_model',
            'integrasi_replikasi/integrasi_replikasi_model'      => 'integrasi_replikasi_model',
        ]);
    }

    public function index()
    {
        // if (empty($this->session->userdata('email'))) {
        //     $data['title']        = "Login";
        //     $page                 = 'android/android';
        //     $data['extra_css']    = $this->load->view('android/css', $data, true);
        //     $data['extra_js']    = $this->load->view('android/js', $data, true);
        //     $this->template->load('android_template', $page, $data);
        // } else {
        //     redirect('dashboard');
        // }
    }

    
    public function master_instansi()
    {
        $token_replikasi = $this->identitas['token'];
        $token_request = $this->input->get('token');
        if ($token_replikasi==$token_request) {
            $key = "";
                $output     = [
                    'status' => true, 
                    'messages' => "Token diterima", 
                    'data'=>[
                        'asisten_1'=>[],
                    ],
                ];
                $integrasi_replikasi = $this->integrasi_replikasi_model;
                $skpd_kab_kota = $integrasi_replikasi->master_instansi()->result_array();
                foreach ($skpd_kab_kota as $k => $v) {
                    $output['data'][$k]['kode_opd'] = $v['kode_opd'];
                    // $output['data'][$k]['id_instansi'] = $v['id_instansi'];
                    $output['data'][$k]['nama_instansi'] = $v['nama_instansi'];
                }
        }else{
            $output     = [
                    'status' => false, 
                    'messages' => "Token ditolak", 
                ];
        }
            header('Content-Type: application/json');
            echo json_encode($output);
    }





    public function pdf_laporan_realisasi_akumulasi()
    {
        error_reporting(0);
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'Legal',
            'orientation' => 'L',
            'tempDir' => '/tmp'
        ]);
        $data['keuangan']=$this->realisasi_keuangan_model;

        $data_apbd_model   = $this->data_apbd_model;

        // $mpdf->setFooter('Page {PAGENO}');
        global $id_instansi;
        global $kategori;
        global $bulan;

        $id_instansi    = sbe_crypt($this->input->get('id_opd'), 'D');

        $identitas = $this->identitas;
    // $id_instansi = 12;
        $kategori_penampilan_laporan    = $this->input->get('kategori_penampilan_data');
        $kategori       = $this->input->get('kategori');
        $bulan              = $this->input->get('bulan');
        $tahun              = $this->input->get('tahun');
        $tahap              = $this->input->get('tahap');
        switch ($kategori) {
            case 'akumulasi':
                $ope = '<=';
                $judul_laporan = "Realisasi  sampai dengan bulan ".bulan_global($bulan);
                break;
            default:
                $ope = '=';
                $judul_laporan = "Realisasi  bulan ".bulan_global($bulan);
                break;
        }

        $total_pagu_skpd = $this->db->query("SELECT total_anggaran_skpd_awal($id_instansi, $tahun) as pagu_skpd")->row_array();
        $data['pagu_skpd'] = $total_pagu_skpd['pagu_skpd'];
        $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();

          $data['tot_subkeg']                 =$data_apbd_model->total_data_per_instansi($id_instansi, $tahap, $tahun)['subkeg'];



        $data['identitas']=$identitas;
        $data['program']=$program;
        $data['ope']=$ope;
        $data['bulan']=$bulan;
        $data['nama_tahap']=pilihan_nama_tahapan($tahap);
        $data['kode_tahap']=$tahap;
        $data['tahun']=$tahun;
        $data['id_instansi']=$id_instansi;
        $nama_instansi = $this->sbe_nama_instansi($id_instansi);
       
        $data['title']=$judul_laporan.' '.$nama_instansi;
        $data['nama_instansi']=$nama_instansi;
        $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

        $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        if ($kategori_penampilan_laporan=='rfk_akumulasi') {
            $judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
            $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_dengan_bobot.php', $data, true);
            // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi', $data, true);
            $mpdf->SetMargins(0, 0, 42);
        }
      
         $data['judul_laporan']=$judul_penampilan_laporan;
        $header =  $this->load->view('laporan/pdf/realisasi_akumulasi/header', $data, true);
        $footer =  $this->load->view('laporan/pdf/realisasi_akumulasi/footer', $data, true);


        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output($nama_instansi.' - '.$judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
    }






    public function laporan_rekap_asisten()
    {
        
        $bulan              = $this->input->get('bulan');
        $tahap              = $this->input->get('tahap');
        $tahun              = $this->input->get('tahun');
        $kategori               = $this->input->get('kategori');
        $perhitungan                = 'Akuntansi'; //$this->input->get('perhitungan');
        $cara_hitung = $perhitungan ;


        

        $identitas = $this->db->get('identitas')->row_array();
            
        if ($kategori=='Bulanan') {
            $deskripsi_bulan = 'kondisi realisasi bulan '.bulan_global($bulan) . ' ' . tahun_anggaran();
        }else{
           if ($bulan==date('n') && tahun_anggaran()==date('Y')) {
               $deskripsi_bulan = 'kondisi realisasi sampai ' . (date('d')). ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
           }else{
               $deskripsi_bulan = 'kondisi realisasi sampai ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
           }
        }


        $data['desc_bulan']=$deskripsi_bulan;

        $asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan, $cara_hitung, $kategori)->result();
        $asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan, $cara_hitung, $kategori)->result();
        $asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan, $cara_hitung, $kategori)->result();
        $asisten_1_belum_terekap = $this->rekap_asisten_model->get_opd_asisten_belum_terekap(204, $bulan)->result();
        $asisten_2_belum_terekap = $this->rekap_asisten_model->get_opd_asisten_belum_terekap(205, $bulan)->result();
        $asisten_3_belum_terekap = $this->rekap_asisten_model->get_opd_asisten_belum_terekap(206, $bulan)->result();




        $judul_file="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan;
        $data['judul_laporan']= "Laporan Rekap Realisasi Fisik Dan Keuangan Per SKPD <br>".$deskripsi_bulan;
        $data['identitas']=$identitas;
        $data['asisten_1']=$asisten_1;
        $data['asisten_1_belum_terekap']=$asisten_1_belum_terekap;
        $data['asisten_2']=$asisten_2;
        $data['asisten_2_belum_terekap']=$asisten_2_belum_terekap;
        $data['asisten_3']=$asisten_3;
        $data['asisten_3_belum_terekap']=$asisten_3_belum_terekap;
        $data['periode']=pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
        $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        // $html =  $this->load->view('laporan/pdf/realisasi_asisten/content', $data);


        $output = [
            'identitas_pemerintahan'=>$identitas['identitas'],
            'caption_ratarata_rekap_asisten'=>$identitas['caption_ratarata_rekap_asisten'],
            'tahun'=>$tahun,
            'tahapan_apbd'=>pilihan_nama_tahapan($tahap),
            'caption_laporan'=>"Laporan Rekap Realisasi Fisik Dan Keuangan Per SKPD <br>".$deskripsi_bulan,
            'data'=>[],

        ];


























// bagian eksekusi
    $total_peringatan_dev_fisik_merah = 0;
    $total_peringatan_dev_fisik_kuning = 0;
    $total_peringatan_dev_fisik_hijau = 0;
    $total_peringatan_dev_keu_merah = 0;
    $total_peringatan_dev_keu_kuning = 0;
    $total_peringatan_dev_keu_hijau = 0;



    $total_peringatan_dev_fisik_merah_satu = 0;
    $total_peringatan_dev_fisik_kuning_satu = 0;
    $total_peringatan_dev_fisik_hijau_satu = 0;
    $total_peringatan_dev_keu_merah_satu = 0;
    $total_peringatan_dev_keu_kuning_satu = 0;
    $total_peringatan_dev_keu_hijau_satu = 0;



    $total_peringatan_dev_fisik_merah_dua = 0;
    $total_peringatan_dev_fisik_kuning_dua = 0;
    $total_peringatan_dev_fisik_hijau_dua = 0;
    $total_peringatan_dev_keu_merah_dua = 0;
    $total_peringatan_dev_keu_kuning_dua = 0;
    $total_peringatan_dev_keu_hijau_dua = 0;



    $total_peringatan_dev_fisik_merah_tiga = 0;
    $total_peringatan_dev_fisik_kuning_tiga = 0;
    $total_peringatan_dev_fisik_hijau_tiga = 0;
    $total_peringatan_dev_keu_merah_tiga = 0;
    $total_peringatan_dev_keu_kuning_tiga = 0;
    $total_peringatan_dev_keu_hijau_tiga = 0;

    $total_data_skpd = 0;
    $total_data_skpd_satu = 0;
    $total_data_skpd_dua = 0;
    $total_data_skpd_tiga = 0;




    $total_pagu_bo_bbj =0;
    $total_pagu_bo_bs =0;
    $total_pagu_bo_bh =0;
    $total_pagu_bo_bbs =0;
    $total_pagu_bm_bmt =0;
    $total_pagu_bm_bmpm =0;
    $total_pagu_bm_bmgb =0;
    $total_pagu_bm_bmjji =0;
    $total_pagu_bm_bmatl =0;
    $total_pagu_bm_bmatb =0;
    $total_pagu_btt =0;
    $total_pagu_bt_bbh =0;
    $total_pagu_bt_bbk =0;
    $total_pagu_total =0;
    $total_rp_target_keuangan_akumulasi =0;
    $total_rp_target_keuangan_bulanan =0;
    $total_rp_realisasi_keuangan_akumulasi =0;
    $total_rp_realisasi_keuangan_akumulasi_bo_bp =0;
    $total_rp_realisasi_keuangan_akumulasi_bo_bbj =0;
    $total_rp_realisasi_keuangan_akumulasi_bo_bs =0;
    $total_rp_realisasi_keuangan_akumulasi_bo_bh =0;
    $total_rp_realisasi_keuangan_akumulasi_bo_bbs =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmt =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmpm =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmgb =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmjji =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmatl =0;
    $total_rp_realisasi_keuangan_akumulasi_bm_bmatb =0;
    $total_rp_realisasi_keuangan_akumulasi_btt =0;
    $total_rp_realisasi_keuangan_akumulasi_bt_bbh =0;
    $total_rp_realisasi_keuangan_akumulasi_bt_bbk =0;
    $total_rp_realisasi_keuangan_bulanan =0;
    $total_rp_realisasi_keuangan_bulanan_bo_bp =0;
    $total_rp_realisasi_keuangan_bulanan_bo_bbj =0;
    $total_rp_realisasi_keuangan_bulanan_bo_bs =0;
    $total_rp_realisasi_keuangan_bulanan_bo_bh =0;
    $total_rp_realisasi_keuangan_bulanan_bo_bbs =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmt =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmpm =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmgb =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmjji =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmatl =0;
    $total_rp_realisasi_keuangan_bulanan_bm_bmatb =0;
    $total_rp_realisasi_keuangan_bulanan_btt =0;
    $total_rp_realisasi_keuangan_bulanan_bt_bbh =0;
    $total_rp_realisasi_keuangan_bulanan_bt_bbk =0;


// asisten 1 
    $tertimbang_satu       = 0;
          $total_t_fisik_satu    = 0;
          $total_t_keu_satu      = 0;
          $total_r_fisik_satu    = 0;
          $total_r_keu_satu      = 0;
          $total_tertimbang_satu = 0;
          $jml_skpd_satu         = 0;

          $total_pagu =0;
          $total_rp_t_keu = 0;  
          $total_rp_r_keu = 0;

          $total_pagu_satu =0;
          $total_rp_t_keu_satu = 0;  
          $total_rp_r_keu_satu = 0;



        $kumpul_asisten_satu = [];
       foreach ($asisten_1 as $satu) { 

        $total_pagu_satu +=$satu->pagu_total;
        $total_rp_t_keu_satu +=$satu->rp_target_keuangan;
        $total_rp_r_keu_satu +=$satu->rp_realisasi_keuangan;



        $total_pagu +=$satu->pagu_total;
        $total_rp_t_keu +=$satu->rp_target_keuangan;
        $total_rp_r_keu +=$satu->rp_realisasi_keuangan;

        $total_data_skpd +=1;
        $total_data_skpd_satu +=1;


        $dev_fisik = round($satu->realisasi_fisik -$satu->target_fisik ,2);
          $dev_keu = round($satu->realisasi_keuangan - $satu->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_satu += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_satu += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_satu += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_satu += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_satu += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_satu += 1; 
            }


            $total_t_fisik_satu    += $satu->target_fisik;
            $total_t_keu_satu      += $satu->target_keuangan;
            $total_r_fisik_satu    += $satu->realisasi_fisik;
            $total_r_keu_satu      += $satu->realisasi_keuangan;
            $jml_skpd_satu++;

            $data_asisten_satu = [
                'kode_opd'=>$satu->kode_opd,
                'nama_instansi'=>$satu->nama_instansi,
                'tf'=>$satu->target_fisik,
                'rf'=>$satu->realisasi_fisik,
                'df'=>$dev_fisik,
                'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>$satu->rp_target_keuangan,
                'rk'=>$satu->rp_realisasi_keuangan,
                'dk'=>$dev_keu,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>$satu->rp_target_keuangan,
                // 'rp_realisasi_keuangan'=>$satu->rp_realisasi_keuangan,
                // 'rp_target_keuangan_bulanan'=>$satu->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan'=>$satu->rp_realisasi_keuangan_bulanan,

                // 'pagu_bo_bbj'=>$satu->pagu_bo_bbj,
                // 'pagu_bo_bs'=>$satu->pagu_bo_bs,
                // 'pagu_bo_bh'=>$satu->pagu_bo_bh,
                // 'pagu_bo_bbs'=>$satu->pagu_bo_bbs,
                // 'pagu_bm_bmt'=>$satu->pagu_bm_bmt,
                // 'pagu_bm_bmpm'=>$satu->pagu_bm_bmpm,
                // 'pagu_bm_bmgb'=>$satu->pagu_bm_bmgb,
                // 'pagu_bm_bmjji'=>$satu->pagu_bm_bmjji,
                // 'pagu_bm_bmatl'=>$satu->pagu_bm_bmatl,
                // 'pagu_bm_bmatb'=>$satu->pagu_bm_bmatb,
                // 'pagu_btt'=>$satu->pagu_btt,
                // 'pagu_bt_bbh'=>$satu->pagu_bt_bbh,
                // 'pagu_bt_bbk'=>$satu->pagu_bt_bbk,
                // 'pagu_total'=>$satu->pagu_total,

                // 'rp_target_keuangan_akumulasi'=>$satu->rp_target_keuangan_akumulasi,
                // 'rp_target_keuangan_bulanan'=>$satu->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_akumulasi'=>$satu->rp_realisasi_keuangan_akumulasi,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>$satu->rp_realisasi_keuangan_akumulasi_bo_bp,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>$satu->rp_realisasi_keuangan_akumulasi_bo_bbj,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>$satu->rp_realisasi_keuangan_akumulasi_bo_bs,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>$satu->rp_realisasi_keuangan_akumulasi_bo_bh,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>$satu->rp_realisasi_keuangan_akumulasi_bo_bbs,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmt,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmpm,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmgb,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmjji,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmatl,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>$satu->rp_realisasi_keuangan_akumulasi_bm_bmatb,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>$satu->rp_realisasi_keuangan_akumulasi_btt,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>$satu->rp_realisasi_keuangan_akumulasi_bt_bbh,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>$satu->rp_realisasi_keuangan_akumulasi_bt_bbk,
                // 'rp_realisasi_keuangan_bulanan'=>$satu->rp_realisasi_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>$satu->rp_realisasi_keuangan_bulanan_bo_bp,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>$satu->rp_realisasi_keuangan_bulanan_bo_bbj,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>$satu->rp_realisasi_keuangan_bulanan_bo_bs,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>$satu->rp_realisasi_keuangan_bulanan_bo_bh,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>$satu->rp_realisasi_keuangan_bulanan_bo_bbs,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmt,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmpm,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmgb,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmjji,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmatl,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>$satu->rp_realisasi_keuangan_bulanan_bm_bmatb,
                // 'rp_realisasi_keuangan_bulanan_btt'=>$satu->rp_realisasi_keuangan_bulanan_btt,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>$satu->rp_realisasi_keuangan_bulanan_bt_bbh,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>$satu->rp_realisasi_keuangan_bulanan_bt_bbk,
                'last_update'=>$satu->last_update,
            ];
            array_push($kumpul_asisten_satu, $data_asisten_satu);

$total_pagu_bo_bbj += $satu->pagu_bo_bbj;
$total_pagu_bo_bs += $satu->pagu_bo_bs;
$total_pagu_bo_bh += $satu->pagu_bo_bh;
$total_pagu_bo_bbs += $satu->pagu_bo_bbs;
$total_pagu_bm_bmt += $satu->pagu_bm_bmt;
$total_pagu_bm_bmpm += $satu->pagu_bm_bmpm;
$total_pagu_bm_bmgb += $satu->pagu_bm_bmgb;
$total_pagu_bm_bmjji += $satu->pagu_bm_bmjji;
$total_pagu_bm_bmatl += $satu->pagu_bm_bmatl;
$total_pagu_bm_bmatb += $satu->pagu_bm_bmatb;
$total_pagu_btt += $satu->pagu_btt;
$total_pagu_bt_bbh += $satu->pagu_bt_bbh;
$total_pagu_bt_bbk += $satu->pagu_bt_bbk;
$total_pagu_total += $satu->pagu_total;
$total_rp_target_keuangan_akumulasi += $satu->rp_target_keuangan_akumulasi;
$total_rp_target_keuangan_bulanan += $satu->rp_target_keuangan_bulanan;
$total_rp_realisasi_keuangan_akumulasi += $satu->rp_realisasi_keuangan_akumulasi;
$total_rp_realisasi_keuangan_akumulasi_bo_bp += $satu->rp_realisasi_keuangan_akumulasi_bo_bp;
$total_rp_realisasi_keuangan_akumulasi_bo_bbj += $satu->rp_realisasi_keuangan_akumulasi_bo_bbj;
$total_rp_realisasi_keuangan_akumulasi_bo_bs += $satu->rp_realisasi_keuangan_akumulasi_bo_bs;
$total_rp_realisasi_keuangan_akumulasi_bo_bh += $satu->rp_realisasi_keuangan_akumulasi_bo_bh;
$total_rp_realisasi_keuangan_akumulasi_bo_bbs += $satu->rp_realisasi_keuangan_akumulasi_bo_bbs;
$total_rp_realisasi_keuangan_akumulasi_bm_bmt += $satu->rp_realisasi_keuangan_akumulasi_bm_bmt;
$total_rp_realisasi_keuangan_akumulasi_bm_bmpm += $satu->rp_realisasi_keuangan_akumulasi_bm_bmpm;
$total_rp_realisasi_keuangan_akumulasi_bm_bmgb += $satu->rp_realisasi_keuangan_akumulasi_bm_bmgb;
$total_rp_realisasi_keuangan_akumulasi_bm_bmjji += $satu->rp_realisasi_keuangan_akumulasi_bm_bmjji;
$total_rp_realisasi_keuangan_akumulasi_bm_bmatl += $satu->rp_realisasi_keuangan_akumulasi_bm_bmatl;
$total_rp_realisasi_keuangan_akumulasi_bm_bmatb += $satu->rp_realisasi_keuangan_akumulasi_bm_bmatb;
$total_rp_realisasi_keuangan_akumulasi_btt += $satu->rp_realisasi_keuangan_akumulasi_btt;
$total_rp_realisasi_keuangan_akumulasi_bt_bbh += $satu->rp_realisasi_keuangan_akumulasi_bt_bbh;
$total_rp_realisasi_keuangan_akumulasi_bt_bbk += $satu->rp_realisasi_keuangan_akumulasi_bt_bbk;
$total_rp_realisasi_keuangan_bulanan += $satu->rp_realisasi_keuangan_bulanan;
$total_rp_realisasi_keuangan_bulanan_bo_bp += $satu->rp_realisasi_keuangan_bulanan_bo_bp;
$total_rp_realisasi_keuangan_bulanan_bo_bbj += $satu->rp_realisasi_keuangan_bulanan_bo_bbj;
$total_rp_realisasi_keuangan_bulanan_bo_bs += $satu->rp_realisasi_keuangan_bulanan_bo_bs;
$total_rp_realisasi_keuangan_bulanan_bo_bh += $satu->rp_realisasi_keuangan_bulanan_bo_bh;
$total_rp_realisasi_keuangan_bulanan_bo_bbs += $satu->rp_realisasi_keuangan_bulanan_bo_bbs;
$total_rp_realisasi_keuangan_bulanan_bm_bmt += $satu->rp_realisasi_keuangan_bulanan_bm_bmt;
$total_rp_realisasi_keuangan_bulanan_bm_bmpm += $satu->rp_realisasi_keuangan_bulanan_bm_bmpm;
$total_rp_realisasi_keuangan_bulanan_bm_bmgb += $satu->rp_realisasi_keuangan_bulanan_bm_bmgb;
$total_rp_realisasi_keuangan_bulanan_bm_bmjji += $satu->rp_realisasi_keuangan_bulanan_bm_bmjji;
$total_rp_realisasi_keuangan_bulanan_bm_bmatl += $satu->rp_realisasi_keuangan_bulanan_bm_bmatl;
$total_rp_realisasi_keuangan_bulanan_bm_bmatb += $satu->rp_realisasi_keuangan_bulanan_bm_bmatb;
$total_rp_realisasi_keuangan_bulanan_btt += $satu->rp_realisasi_keuangan_bulanan_btt;
$total_rp_realisasi_keuangan_bulanan_bt_bbh += $satu->rp_realisasi_keuangan_bulanan_bt_bbh;
$total_rp_realisasi_keuangan_bulanan_bt_bbk += $satu->rp_realisasi_keuangan_bulanan_bt_bbk;


        }


 foreach ($asisten_1_belum_terekap as $satu) { 

        $total_data_skpd +=1;
        $total_data_skpd_satu +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;
        $total_peringatan_dev_fisik_hijau_satu+=1;
        $total_peringatan_dev_keu_hijau_satu+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_satu++;


            $data_asisten_satu = [
                'kode_opd'=>'',
                'nama_instansi'=>$satu->nama_instansi,
                'tf'=>0,
                'rf'=>0,
                'df'=>0,
                 'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>0,
                'rk'=>0,
                'dk'=>0,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>0,
                // 'rp_realisasi_keuangan'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,

                // 'pagu_bo_bbj'=>0,
                // 'pagu_bo_bs'=>0,
                // 'pagu_bo_bh'=>0,
                // 'pagu_bo_bbs'=>0,
                // 'pagu_bm_bmt'=>0,
                // 'pagu_bm_bmpm'=>0,
                // 'pagu_bm_bmgb'=>0,
                // 'pagu_bm_bmjji'=>0,
                // 'pagu_bm_bmatl'=>0,
                // 'pagu_bm_bmatb'=>0,
                // 'pagu_btt'=>0,
                // 'pagu_bt_bbh'=>0,
                // 'pagu_bt_bbk'=>0,
                // 'pagu_total'=>0,

                // 'rp_target_keuangan_akumulasi'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_akumulasi'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_bulanan_btt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>0,
                'last_update'=>0,
            ];
            array_push($kumpul_asisten_satu, $data_asisten_satu);

        }




// asusten 2
            $tertimbang_dua       = 0;
          $total_t_fisik_dua    = 0;
          $total_t_keu_dua      = 0;
          $total_r_fisik_dua    = 0;
          $total_r_keu_dua      = 0;
          $total_tertimbang_dua = 0;
          $jml_skpd_dua         = 0;



          $total_pagu_dua =0;
          $total_rp_t_keu_dua = 0;  
          $total_rp_r_keu_dua = 0;
        $kumpul_asisten_dua = [];
       foreach ($asisten_2 as $dua) { 

        $total_pagu_dua +=$dua->pagu_total;
        $total_rp_t_keu_dua +=$dua->rp_target_keuangan;
        $total_rp_r_keu_dua +=$dua->rp_realisasi_keuangan;



        $total_pagu +=$dua->pagu_total;
        $total_rp_t_keu +=$dua->rp_target_keuangan;
        $total_rp_r_keu +=$dua->rp_realisasi_keuangan;

        $total_data_skpd +=1;
        $total_data_skpd_dua +=1;


        $dev_fisik = round($dua->realisasi_fisik -$dua->target_fisik ,2);
          $dev_keu = round($dua->realisasi_keuangan - $dua->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_dua += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_dua += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_dua += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_dua += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_dua += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_dua += 1; 
            }


            $total_t_fisik_dua    += $dua->target_fisik;
            $total_t_keu_dua      += $dua->target_keuangan;
            $total_r_fisik_dua    += $dua->realisasi_fisik;
            $total_r_keu_dua      += $dua->realisasi_keuangan;
            $jml_skpd_dua++;

            $data_asisten_dua = [
                'kode_opd'=>'',
                'nama_instansi'=>$dua->nama_instansi,
                'tf'=>$dua->target_fisik,
                'rf'=>$dua->realisasi_fisik,
                'df'=>$dev_fisik,
                 'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>$dua->rp_target_keuangan,
                'rk'=>$dua->rp_realisasi_keuangan,
                'dk'=>$dev_keu,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>$dua->rp_target_keuangan,
                // 'rp_realisasi_keuangan'=>$dua->rp_realisasi_keuangan,
                // 'rp_target_keuangan_bulanan'=>$dua->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan'=>$dua->rp_realisasi_keuangan_bulanan,

                // 'pagu_bo_bbj'=>$dua->pagu_bo_bbj,
                // 'pagu_bo_bs'=>$dua->pagu_bo_bs,
                // 'pagu_bo_bh'=>$dua->pagu_bo_bh,
                // 'pagu_bo_bbs'=>$dua->pagu_bo_bbs,
                // 'pagu_bm_bmt'=>$dua->pagu_bm_bmt,
                // 'pagu_bm_bmpm'=>$dua->pagu_bm_bmpm,
                // 'pagu_bm_bmgb'=>$dua->pagu_bm_bmgb,
                // 'pagu_bm_bmjji'=>$dua->pagu_bm_bmjji,
                // 'pagu_bm_bmatl'=>$dua->pagu_bm_bmatl,
                // 'pagu_bm_bmatb'=>$dua->pagu_bm_bmatb,
                // 'pagu_btt'=>$dua->pagu_btt,
                // 'pagu_bt_bbh'=>$dua->pagu_bt_bbh,
                // 'pagu_bt_bbk'=>$dua->pagu_bt_bbk,
                // 'pagu_total'=>$dua->pagu_total,

                // 'rp_target_keuangan_akumulasi'=>$dua->rp_target_keuangan_akumulasi,
                // 'rp_target_keuangan_bulanan'=>$dua->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_akumulasi'=>$dua->rp_realisasi_keuangan_akumulasi,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>$dua->rp_realisasi_keuangan_akumulasi_bo_bp,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>$dua->rp_realisasi_keuangan_akumulasi_bo_bbj,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>$dua->rp_realisasi_keuangan_akumulasi_bo_bs,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>$dua->rp_realisasi_keuangan_akumulasi_bo_bh,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>$dua->rp_realisasi_keuangan_akumulasi_bo_bbs,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmt,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmpm,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmgb,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmjji,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmatl,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>$dua->rp_realisasi_keuangan_akumulasi_bm_bmatb,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>$dua->rp_realisasi_keuangan_akumulasi_btt,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>$dua->rp_realisasi_keuangan_akumulasi_bt_bbh,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>$dua->rp_realisasi_keuangan_akumulasi_bt_bbk,
                // 'rp_realisasi_keuangan_bulanan'=>$dua->rp_realisasi_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>$dua->rp_realisasi_keuangan_bulanan_bo_bp,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>$dua->rp_realisasi_keuangan_bulanan_bo_bbj,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>$dua->rp_realisasi_keuangan_bulanan_bo_bs,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>$dua->rp_realisasi_keuangan_bulanan_bo_bh,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>$dua->rp_realisasi_keuangan_bulanan_bo_bbs,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmt,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmpm,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmgb,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmjji,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmatl,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>$dua->rp_realisasi_keuangan_bulanan_bm_bmatb,
                // 'rp_realisasi_keuangan_bulanan_btt'=>$dua->rp_realisasi_keuangan_bulanan_btt,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>$dua->rp_realisasi_keuangan_bulanan_bt_bbh,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>$dua->rp_realisasi_keuangan_bulanan_bt_bbk,
                'last_update'=>$dua->last_update,
            ];
            array_push($kumpul_asisten_dua, $data_asisten_dua);



            $total_pagu_bo_bbj += $dua->pagu_bo_bbj;
            $total_pagu_bo_bs += $dua->pagu_bo_bs;
            $total_pagu_bo_bh += $dua->pagu_bo_bh;
            $total_pagu_bo_bbs += $dua->pagu_bo_bbs;
            $total_pagu_bm_bmt += $dua->pagu_bm_bmt;
            $total_pagu_bm_bmpm += $dua->pagu_bm_bmpm;
            $total_pagu_bm_bmgb += $dua->pagu_bm_bmgb;
            $total_pagu_bm_bmjji += $dua->pagu_bm_bmjji;
            $total_pagu_bm_bmatl += $dua->pagu_bm_bmatl;
            $total_pagu_bm_bmatb += $dua->pagu_bm_bmatb;
            $total_pagu_btt += $dua->pagu_btt;
            $total_pagu_bt_bbh += $dua->pagu_bt_bbh;
            $total_pagu_bt_bbk += $dua->pagu_bt_bbk;
            $total_pagu_total += $dua->pagu_total;
            $total_rp_target_keuangan_akumulasi += $dua->rp_target_keuangan_akumulasi;
            $total_rp_target_keuangan_bulanan += $dua->rp_target_keuangan_bulanan;
            $total_rp_realisasi_keuangan_akumulasi += $dua->rp_realisasi_keuangan_akumulasi;
            $total_rp_realisasi_keuangan_akumulasi_bo_bp += $dua->rp_realisasi_keuangan_akumulasi_bo_bp;
            $total_rp_realisasi_keuangan_akumulasi_bo_bbj += $dua->rp_realisasi_keuangan_akumulasi_bo_bbj;
            $total_rp_realisasi_keuangan_akumulasi_bo_bs += $dua->rp_realisasi_keuangan_akumulasi_bo_bs;
            $total_rp_realisasi_keuangan_akumulasi_bo_bh += $dua->rp_realisasi_keuangan_akumulasi_bo_bh;
            $total_rp_realisasi_keuangan_akumulasi_bo_bbs += $dua->rp_realisasi_keuangan_akumulasi_bo_bbs;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmt += $dua->rp_realisasi_keuangan_akumulasi_bm_bmt;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmpm += $dua->rp_realisasi_keuangan_akumulasi_bm_bmpm;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmgb += $dua->rp_realisasi_keuangan_akumulasi_bm_bmgb;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmjji += $dua->rp_realisasi_keuangan_akumulasi_bm_bmjji;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmatl += $dua->rp_realisasi_keuangan_akumulasi_bm_bmatl;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmatb += $dua->rp_realisasi_keuangan_akumulasi_bm_bmatb;
            $total_rp_realisasi_keuangan_akumulasi_btt += $dua->rp_realisasi_keuangan_akumulasi_btt;
            $total_rp_realisasi_keuangan_akumulasi_bt_bbh += $dua->rp_realisasi_keuangan_akumulasi_bt_bbh;
            $total_rp_realisasi_keuangan_akumulasi_bt_bbk += $dua->rp_realisasi_keuangan_akumulasi_bt_bbk;
            $total_rp_realisasi_keuangan_bulanan += $dua->rp_realisasi_keuangan_bulanan;
            $total_rp_realisasi_keuangan_bulanan_bo_bp += $dua->rp_realisasi_keuangan_bulanan_bo_bp;
            $total_rp_realisasi_keuangan_bulanan_bo_bbj += $dua->rp_realisasi_keuangan_bulanan_bo_bbj;
            $total_rp_realisasi_keuangan_bulanan_bo_bs += $dua->rp_realisasi_keuangan_bulanan_bo_bs;
            $total_rp_realisasi_keuangan_bulanan_bo_bh += $dua->rp_realisasi_keuangan_bulanan_bo_bh;
            $total_rp_realisasi_keuangan_bulanan_bo_bbs += $dua->rp_realisasi_keuangan_bulanan_bo_bbs;
            $total_rp_realisasi_keuangan_bulanan_bm_bmt += $dua->rp_realisasi_keuangan_bulanan_bm_bmt;
            $total_rp_realisasi_keuangan_bulanan_bm_bmpm += $dua->rp_realisasi_keuangan_bulanan_bm_bmpm;
            $total_rp_realisasi_keuangan_bulanan_bm_bmgb += $dua->rp_realisasi_keuangan_bulanan_bm_bmgb;
            $total_rp_realisasi_keuangan_bulanan_bm_bmjji += $dua->rp_realisasi_keuangan_bulanan_bm_bmjji;
            $total_rp_realisasi_keuangan_bulanan_bm_bmatl += $dua->rp_realisasi_keuangan_bulanan_bm_bmatl;
            $total_rp_realisasi_keuangan_bulanan_bm_bmatb += $dua->rp_realisasi_keuangan_bulanan_bm_bmatb;
            $total_rp_realisasi_keuangan_bulanan_btt += $dua->rp_realisasi_keuangan_bulanan_btt;
            $total_rp_realisasi_keuangan_bulanan_bt_bbh += $dua->rp_realisasi_keuangan_bulanan_bt_bbh;
            $total_rp_realisasi_keuangan_bulanan_bt_bbk += $dua->rp_realisasi_keuangan_bulanan_bt_bbk;

        }


 foreach ($asisten_2_belum_terekap as $dua) { 

        $total_data_skpd +=1;
        $total_data_skpd_dua +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;
        $total_peringatan_dev_fisik_hijau_dua+=1;
        $total_peringatan_dev_keu_hijau_dua+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_dua++;


            $data_asisten_dua = [
                'kode_opd'=>'',
                'nama_instansi'=>$dua->nama_instansi,
                'tf'=>0,
                'rf'=>0,
                'df'=>0,
                'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>0,
                'rk'=>0,
                'dk'=>0,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>0,
                // 'rp_realisasi_keuangan'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,

                // 'pagu_bo_bbj'=>0,
                // 'pagu_bo_bs'=>0,
                // 'pagu_bo_bh'=>0,
                // 'pagu_bo_bbs'=>0,
                // 'pagu_bm_bmt'=>0,
                // 'pagu_bm_bmpm'=>0,
                // 'pagu_bm_bmgb'=>0,
                // 'pagu_bm_bmjji'=>0,
                // 'pagu_bm_bmatl'=>0,
                // 'pagu_bm_bmatb'=>0,
                // 'pagu_btt'=>0,
                // 'pagu_bt_bbh'=>0,
                // 'pagu_bt_bbk'=>0,
                // 'pagu_total'=>0,

                // 'rp_target_keuangan_akumulasi'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_akumulasi'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_bulanan_btt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>0,
                'last_update'=>0,
            ];
            array_push($kumpul_asisten_dua, $data_asisten_dua);


        }





        // asisten 3
            $tertimbang_tiga       = 0;
          $total_t_fisik_tiga    = 0;
          $total_t_keu_tiga      = 0;
          $total_r_fisik_tiga    = 0;
          $total_r_keu_tiga      = 0;
          $total_tertimbang_tiga = 0;
          $jml_skpd_tiga         = 0;



          $total_pagu_tiga =0;
          $total_rp_t_keu_tiga = 0;  
          $total_rp_r_keu_tiga = 0;





        $kumpul_asisten_tiga = [];
       foreach ($asisten_3 as $tiga) { 

        $total_pagu_tiga +=$tiga->pagu_total;
        $total_rp_t_keu_tiga +=$tiga->rp_target_keuangan;
        $total_rp_r_keu_tiga +=$tiga->rp_realisasi_keuangan;


        $total_pagu +=$tiga->pagu_total;
        $total_rp_t_keu +=$tiga->rp_target_keuangan;
        $total_rp_r_keu +=$tiga->rp_realisasi_keuangan;

        $total_data_skpd +=1;
        $total_data_skpd_tiga +=1;


        $dev_fisik = round($tiga->realisasi_fisik -$tiga->target_fisik ,2);
          $dev_keu = round($tiga->realisasi_keuangan - $tiga->target_keuangan,2);


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
              $total_peringatan_dev_fisik_merah_tiga += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
              $total_peringatan_dev_fisik_kuning_tiga += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
              $total_peringatan_dev_fisik_hijau_tiga += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
              $total_peringatan_dev_keu_merah_tiga += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
              $total_peringatan_dev_keu_kuning_tiga += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
              $total_peringatan_dev_keu_hijau_tiga += 1; 
            }


            $total_t_fisik_tiga    += $tiga->target_fisik;
            $total_t_keu_tiga      += $tiga->target_keuangan;
            $total_r_fisik_tiga    += $tiga->realisasi_fisik;
            $total_r_keu_tiga      += $tiga->realisasi_keuangan;
            $jml_skpd_tiga++;

            $data_asisten_tiga = [
                'kode_opd'=>'',
                'nama_instansi'=>$tiga->nama_instansi,
                'tf'=>$tiga->target_fisik,
                'rf'=>$tiga->realisasi_fisik,
                'df'=>$dev_fisik,
                'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>$tiga->rp_target_keuangan,
                'rk'=>$tiga->rp_realisasi_keuangan,
                'dk'=>$dev_keu,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>$tiga->rp_target_keuangan,
                // 'rp_realisasi_keuangan'=>$tiga->rp_realisasi_keuangan,
                // 'rp_target_keuangan_bulanan'=>$tiga->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan'=>$tiga->rp_realisasi_keuangan_bulanan,

                // 'pagu_bo_bbj'=>$tiga->pagu_bo_bbj,
                // 'pagu_bo_bs'=>$tiga->pagu_bo_bs,
                // 'pagu_bo_bh'=>$tiga->pagu_bo_bh,
                // 'pagu_bo_bbs'=>$tiga->pagu_bo_bbs,
                // 'pagu_bm_bmt'=>$tiga->pagu_bm_bmt,
                // 'pagu_bm_bmpm'=>$tiga->pagu_bm_bmpm,
                // 'pagu_bm_bmgb'=>$tiga->pagu_bm_bmgb,
                // 'pagu_bm_bmjji'=>$tiga->pagu_bm_bmjji,
                // 'pagu_bm_bmatl'=>$tiga->pagu_bm_bmatl,
                // 'pagu_bm_bmatb'=>$tiga->pagu_bm_bmatb,
                // 'pagu_btt'=>$tiga->pagu_btt,
                // 'pagu_bt_bbh'=>$tiga->pagu_bt_bbh,
                // 'pagu_bt_bbk'=>$tiga->pagu_bt_bbk,
                // 'pagu_total'=>$tiga->pagu_total,

                // 'rp_target_keuangan_akumulasi'=>$tiga->rp_target_keuangan_akumulasi,
                // 'rp_target_keuangan_bulanan'=>$tiga->rp_target_keuangan_bulanan,
                // 'rp_realisasi_keuangan_akumulasi'=>$tiga->rp_realisasi_keuangan_akumulasi,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>$tiga->rp_realisasi_keuangan_akumulasi_bo_bp,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>$tiga->rp_realisasi_keuangan_akumulasi_bo_bbj,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>$tiga->rp_realisasi_keuangan_akumulasi_bo_bs,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>$tiga->rp_realisasi_keuangan_akumulasi_bo_bh,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>$tiga->rp_realisasi_keuangan_akumulasi_bo_bbs,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmt,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmpm,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmgb,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmjji,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmatl,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>$tiga->rp_realisasi_keuangan_akumulasi_bm_bmatb,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>$tiga->rp_realisasi_keuangan_akumulasi_btt,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>$tiga->rp_realisasi_keuangan_akumulasi_bt_bbh,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>$tiga->rp_realisasi_keuangan_akumulasi_bt_bbk,
                // 'rp_realisasi_keuangan_bulanan'=>$tiga->rp_realisasi_keuangan_bulanan,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>$tiga->rp_realisasi_keuangan_bulanan_bo_bp,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>$tiga->rp_realisasi_keuangan_bulanan_bo_bbj,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>$tiga->rp_realisasi_keuangan_bulanan_bo_bs,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>$tiga->rp_realisasi_keuangan_bulanan_bo_bh,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>$tiga->rp_realisasi_keuangan_bulanan_bo_bbs,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmt,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmpm,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmgb,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmjji,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmatl,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>$tiga->rp_realisasi_keuangan_bulanan_bm_bmatb,
                // 'rp_realisasi_keuangan_bulanan_btt'=>$tiga->rp_realisasi_keuangan_bulanan_btt,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>$tiga->rp_realisasi_keuangan_bulanan_bt_bbh,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>$tiga->rp_realisasi_keuangan_bulanan_bt_bbk,
                'last_update'=>$tiga->last_update,
            ];
            array_push($kumpul_asisten_tiga, $data_asisten_tiga);



            $total_pagu_bo_bbj += $tiga->pagu_bo_bbj;
            $total_pagu_bo_bs += $tiga->pagu_bo_bs;
            $total_pagu_bo_bh += $tiga->pagu_bo_bh;
            $total_pagu_bo_bbs += $tiga->pagu_bo_bbs;
            $total_pagu_bm_bmt += $tiga->pagu_bm_bmt;
            $total_pagu_bm_bmpm += $tiga->pagu_bm_bmpm;
            $total_pagu_bm_bmgb += $tiga->pagu_bm_bmgb;
            $total_pagu_bm_bmjji += $tiga->pagu_bm_bmjji;
            $total_pagu_bm_bmatl += $tiga->pagu_bm_bmatl;
            $total_pagu_bm_bmatb += $tiga->pagu_bm_bmatb;
            $total_pagu_btt += $tiga->pagu_btt;
            $total_pagu_bt_bbh += $tiga->pagu_bt_bbh;
            $total_pagu_bt_bbk += $tiga->pagu_bt_bbk;
            $total_pagu_total += $tiga->pagu_total;
            $total_rp_target_keuangan_akumulasi += $tiga->rp_target_keuangan_akumulasi;
            $total_rp_target_keuangan_bulanan += $tiga->rp_target_keuangan_bulanan;
            $total_rp_realisasi_keuangan_akumulasi += $tiga->rp_realisasi_keuangan_akumulasi;
            $total_rp_realisasi_keuangan_akumulasi_bo_bp += $tiga->rp_realisasi_keuangan_akumulasi_bo_bp;
            $total_rp_realisasi_keuangan_akumulasi_bo_bbj += $tiga->rp_realisasi_keuangan_akumulasi_bo_bbj;
            $total_rp_realisasi_keuangan_akumulasi_bo_bs += $tiga->rp_realisasi_keuangan_akumulasi_bo_bs;
            $total_rp_realisasi_keuangan_akumulasi_bo_bh += $tiga->rp_realisasi_keuangan_akumulasi_bo_bh;
            $total_rp_realisasi_keuangan_akumulasi_bo_bbs += $tiga->rp_realisasi_keuangan_akumulasi_bo_bbs;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmt += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmt;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmpm += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmpm;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmgb += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmgb;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmjji += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmjji;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmatl += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmatl;
            $total_rp_realisasi_keuangan_akumulasi_bm_bmatb += $tiga->rp_realisasi_keuangan_akumulasi_bm_bmatb;
            $total_rp_realisasi_keuangan_akumulasi_btt += $tiga->rp_realisasi_keuangan_akumulasi_btt;
            $total_rp_realisasi_keuangan_akumulasi_bt_bbh += $tiga->rp_realisasi_keuangan_akumulasi_bt_bbh;
            $total_rp_realisasi_keuangan_akumulasi_bt_bbk += $tiga->rp_realisasi_keuangan_akumulasi_bt_bbk;
            $total_rp_realisasi_keuangan_bulanan += $tiga->rp_realisasi_keuangan_bulanan;
            $total_rp_realisasi_keuangan_bulanan_bo_bp += $tiga->rp_realisasi_keuangan_bulanan_bo_bp;
            $total_rp_realisasi_keuangan_bulanan_bo_bbj += $tiga->rp_realisasi_keuangan_bulanan_bo_bbj;
            $total_rp_realisasi_keuangan_bulanan_bo_bs += $tiga->rp_realisasi_keuangan_bulanan_bo_bs;
            $total_rp_realisasi_keuangan_bulanan_bo_bh += $tiga->rp_realisasi_keuangan_bulanan_bo_bh;
            $total_rp_realisasi_keuangan_bulanan_bo_bbs += $tiga->rp_realisasi_keuangan_bulanan_bo_bbs;
            $total_rp_realisasi_keuangan_bulanan_bm_bmt += $tiga->rp_realisasi_keuangan_bulanan_bm_bmt;
            $total_rp_realisasi_keuangan_bulanan_bm_bmpm += $tiga->rp_realisasi_keuangan_bulanan_bm_bmpm;
            $total_rp_realisasi_keuangan_bulanan_bm_bmgb += $tiga->rp_realisasi_keuangan_bulanan_bm_bmgb;
            $total_rp_realisasi_keuangan_bulanan_bm_bmjji += $tiga->rp_realisasi_keuangan_bulanan_bm_bmjji;
            $total_rp_realisasi_keuangan_bulanan_bm_bmatl += $tiga->rp_realisasi_keuangan_bulanan_bm_bmatl;
            $total_rp_realisasi_keuangan_bulanan_bm_bmatb += $tiga->rp_realisasi_keuangan_bulanan_bm_bmatb;
            $total_rp_realisasi_keuangan_bulanan_btt += $tiga->rp_realisasi_keuangan_bulanan_btt;
            $total_rp_realisasi_keuangan_bulanan_bt_bbh += $tiga->rp_realisasi_keuangan_bulanan_bt_bbh;
            $total_rp_realisasi_keuangan_bulanan_bt_bbk += $tiga->rp_realisasi_keuangan_bulanan_bt_bbk;
        }


 foreach ($asisten_3_belum_terekap as $tiga) { 

        $total_data_skpd +=1;
        $total_data_skpd_tiga +=1;

        $total_peringatan_dev_fisik_hijau+=1;
        $total_peringatan_dev_keu_hijau+=1;
        $total_peringatan_dev_fisik_hijau_tiga+=1;
        $total_peringatan_dev_keu_hijau_tiga+=1;


              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            $jml_skpd_tiga++;


            $data_asisten_tiga = [
                'kode_opd'=>$tiga->kode_opd,
                'nama_instansi'=>$tiga->nama_instansi,
                'tf'=>0,
                'rf'=>0,
                'df'=>0,
                 'warna_df'=>$warna_peringatan_dev_fisik,
                'tk'=>0,
                'rk'=>0,
                'dk'=>0,
                'warna_dk'=>$warna_peringatan_dev_keu,
                // 'rp_target_keuangan'=>0,
                // 'rp_realisasi_keuangan'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,

                // 'pagu_bo_bbj'=>0,
                // 'pagu_bo_bs'=>0,
                // 'pagu_bo_bh'=>0,
                // 'pagu_bo_bbs'=>0,
                // 'pagu_bm_bmt'=>0,
                // 'pagu_bm_bmpm'=>0,
                // 'pagu_bm_bmgb'=>0,
                // 'pagu_bm_bmjji'=>0,
                // 'pagu_bm_bmatl'=>0,
                // 'pagu_bm_bmatb'=>0,
                // 'pagu_btt'=>0,
                // 'pagu_bt_bbh'=>0,
                // 'pagu_bt_bbk'=>0,
                // 'pagu_total'=>0,

                // 'rp_target_keuangan_akumulasi'=>0,
                // 'rp_target_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_akumulasi'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bp'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_akumulasi_btt'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_akumulasi_bt_bbk'=>0,
                // 'rp_realisasi_keuangan_bulanan'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bp'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbj'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmpm'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmgb'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmjji'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatl'=>0,
                // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>0,
                // 'rp_realisasi_keuangan_bulanan_btt'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbh'=>0,
                // 'rp_realisasi_keuangan_bulanan_bt_bbk'=>0,
                'last_update'=>0,
            ];
            array_push($kumpul_asisten_tiga, $data_asisten_tiga);


        }





            $output['data']['asisten_1']['skpd']=$kumpul_asisten_satu;
            $output['data']['asisten_2']['skpd']=$kumpul_asisten_dua;
            $output['data']['asisten_3']['skpd']=$kumpul_asisten_tiga;
            // array_push($output['data'],$kumpul_asisten_dua);
            // array_push($output['data'],$kumpul_asisten_tiga);



            $tf_asisten_satu = round($total_t_fisik_satu / count($kumpul_asisten_satu),2);
            $rf_asisten_satu = round($total_r_fisik_satu / count($kumpul_asisten_satu),2);
            $df_asisten_satu = $rf_asisten_satu - $tf_asisten_satu;
            $tk_asisten_satu = round(($total_rp_t_keu_satu / $total_pagu_satu) * 100,2);
            $rk_asisten_satu = round(($total_rp_r_keu_satu / $total_pagu_satu) * 100,2);
            $dk_asisten_satu = $rk_asisten_satu - $tk_asisten_satu;
            $pencapaian_asisten_1 = [
                'tf'=>$tf_asisten_satu,
                'rf'=>$rf_asisten_satu,
                'df'=>round($df_asisten_satu,2),
                'tk'=>$tk_asisten_satu,
                'rk'=>$rk_asisten_satu,
                'dk'=>round($dk_asisten_satu,2),
            ];
            $output['data']['asisten_1']['pencapaian']=$pencapaian_asisten_1;

            $tf_asisten_dua = round($total_t_fisik_dua / count($kumpul_asisten_dua),2);
            $rf_asisten_dua = round($total_r_fisik_dua / count($kumpul_asisten_dua),2);
            $df_asisten_dua = $rf_asisten_dua - $tf_asisten_dua;
            $tk_asisten_dua = round(($total_rp_t_keu_dua / $total_pagu_dua) * 100,2);
            $rk_asisten_dua = round(($total_rp_r_keu_dua / $total_pagu_dua) * 100,2);
            $dk_asisten_dua = $rk_asisten_dua - $tk_asisten_dua;
            $pencapaian_asisten_1 = [
                'tf'=>$tf_asisten_dua,
                'rf'=>$rf_asisten_dua,
                'df'=>round($df_asisten_dua,2),
                'tk'=>$tk_asisten_dua,
                'rk'=>$rk_asisten_dua,
                'dk'=>round($dk_asisten_dua,2),
            ];
            $output['data']['asisten_2']['pencapaian']=$pencapaian_asisten_1;

            $tf_asisten_tiga = round($total_t_fisik_tiga / count($kumpul_asisten_tiga),2);
            $rf_asisten_tiga = round($total_r_fisik_tiga / count($kumpul_asisten_tiga),2);
            $df_asisten_tiga = $rf_asisten_tiga - $tf_asisten_tiga;
            $tk_asisten_tiga = round(($total_rp_t_keu_tiga / $total_pagu_tiga) * 100,2);
            $rk_asisten_tiga = round(($total_rp_r_keu_tiga / $total_pagu_tiga) * 100,2);
            $dk_asisten_tiga = $rk_asisten_tiga - $tk_asisten_tiga;
            $pencapaian_asisten_1 = [
                'tf'=>$tf_asisten_tiga,
                'rf'=>$rf_asisten_tiga,
                'df'=>round($df_asisten_tiga,2),
                'tk'=>$tk_asisten_tiga,
                'rk'=>$rk_asisten_tiga,
                'dk'=>round($dk_asisten_tiga,2),
            ];
            $output['data']['asisten_3']['pencapaian']=$pencapaian_asisten_1;



$data_rekap_deviasi = [
'total_peringatan_dev_fisik_merah_satu'=>$total_peringatan_dev_fisik_merah_satu,
'total_peringatan_dev_keu_merah_satu'=>$total_peringatan_dev_keu_merah_satu,
'total_peringatan_dev_fisik_merah_dua'=>$total_peringatan_dev_fisik_merah_dua,
'total_peringatan_dev_keu_merah_dua'=>$total_peringatan_dev_keu_merah_dua,
'total_peringatan_dev_fisik_merah_tiga'=>$total_peringatan_dev_fisik_merah_tiga,
'total_peringatan_dev_keu_merah_tiga'=>$total_peringatan_dev_keu_merah_tiga,
'total_peringatan_dev_fisik_merah'=>$total_peringatan_dev_fisik_merah,
'total_peringatan_dev_keu_merah'=>$total_peringatan_dev_keu_merah,
'total_peringatan_dev_fisik_kuning_satu'=>$total_peringatan_dev_fisik_kuning_satu,
'total_peringatan_dev_keu_kuning_satu'=>$total_peringatan_dev_keu_kuning_satu,
'total_peringatan_dev_fisik_kuning_dua'=>$total_peringatan_dev_fisik_kuning_dua,
'total_peringatan_dev_keu_kuning_dua'=>$total_peringatan_dev_keu_kuning_dua,
'total_peringatan_dev_fisik_kuning_tiga'=>$total_peringatan_dev_fisik_kuning_tiga,
'total_peringatan_dev_keu_kuning_tiga'=>$total_peringatan_dev_keu_kuning_tiga,
'total_peringatan_dev_fisik_kuning'=>$total_peringatan_dev_fisik_kuning,
'total_peringatan_dev_keu_kuning'=>$total_peringatan_dev_keu_kuning,
'total_peringatan_dev_fisik_hijau_satu'=>$total_peringatan_dev_fisik_hijau_satu,
'total_peringatan_dev_keu_hijau_satu'=>$total_peringatan_dev_keu_hijau_satu,
'total_peringatan_dev_fisik_hijau_dua'=>$total_peringatan_dev_fisik_hijau_dua,
'total_peringatan_dev_keu_hijau_dua'=>$total_peringatan_dev_keu_hijau_dua,
'total_peringatan_dev_fisik_hijau_tiga'=>$total_peringatan_dev_fisik_hijau_tiga,
'total_peringatan_dev_keu_hijau_tiga'=>$total_peringatan_dev_keu_hijau_tiga,
'total_peringatan_dev_fisik_hijau'=>$total_peringatan_dev_fisik_hijau,
'total_peringatan_dev_keu_hijau'=>$total_peringatan_dev_keu_hijau,
'total_data_skpd_satu'=>$total_data_skpd_satu,
'total_data_skpd_dua'=>$total_data_skpd_dua,
'total_data_skpd_tiga'=>$total_data_skpd_tiga,
'total_data_skpd'=>$total_data_skpd,
];






// pencapaian total
 $semua_skpd = $jml_skpd_satu + $jml_skpd_dua + $jml_skpd_tiga;
    $semua_total_t_fisik = ($total_t_fisik_satu +$total_t_fisik_dua +$total_t_fisik_tiga) / $semua_skpd;
    $semua_total_r_fisik = ($total_r_fisik_satu +$total_r_fisik_dua +$total_r_fisik_tiga)  / $semua_skpd ;
    $semua_total_dev_fisik = $semua_total_r_fisik - $semua_total_t_fisik  ;
    $semua_total_t_keu = ($total_rp_t_keu / $total_pagu) * 100 ;//($total_t_keu_satu +$total_t_keu_dua +$total_t_keu_tiga) / $semua_skpd;
    $semua_total_r_keu = ($total_rp_r_keu / $total_pagu) * 100 ;;//($total_r_keu_satu +$total_r_keu_dua +$total_r_keu_tiga) / $semua_skpd;
    $semua_total_dev_keu = $semua_total_r_keu - $semua_total_t_keu ;
$pencapaian = [
'tf'=>round($semua_total_t_fisik,2),
'rf'=>round($semua_total_r_fisik,2),
'df'=>round($semua_total_dev_fisik,2),
'tk'=>round($semua_total_t_keu,2),
'rk'=>round($semua_total_r_keu,2),
'dk'=>round($semua_total_dev_keu,2),



'total_pagu_bo_bbj'=>$total_pagu_bo_bbj,
'total_pagu_bo_bs'=>$total_pagu_bo_bs,
'total_pagu_bo_bh'=>$total_pagu_bo_bh,
'total_pagu_bo_bbs'=>$total_pagu_bo_bbs,
'total_pagu_bm_bmt'=>$total_pagu_bm_bmt,
'total_pagu_bm_bmpm'=>$total_pagu_bm_bmpm,
'total_pagu_bm_bmgb'=>$total_pagu_bm_bmgb,
'total_pagu_bm_bmjji'=>$total_pagu_bm_bmjji,
'total_pagu_bm_bmatl'=>$total_pagu_bm_bmatl,
'total_pagu_bm_bmatb'=>$total_pagu_bm_bmatb,
'total_pagu_btt'=>$total_pagu_btt,
'total_pagu_bt_bbh'=>$total_pagu_bt_bbh,
'total_pagu_bt_bbk'=>$total_pagu_bt_bbk,
'total_pagu_total'=>$total_pagu_total,
'total_rp_target_keuangan_akumulasi'=>$total_rp_target_keuangan_akumulasi,
'total_rp_target_keuangan_bulanan'=>$total_rp_target_keuangan_bulanan,
'total_rp_realisasi_keuangan_akumulasi'=>$total_rp_realisasi_keuangan_akumulasi,
'total_rp_realisasi_keuangan_akumulasi_bo_bp'=>$total_rp_realisasi_keuangan_akumulasi_bo_bp,
'total_rp_realisasi_keuangan_akumulasi_bo_bbj'=>$total_rp_realisasi_keuangan_akumulasi_bo_bbj,
'total_rp_realisasi_keuangan_akumulasi_bo_bs'=>$total_rp_realisasi_keuangan_akumulasi_bo_bs,
'total_rp_realisasi_keuangan_akumulasi_bo_bh'=>$total_rp_realisasi_keuangan_akumulasi_bo_bh,
'total_rp_realisasi_keuangan_akumulasi_bo_bbs'=>$total_rp_realisasi_keuangan_akumulasi_bo_bbs,
'total_rp_realisasi_keuangan_akumulasi_bm_bmt'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmt,
'total_rp_realisasi_keuangan_akumulasi_bm_bmpm'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmpm,
'total_rp_realisasi_keuangan_akumulasi_bm_bmgb'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmgb,
'total_rp_realisasi_keuangan_akumulasi_bm_bmjji'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmjji,
'total_rp_realisasi_keuangan_akumulasi_bm_bmatl'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmatl,
'total_rp_realisasi_keuangan_akumulasi_bm_bmatb'=>$total_rp_realisasi_keuangan_akumulasi_bm_bmatb,
'total_rp_realisasi_keuangan_akumulasi_btt'=>$total_rp_realisasi_keuangan_akumulasi_btt,
'total_rp_realisasi_keuangan_akumulasi_bt_bbh'=>$total_rp_realisasi_keuangan_akumulasi_bt_bbh,
'total_rp_realisasi_keuangan_akumulasi_bt_bbk'=>$total_rp_realisasi_keuangan_akumulasi_bt_bbk,
'total_rp_realisasi_keuangan_bulanan'=>$total_rp_realisasi_keuangan_bulanan,
'total_rp_realisasi_keuangan_bulanan_bo_bp'=>$total_rp_realisasi_keuangan_bulanan_bo_bp,
'total_rp_realisasi_keuangan_bulanan_bo_bbj'=>$total_rp_realisasi_keuangan_bulanan_bo_bbj,
'total_rp_realisasi_keuangan_bulanan_bo_bs'=>$total_rp_realisasi_keuangan_bulanan_bo_bs,
'total_rp_realisasi_keuangan_bulanan_bo_bh'=>$total_rp_realisasi_keuangan_bulanan_bo_bh,
'total_rp_realisasi_keuangan_bulanan_bo_bbs'=>$total_rp_realisasi_keuangan_bulanan_bo_bbs,
'total_rp_realisasi_keuangan_bulanan_bm_bmt'=>$total_rp_realisasi_keuangan_bulanan_bm_bmt,
'total_rp_realisasi_keuangan_bulanan_bm_bmpm'=>$total_rp_realisasi_keuangan_bulanan_bm_bmpm,
'total_rp_realisasi_keuangan_bulanan_bm_bmgb'=>$total_rp_realisasi_keuangan_bulanan_bm_bmgb,
'total_rp_realisasi_keuangan_bulanan_bm_bmjji'=>$total_rp_realisasi_keuangan_bulanan_bm_bmjji,
'total_rp_realisasi_keuangan_bulanan_bm_bmatl'=>$total_rp_realisasi_keuangan_bulanan_bm_bmatl,
'total_rp_realisasi_keuangan_bulanan_bm_bmatb'=>$total_rp_realisasi_keuangan_bulanan_bm_bmatb,
'total_rp_realisasi_keuangan_bulanan_btt'=>$total_rp_realisasi_keuangan_bulanan_btt,
'total_rp_realisasi_keuangan_bulanan_bt_bbh'=>$total_rp_realisasi_keuangan_bulanan_bt_bbh,
'total_rp_realisasi_keuangan_bulanan_bt_bbk'=>$total_rp_realisasi_keuangan_bulanan_bt_bbk,
];

        $output['rekap_deviasi']=$data_rekap_deviasi;
        $output['pencapaian']=$pencapaian;

        // error_reporting(0);
        header('Content-Type: application/json');
        echo json_encode($output);




        // $mpdf->AddPage();

        // $cek_instansi_yang_sudah = $this->db->query("SELECT id_instansi from grafik g
        //  where  g.kode_tahap = '$tahap'
  //                                 and g.tahun = '$tahun'
  //                                 AND g.bulan = {$bulan}
  //                                 ");
        // $kumpul_instansi_sudah = [];
        // foreach ($cek_instansi_yang_sudah->result_array() as $k => $v) {
        //  array_push($kumpul_instansi_sudah, $v['id_instansi']);
        // }

        // $id_instansi_yang_sudah = join(",",$kumpul_instansi_sudah);
        // $instansi_yang_belum = $this->db->query("SELECT nama_instansi from master_instansi where 
        //  is_active=1 
        //  and id_instansi not in ($id_instansi_yang_sudah) ")->result_array();

        // // $mpdf->WriteHTML(json_encode($instansi_yang_belum));
     
    }






	public function laporan_realisasi_semua_opd()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		$bulan 				= $this->input->get('bulan');
		$filter 				= $this->input->get('filter');
		$realisasi 				= $this->input->get('realisasi');
		$tahap 				= $this->input->get('tahap');
		$tahun 				= $this->input->get('tahun');
		$nomenklatur 				= 'baru';//$this->input->get('nomenklatur');
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');

		$kategori 				= $this->input->get('kategori');
		$perhitungan 				= 'Akuntansi';//$this->input->get('perhitungan');
		$cara_hitung = $perhitungan	;

		$identitas = $this->db->get('identitas')->row_array();







		if ($kategori=='Bulanan') {
			$deskripsi_bulan = 'Realisasi bulan '.bulan_global($bulan) . ' ' . tahun_anggaran();
		}else{
	       if ($bulan==date('n') && tahun_anggaran()==date('Y')) {
			   $deskripsi_bulan = 'kondisi realisasi sampai ' . (date('d')). ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
	       }else{
		       $deskripsi_bulan = 'kondisi realisasi sampai ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
	       }
		}
	    

	    $asisten = [
	    	'semua'=>'Semua SKPD',
	    	'204'=>'SKPD lingkup Asisten Pemerintahan Dan Kesra',
	    	'205'=>'SKPD lingkup Asisten Perekonomian Dan Pembangunan',
	    	'206'=>'SKPD lingkup Asisten Administrasi Umum',
	    ];

	    $skpd = $this->ratarata_fisik_keuangan->skpd($filter, $bulan, $realisasi, $nomenklatur, $cara_hitung, $kategori)->result();
	    $skpd_belum_terekap = $this->ratarata_fisik_keuangan->skpd_belum_terekap($filter, $bulan)->result_array();
	    $kelompok = $asisten[$filter];
	
	    $skpd_terurut = [];
	    foreach ($skpd as $k => $v) { 
	    	$dev_fisik =  $v->realisasi_fisik - $v->target_fisik;//$v->deviasi_fisik;
	    	$dev_keuangan = $v->deviasi_keuangan;

	    	if ($dev_fisik <-10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
            }

            if ($dev_keuangan <-10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
            }
            elseif ($dev_keuangan <-5  && $dev_keuangan >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
            }



            if ($kategori=='Akumulasi') {
            	$rp_target_keuangan = $v->rp_target_keuangan_akumulasi;
            	$rp_realisasi_keuangan = $v->rp_realisasi_keuangan_akumulasi;
            	# code...
            }else{
            	$rp_target_keuangan = $v->rp_target_keuangan_bulanan;
            	$rp_realisasi_keuangan = $v->rp_realisasi_keuangan_bulanan;
            }
	    	$data = [
	    		'nama_instansi' => $v->nama_instansi,
	    		'pagu_total' => $v->pagu_total,

	    		// 'pagu_bo' => $v->pagu_bo,
	    		// 'pagu_bm' => $v->pagu_bm,
	    		// 'pagu_btt' => $v->pagu_btt,
	    		// 'pagu_bt' => $v->pagu_bt,

	    		// 'rp_realisasi_keuangan_bo' => $v->rp_realisasi_keuangan_bo,
	    		// 'rp_realisasi_keuangan_bm' => $v->rp_realisasi_keuangan_bm,
	    		// 'rp_realisasi_keuangan_btt' => $v->rp_realisasi_keuangan_btt,
	    		// 'rp_realisasi_keuangan_bt' => $v->rp_realisasi_keuangan_bt,

	    		
	    		'rp_realisasi_keuangan' => $rp_realisasi_keuangan,
	    		'rp_target_keuangan' => $rp_target_keuangan	,
	    		'tf' => $v->target_fisik == '' ? 0 : $v->target_fisik,
	    		'rf' => $v->realisasi_fisik == '' ? 0 : $v->realisasi_fisik,
	    		'df' => $dev_fisik == '' ? 0 : $dev_fisik,
	    		'wf' => $warna_peringatan_dev_fisik,
	    		'tk' => $v->target_keuangan == '' ? 0 : $v->target_keuangan,
	    		'rk' => $v->realisasi_keuangan == '' ? 0 : $v->realisasi_keuangan,
	    		'dk' => $dev_keuangan == '' ? 0 : $dev_keuangan,
	    		'wk' => $warna_peringatan_dev_keu,
	    	];
	    	array_push($skpd_terurut, $data);

	    	// echo $dev_fisik." - ".$warna_peringatan_dev_fisik.'<br>';
	    }



	    if ($realisasi=='fisik') {
	      $caption_realisasi = "Berdasarkan Realisasi Fisik Tertinggi";
	    }
	    elseif ($realisasi=='keu') {
	      $caption_realisasi = "Berdasarkan Realisasi Keuangan Tertinggi";
	    }else{
	      $caption_realisasi = "";

	    }

	     "Laporan ".$kategori." Realisasi Fisik Dan Keuangan Per SKPD ";
	    


	    $judul_file="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan;
	    $data['judul_laporan']= "Laporan ".$kategori." Realisasi Fisik Dan Keuangan <br> ".$kelompok.'<br>'."  ".$deskripsi_bulan." ".$caption_realisasi;
	    $data['kategori']=$kategori;
	    $data['skpd_belum_terekap']=$skpd_belum_terekap;
	    $data['cara_hitung']=$cara_hitung;
	    $data['identitas']=$identitas;
	    $data['skpd']=$skpd_terurut;
	    $data['tahun']=$tahun;
	    $data['kelompok']=$kelompok;
	    $data['periode']=pilihan_nama_tahapan($tahap) .' Tahun '.$tahun;
	    $data['caption_realisasi']=$caption_realisasi;
	    $data['realisasi']=$realisasi;
	  	$tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;
	  

	     if ($kategori_penampilan_laporan=='perengkingan_dengan_deviasi') {
		  	$data['desc_bulan']= $deskripsi_bulan;
	     	$judul_laporan="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan.' '.$kelompok.' '.$caption_realisasi ;
        	$judul_penampilan_laporan = "Penampilan data berdasarkan Sumber Dana, Target, Realisasi, Dan Deviasi";
		    $html =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/content_perengkingan', $data, true);
        	# code...
        }
        elseif ($kategori_penampilan_laporan=='pagu_dan_realisasi_skpd_per_jenis_belanja_bulanan') {
		  	$data['desc_bulan']= "Kondisi Realisasi Bulan ".bulan_global($bulan) . ' ' . tahun_anggaran();
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Penampilan data Pagu dan Realisasi Keuangan berdasarkan kelompok jenis belanja";
		    $html =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/content_skpd_jenis_pelanja', $data, true);
        	# code...
        }
        elseif ($kategori_penampilan_laporan=='pagu_dan_realisasi_skpd_per_jenis_belanja_akumulasi') {
		  	$data['desc_bulan']= "Kondisi Realisasi Sampai Bulan ".bulan_global($bulan) . ' ' . tahun_anggaran();
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Penampilan data Pagu dan Realisasi Keuangan berdasarkan kelompok jenis belanja";
		    $html =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/content_skpd_jenis_pelanja', $data, true);
        	# code...
        }



	    $header =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 38);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}


}
