<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Laporan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Replikasi extends MY_Controller { public function __construct() {
parent::__construct(); $this->load->model([
'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
'Laporan/rekap_asisten_model'					=> 'rekap_asisten_model',
'Laporan/ratarata_fisik_keuangan'					=> 'ratarata_fisik_keuangan',
'Laporan/rekap_realisasi_total_model'	=> 'rekap_realisasi_total_model',
'Laporan/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
'Laporan/rekap_kegiatan_kab_kota'	=> 'rekap_kegiatan_kab_kota',
'Laporan/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
'Laporan/realisasi_per_kab_kota'	=> 'realisasi_per_kab_kota',
'Laporan/realisasi_gabungan_per_kab_kota'	=> 'realisasi_gabungan_per_kab_kota',
'Laporan/target_realisasi_model'	=> 'target_realisasi_model',
'Laporan/rekap_permasalahan_model'	=> 'rekap_permasalahan_model',
'config/config_model' => 'config_model',
'data_apbd/data_apbd_model'      => 'data_apbd_model',
		]);
	}

	public function index()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Realisasi Fisik dan Keuangan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan realisasi fisik dan keuangan";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$data['config']					= $this->db->get('config')->result_array();
		$page               	= 'laporan/realisasi_akumulasi/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/realisasi_akumulasi/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/realisasi_akumulasi/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/realisasi_akumulasi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}



	public function bulan_global($ke){
		$bulan = [
			1=>'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember',
		];
		return $bulan[$ke];
	}

	
	public function data_jumlah_aktivitas()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> []
			];

			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();
			$total_anggaran = 0;
			$total_paket_rutin = 0;
			$total_paket_swakelola = 0;
			$total_paket_penyedia = 0;


			foreach ($opd as $key => $value) {
				$program = $this->jumlah_aktivitas_model->program($value->id_instansi);
				$kegiatan=$this->jumlah_aktivitas_model->kegiatan($value->id_instansi);
				$pagu_anggaran = $this->jumlah_aktivitas_model->pagu_anggaran($value->id_instansi);
				$p_swakelola = $this->jumlah_aktivitas_model->paket($value->id_instansi, "SWAKELOLA");
				$p_penyedia = $this->jumlah_aktivitas_model->paket($value->id_instansi, "PENYEDIA");
				$p_rutin = $this->jumlah_aktivitas_model->paket($value->id_instansi, "RUTIN");

				





				$total_anggaran += $pagu_anggaran ; 
				$total_paket_rutin += $p_rutin ; 
				$total_paket_penyedia += $p_penyedia ; 
				$total_paket_swakelola += $p_swakelola ; 


				$output['data'][$key]['id_instansi'] 	= $value->id_instansi;
	
				$output['data'][$key]['nama_instansi'] 	= $value->nama_instansi;
				$output['data'][$key]['pagu_anggaran'] 	= number_format($pagu_anggaran);
				$output['data'][$key]['jumlah_program'] 	= number_format($program);
				$output['data'][$key]['jumlah_kegiatan'] 	= number_format($kegiatan);
				$output['data'][$key]['paket_rutin'] 	= $p_rutin;
				$output['data'][$key]['paket_swakelola'] 	= $p_swakelola;
				$output['data'][$key]['paket_penyedia'] 	= $p_penyedia;
				$output['status'] = true;
			}
			
			$output['total_anggaran'] = number_format($total_anggaran);
			$output['total_paket_swakelola'] = number_format($total_paket_swakelola);
			$output['total_paket_penyedia'] = number_format($total_paket_penyedia);
			$output['total_paket_rutin'] = number_format($total_paket_rutin);
			echo json_encode($output);
		}
	}

	public function data_ratarata_fisik_keu($filter="")
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		} else {
			$output = [
				'status' 	=> false,
				'data' 		=> []
			];

			$bulan_aktif = bulan_aktif();
			if ($filter =='keuangan') {
				$order = "r_keuangan DESC, r_fisik desc";
			}else{
				$order = "r_fisik desc, r_keuangan DESC";
			}
			$opd 	= $this->db->query("SELECT mi.id_instansi, mi.kode_opd, mi.nama_instansi , 
				(SELECT target_fisik from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') as tfisik,
				(SELECT target_keuangan from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') as tkeuangan,
				(SELECT realisasi_fisik from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') as r_fisik,
				(SELECT realisasi_keuangan from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') as r_keuangan,
				(
				(SELECT realisasi_fisik from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') -
				(SELECT target_fisik from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif')
				) as deviasi_fisik ,
				(
				 (SELECT realisasi_keuangan from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') -
				(SELECT target_keuangan from grafik where id_instansi=mi.id_instansi and bulan = '$bulan_aktif') 
				) as deviasi_keuangan
				FROM master_instansi mi 
				WHERE mi.kategori = 'OPD' and mi.is_active='1' AND mi.id_instansi not in (163,164,165,200,201,202,203,204,205,206) 
				ORDER BY $order")->result();
			$total_anggaran = 0;
			$total_paket_rutin = 0;
			$total_paket_swakelola = 0;
			$total_paket_penyedia = 0;


			foreach ($opd as $key => $value) {


				
				$pagu_anggaran = $this->jumlah_aktivitas_model->pagu_anggaran($value->id_instansi);
				


				$output['data'][$key]['id_instansi'] 	= $value->id_instansi;
	
				$output['data'][$key]['nama_instansi'] 	= $value->nama_instansi;
				$output['data'][$key]['pagu_anggaran'] 	= number_format($pagu_anggaran);
				$output['data'][$key]['target_fisik'] 	= $value->tfisik== '' ? 0 : $value->tfisik;
				$output['data'][$key]['realisasi_fisik'] 	= $value->r_fisik== '' ? 0 : $value->r_fisik;
				$output['data'][$key]['deviasi_fisik'] 	= $value->deviasi_fisik== '' ? 0 : $value->deviasi_fisik;
				$output['data'][$key]['target_keuangan'] 	= $value->tkeuangan== '' ? 0 : $value->tkeuangan;
				$output['data'][$key]['realisasi_keuangan'] 	= $value->r_keuangan== '' ? 0 : $value->r_keuangan;
				$output['data'][$key]['deviasi_keuangan'] 	= $value->deviasi_keuangan== '' ? 0 : $value->deviasi_keuangan;
				$output['status'] = true;
			}
			
			// $output['total_anggaran'] = number_format($total_anggaran);
			// $output['total_paket_swakelola'] = number_format($total_paket_swakelola);
			// $output['total_paket_penyedia'] = number_format($total_paket_penyedia);
			// $output['total_paket_rutin'] = number_format($total_paket_rutin);
			echo json_encode($output);
		}
	}

	public function data_jumlah_aktivitas_pdf()
	{
		
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= 43;
		$kategori 		= 'akumulasi';
		$bulan 				= 8;
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				break;
			case 'per_bulan':
				$ope = '=';
				break;
		}
		$judul_file 	= "Laporan Aktivitas SKPD Tahun ". tahun_anggaran().".pdf";

		// New
		$this->load->library('pdf_jumlah_aktivitas');
		$pdf = new Pdf_jumlah_aktivitas('P', 'mm', 'a4');
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(4);
		$pdf->AddPage();
		$pdf->SetTitle($judul_file);
		// $pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);
		$pdf->SetFont('Arial');
		 $pdf->SetFontSize(6);













			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi not in (203,164,165) and is_active='1' ORDER BY nama_instansi ASC")->result();
			$total_anggaran = 0;
			$total_paket_rutin = 0;
			$total_paket_swakelola = 0;
			$total_paket_penyedia = 0;
			$jumlah_program = 0;
			$jumlah_kegiatan = 0;
			$jumlah_sub_kegiatan = 0;

			$no = 1;
			foreach ($opd as $key => $value) {
				$program = $this->jumlah_aktivitas_model->program($value->id_instansi);
				$kegiatan=$this->jumlah_aktivitas_model->kegiatan($value->id_instansi);
				$sub_kegiatan=$this->jumlah_aktivitas_model->sub_kegiatan($value->id_instansi);
				$pagu_anggaran = $this->jumlah_aktivitas_model->pagu_anggaran($value->id_instansi);
				$p_swakelola = $this->jumlah_aktivitas_model->paket($value->id_instansi, "SWAKELOLA");
				$p_penyedia = $this->jumlah_aktivitas_model->paket($value->id_instansi, "PENYEDIA");
				$p_rutin = $this->jumlah_aktivitas_model->paket($value->id_instansi, "RUTIN");

				





				$total_anggaran += $pagu_anggaran ;



				$total_paket_rutin += $p_rutin ; 
				$total_paket_penyedia += $p_penyedia ; 
				$total_paket_swakelola += $p_swakelola ; 


				$id_instansi	= $value->id_instansi;
	
				$nama_instansi	= $value->nama_instansi;
				$pagu_anggaran	= number_format($pagu_anggaran);
				$banyak_program	= number_format($program);
				$banyak_kegiatan	= number_format($kegiatan);
				$banyak_sub_kegiatan	= number_format($sub_kegiatan);
				$paket_rutin	= $p_rutin;
				$paket_swakelola	= $p_swakelola;
				$paket_penyedia	= $p_penyedia;

				$total_program =$jumlah_program += $program ;
				$total_kegiatan =$jumlah_kegiatan += $kegiatan ;
				$total_sub_kegiatan =$jumlah_sub_kegiatan += $sub_kegiatan ;


				$pdf->cell(10, 5, $no++, 1, 0,'C');
		$pdf->cell(88, 5, ucwords($nama_instansi), 1, 0 );
		$pdf->cell(20, 5, ($pagu_anggaran), 1, 0, 'R');
		$pdf->cell(15, 5, ($banyak_program), 1, 0, 'C');
		$pdf->cell(15, 5, ($banyak_kegiatan), 1, 0, 'C');
		$pdf->cell(15, 5, ($banyak_sub_kegiatan), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_rutin), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_swakelola), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_penyedia), 1, 0, 'C');
		$pdf->Ln(5);
			
			}
			
			$total_anggaran = number_format($total_anggaran);
			$total_paket_swakelola = number_format($total_paket_swakelola);
			$total_paket_penyedia = number_format($total_paket_penyedia);
			$total_paket_rutin = number_format($total_paket_rutin);
	

			$pdf->cell(98, 5, "Total ", 1, 0);
			$pdf->cell(20, 5, $total_anggaran, 1, 0, 'R');
			$pdf->cell(15, 5, ($total_program), 1, 0, 'C');
			$pdf->cell(15, 5, ($total_kegiatan), 1, 0, 'C');
			$pdf->cell(15, 5, ($total_sub_kegiatan), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_rutin), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_swakelola), 1, 0, 'C');
			$pdf->cell(13, 5, ($total_paket_penyedia), 1, 0, 'C');






	
		

		
		// last update 09102020

		$pdf->Output($judul_file, 'I');
		

	}

	public function laporan_realisasi_fisik_keuangan()
	{
		
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= 43;
		$kategori 		= 'akumulasi';
		$bulan 				= 8;
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				break;
			case 'per_bulan':
				$ope = '=';
				break;
		}
		$judul_file 	= "Laporan Fisik dan keuangan ". tahun_anggaran().".pdf";

		// New
		$this->load->library('pdf_laporan_realisasi_fisik_keuangan');
		$pdf = new Pdf_laporan_realisasi_fisik_keuangan('P', 'mm', 'a4');
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(4);
		$pdf->AddPage();
		$pdf->SetTitle($judul_file);
		// $pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);
		$pdf->SetFont('Arial');
		 $pdf->SetFontSize(7);

		 	$query	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC");
			$opd 	= $query->result();
			$totalopd 	= $query->num_rows();
			$total_fisik = 0;
			$total_keuangan = 0;


			$no = 1;
			foreach ($opd as $key => $value) {
				$program = $this->jumlah_aktivitas_model->program($value->id_instansi);
				$kegiatan=$this->jumlah_aktivitas_model->kegiatan($value->id_instansi);
				$pagu_anggaran = $this->jumlah_aktivitas_model->pagu_anggaran($value->id_instansi);
				$id_instansi	= $value->id_instansi;
				$nama_instansi	= $value->nama_instansi;
				$grafik = $this->lap_realisasi_fisik_keu->realisasi_fisik($id_instansi);
				$realisasi_keuangan = $this->lap_realisasi_fisik_keu->realisasi_keuangan($id_instansi)->realisasi_keuangan;
				$persen_keuangan = ($realisasi_keuangan / $pagu_anggaran ) * 100;
				$total_fisik = $total_fisik += $grafik->realisasi_fisik;
				$total_keuangan = $total_keuangan += $persen_keuangan;
				$pdf->cell(10, 5, $no++, 1, 0,'C');
				$pdf->cell(130, 5, ucwords($nama_instansi), 1, 0 );
				$pdf->cell(30, 5, $grafik->realisasi_fisik, 1, 0, 'C');
				$pdf->cell(30, 5, round( $persen_keuangan, 2), 1, 0, 'C');
				$pdf->Ln(5);
				}
			
		$pdf->cell(140, 5, "Total", 1, 0 );



		$pdf->cell(30, 5, round( ($total_fisik / $totalopd), 2), 1, 0, 'C');
		$pdf->cell(30, 5, round( ($total_keuangan / $totalopd), 2), 1, 0, 'C');

		$pdf->Ln(5);
			// $total_anggaran = number_format($total_anggaran);
			// $total_paket_swakelola = number_format($total_paket_swakelola);
			// $total_paket_penyedia = number_format($total_paket_penyedia);
			// $total_paket_rutin = number_format($total_paket_rutin);
	

			// $pdf->cell(108, 5, "Total ", 1, 0);
			// $pdf->cell(25, 5, $total_anggaran, 1, 0, 'R');
			// $pdf->cell(15, 5, ($jumlah_program), 1, 0, 'C');
			// $pdf->cell(15, 5, ($jumlah_kegiatan), 1, 0, 'C');
			// $pdf->cell(13, 5, ($total_paket_rutin), 1, 0, 'C');
			// $pdf->cell(13, 5, ($total_paket_swakelola), 1, 0, 'C');
			// $pdf->cell(13, 5, ($total_paket_penyedia), 1, 0, 'C');






	
		

		
		// last update 09102020

		$pdf->Output($judul_file, 'I');
		

	}



 // public function sync_all()
 //    {

 //        $opd    = $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();
 //        foreach ($opd as $key => $value) {
 //            $id_instansi        = $value->id_instansi;
 //            $this->db->delete('grafik', ['id_instansi' => $id_instansi]);
 //            $t_anggaran         = $this->target_realisasi_model->get_anggaran($id_instansi);
 //            $target_fisik       = [];
 //            $target_keu         = [];
 //            $realisasi_fisik    = [];
 //            $realisasi_keuangan = [];

 //            $t_fisik_jan = 0;
 //            $t_fisik_feb = 0;
 //            $t_fisik_mar = 0;
 //            $t_fisik_apr = 0;
 //            $t_fisik_mei = 0;
 //            $t_fisik_jun = 0;
 //            $t_fisik_jul = 0;
 //            $t_fisik_agu = 0;
 //            $t_fisik_sep = 0;
 //            $t_fisik_okt = 0;
 //            $t_fisik_nov = 0;
 //            $t_fisik_des = 0;

 //            $t_keu_jan   = 0;
 //            $t_keu_feb   = 0;
 //            $t_keu_mar   = 0;
 //            $t_keu_apr   = 0;
 //            $t_keu_mei   = 0;
 //            $t_keu_jun   = 0;
 //            $t_keu_jul   = 0;
 //            $t_keu_agu   = 0;
 //            $t_keu_sep   = 0;
 //            $t_keu_okt   = 0;
 //            $t_keu_nov   = 0;
 //            $t_keu_des   = 0;

 //            $r_jan     = 0;
 //            $r_feb  = 0;
 //            $r_mar  = 0;
 //            $r_apr  = 0;
 //            $r_mei  = 0;
 //            $r_jun  = 0;
 //            $r_jul  = 0;
 //            $r_agu  = 0;
 //            $r_sep  = 0;
 //            $r_okt  = 0;
 //            $r_nov  = 0;
 //            $r_des  = 0;

 //            $t_fisik = $this->target_realisasi_model->get_target_fisik($id_instansi);
 //            foreach ($t_fisik->result() as $key => $value) {
 //                $t_fisik_jan += $value->jan;
 //                $t_fisik_feb += $value->feb;
 //                $t_fisik_mar += $value->mar;
 //                $t_fisik_apr += $value->apr;
 //                $t_fisik_mei += $value->mei;
 //                $t_fisik_jun += $value->jun;
 //                $t_fisik_jul += $value->jul;
 //                $t_fisik_agu += $value->agu;
 //                $t_fisik_sep += $value->sep;
 //                $t_fisik_okt += $value->okt;
 //                $t_fisik_nov += $value->nov;
 //                $t_fisik_des += $value->des;
 //            }

 //            $t_keuangan = $this->target_realisasi_model->get_target_keuangan($id_instansi);

 //            foreach ($t_keuangan->result() as $key => $value) {
 //                $t_keu_jan   += ($value->jan / $t_anggaran) * 100;
 //                $t_keu_feb   += ($value->feb / $t_anggaran) * 100;
 //                $t_keu_mar   += ($value->mar / $t_anggaran) * 100;
 //                $t_keu_apr   += ($value->apr / $t_anggaran) * 100;
 //                $t_keu_mei   += ($value->mei / $t_anggaran) * 100;
 //                $t_keu_jun   += ($value->jun / $t_anggaran) * 100;
 //                $t_keu_jul   += ($value->jul / $t_anggaran) * 100;
 //                $t_keu_agu   += ($value->agu / $t_anggaran) * 100;
 //                $t_keu_sep   += ($value->sep / $t_anggaran) * 100;
 //                $t_keu_okt   += ($value->okt / $t_anggaran) * 100;
 //                $t_keu_nov   += ($value->nov / $t_anggaran) * 100;
 //                $t_keu_des   += ($value->des / $t_anggaran) * 100;
 //            }

 //            $r_keuangan = $this->target_realisasi_model->get_realisasi_keuangan($id_instansi);
 //            foreach ($r_keuangan->result() as $key => $value) {
 //                $r_jan  += $value->jan / $t_anggaran * 100;
 //                $r_feb  += $value->feb / $t_anggaran * 100;
 //                $r_mar  += $value->mar / $t_anggaran * 100;
 //                $r_apr  += $value->apr / $t_anggaran * 100;
 //                $r_mei  += $value->mei / $t_anggaran * 100;
 //                $r_jun  += $value->jun / $t_anggaran * 100;
 //                $r_jul  += $value->jul / $t_anggaran * 100;
 //                $r_agu  += $value->agu / $t_anggaran * 100;
 //                $r_sep  += $value->sep / $t_anggaran * 100;
 //                $r_okt  += $value->okt / $t_anggaran * 100;
 //                $r_nov  += $value->nov / $t_anggaran * 100;
 //                $r_des  += $value->des / $t_anggaran * 100;
 //            }

 //            $target_fisik[] = $t_fisik_jan >100 ? 100 : $t_fisik_jan;
 //            $target_fisik[] = $t_fisik_feb >100 ? 100 : $t_fisik_feb;
 //            $target_fisik[] = $t_fisik_mar >100 ? 100 : $t_fisik_mar;
 //            $target_fisik[] = $t_fisik_apr >100 ? 100 : $t_fisik_apr;
 //            $target_fisik[] = $t_fisik_mei >100 ? 100 : $t_fisik_mei;
 //            $target_fisik[] = $t_fisik_jun >100 ? 100 : $t_fisik_jun;
 //            $target_fisik[] = $t_fisik_jul >100 ? 100 : $t_fisik_jul;
 //            $target_fisik[] = $t_fisik_agu >100 ? 100 : $t_fisik_agu;
 //            $target_fisik[] = $t_fisik_sep >100 ? 100 : $t_fisik_sep;
 //            $target_fisik[] = $t_fisik_okt >100 ? 100 : $t_fisik_okt;
 //            $target_fisik[] = $t_fisik_nov >100 ? 100 : $t_fisik_nov;
 //            $target_fisik[] = $t_fisik_des >100 ? 100 : $t_fisik_des;

 //             $target_keuangan[] = $t_keu_jan>100 ? 100 : $t_keu_jan;
 //            $target_keuangan[] = $t_keu_feb>100 ? 100 : $t_keu_feb;
 //            $target_keuangan[] = $t_keu_mar>100 ? 100 : $t_keu_mar;
 //            $target_keuangan[] = $t_keu_apr>100 ? 100 : $t_keu_apr;
 //            $target_keuangan[] = $t_keu_mei>100 ? 100 : $t_keu_mei;
 //            $target_keuangan[] = $t_keu_jun>100 ? 100 : $t_keu_jun;
 //            $target_keuangan[] = $t_keu_jul>100 ? 100 : $t_keu_jul;
 //            $target_keuangan[] = $t_keu_agu>100 ? 100 : $t_keu_agu;
 //            $target_keuangan[] = $t_keu_sep>100 ? 100 : $t_keu_sep;
 //            $target_keuangan[] = $t_keu_okt>100 ? 100 : $t_keu_okt;
 //            $target_keuangan[] = $t_keu_nov>100 ? 100 : $t_keu_nov;
 //            $target_keuangan[] = $t_keu_des >100 ? 100 : $t_keu_des;

 //            $realisasi_fisik[] = $this->realisasi_fisik($id_instansi);

 //            $realisasi_keuangan[]    = $r_jan > 0 ? $r_jan : 0;
 //            $realisasi_keuangan[]    = $r_feb > 0 ? ROUND($r_feb + $realisasi_keuangan[0], 2) : $realisasi_keuangan[0];
 //            $realisasi_keuangan[]    = $r_mar > 0 ? ROUND($r_mar + $realisasi_keuangan[1], 2) : $realisasi_keuangan[1];
 //            $realisasi_keuangan[]    = $r_apr > 0 ? ROUND($r_apr + $realisasi_keuangan[2], 2) : $realisasi_keuangan[2];
 //            $realisasi_keuangan[]    = $r_mei > 0 ? ROUND($r_mei + $realisasi_keuangan[3], 2) : $realisasi_keuangan[3];
 //            $realisasi_keuangan[]    = $r_jun > 0 ? ROUND($r_jun + $realisasi_keuangan[4], 2) : $realisasi_keuangan[4];
 //            $realisasi_keuangan[]    = $r_jul > 0 ? ROUND($r_jul + $realisasi_keuangan[5], 2) : $realisasi_keuangan[5];
 //            $realisasi_keuangan[]    = $r_agu > 0 ? ROUND($r_agu + $realisasi_keuangan[6], 2) : $realisasi_keuangan[6];
 //            $realisasi_keuangan[]    = $r_sep > 0 ? ROUND($r_sep + $realisasi_keuangan[7], 2) : $realisasi_keuangan[7];
 //            $realisasi_keuangan[]    = $r_okt > 0 ? ROUND($r_okt + $realisasi_keuangan[8], 2) : $realisasi_keuangan[8];
 //            $realisasi_keuangan[]    = $r_nov > 0 ? ROUND($r_nov + $realisasi_keuangan[9], 2) : $realisasi_keuangan[9];
 //            $realisasi_keuangan[]    = $r_des > 0 ? ROUND($r_des + $realisasi_keuangan[10], 2) : $realisasi_keuangan[10];

 //            $data = [];
 //            foreach ($target_fisik as $key => $value) {
 //                $data[] = array(
 //                    'id_instansi' => $id_instansi,
 //                    'bulan' => $key + 1,
 //                    'target_fisik' => $target_fisik[$key],
 //                    'target_keuangan' => $target_keuangan[$key],
 //                    'realisasi_fisik' => $realisasi_fisik[0][$key],
 //                    'realisasi_keuangan' => $realisasi_keuangan[$key],
 //                    'last_update' => timestamp()
 //                );
 //            }

 //            $result = $this->db->insert_batch('grafik', $data);


 //        }
 //            $output = [];
 //            $output['status'] = true;
 //            echo json_encode($output);
 //    }



    public function realisasi_fisik($id_instansi)
    {
        $realisasi_fisik = [];
        $total_fisik_bulan = [];

        $kegiatan = $this->target_realisasi_model->get_kode_rekening_kegiatan($id_instansi);
        // $kegiatan = $this->target_realisasi_model->all_kegiatan($id_instansi);

        foreach ($kegiatan as $key => $value) {
            $total_paket    = $this->target_realisasi_model->total_paket($value->kode_rekening_kegiatan)->row()->total_paket;

            for ($i = 1; $i <= date('n'); $i++) {

                $swakelola      = $this->target_realisasi_model->persentase($value->kode_rekening_kegiatan, 'SWAKELOLA', $i)->num_rows() > 0 ? $this->target_realisasi_model->persentase($value->kode_rekening_kegiatan, 'SWAKELOLA', $i)->row()->total : 0;
                $penyedia       = $this->target_realisasi_model->persentase($value->kode_rekening_kegiatan, 'PENYEDIA', $i)->num_rows() > 0 ? $this->target_realisasi_model->persentase($value->kode_rekening_kegiatan, 'PENYEDIA', $i)->row()->total : 0;
                $rutin          = $this->rutin($i);

                if ($swakelola + $penyedia + $rutin == 0) {
                    $total_fisik = 0;
                } else {
                    $total_fisik = ROUND(($swakelola + $penyedia + $rutin) / $total_paket, 2);
                }
                $total_fisik  = ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);

                $total_fisik_bulan[$i][] = $total_fisik;
            }
        }

        if (empty($total_fisik_bulan)) :
            $fisik_array[] = 0;
        else :
            for ($i = 1; $i <= date('n'); $i++) {
                $fisik_array[] = ROUND(array_sum(explode(',', implode(',', $total_fisik_bulan[$i]))) / count($kegiatan), 2);
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
	 public function rutin($bulan)
    {
        return ROUND($bulan / 12 * 100, 2);
    }

	public function ratarata_fisik_keu()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Laporan', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Laporan Data Rata-rata Realisasi";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Berdasarkan Realisasi fisik / keuangan tertinggi";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();

		$data['config']					= $this->db->get('config')->result_array();
		$page               	= 'laporan/ratarata_fisik_keu/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/ratarata_fisik_keu/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/ratarata_fisik_keu/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/ratarata_fisik_keu/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}



	public function pdf_laporan_realisasi_akumulasi()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
		// $id_instansi 	= $this->input->get('id_opd');
		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Laporan realisasi  sampai dengan bulan ".bulan_global($bulan);
				break;
			default:
				$ope = '=';
				$judul_laporan = "Laporan realisasi  bulan ".bulan_global($bulan);
				break;
		}

	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();
	    $data['identitas']=$identitas;
	    $data['program']=$program;
	    $data['ope']=$ope;
	    $data['bulan']=$bulan;
	    $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	    $data['judul_laporan']=$judul_laporan;
	    $data['title']=$judul_laporan.' '.$nama_instansi;
	    $data['nama_instansi']=$nama_instansi;
	    $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;
	    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_akumulasi/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_akumulasi/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}




	public function pdf_laporan_realisasi_per_kab_kota()
	{
		error_reporting(0);
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => [210,330],
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
        $config_model       = $this->config_model;

		$id_kota 	= sbe_crypt($this->input->get('id_kota'), 'D');
		$id_provinsi 	= $this->input->get('id_provinsi');


		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');

		$config =  $this->config_model->config_kab_kota($id_provinsi, $id_kota)->row();
		// $tahap = $tahap = config_kab_kota()->tahapan_apbd;
		$nama_tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
		$nama_kota = $this->realisasi_per_kab_kota->nama_kota($id_kota)->row()->nama_kota;
		$tahap = $this->input->get('tahap');
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) ".$nama_tahap[$tahap]."<br>".$nama_kota."<br>sampai dengan bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
			default:
				$ope = '=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) <br>".$nama_kota."<br>bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
		}

	    $skpd = $this->realisasi_per_kab_kota->instansi_kab_kota($id_provinsi,$id_kota)->result();
	    $data['bulan_aktif']=$bulan;	
	    $data['tahap']=$tahap;	
	    $data['nama_tahap']=$nama_tahap[$tahap];	
	    $data['fisik_keuangan']=$fisik_keuangan;	
	    $data['skpd']=$skpd;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=$judul_laporan;	
	    $data['config']=$config;	
	    $data['nama_kota']=$nama_kota;	
	  
	    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 48);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$nama_file = str_replace('<br>', ' ', $judul_laporan);
		$mpdf->Output($nama_file.'.pdf', 'I');
	}


	public function pdf_laporan_gabungan_realisasi_per_kab_kota()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => [210,330],
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		
		$id_provinsi 	= $this->input->get('id_provinsi');
		$wilayah 	= $this->input->get('wilayah');
		$tahap 	= $this->input->get('tahap');

		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
		$model_realisasi_gabungan	       = $this->realisasi_gabungan_per_kab_kota;
		// $tahap = $tahap = config_kab_kota()->tahapan_apbd;
		$nama_tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
		$show_nama_tahap=$nama_tahap[$tahap];	

		if ($wilayah=='semua') {
		    $list_kota = $this->db->get_where('kota',['id_provinsi'=>$id_provinsi])->result();
		    $nama_wilayah = "";
		}else{
		    $list_kota = $this->db->query("SELECT ckk.id_kota, k.nama_kota from config_kab_kota ckk 
		    	left join kota k on ckk.id_kota = k.id_kota where ckk.wilayah='$wilayah'")->result();
		    $nama_wilayah = "<br>Wilayah ".$wilayah;

		}


		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) Kabupaten / kota se sumatera barat [".$show_nama_tahap."]".$nama_wilayah." <br>sampai dengan bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
			default:
				$ope = '=';
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) Kabupaten / kota se sumatera barat [".$show_nama_tahap."]".$nama_wilayah."<br>bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
		}

		
	    $data['list_kota']=$list_kota;	
	    $data['tahap']=$tahap;	
	    $data['nama_tahap']=$nama_tahap[$tahap];	
	    $data['model_realisasi_gabungan']=$model_realisasi_gabungan;	
	    $data['bulan']=$bulan;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=str_replace('<br>', ' ', $judul_laporan);	
	  
	    $html =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_gabungan_per_kab_kota/footer', $data, true);

	    if ($wilayah=='semua') {
		    $mpdf->SetMargins(0, 0, 48);
		}else{
		    $mpdf->SetMargins(0, 0, 52);
		}

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.'.pdf', 'I');
	}



	public function pdf_rekap_laporan_permasalahan_sub_kegiatan()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;



	    $instansi = $this->rekap_permasalahan_model->instansi_yang_menyampaikan()->result();
	    $judul_laporan = 'Rekap laporan permasalahan sub Kegiatan yang disampaikan oleh SKPD';
	    $data['judul_laporan']=$judul_laporan;
	    $data['kode_tahap']=tahapan_apbd();
	    $data['title']=$judul_laporan;
	    $data['instansi_yang_menyampaikan']=$instansi;
	    $html =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/rekap_semua_permasalahan_sub_kegiatan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		// $mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.'.pdf', 'I');
	}


	public function pdf_laporan_rekap_asisten()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);


		
		global $bulan;
		$bulan 				= $this->input->get('bulan');
		$tahap 				= $this->input->get('tahap');
		$tahun 				= $this->input->get('tahun');

		$identitas = $this->db->get('identitas')->row_array();
	

       if ($bulan==date('n') && tahun_anggaran()==date('Y')) {
	       $deskripsi_bulan = 'Kondisi realisasi sampai ' . (date('d') -1). ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
       	# code...
       }else{
	       $deskripsi_bulan = 'Kondisi realisasi sampai ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
       }
	    $data['desc_bulan']=$deskripsi_bulan;

	    $asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan)->result();
		$asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan)->result();
		$asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan)->result();




	    $judul_laporan="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan;
	    $data['identitas']=$identitas;
	    $data['asisten_1']=$asisten_1;
	    $data['asisten_2']=$asisten_2;
	    $data['asisten_3']=$asisten_3;
	    $data['periode']=pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

	    $html =  $this->load->view('laporan/pdf/realisasi_asisten/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_asisten/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_asisten/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 38);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}



	public function pdf_laporan_ratarata_realisasi()
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
	
       if ($bulan==date('n') && tahun_anggaran()==date('Y')) {
	       $deskripsi_bulan = 'Kondisi realisasi sampai ' . (date('d')). ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
       	# code...
       }else{
	       $deskripsi_bulan = 'Kondisi realisasi sampai ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
       }
	    

	    $asisten = [
	    	'semua'=>'Semua Data',
	    	'204'=>'Asisten Pemerintahan Dan Kesra',
	    	'205'=>'Asisten Perekonomian Dan Pembangunan',
	    	'206'=>'Asisten Administrasi Umum',
	    ];

	    $skpd = $this->ratarata_fisik_keuangan->skpd($filter, $bulan, $realisasi, $nomenklatur)->result();
	    $kelompok = $asisten[$filter];
	
	    $skpd_terurut = [];
	    foreach ($skpd as $k => $v) {
	    	$dev_fisik = $v->deviasi_fisik;
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
	    	$data = [
	    		'nama_instansi' => $v->nama_instansi,
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
	    $judul_laporan="Rekapitulasi SIMBANGDA Based Evidence Per SKPD ". $deskripsi_bulan.' '.$kelompok.' '.$caption_realisasi ;
	    $data['skpd']=$skpd_terurut;
	    $data['kelompok']=$kelompok;
	    $data['periode']=pilihan_nama_tahapan($tahap) .' Tahun '.$tahun;
	    $data['caption_realisasi']=$caption_realisasi;
	    $data['realisasi']=$realisasi;
	  	$data['desc_bulan']= $deskripsi_bulan;
	  	$tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;
	  

	    $html =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/content', $data, true);
	    $header =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/ratarata_fisik_keuangan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 38);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}




	public function pdf_laporan_kegiatan_kab_kota()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		]);

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
		$id_kota 	= sbe_crypt($this->input->get('id_kota'), 'D');
		$tahun 	= $this->input->get('tahun');
    // $id_instansi = 12;
	

	  
	    
	    $data['judul_laporan']="Laporan pelaksanaan kegiatan di Kabupaten / Kota";
	    $domisili =$this->rekap_kegiatan_kab_kota->kab_kota($id_kota);

	    $data['provinsi']=$domisili->nama_provinsi;
	    $data['kab_kota']=$domisili->nama_kota;
	    $data['tahun']=$tahun;
	    $data['lokasi_per_skpd']=$this->rekap_kegiatan_kab_kota->lokasi_per_skpd($id_kota);
	    $data['title']=$data['judul_laporan'].' | '.$data['provinsi'].' '.$data['kab_kota'];
	    $html =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/content', $data, true);

	    $header =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/rekap_kegiatan_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 30);
	    $mpdf->SetDisplayMode('fullpage');
		 $mpdf->SetHTMLHeader($header);
		// $mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($data['title'].'.pdf', 'I');
	}



    public function list_kab_kota()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $output = [
                'status'     => false,
                'data'         => [],
                'message'     => ''
            ];
            $id_provinsi    = sbe_crypt($this->input->post('id_provinsi'), 'D'); 
           
                $kab_kota = $this->db->query("SELECT id_kota, nama_kota FROM kota where id_provinsi = '$id_provinsi'");

            if ($kab_kota->num_rows() > 0) {
                $output['status']     = true;
                $output['message']     = 'Sukses';
                foreach ($kab_kota->result() as $key => $value) {
                    $output['data'][$key]['id']         =  sbe_crypt($value->id_kota, 'E') ;
                    $output['data'][$key]['kab_kota']     = $value->nama_kota;
                }
            } else {
                $output['status']     = false;
                $output['message']     = 'Gagal';
            }

            echo json_encode($output);
        }
    }
	public function laporan_dompdf(){
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';


    $data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        )
    );
    $dompdf = new Dompdf();
    $id_instansi = 12;
    $program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
    $data['program']=$program;
    $data['id_instansi']=$id_instansi;
    $html =  $this->load->view('laporan/tes/tes', $data, true);
   $dompdf->load_html($html);
   $dompdf->set_paper('F4','landscape');
   $dompdf->render();
   $pdf = $dompdf->output();
   $dompdf->stream('laporan.pdf',array("Attachment"=>false));
}
	public function laporan_dompdf2(){
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';

    $dompdf = new Dompdf();


    global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
    // $id_instansi = 12;
		// $id_instansi 	= $this->input->get('id_opd');
		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				break;
			case 'per_bulan':
				$ope = '=';
				break;
		}

    $program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
    $data['program']=$program;
    $data['ope']=$ope;
    $data['bulan']=$bulan;
    $data['id_instansi']=$id_instansi;
    $data['nama_instansi']=$this->sbe_nama_instansi($id_instansi);
    $html =  $this->load->view('laporan/tes/tes', $data, true);
   $dompdf->load_html($html);
   $dompdf->set_paper('F4','landscape');
   $dompdf->render();
   $pdf = $dompdf->output();
   $dompdf->stream('laporan.pdf',array("Attachment"=>false));
	}




	public function permasalahan_sub_kegiatan()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Laporan Permasalahan Sub Kegiatan', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Permasalahan Sub Kegiatan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan permasalahan sub kegiatan berdasarkan deviasi";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$page               	= 'laporan/permasalahan_sub_kegiatan/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/permasalahan_sub_kegiatan/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/permasalahan_sub_kegiatan/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/permasalahan_sub_kegiatan/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}




    public function show_permasalahan_sub_kegiatan()
    {
    	error_reporting(0);
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
        $data['input_by']                      = "all";
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
    	$data['id_instansi']				=$id_instansi;
    	$data['nama_instansi']				=$this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
    	$data['controller']				=$this->router->fetch_class();
        $page                               = 'laporan/permasalahan_sub_kegiatan/permasalahan';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        $data['extra_css']                  = $this->load->view('data_apbd/data_apbd/css', $data, true);
        $data['extra_js']                   = $this->load->view('data_apbd/data_apbd/js', $data, true);
        $data['modal']                      = $this->load->view('data_apbd/data_apbd/modal', $data, true);
        $this->load->view($page, $data);
    }






	public function desain()
	{
		error_reporting(0);
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => [210,330],
		    'orientation' => 'P',
		    'tempDir' => '/tmp'
		]);


		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
        $config_model       = $this->config_model;

		$id_kota 	= sbe_crypt($this->input->get('id_kota'), 'D');
		$id_provinsi 	= $this->input->get('id_provinsi');


		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');

		$config =  $this->config_model->config_kab_kota($id_provinsi, $id_kota)->row();
		// $tahap = $tahap = config_kab_kota()->tahapan_apbd;
		$nama_tahap = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];
		$nama_kota = $this->realisasi_per_kab_kota->nama_kota($id_kota)->row()->nama_kota;
		$tahap = $this->input->get('tahap');
		switch ($kategori) {
			case 'akumulasi':
				$ope = '<=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) ".$nama_tahap[$tahap]."<br>".$nama_kota."<br>sampai dengan bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
			default:
				$ope = '=';
				$judul_laporan = "Laporan realisasi Fisik dan Keuangan (RFK) <br>".$nama_kota."<br>bulan ".bulan_global($bulan).' '.tahun_anggaran();
				break;
		}

	    $skpd = $this->realisasi_per_kab_kota->instansi_kab_kota($id_provinsi,$id_kota)->result();
	    $data['bulan_aktif']=$bulan;	
	    $data['tahap']=$tahap;	
	    $data['nama_tahap']=$nama_tahap[$tahap];	
	    $data['fisik_keuangan']=$fisik_keuangan;	
	    $data['skpd']=$skpd;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=$judul_laporan;	
	    $data['config']=$config;	
	    $data['nama_kota']=$nama_kota;	
	  
	    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/desain', $data, true);

	    $header =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 48);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$nama_file = str_replace('<br>', ' ', $judul_laporan);
		$mpdf->Output($nama_file.'.pdf', 'I');
	}




}
