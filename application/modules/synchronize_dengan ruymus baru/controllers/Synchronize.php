<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Synchronize.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Synchronize extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model([
            'synchronize/target_realisasi_model'     => 'target_realisasi_model',
            'datatables_model'                      => 'datatables_model',

            'Laporan/realisasi_akumulasi_model'     => 'realisasi_akumulasi_model',
        ]);
    }

    public function index()
    {
        $this->target_realisasi();
    }

    public function target_realisasi()
    {
        $breadcrumbs         = $this->breadcrumbs;
        $target_realisasi     = $this->target_realisasi_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Synchronize', base_url($this->router->fetch_class()));
        $breadcrumbs->add('Target dan Realisasi', base_url());
        $breadcrumbs->render();

        $data['title']                        = "Synchronize Target dan Realisasi";
        $data['icon']                       = "metismenu-icon fa fa-crosshairs";
        $data['description']                = "Synchronize Target dan Realisasi";
        $data['breadcrumbs']                = $breadcrumbs->render();
        $page                                 = 'synchronize/target_realisasi/index';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                    = $this->load->view('synchronize/target_realisasi/css', $data, true);
        $data['extra_js']                    = $this->load->view('synchronize/target_realisasi/js', $data, true);
        $data['extra_js2']                    = $this->load->view('dashboard/js', $data, true);
        $data['modal']                      = $this->load->view('synchronize/target_realisasi/modal', $data, true);
        $this->template->load('backend_template', $page, $data);
    }

    public function cek_data($id_instansi){

        $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi, $tahun, $tahap)->row_array();
        echo  json_encode($t_fisik);

    }

    public function sync()
    {
        $class = $this->router->fetch_class();
        $id_instansi        = $this->input->post('id_instansi');
        $kode_tahap        = tahapan_apbd();
        $tahap = $kode_tahap;
        $tahun        = tahun_anggaran();
        $where  =['id_instansi' => $id_instansi,'kode_tahap' => $kode_tahap,'tahun' => $tahun];

        $this->db->delete('grafik', $where);
        $t_anggaran = $this->target_realisasi_model->get_anggaran($id_instansi, $kode_tahap, $tahun);
       
    // 
        $output = [];
        $output['status'] = true;
  


$no_sub_kegiatan =0;

if ($kode_tahap==4) {
	$sub_kegiatan = $this->db->query("SELECT kode_sub_kegiatan, kode_tahap, tahun from sub_kegiatan_instansi where id_instansi='$id_instansi' and tahun='$tahun' and status='1'");
	$pagu_skpd = $this->db->query("SELECT total_anggaran_skpd_perubahan($id_instansi, $tahun) as pagu_skpd")->row_array()['pagu_skpd'];
}else{
	$sub_kegiatan = $this->db->query("SELECT kode_sub_kegiatan, kode_tahap, tahun from sub_kegiatan_instansi where id_instansi='$id_instansi' and tahun='$tahun' and kode_tahap='$tahap'");
	$pagu_skpd = $this->db->query("SELECT total_anggaran_skpd_awal($id_instansi, $tahun) as pagu_skpd")->row_array()['pagu_skpd'];

}

$kumpulkan = [];



for ($bulan=1; $bulan <=12 ; $bulan++) { 
  

$ope_akumulasi = '<=';
$ope_bulanan = '=';
$total_bobot_ski = 0;
$total_tft_ski = 0;
$total_tft_ski_bulanan = 0;
$total_rft_ski = 0;
$total_rft_ski_bulanan = 0;

$total_rp_tk = 0;
$total_rp_rk = 0;

$total_rp_tk_bulanan = 0;
$total_rp_rk_bulanan = 0;
      
$total_pagu_semua = 0;
$total_pagu_bo_bp = 0;
$total_pagu_bo_bbj = 0;
$total_pagu_bo_bs = 0;
$total_pagu_bo_bh = 0;
$total_pagu_bm_bmt = 0;
$total_pagu_bm_bmpm = 0;
$total_pagu_bm_bmgb = 0;
$total_pagu_bm_bmjji = 0;
$total_pagu_bm_bmatl = 0;
$total_pagu_btt = 0;
$total_pagu_bt_bbh = 0;
$total_pagu_bt_bbk = 0;

$total_realisasi_semua = 0;
$total_realisasi_bo_bp = 0;
$total_realisasi_bo_bbj = 0;
$total_realisasi_bo_bs = 0;
$total_realisasi_bo_bh = 0;
$total_realisasi_bm_bmt = 0;
$total_realisasi_bm_bmpm = 0;
$total_realisasi_bm_bmgb = 0;
$total_realisasi_bm_bmjji = 0;
$total_realisasi_bm_bmatl = 0;
$total_realisasi_btt = 0;
$total_realisasi_bt_bbh = 0;
$total_realisasi_bt_bbk = 0;

$total_realisasi_bulanan_semua =0;
$total_realisasi_bulanan_bo_bp =0;
$total_realisasi_bulanan_bo_bbj =0;
$total_realisasi_bulanan_bo_bs =0;
$total_realisasi_bulanan_bo_bh =0;
$total_realisasi_bulanan_bm_bmt =0;
$total_realisasi_bulanan_bm_bmpm =0;
$total_realisasi_bulanan_bm_bmgb =0;
$total_realisasi_bulanan_bm_bmjji =0;
$total_realisasi_bulanan_bm_bmatl =0;
$total_realisasi_bulanan_btt =0;
$total_realisasi_bulanan_bt_bbh =0;
$total_realisasi_bulanan_bt_bbk =0;








 //        echo "Bulan : ".$bulan."<br><table  border=1 width='100%' style='border-collapse: collapse;'>";
 //        echo '
 //        <thead class="header">
   
 //  <tr>
 //    <th>No</th>
 //    <th>Kode Rekening</th>
 //    <th>Pagu</th>
 //    <th>Bobot</th>
 //    <th>TF</th>
 //    <th>TF_ttb</th>
 //    <th>RF</th>
 //    <th>RF_ttb</th>
 //    <th>TK_Rp</th>
 //    <th>TK_%</th>
 //    <th>RK_Rp</th>
 //    <th>RK_%</th>
 //    <th>Pembatas</th>
 //    <th>TF_bulanan</th>
 //    <th>TF_ttb_bulanan</th>
 //    <th>RF_bulanan</th>
 //    <th>RF_ttb_bulanan</th>
 //    <th>TK_Rp_bulanan</th>
 //    <th>TK_%_bulanan</th>
 //    <th>RK_Rp_bulanan</th>
 //    <th>RK_%_bulanan</th>
 //    <th>Pembatas</th>
 //    <th>pagu_bo_bp</th>
 //    <th>pagu_bo_bbj</th>
 //    <th>pagu_bo_bs</th>
 //    <th>pagu_bo_bh</th>
 //    <th>pagu_bm_bmt</th>
 //    <th>pagu_bm_bmpm</th>
 //    <th>pagu_bm_bmgb</th>
 //    <th>pagu_bm_bmjji</th>
 //    <th>pagu_bm_bmatl</th>
 //    <th>pagu_btt</th>
 //    <th>pagu_bt_bbh</th>
 //    <th>pagu_bt_bbk</th>
 //    <th>Pembatas</th>
 //    <th>realisasi_bo_bp</th>
 //    <th>realisasi_bo_bbj</th>
 //    <th>realisasi_bo_bs</th>
 //    <th>realisasi_bo_bh</th>
 //    <th>realisasi_bm_bmt</th>
 //    <th>realisasi_bm_bmpm</th>
 //    <th>realisasi_bm_bmgb</th>
 //    <th>realisasi_bm_bmjji</th>
 //    <th>realisasi_bm_bmatl</th>
 //    <th>realisasi_btt</th>
 //    <th>realisasi_bt_bbh</th>
 //    <th>realisasi_bt_bbk</th>
 //    <th>Pembatas</th>
 //    <th>realisasi_bulanan_bo_bp</th>
 //    <th>realisasi_bulanan_bo_bbj</th>
 //    <th>realisasi_bulanan_bo_bs</th>
 //    <th>realisasi_bulanan_bo_bh</th>
 //    <th>realisasi_bulanan_bm_bmt</th>
 //    <th>realisasi_bulanan_bm_bmpm</th>
 //    <th>realisasi_bulanan_bm_bmgb</th>
 //    <th>realisasi_bulanan_bm_bmjji</th>
 //    <th>realisasi_bulanan_bm_bmatl</th>
 //    <th>realisasi_bulanan_btt</th>
 //    <th>realisasi_bulanan_bt_bbh</th>
 //    <th>realisasi_bulanan_bt_bbk</th>

 //  </tr>

 // </thead>'
 //        ;





        foreach ($sub_kegiatan->result() as $key => $value_sk) {
        	$tahap = $value_sk->kode_tahap;
        $kode_rekening_sub_kegiatan = $value_sk->kode_sub_kegiatan;
        $pagu_ski = $this->db->query(
            "SELECT
               sum(bo_bp + bo_bbj+ bo_bs+bo_bh + bm_bmt + bm_bmpm + bm_bmgb + bm_bmjji + bm_bmatl +btt +  bt_bbh+bt_bbk ) as pagu_total,
                                        sum(bo_bp) as pagu_bo_bp,
                                        sum(bo_bbj) as pagu_bo_bbj,
                                        sum(bo_bs) as pagu_bo_bs,
                                        sum(bo_bh) as pagu_bo_bh,
                                        sum(bm_bmt) as pagu_bm_bmt,
                                        sum(bm_bmpm) as pagu_bm_bmpm,
                                        sum(bm_bmgb) as pagu_bm_bmgb,
                                        sum(bm_bmjji) as pagu_bm_bmjji,
                                        sum(bm_bmatl) as pagu_bm_bmatl,
                                        sum(btt) as pagu_btt,
                                        sum(bt_bbh) as pagu_bt_bbh,
                                        sum(bt_bbk) as pagu_bt_bbk
                                    FROM
                                        anggaran_sub_kegiatan 
                                    WHERE
                                        id_instansi = {$id_instansi} 
                                        AND kode_sub_kegiatan = '{$kode_rekening_sub_kegiatan}'
                                        AND kode_tahap = '$tahap'
                                        AND tahun='$tahun'")->row_array();
            $no_sub_kegiatan ++;


            $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, $value_sk->kode_tahap, $value_sk->tahun)->row_array();
            $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, $ope_akumulasi, $tahun, $tahap)->row_array();
            $realisasi_keuangan_bulanan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, $ope_bulanan, $tahun, $tahap)->row_array();
             $target_keuangan = $target['target_keuangan'];
            $target_fisik = $target['target_fisik'];
            $nilai_persen_target_keuangan = ($target['target_keuangan'] / $pagu_ski['pagu_total']) * 100 ; 


            
            $target_keuangan = $target['target_keuangan'];
            $target_fisik = $target['target_fisik'];
            $nilai_persen_target_keuangan = ($target['target_keuangan'] / $pagu_ski['pagu_total']) * 100 ; 
            $target_fisik_bulanan = $target['target_fisik_bulanan'];
            $target_keuangan_bulanan = $target['target_keuangan_bulanan'];
            $nilai_persen_target_keuangan_bulanan = ($target['target_keuangan_bulanan'] / $pagu_ski['pagu_total']) * 100 ; 

          
            if ($pagu_ski['pagu_total'] == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
          } else {
          $persen_target_keuangan = $nilai_persen_target_keuangan; 
            $persen_realisasi_keuangan  = ($realisasi_keuangan['total_realisasi'] / $pagu_ski['pagu_total']) * 100;
            $persen_realisasi_keuangan_bulanan  = ($realisasi_keuangan_bulanan['total_realisasi'] / $pagu_ski['pagu_total']) * 100;
          }
            


          






        $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_sub_kegiatan, $tahun, $tahap)->num_rows();
          $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
            // realisasi fisik akumulasi
          $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, 'SWAKELOLA', $ope_akumulasi, $tahun, $tahap)->row_array();
          $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, 'PENYEDIA', $ope_akumulasi, $tahun, $tahap)->row_array();
            // realisasi fisik bulanan
        $swa_bulanan = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, 'SWAKELOLA', $ope_bulanan, $tahun, $tahap)->row_array();
          $pen_bulanan = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_sub_kegiatan, $bulan, 'PENYEDIA', $ope_bulanan, $tahun, $tahap)->row_array();





          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=>($ke / $lama_realisasi * 100)
            ];
            array_push($realisasi_rutin_bulan, $push);
            
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              
                $realisasi_rutin_bulanan = (1/$lama_realisasi) *100;
              
                $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
              
            }
          // $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $rut = $jenis_rutin > 0 ? $persen_realisasi_keuangan : 0;


          // $rut_bulanan = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin_bulanan) : 0;
          $rut_bulanan = $jenis_rutin > 0 ? $persen_realisasi_keuangan_bulanan : 0;



           
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;

          // bulanan
          $swa_tot_bulanan  = !empty($swa_bulanan['total']) ? $swa_bulanan['total'] : 0;
          $pen_tot_bulanan  = !empty($pen_bulanan['total']) ? $pen_bulanan['total'] : 0;
          $rut_tot_bulanan  = !empty($rut_bulanan) ? $rut_bulanan : 0;
         

          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
            $total_fisik_bulanan = ($swa_tot_bulanan + $pen_tot_bulanan + $rut_tot_bulanan) / $total_paket;
          } else {
            $total_fisik_bulanan = 0;
            $total_fisik = 0;
          }
          $realisasi_fisik = $total_fisik;
          $realisasi_fisik_bulanan = $total_fisik_bulanan;

          // tertimbang
          $bobot_ski = ($pagu_ski['pagu_total']/$pagu_skpd)*100;
            $tft_ski = $target_fisik * $bobot_ski /100;
            $rft_ski = $realisasi_fisik * $bobot_ski / 100;

            $tft_ski_bulanan = $target_fisik_bulanan * $bobot_ski /100;
            $rft_ski_bulanan = $realisasi_fisik_bulanan * $bobot_ski /100;





            $total_bobot_ski +=$bobot_ski;
            $total_tft_ski +=$tft_ski;
            $total_tft_ski_bulanan +=$tft_ski_bulanan;
            $total_rft_ski_bulanan +=$rft_ski_bulanan;
            $total_rft_ski +=$rft_ski;

            $total_rp_tk +=$target_keuangan;
            $total_rp_rk +=$realisasi_keuangan['total_realisasi'];
            $total_rp_tk_bulanan +=$target_keuangan_bulanan;
            $total_rp_rk_bulanan +=$realisasi_keuangan_bulanan['total_realisasi'];





