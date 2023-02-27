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
        $this->load->model([
            'synchronize/target_realisasi_model'     => 'target_realisasi_model',
            'datatables_model'                      => 'datatables_model'
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

    public function sync()
    {
        $id_instansi        = $this->input->post('id_instansi');
        $tahap = tahapan_apbd();
        $tahun_anggaran = tahun_anggaran();
        $this->db->delete('grafik', ['id_instansi' => $id_instansi]);
        $t_anggaran         = $this->target_realisasi_model->get_anggaran($id_instansi);
        $target_fisik       = [];
        $target_keu         = [];
        $realisasi_fisik    = [];
        $realisasi_keuangan = [];

        $t_fisik_jan = 0;
        $t_fisik_feb = 0;
        $t_fisik_mar = 0;
        $t_fisik_apr = 0;
        $t_fisik_mei = 0;
        $t_fisik_jun = 0;
        $t_fisik_jul = 0;
        $t_fisik_agu = 0;
        $t_fisik_sep = 0;
        $t_fisik_okt = 0;
        $t_fisik_nov = 0;
        $t_fisik_des = 0;

        $t_keu_jan   = 0;
        $t_keu_feb   = 0;
        $t_keu_mar   = 0;
        $t_keu_apr   = 0;
        $t_keu_mei   = 0;
        $t_keu_jun   = 0;
        $t_keu_jul   = 0;
        $t_keu_agu   = 0;
        $t_keu_sep   = 0;
        $t_keu_okt   = 0;
        $t_keu_nov   = 0;
        $t_keu_des   = 0;

        $r_jan     = 0;
        $r_feb  = 0;
        $r_mar  = 0;
        $r_apr  = 0;
        $r_mei  = 0;
        $r_jun  = 0;
        $r_jul  = 0;
        $r_agu  = 0;
        $r_sep  = 0;
        $r_okt  = 0;
        $r_nov  = 0;
        $r_des  = 0;

        $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi);
        foreach ($t_fisik->result() as $key => $value) {
            $t_fisik_jan += $value->jan;
            $t_fisik_feb += $value->feb;
            $t_fisik_mar += $value->mar;
            $t_fisik_apr += $value->apr;
            $t_fisik_mei += $value->mei;
            $t_fisik_jun += $value->jun;
            $t_fisik_jul += $value->jul;
            $t_fisik_agu += $value->agu;
            $t_fisik_sep += $value->sep;
            $t_fisik_okt += $value->okt;
            $t_fisik_nov += $value->nov;
            $t_fisik_des += $value->des;
        }

        $t_keuangan = $this->target_realisasi_model->get_target_keuangan($id_instansi);

        foreach ($t_keuangan->result() as $key => $value) {
            $t_keu_jan   += ($value->jan / $t_anggaran) * 100;
            $t_keu_feb   += ($value->feb / $t_anggaran) * 100;
            $t_keu_mar   += ($value->mar / $t_anggaran) * 100;
            $t_keu_apr   += ($value->apr / $t_anggaran) * 100;
            $t_keu_mei   += ($value->mei / $t_anggaran) * 100;
            $t_keu_jun   += ($value->jun / $t_anggaran) * 100;
            $t_keu_jul   += ($value->jul / $t_anggaran) * 100;
            $t_keu_agu   += ($value->agu / $t_anggaran) * 100;
            $t_keu_sep   += ($value->sep / $t_anggaran) * 100;
            $t_keu_okt   += ($value->okt / $t_anggaran) * 100;
            $t_keu_nov   += ($value->nov / $t_anggaran) * 100;
            $t_keu_des   += ($value->des / $t_anggaran) * 100;
        }

        $r_keuangan = $this->target_realisasi_model->get_realisasi_keuangan($id_instansi);
        foreach ($r_keuangan->result() as $key => $value) {
            $r_jan  += (($value->jan / $t_anggaran) * 100);
            $r_feb  += (($value->feb / $t_anggaran) * 100);
            $r_mar  += (($value->mar / $t_anggaran) * 100);
            $r_apr  += (($value->apr / $t_anggaran) * 100);
            $r_mei  += (($value->mei / $t_anggaran) * 100);
            $r_jun  += (($value->jun / $t_anggaran) * 100);
            $r_jul  += (($value->jul / $t_anggaran) * 100);
            $r_agu  += (($value->agu / $t_anggaran) * 100);
            $r_sep  += (($value->sep / $t_anggaran) * 100);
            $r_okt  += (($value->okt / $t_anggaran) * 100);
            $r_nov  += (($value->nov / $t_anggaran) * 100);
            $r_des  += (($value->des / $t_anggaran) * 100);
        }

        $target_fisik[] = $t_fisik_jan >100 ? 100 : $t_fisik_jan;
        $target_fisik[] = $t_fisik_feb >100 ? 100 : $t_fisik_feb;
        $target_fisik[] = $t_fisik_mar >100 ? 100 : $t_fisik_mar;
        $target_fisik[] = $t_fisik_apr >100 ? 100 : $t_fisik_apr;
        $target_fisik[] = $t_fisik_mei >100 ? 100 : $t_fisik_mei;
        $target_fisik[] = $t_fisik_jun >100 ? 100 : $t_fisik_jun;
        $target_fisik[] = $t_fisik_jul >100 ? 100 : $t_fisik_jul;
        $target_fisik[] = $t_fisik_agu >100 ? 100 : $t_fisik_agu;
        $target_fisik[] = $t_fisik_sep >100 ? 100 : $t_fisik_sep;
        $target_fisik[] = $t_fisik_okt >100 ? 100 : $t_fisik_okt;
        $target_fisik[] = $t_fisik_nov >100 ? 100 : $t_fisik_nov;
        $target_fisik[] = $t_fisik_des >100 ? 100 : $t_fisik_des;

         $target_keuangan[] = $t_keu_jan>100 ? 100 : $t_keu_jan;
        $target_keuangan[] = $t_keu_feb>100 ? 100 : $t_keu_feb;
        $target_keuangan[] = $t_keu_mar>100 ? 100 : $t_keu_mar;
        $target_keuangan[] = $t_keu_apr>100 ? 100 : $t_keu_apr;
        $target_keuangan[] = $t_keu_mei>100 ? 100 : $t_keu_mei;
        $target_keuangan[] = $t_keu_jun>100 ? 100 : $t_keu_jun;
        $target_keuangan[] = $t_keu_jul>100 ? 100 : $t_keu_jul;
        $target_keuangan[] = $t_keu_agu>100 ? 100 : $t_keu_agu;
        $target_keuangan[] = $t_keu_sep>100 ? 100 : $t_keu_sep;
        $target_keuangan[] = $t_keu_okt>100 ? 100 : $t_keu_okt;
        $target_keuangan[] = $t_keu_nov>100 ? 100 : $t_keu_nov;
        $target_keuangan[] = $t_keu_des >100 ? 100 : $t_keu_des;

        $realisasi_fisik[] = $this->realisasi_fisik($id_instansi);


        for ($i=1; $i <= date('n') ; $i++) { 
            $rk = $this->target_realisasi_model->realisasi_keuangan($id_instansi, $i)->realisasi_keuangan;
            @$realisasi_keuangan[]    = ($rk / $t_anggaran) * 100;
        }
        // $realisasi_keuangan[]    = $r_jan > 0 ? $r_jan : 0;
        // $realisasi_keuangan[]    = $r_feb > 0 ? ROUND($r_feb + $realisasi_keuangan[0], 2) : $realisasi_keuangan[0];
        // $realisasi_keuangan[]    = $r_mar > 0 ? ROUND($r_mar + $realisasi_keuangan[1], 2) : $realisasi_keuangan[1];
        // $realisasi_keuangan[]    = $r_apr > 0 ? ROUND($r_apr + $realisasi_keuangan[2], 2) : $realisasi_keuangan[2];
        // $realisasi_keuangan[]    = $r_mei > 0 ? ROUND($r_mei + $realisasi_keuangan[3], 2) : $realisasi_keuangan[3];
        // $realisasi_keuangan[]    = $r_jun > 0 ? ROUND($r_jun + $realisasi_keuangan[4], 2) : $realisasi_keuangan[4];
        // $realisasi_keuangan[]    = $r_jul > 0 ? ROUND($r_jul + $realisasi_keuangan[5], 2) : $realisasi_keuangan[5];
        // $realisasi_keuangan[]    = $r_agu > 0 ? ROUND($r_agu + $realisasi_keuangan[6], 2) : $realisasi_keuangan[6];
        // $realisasi_keuangan[]    = $r_sep > 0 ? ROUND($r_sep + $realisasi_keuangan[7], 2) : $realisasi_keuangan[7];
        // $realisasi_keuangan[]    = $r_okt > 0 ? ROUND($r_okt + $realisasi_keuangan[8], 2) : $realisasi_keuangan[8];
        // $realisasi_keuangan[]    = $r_nov > 0 ? ROUND($r_nov + $realisasi_keuangan[9], 2) : $realisasi_keuangan[9];
        // $realisasi_keuangan[]    = $r_des > 0 ? ROUND($r_des + $realisasi_keuangan[10], 2) : $realisasi_keuangan[10];

        $data = [];
        foreach ($target_fisik as $key => $value) {
            $data[] = array(
                'id_instansi' => $id_instansi,
                'kode_tahap' => $tahap,
                'tahun_anggaran' => $tahun_anggaran,
                'bulan' => $key + 1,
                'target_fisik' => $target_fisik[$key],
                'target_keuangan' => $target_keuangan[$key],
                'realisasi_fisik' => $realisasi_fisik[0][$key],
                'realisasi_keuangan' => $realisasi_keuangan[$key],
                'last_update' => timestamp()
            );
        }

        $result = $this->db->insert_batch('grafik', $data);

        $output = [];
        $output['status'] = true;

        echo json_encode($output);
    }

  
    public function realisasi_fisik($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];

        // $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi);
      
        $no = 1;
        $tampung_kegiatan_berpagu = [];
        foreach ($kegiatan as $key => $value) {
                if ($value->pagu >0) {
                    $satu = 1;
                }else{
                    $satu = 0;
                }

                array_push($tampung_kegiatan_berpagu, $satu);


            $total_paket    = $this->target_realisasi_model->total_paket($id_instansi, $value->kode_rekening_sub_kegiatan)->num_rows();
            $jenis_swakelola    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'SWAKELOLA')->num_rows();
            $jenis_penyedia    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'PENYEDIA')->num_rows();
            $jenis_rutin    = $this->target_realisasi_model->total_paket_perjenis($id_instansi, $value->kode_rekening_sub_kegiatan, 'RUTIN')->num_rows();
	 
           
 
		        // echo "<pre>".print_r($swakelola)."</pre>";
            for ($i = 1; $i <= date('n'); $i++) {

                $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'SWAKELOLA', $i)->row()->total;
                $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->num_rows() == '' ? 0 : $this->target_realisasi_model->persentase($value->kode_rekening_sub_kegiatan, 'PENYEDIA', $i)->row()->total;


                $rutin          = $jenis_rutin == '' ? 0 : ($jenis_rutin   * $this->rutin($i, $id_instansi)) ;
             

                $total_fisik_perkegiatan = ($swakelola + $penyedia + $rutin); 
                @$ratarata_fisik = $total_fisik_perkegiatan / $total_paket;
        		




                if ($swakelola + $penyedia + $rutin == 0) {
                    $total_fisik = 0;
                } else {
                	if ($total_paket==0) {
	                    $total_fisik = 0;
                	}else{
	                   $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
                	}
                }
                $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

                $total_fisik_bulan[$i][] = $total_fisik;
            }
        }



        if (empty($total_fisik_bulan)) :
            $fisik_array[] = 0;
        else :
            for ($i = 1; $i <= date('n'); $i++) {
                $fisik_array[] = ROUND(array_sum($total_fisik_bulan[$i]) / array_sum($tampung_kegiatan_berpagu), 2);
            }
        endif;


        $realisasi_fisik[] = (!empty($fisik_array[0]) and $fisik_array[0] > 0) ? $fisik_array[0] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[1]) and $fisik_array[1] > 0) ? $fisik_array[1] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[2]) and $fisik_array[2] > 0) ? $fisik_array[2] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[3]) and $fisik_array[3] > 0) ? $fisik_array[3] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[4]) and $fisik_array[4] > 0) ? $fisik_array[4] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[5]) and $fisik_array[5] > 0) ? $fisik_array[5] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[6]) and $fisik_array[6] > 0) ? $fisik_array[6] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[7]) and $fisik_array[7] > 0) ? $fisik_array[7] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[8]) and $fisik_array[8] > 0) ? $fisik_array[8] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[9]) and $fisik_array[9] > 0) ? $fisik_array[9] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[10]) and $fisik_array[10] > 0) ? $fisik_array[10] : 0;
        $realisasi_fisik[] = (!empty($fisik_array[11]) and $fisik_array[11] > 0) ? $fisik_array[11] : 0;
        return $realisasi_fisik;
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
    public function semua_instansi()
    {
        $q = $this->db->query("SELECT count(id_instansi) as banyak_instansi from master_instansi where kategori='OPD'")->row();
        echo $q->banyak_instansi;
    }
}