$total_pagu_semua += $pagu_ski['pagu_total'];
$total_pagu_bo_bp += $pagu_ski['pagu_bo_bp'];
$total_pagu_bo_bbj += $pagu_ski['pagu_bo_bbj'];
$total_pagu_bo_bs += $pagu_ski['pagu_bo_bs'];
$total_pagu_bo_bh += $pagu_ski['pagu_bo_bh'];
$total_pagu_bm_bmt += $pagu_ski['pagu_bm_bmt'];
$total_pagu_bm_bmpm += $pagu_ski['pagu_bm_bmpm'];
$total_pagu_bm_bmgb += $pagu_ski['pagu_bm_bmgb'];
$total_pagu_bm_bmjji += $pagu_ski['pagu_bm_bmjji'];
$total_pagu_bm_bmatl += $pagu_ski['pagu_bm_bmatl'];
$total_pagu_btt += $pagu_ski['pagu_btt'];
$total_pagu_bt_bbh += $pagu_ski['pagu_bt_bbh'];
$total_pagu_bt_bbk += $pagu_ski['pagu_bt_bbk'];

$total_realisasi_semua += $realisasi_keuangan['total_realisasi'];
$total_realisasi_bo_bp += $realisasi_keuangan['realisasi_bo_bp'];
$total_realisasi_bo_bbj += $realisasi_keuangan['realisasi_bo_bbj'];
$total_realisasi_bo_bs += $realisasi_keuangan['realisasi_bo_bs'];
$total_realisasi_bo_bh += $realisasi_keuangan['realisasi_bo_bh'];
$total_realisasi_bm_bmt += $realisasi_keuangan['realisasi_bm_bmt'];
$total_realisasi_bm_bmpm += $realisasi_keuangan['realisasi_bm_bmpm'];
$total_realisasi_bm_bmgb += $realisasi_keuangan['realisasi_bm_bmgb'];
$total_realisasi_bm_bmjji += $realisasi_keuangan['realisasi_bm_bmjji'];
$total_realisasi_bm_bmatl += $realisasi_keuangan['realisasi_bm_bmatl'];
$total_realisasi_btt += $realisasi_keuangan['realisasi_btt'];
$total_realisasi_bt_bbh += $realisasi_keuangan['realisasi_bt_bbh'];
$total_realisasi_bt_bbk += $realisasi_keuangan['realisasi_bt_bbk'];

$total_realisasi_bulanan_semua += $realisasi_keuangan_bulanan['total_realisasi'];
$total_realisasi_bulanan_bo_bp += $realisasi_keuangan_bulanan['realisasi_bo_bp'];
$total_realisasi_bulanan_bo_bbj += $realisasi_keuangan_bulanan['realisasi_bo_bbj'];
$total_realisasi_bulanan_bo_bs += $realisasi_keuangan_bulanan['realisasi_bo_bs'];
$total_realisasi_bulanan_bo_bh += $realisasi_keuangan_bulanan['realisasi_bo_bh'];
$total_realisasi_bulanan_bm_bmt += $realisasi_keuangan_bulanan['realisasi_bm_bmt'];
$total_realisasi_bulanan_bm_bmpm += $realisasi_keuangan_bulanan['realisasi_bm_bmpm'];
$total_realisasi_bulanan_bm_bmgb += $realisasi_keuangan_bulanan['realisasi_bm_bmgb'];
$total_realisasi_bulanan_bm_bmjji += $realisasi_keuangan_bulanan['realisasi_bm_bmjji'];
$total_realisasi_bulanan_bm_bmatl += $realisasi_keuangan_bulanan['realisasi_bm_bmatl'];
$total_realisasi_bulanan_btt += $realisasi_keuangan_bulanan['realisasi_btt'];
$total_realisasi_bulanan_bt_bbh += $realisasi_keuangan_bulanan['realisasi_bt_bbh'];
$total_realisasi_bulanan_bt_bbk += $realisasi_keuangan_bulanan['realisasi_bt_bbk'];




            // echo "
            //  <tr>
            //     <td>".$no_sub_kegiatan."</td>
            //     <td>".$value_sk->kode_sub_kegiatan."</td>
            //     <td>".$pagu_ski['pagu_total']."</td>
            //     <td>".$bobot_ski."</td>
            //     <td>".$target_fisik."</td>
            //     <td>".$tft_ski."</td>
            //     <td>".$realisasi_fisik."</td>
            //     <td>".$rft_ski."</td>
            //     <td>".$target_keuangan."</td>
            //     <td>".$nilai_persen_target_keuangan."</td>
            //     <td>".$realisasi_keuangan['total_realisasi']."</td>
            //     <td>".$persen_realisasi_keuangan."</td>
            //     <td> -- </td>
            //     <td>".$target_fisik_bulanan."</td>
            //     <td>".$tft_ski_bulanan."</td>
            //     <td style='background:red'> ".$realisasi_fisik_bulanan." </td>
            //     <td style='background:red'> ".$rft_ski_bulanan." </td>
            //     <td>".$target_keuangan_bulanan."</td>
            //     <td>".$nilai_persen_target_keuangan_bulanan."</td>
            //     <td>".$realisasi_keuangan_bulanan['total_realisasi']."</td>
            //     <td>".$persen_realisasi_keuangan_bulanan."</td>
            //     <td> -- </td>
            //     <td>".$pagu_ski['pagu_bo_bp']."</td>
            //     <td>".$pagu_ski['pagu_bo_bbj']."</td>
            //     <td>".$pagu_ski['pagu_bo_bs']."</td>
            //     <td>".$pagu_ski['pagu_bo_bh']."</td>
            //     <td>".$pagu_ski['pagu_bm_bmt']."</td>
            //     <td>".$pagu_ski['pagu_bm_bmpm']."</td>
            //     <td>".$pagu_ski['pagu_bm_bmgb']."</td>
            //     <td>".$pagu_ski['pagu_bm_bmjji']."</td>
            //     <td>".$pagu_ski['pagu_bm_bmatl']."</td>
            //     <td>".$pagu_ski['pagu_btt']."</td>
            //     <td>".$pagu_ski['pagu_bt_bbh']."</td>
            //     <td>".$pagu_ski['pagu_bt_bbk']."</td>
            //     <td> -- </td>
            //     <td>".$realisasi_keuangan['realisasi_bo_bp']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bo_bbj']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bo_bs']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bo_bh']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bm_bmt']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bm_bmpm']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bm_bmgb']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bm_bmjji']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bm_bmatl']."</td>
            //     <td>".$realisasi_keuangan['realisasi_btt']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bt_bbh']."</td>
            //     <td>".$realisasi_keuangan['realisasi_bt_bbk']."</td>
            //     <td> -- </td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bo_bp']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bo_bbj']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bo_bs']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bo_bh']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bm_bmt']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bm_bmpm']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bm_bmgb']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bm_bmjji']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bm_bmatl']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_btt']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bt_bbh']."</td>
            //     <td>".$realisasi_keuangan_bulanan['realisasi_bt_bbk']."</td>
              
            //   </tr>

            // ";
        }


            $persen_total_tk = ($total_rp_tk / $pagu_skpd)*100;
            $persen_total_rk = ($total_rp_rk / $pagu_skpd)*100;
            $persen_total_tk_bulanan = ($total_rp_tk_bulanan / $pagu_skpd)*100;
            $persen_total_rk_bulanan = ($total_rp_rk_bulanan / $pagu_skpd)*100;

            $tf_pencapaian = $total_bobot_ski*$total_tft_ski/100;
        $rf_pencapaian = $total_bobot_ski*$total_rft_ski/100;

            // echo "
            //  <tr style='background:grey'>
               
            //     <td colspan=2 >Total</td>
            //     <td style='background:aqua'>".$pagu_skpd."</td>
            //     <td>".$total_bobot_ski."</td>
            //     <td> -- </td>
            //     <td style='background:pink'>".$total_tft_ski."</td>
            //     <td> -- </td>
            //     <td style='background:pink'>".$total_rft_ski."</td>
              
            //     <td style='background:pink'>".$total_rp_tk."</td>
            //     <td style='background:pink'>".$persen_total_tk."</td>
            //     <td style='background:pink'>".$total_rp_rk."</td>
            //     <td style='background:pink'>".$persen_total_rk."</td>
            //     <td></td>
            //     <td></td>
            //     <td style='background:pink'>".$total_tft_ski_bulanan."</td>
            //     <td></td>
            //     <td style='background:pink'>".$total_rft_ski_bulanan."</td>
            //     <td style='background:pink'>".$total_rp_tk_bulanan."</td>
            //     <td style='background:pink'>".$persen_total_tk_bulanan."</td>
            //     <td style='background:pink'>".$total_rp_rk_bulanan."</td>
            //     <td style='background:pink'>".$persen_total_rk_bulanan."</td>
            //     <td></td>
            //     <td style='background:pink'>".$total_pagu_bo_bp."</td>
            //     <td style='background:pink'>".$total_pagu_bo_bbj."</td>
            //     <td style='background:pink'>".$total_pagu_bo_bs."</td>
            //     <td style='background:pink'>".$total_pagu_bo_bh."</td>
            //     <td style='background:pink'>".$total_pagu_bm_bmt."</td>
            //     <td style='background:pink'>".$total_pagu_bm_bmpm."</td>
            //     <td style='background:pink'>".$total_pagu_bm_bmgb."</td>
            //     <td style='background:pink'>".$total_pagu_bm_bmjji."</td>
            //     <td style='background:pink'>".$total_pagu_bm_bmatl."</td>
            //     <td style='background:pink'>".$total_pagu_btt."</td>
            //     <td style='background:pink'>".$total_pagu_bt_bbh."</td>
            //     <td style='background:pink'>".$total_pagu_bt_bbk."</td>
            //     <td></td>
            //     <td style='background:pink'>".$total_realisasi_bo_bp."</td>
            //     <td style='background:pink'>".$total_realisasi_bo_bbj."</td>
            //     <td style='background:pink'>".$total_realisasi_bo_bs."</td>
            //     <td style='background:pink'>".$total_realisasi_bo_bh."</td>
            //     <td style='background:pink'>".$total_realisasi_bm_bmt."</td>
            //     <td style='background:pink'>".$total_realisasi_bm_bmpm."</td>
            //     <td style='background:pink'>".$total_realisasi_bm_bmgb."</td>
            //     <td style='background:pink'>".$total_realisasi_bm_bmjji."</td>
            //     <td style='background:pink'>".$total_realisasi_bm_bmatl."</td>
            //     <td style='background:pink'>".$total_realisasi_btt."</td>
            //     <td style='background:pink'>".$total_realisasi_bt_bbh."</td>
            //     <td style='background:pink'>".$total_realisasi_bt_bbk."</td>
            //     <td></td>

            //     <td style='background:pink'>".$total_realisasi_bulanan_bo_bp."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bo_bbj."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bo_bs."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bo_bh."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bm_bmt."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bm_bmpm."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bm_bmgb."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bm_bmjji."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bm_bmatl."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_btt."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bt_bbh."</td>
            //     <td style='background:pink'>".$total_realisasi_bulanan_bt_bbk."</td>
            //   </tr>
            // ";

          // echo "
          //    <tr>
               
          //       <td colspan=4>Pencapaian</td>
          //       <td></td>
          //       <td></td>
          //       <td colspan=2>".$tf_pencapaian."</td>
          //       <td colspan=2>".$rf_pencapaian."</td>
              
          //       <td></td>
          //       <td></td>
          //       <td></td>
          //       <td></td>
          //       <td></td>
            
          //       <td></td>
          //     </tr>
          //   ";
        // echo "</table><hr>";

        $persen_tf_skpd = $total_tft_ski;
        $persen_tf_skpd_bulanan = $total_rft_ski_bulanan;
        $persen_rf_skpd = $total_rft_ski;
        $persen_rf_skpd_bulanan = $total_rft_ski_bulanan;



        $data_insert = [
            'id_instansi'=>$id_instansi,
            'bulan'=>$bulan,
            'kode_tahap'=>$tahap,
            'tahun'=>$tahun,
            'target_fisik_akumulasi'=>round($persen_tf_skpd,2),
            // 'target_fisik_akumulasi_ratarata'=>'',
            'target_fisik_bulanan'=>round($persen_tf_skpd_bulanan,2),
            // 'target_fisik_bulanan_ratarata'=>'',
            'realisasi_fisik_akumulasi'=>round($persen_rf_skpd,2),
            // 'realisasi_fisik_akumulasi_ratarata'=>'',
            'realisasi_fisik_bulanan'=>round($persen_rf_skpd_bulanan,2),

            



            // 'realisasi_fisik_bulanan_ratarata'=>'',
            'target_keuangan_akumulasi'=>round($persen_total_tk,2),
            // 'target_keuangan_akumulasi_ratarata'=>'',
            'target_keuangan_bulanan'=>round($persen_total_tk_bulanan,2),
            // 'target_keuangan_bulanan_ratarata'=>'',
            'realisasi_keuangan_akumulasi'=>round($persen_total_rk,2),
            // 'realisasi_keuangan_akumulasi_ratarata'=>'',
            'realisasi_keuangan_bulanan'=>round($persen_total_rk_bulanan,2),
            // 'realisasi_keuangan_bulanan_ratarata'=>'',


            'pagu_bo_bp'=>$total_pagu_bo_bp,
            'pagu_bo_bbj'=>$total_pagu_bo_bbj,
            'pagu_bo_bs'=>$total_pagu_bo_bs,
            'pagu_bo_bh'=>$total_pagu_bo_bh,
            // 'pagu_bo_bbs'=>'',
            'pagu_bm_bmt'=>$total_pagu_bm_bmt,
            'pagu_bm_bmpm'=>$total_pagu_bm_bmpm,
            'pagu_bm_bmgb'=>$total_pagu_bm_bmgb,
            'pagu_bm_bmjji'=>$total_pagu_bm_bmjji,
            'pagu_bm_bmatl'=>$total_pagu_bm_bmatl,
            // 'pagu_bm_bmatb'=>'',
            'pagu_btt'=>$total_pagu_btt,
            'pagu_bt_bbh'=>$total_pagu_bt_bbh,
            'pagu_bt_bbk'=>$total_pagu_bt_bbk,
            'pagu_total'=>$pagu_skpd,


            'rp_target_keuangan_akumulasi'=>$total_rp_tk,
            'rp_target_keuangan_bulanan'=>$total_rp_tk_bulanan,


            'rp_realisasi_keuangan_akumulasi'=>$total_rp_rk,
            'rp_realisasi_keuangan_akumulasi_bo_bp'=>$total_realisasi_bo_bp,
            'rp_realisasi_keuangan_akumulasi_bo_bbj'=>$total_realisasi_bo_bbj,
            'rp_realisasi_keuangan_akumulasi_bo_bs'=>$total_realisasi_bo_bs,
            'rp_realisasi_keuangan_akumulasi_bo_bh'=>$total_realisasi_bo_bh,
            // 'rp_realisasi_keuangan_akumulasi_bo_bbs'=>'',
            'rp_realisasi_keuangan_akumulasi_bm_bmt'=>$total_realisasi_bm_bmt,
            'rp_realisasi_keuangan_akumulasi_bm_bmpm'=>$total_realisasi_bm_bmpm,
            'rp_realisasi_keuangan_akumulasi_bm_bmgb'=>$total_realisasi_bm_bmgb,
            'rp_realisasi_keuangan_akumulasi_bm_bmjji'=>$total_realisasi_bm_bmjji,
            'rp_realisasi_keuangan_akumulasi_bm_bmatl'=>$total_realisasi_bm_bmatl,
            // 'rp_realisasi_keuangan_akumulasi_bm_bmatb'=>'',
            'rp_realisasi_keuangan_akumulasi_btt'=>$total_realisasi_btt,
            'rp_realisasi_keuangan_akumulasi_bt_bbh'=>$total_realisasi_bt_bbh,
            'rp_realisasi_keuangan_akumulasi_bt_bbk'=>$total_realisasi_bt_bbk,


            'rp_realisasi_keuangan_bulanan'=>$total_rp_rk_bulanan,
            'rp_realisasi_keuangan_bulanan_bo_bp'=>$total_realisasi_bulanan_bo_bp,
            'rp_realisasi_keuangan_bulanan_bo_bbj'=>$total_realisasi_bulanan_bo_bbj,
            'rp_realisasi_keuangan_bulanan_bo_bs'=>$total_realisasi_bulanan_bo_bs,
            'rp_realisasi_keuangan_bulanan_bo_bh'=>$total_realisasi_bulanan_bo_bh,
            // 'rp_realisasi_keuangan_bulanan_bo_bbs'=>'',
            'rp_realisasi_keuangan_bulanan_bm_bmt'=>$total_realisasi_bulanan_bm_bmt,
            'rp_realisasi_keuangan_bulanan_bm_bmpm'=>$total_realisasi_bulanan_bm_bmpm,
            'rp_realisasi_keuangan_bulanan_bm_bmgb'=>$total_realisasi_bulanan_bm_bmgb,
            'rp_realisasi_keuangan_bulanan_bm_bmjji'=>$total_realisasi_bulanan_bm_bmjji,
            'rp_realisasi_keuangan_bulanan_bm_bmatl'=>$total_realisasi_bulanan_bm_bmatl,
            // 'rp_realisasi_keuangan_bulanan_bm_bmatb'=>'',
            'rp_realisasi_keuangan_bulanan_btt'=>$total_realisasi_bulanan_btt,
            'rp_realisasi_keuangan_bulanan_bt_bbh'=>$total_realisasi_bulanan_bt_bbh,
            'rp_realisasi_keuangan_bulanan_bt_bbk'=>$total_realisasi_bulanan_bt_bbk,
            'last_update '=>'',
        ];

        array_push($kumpulkan, $data_insert);
        } // end for bulan

    // var_dump($kumpulkan);

        $result = $this->db->insert_batch('grafik', $kumpulkan);
        echo json_encode($output);






        


        // echo json_encode($output);
    }


    public function realisasi_fisik($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);
        $ope = '<=';
        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;
			foreach ($kegiatan as $key => $value_sk) {
		    	$total_sub_kegiatan +=1;
				$no_sub_kegiatan++;   
				$nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
				$total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
				$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
				$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
				$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();
                $bulan = $a;
                $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)->row_array();
                $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);



				$bulan_mulai = mulai_realisasi_instansi($id_instansi);
				$bulan_akhir = akhir_realisasi_instansi($id_instansi);
				$lama_realisasi = $bulan_akhir - $bulan_mulai +1;
				$realisasi_rutin_bulan = [];
				$ke = 0;
	          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
	            $ke++;
	            $bulan_realisasi = $bulan_mulai + $i;
	            $push = [
	               $i=> ($ke / $lama_realisasi) * 100
	            ];
	            array_push($realisasi_rutin_bulan, $push);
	          }
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }
          // $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $rut = $jenis_rutin > 0 ? $persen_realisasi_keuangan : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }
          $total_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
      $total_fisik_semua +=$total_fisik;
       
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)



        @$ratarata_realisasi_fisik = $total_fisik_semua / $total_sub_kegiatan;
 
		array_push($realisasi_fisik, round($ratarata_realisasi_fisik,2));
		}

		// echo json_encode($realisasi_fisik);
		return $realisasi_fisik;
                
}

  
    public function realisasi_fisik_bulanan($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];
        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);
        $ope = '=';
        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;
			foreach ($kegiatan as $key => $value_sk) {
		    	$total_sub_kegiatan +=1;
				$no_sub_kegiatan++;   
				$nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
				$total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $tahun, $tahap)->num_rows();
				$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN", $tahun, $tahap)->num_rows();
				$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
				$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();
				$bulan_mulai = mulai_realisasi_instansi($id_instansi);
				$bulan_akhir = akhir_realisasi_instansi($id_instansi);
				$lama_realisasi = $bulan_akhir - $bulan_mulai +1;
				$realisasi_rutin_bulan = [];
				$ke = 0;
	          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
	            $ke++;
	            $bulan_realisasi = $bulan_mulai + $i;
	            $push = [
	              $i=> ($ke / $lama_realisasi) * 100
	            ];
	            array_push($realisasi_rutin_bulan, $push);
	          }
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
               $realisasi_rutin = (1/$lama_realisasi) *100; ;//$realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }
          $rut = $jenis_rutin > 0 ? ($jenis_rutin * $realisasi_rutin) : 0;
          $swa_tot  = !empty($swa['total']) ? $swa['total'] : 0;
          $pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
          $rut_tot  = !empty($rut) ? $rut : 0;
          if ($total_paket != 0) {
            $total_fisik = ($swa_tot + $pen_tot + $rut_tot) / $total_paket;
          } else {
            $total_fisik = 0;
          }
          $total_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
      $total_fisik_semua +=$total_fisik;
       
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)



        @$ratarata_realisasi_fisik = $total_fisik_semua / $total_sub_kegiatan;
 
		array_push($realisasi_fisik, round($ratarata_realisasi_fisik,2));
		}

// echo json_encode($realisasi_fisik);
return $realisasi_fisik;
                
}


    // public function realisasi_fisik($id_instansi)
    // {
    //     $realisasi_fisik = [];
    //     $total_fisik_bulan = [];

    //     // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
    //     $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi);
      
    //     $no = 1;
    //     $tampung_kegiatan_berpagu = [];
    //     foreach ($kegiatan as $key => $value) {
    //             if ($value->pagu >0) {
    //                 $satu = 1;
    //             }else{
    //                 $satu = 0;
    //             }

    //             array_push($tampung_kegiatan_berpagu, $satu);


    //         $total_paket    = $this->target_realisasi_model->total_paket($id_instansi, $value->kode_rekening_sub_kegiatan)->num_rows();
    //         $jenis_swakelola    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'SWAKELOLA')->num_rows();
    //         $jenis_penyedia    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'PENYEDIA')->num_rows();
    //         $jenis_rutin    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'RUTIN')->num_rows();
	 
           
 
		  //       // echo "<pre>".print_r($swakelola)."</pre>";
    //         for ($i = 1; $i <= 12; $i++) {

    //             $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->row()->total;
    //             $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->row()->total;


    //             //  if ($value->pagu > 0 ) {
    //             //     $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
    //             // }else{
    //             //     $rutin          = 0;//$jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
    //             // }
    //                 $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
                    

             

    //             $total_fisik_perkegiatan = ($swakelola + $penyedia + $rutin); 
    //             @$ratarata_fisik = $total_fisik_perkegiatan / $total_paket;
        		




    //             if ($swakelola + $penyedia + $rutin == 0) {
    //                 $total_fisik = 0;
    //             } else {
    //             	if ($total_paket==0) {
	   //                  $total_fisik = 0;
    //             	}else{
	   //                 $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
    //             	}
    //             }
    //             $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

    //             $total_fisik_bulan[$i][] = $total_fisik;
    //         }
    //     }



    //     if (empty($total_fisik_bulan)) :
    //         $fisik_array[] = 0;
    //     else :
    //         for ($i = 1; $i <= 12; $i++) {
    //             $fisik_array[] = ROUND(array_sum($total_fisik_bulan[$i]) / count($tampung_kegiatan_berpagu), 2);
    //         }
    //     endif;


    //     $realisasi_fisik[] = (!empty($fisik_array[0]) and $fisik_array[0] > 0) ? $fisik_array[0] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[1]) and $fisik_array[1] > 0) ? $fisik_array[1] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[2]) and $fisik_array[2] > 0) ? $fisik_array[2] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[3]) and $fisik_array[3] > 0) ? $fisik_array[3] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[4]) and $fisik_array[4] > 0) ? $fisik_array[4] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[5]) and $fisik_array[5] > 0) ? $fisik_array[5] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[6]) and $fisik_array[6] > 0) ? $fisik_array[6] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[7]) and $fisik_array[7] > 0) ? $fisik_array[7] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[8]) and $fisik_array[8] > 0) ? $fisik_array[8] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[9]) and $fisik_array[9] > 0) ? $fisik_array[9] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[10]) and $fisik_array[10] > 0) ? $fisik_array[10] : 0;
    //     $realisasi_fisik[] = (!empty($fisik_array[11]) and $fisik_array[11] > 0) ? $fisik_array[11] : 0;
    //     return $realisasi_fisik;
    // }





    public function realisasi_keuangan_ratarata($id_instansi)
    {
        $data_realisasi_keuangan_ratarata_akumulasi = [];
        $data_realisasi_keuangan_ratarata_bulanan = [];
        $total_fisik_bulan = [];

        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
      
        $no = 1;
        $tampung_kegiatan_berpagu = [];

         // $bulan = 4;
        $tahun = tahun_anggaran();
        $tahap = tahapan_apbd();
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi, $tahun, $tahap);



        for ($a=1; $a <=12 ; $a++) { 
        	$bulan = $a;
      
            

            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_fisik_semua =0;


            // echo "<table border = 1>
            // <tr>
	           //  <td colspan='5'>".bulan_global($bulan)."</td>
            // </tr>
            // <tr>
	           //  <td>No</td>
	           //  <td>Sub KEgiatan</td>
	           //  <td>Pagu</td>
	           //  <td>Realisasi Akumulasi</td>
	           //  <td>Realisasi Bulanan</td>
	           //  <td>% Akumulasi</td>
	           //  <td>% Bulanan</td>
            // </tr>
            // ";


            $no_sub_kegiatan = 0;
            $total_sub_kegiatan = 0;
            $total_realisasi_keuangan_akumulasi_semua =0;
            $total_realisasi_keuangan_bulanan_semua =0;


             foreach ($kegiatan as $key => $value_sk) {
      $total_sub_kegiatan +=1;
      $no_sub_kegiatan++;   
            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
            $pagu = $value_sk->pagu;

             $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, "<=", $tahun, $tahap)->row_array();
             $realisasi_keuangan_bulanan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, "=", $tahun, $tahap)->row_array();

      		$total_realisasi_akumulasi = $realisasi_keuangan['total_realisasi'] ; 
      		$total_realisasi_bulanan = $realisasi_keuangan_bulanan['total_realisasi'] ; 


      		if ($pagu==0) {
      			
	      		@$persen_akumulasi = 0 ; 
	      		@$persen_bulanan = 0 ; 
      		}else{
	      		@$persen_akumulasi = ($total_realisasi_akumulasi / $pagu) * 100 ; 
	      		@$persen_bulanan = ($total_realisasi_bulanan / $pagu) * 100 ; 
      		}

      		$total_realisasi_keuangan_akumulasi_semua += $persen_akumulasi ; 
      		$total_realisasi_keuangan_bulanan_semua += $persen_bulanan ; 
      			// echo "<tr>
	      		// 	<td>".$no_sub_kegiatan."</td>
	      		// 	<td>".$nama_sub_kegiatan."</td>
	      		// 	<td>".number_format($pagu)."</td>
	      			
	      		// 	<td>".number_format($realisasi_keuangan['total_realisasi'])."</td>
	      		// 	<td>".number_format($realisasi_keuangan_bulanan['total_realisasi'])."</td>
	      		// 	<td>".round($persen_akumulasi,2)."</td>
	      		// 	<td>".round($persen_bulanan,2)."</td>
	      		// 	</tr>
      			// ";
        } //akhir foreach ($sub_kegiatan as $key => $value_sk)

        @$ratarata_akumulasi = $total_realisasi_keuangan_akumulasi_semua / $total_sub_kegiatan;
        @$ratarata_bulanan = $total_realisasi_keuangan_bulanan_semua / $total_sub_kegiatan;

        // echo "<tr>
	      	// 		<td colspan=5>Total</td>
	      			
	      	// 		<td> ".round($total_realisasi_keuangan_akumulasi_semua,2)." </td>
	      	// 		<td> ".round($total_realisasi_keuangan_bulanan_semua,2)." </td>
	      	// 		</tr>
      		// 	";
        // echo "<tr>
	      	// 		<td colspan=5>Ratarata</td>
	      			
	      	// 		<td> ".round($ratarata_akumulasi,2)." </td>
	      	// 		<td> ".round($ratarata_bulanan,2)." </td>
	      	// 		</tr>
      		// 	";

     
?>

<?php
array_push($data_realisasi_keuangan_ratarata_akumulasi, round($ratarata_akumulasi,2));
array_push($data_realisasi_keuangan_ratarata_bulanan, round($ratarata_bulanan,2));
}

// echo "</table>";

$kumpul_realisasi_keuangan_ratarata = [];
array_push($kumpul_realisasi_keuangan_ratarata, $data_realisasi_keuangan_ratarata_akumulasi);
array_push($kumpul_realisasi_keuangan_ratarata, $data_realisasi_keuangan_ratarata_bulanan);
// echo json_encode($kumpul_realisasi_keuangan_ratarata);

// header('Content-Type: application/json');
// echo json_encode($data_realisasi_keuangan_ratarata_bulanan);
return $kumpul_realisasi_keuangan_ratarata;
                
}




    public function update_bulan()
    {
        $output = [
            'data' => []
        ];

        $realisasi = $this->db->get('realisasi_fisik');

        foreach ($realisasi->result() as $key => $value) {
            $this->db->update('realisasi_fisik', ['bulan' => date('n', $value->updated_on)], ['id_realisasi_fisik' => $value->id_realisasi_fisik]);
        }

        echo json_encode($output);
    }

    public function rutin($bulan, $id_instansi)
    {
        

          $bulan_mulai = mulai_realisasi_instansi($id_instansi);
          $bulan_akhir = akhir_realisasi_instansi($id_instansi);
          $lama_realisasi = $bulan_akhir - $bulan_mulai +1;

          $realisasi_rutin_bulan = [];
          $ke = 0;
          for ($i=$bulan_mulai; $i <= $bulan_akhir ; $i++) { 
            $ke++;
            $bulan_realisasi = $bulan_mulai + $i;



            $push = [
              $i=> round($ke / $lama_realisasi * 100, 2)
            ];
            array_push($realisasi_rutin_bulan, $push);
            
          }
          
              $selisih_bulan = $bulan - $bulan_mulai;
            if ($bulan<$bulan_mulai) {
                $realisasi_rutin = 0;
            }
            elseif ($bulan>$bulan_akhir) {
                $realisasi_rutin = 100;
            }else{
              $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
            }




        return $realisasi_rutin;
    }
}
