<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Laporan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Laporan/realisasi_akumulasi_model'		=> 'realisasi_akumulasi_model',
			'Laporan/rekap_asisten_model'					=> 'rekap_asisten_model',
			'Laporan/rekap_realisasi_total_model'	=> 'rekap_realisasi_total_model',
			'Laporan/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
			'Laporan/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
			'Laporan/target_realisasi_model'	=> 'target_realisasi_model'
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
		$page               	= 'laporan/realisasi_akumulasi/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/realisasi_akumulasi/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/realisasi_akumulasi/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/realisasi_akumulasi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}

	public function realisasi_akumulasi()
	{
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
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
		$judul_file 	= slug($this->sbe_nama_instansi($id_instansi)) . '- Realisasi ' . $kategori . ' ' . $this->bulan_global($bulan) . '.pdf';

		// New
		$this->load->library('format_realisasi');
		$pdf = new Format_realisasi('L', 'mm', 'legal');
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(4);
		$pdf->AddPage();
		$pdf->SetTitle('Laporan Realisasi Tahun Anggaran ' . date('Y'));
		$pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);

		$no_program 	= 0;
		$pagu_program 	= 0;
		$total_pad 		= 0;
		$total_dau 		= 0;
		$total_dak 		= 0;
		$total_dbh 		= 0;
		$total_lainnya  = 0;
		$total_target_fisik = 0;


		$total_angka_target_keuangan = 0 ; //05012021
		$total_angka_realisasi_keuangan = 0; //06012021
		$total_target_keuangan = 0;
		$total_realisasi_keuangan = 0;
		$total_persen_realisasi_keuangan = 0;
		$total_persen_realisasi_fisik = 0;
		$total_realisasi_ft = 0;
		$total_persen_deviasi_f = 0;
		$total_persen_deviasi_k = 0;
		$hitungdata = 0;

		$nol = 0;
		$program = $this->realisasi_akumulasi_model->get_program($id_instansi)->result();
		foreach ($program as $key => $value) {
			$no_program++;
			$pagu_program += $value->pagu;
			// Font
			$pdf->SetFont('Arial', 'B', 'L');
			$pdf->SetFontSize(6.5);

			$pdf->Cell(10, 6, $no_program, 1, 0);
			$pdf->Cell(337, 6, $value->nama_program, 1, 1, '', false);

			$no_kegiatan = 0;
			
			$kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $value->kode_rekening_program, $value->kode_bidang_urusan)->result();


			foreach ($kegiatan as $key => $value_kegiatan) {
				
				$no_kegiatan++;
				$pdf->SetFont('Arial', 'B', 'L');
				$pdf->SetFontSize(6);
				$pdf->Cell(10, 6, $no_program . '.' . $no_kegiatan, 1, 0);
				$pdf->Cell(337, 6,  '    ' . $value_kegiatan->nama_kegiatan, 1, 1, '', false);

				
				$no_sub_kegiatan = 0;
				$sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan)->result();

			
				foreach ($sub_kegiatan as $key => $value_sk) {
				
					$no_sub_kegiatan++;
					$pdf->SetFont('Arial', '', 'L');
					$pdf->SetFontSize(6);
					$pdf->Cell(10, 6, $no_program . '.' . $no_kegiatan. '.' . $no_sub_kegiatan, 1, 0);
					$pdf->Cell(163, 6, '        ' . $value_sk->nama_sub_kegiatan, 1, 0);
					$pdf->Cell(18, 6, number_format($value_sk->pagu), 1, 0, 'R');

					$sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();

					$pdf->Cell(18, 6, number_format(isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0), 1, 0, 'R');
					$pdf->Cell(18, 6, number_format(isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0), 1, 0, 'R');
					$pdf->Cell(18, 6, number_format(isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0), 1, 0, 'R');
					$pdf->Cell(18, 6, number_format(isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0), 1, 0, 'R');
					$pdf->Cell(18, 6, number_format(isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0), 1, 0, 'R');

					$target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan)->row_array();
					$realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope)->row_array();

					if ($value_sk->pagu == 0) {
						$persen_target_keuangan 	= 0;
						$persen_realisasi_keuangan 	= 0;
					} else {
						$persen_target_keuangan     = round(($target['target_keuangan'] / $value_sk->pagu) * 100, 2);
						$persen_realisasi_keuangan 	= round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);
					}					
					$pdf->Cell(8, 6, $target['target_fisik'] =='' ? 0: $target['target_fisik']	, 1, 0, 'R');
					$pdf->Cell(8, 6, $persen_target_keuangan, 1, 0, 'R');


					$pdf->Cell(18, 6, number_format($realisasi_keuangan['total_realisasi']), 1, 0, 'R');

					$pdf->Cell(8, 6, round($persen_realisasi_keuangan,2), 1, 0, 'R');


					$total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $value_sk->kode_rekening_sub_kegiatan)->num_rows();
					$jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $value_sk->kode_rekening_sub_kegiatan, "RUTIN")->num_rows();
					$swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'SWAKELOLA', $ope)->row_array();
					$pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, 'PENYEDIA', $ope)->row_array();
					$rut = $jenis_rutin > 0 ? ($jenis_rutin * round($bulan / 12 * 100, 2)) : 0;
					$total_angka_target_keuangan += $target['target_keuangan'];

					$swa_tot	= !empty($swa['total']) ? $swa['total'] : 0;
					$pen_tot  = !empty($pen['total']) ? $pen['total'] : 0;
					$rut_tot  = !empty($rut) ? $rut : 0;
					$pagu_opd = $this->realisasi_akumulasi_model->get_pagu_opd($id_instansi)->row_array();
					$tot_pagu = !empty($pagu_opd['pagu']) ? $pagu_opd['pagu'] : 0;

					if ($total_paket != 0) {
						$total_fisik = ROUND(($swa_tot + $pen_tot + $rut_tot) / $total_paket,2);
					} else {
						$total_fisik = 0;
					}

					$total_fisik  	= ROUND($total_fisik, 2) > 100 ? 100 : ROUND($total_fisik, 2);
					$uang_fisik   	= ($total_fisik / 100) * $value_sk->pagu;
					@$persen_fisik 	= ($uang_fisik / $tot_pagu) * 100;

					$pdf->Cell(8, 6, $total_fisik, 1, 0, 'R');
					
					$dev_fisik = $total_fisik - $target['target_fisik'];
					$dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;

					$pdf->Cell(8, 6, ROUND($dev_fisik, 2), 1, 0, 'R');
					$pdf->Cell(8, 6, ROUND($dev_keu, 2), 1, 1, 'R');

					$total_pad 		+= isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0;
					$total_dau 		+= isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0;
					$total_dak 		+= isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0;
					$total_dbh 		+= isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0;
					$total_lainnya 	+= isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0;
					$total_target_fisik 	+= isset($target['target_fisik']) ? $target['target_fisik'] : 0;
					// last update 09102020
					$total_target_keuangan += isset($persen_target_keuangan) ? $persen_target_keuangan : 0;
					$total_realisasi_keuangan += isset($realisasi_keuangan['total_realisasi']) ? $realisasi_keuangan['total_realisasi'] : 0;
					$total_persen_realisasi_keuangan += isset($persen_realisasi_keuangan) ? $persen_realisasi_keuangan : 0;
					$total_persen_realisasi_fisik += isset($total_fisik) ? $total_fisik : 0;
					$total_realisasi_ft += isset($persen_fisik) ? ROUND($persen_fisik, 2) : 0;
					$total_persen_deviasi_f += isset($dev_fisik) ? ROUND($dev_fisik, 2) : 0;
					$total_persen_deviasi_k += isset($dev_keu) ? ROUND($dev_keu, 2) : 0;

				}
			}
		
		}

		$pdf->Cell(173, 6, 'Total', 1, 0, 'R');
		
		$pdf->Cell(18, 6, number_format($pagu_program), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_pad), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_dau), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_dak), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_dbh), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_lainnya), 1, 0, 'R');





		$totaldata = $this->realisasi_akumulasi_model->jumlah_kegiatan($id_instansi);
		// dijadikan untuk rata rata pada target fisik, target keuangan, realisasi keuangan % , realisasi fisik, realisasi fisik tertimbang (FT), deviasi fisik, deviasi keuangan, 
		@$ratarata_target_fisik = $total_target_fisik / $totaldata;
		// $ratarata_target_keuangan = $total_target_keuangan / $totaldata;
		@$ratarata_target_keuangan = ($total_angka_target_keuangan / $pagu_program) * 100; // $totaldata;



		@$ratarata_persen_realisasi_keuangan = ($total_realisasi_keuangan / $pagu_program) * 100;
		// $ratarata_persen_realisasi_keuangan = $total_persen_realisasi_keuangan/$totaldata;
		
		@$ratarata_persen_realisasi_fisik = $total_persen_realisasi_fisik / $totaldata;
		@$ratarata_persen_realisasi_ft = $total_realisasi_ft / $totaldata;

		 

		$total_persen_deviasi_f = $ratarata_persen_realisasi_fisik - $ratarata_target_fisik ;
		$total_persen_deviasi_k = $ratarata_persen_realisasi_keuangan- $ratarata_target_keuangan ;

		$pdf->Cell(8, 6, number_format($ratarata_target_fisik, 2, '.', ''), 1, 0, 'R');
		$pdf->Cell(8, 6, number_format($ratarata_target_keuangan, 2, '.', ''), 1, 0, 'R');
		$pdf->Cell(18, 6, number_format($total_realisasi_keuangan), 1, 0, 'R');
		$pdf->Cell(8, 6, number_format($ratarata_persen_realisasi_keuangan, 2, '.', ''), 1, 0, 'R');
		$pdf->Cell(8, 6, number_format($ratarata_persen_realisasi_fisik, 2, '.', ''), 1, 0, 'R');
		$pdf->Cell(8, 6, number_format($total_persen_deviasi_f, 2, '.', ''), 1, 0, 'R');
		$pdf->Cell(8, 6, number_format($total_persen_deviasi_k, 2, '.', ''), 1, 0, 'R');
		
		// last update 09102020

		$pdf->Output($judul_file, 'I');
		
		
	}

	public function rekap_asisten()
	{
		$breadcrumbs    = $this->breadcrumbs;
		$rekap_asisten  = $this->rekap_asisten_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Rekap Asisten', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Rekap Asisten";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan realisasi fisik dan keuangan per Asisten";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$page               	= 'laporan/rekap_asisten/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/rekap_asisten/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/rekap_asisten/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/rekap_asisten/modal', $data, true);
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
	public function realisasi_per_asisten()
	{
		global $bulan;

		$bulan 			= $this->input->get('bulan');
		$judul_file = 'Rekapitulasi Per Asisten' . '.pdf';

		// New
		$this->load->library('format_realisasi');
		$pdf = new Laporan_asisten('L', 'mm', [215, 330]);
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(10);
		$pdf->AddPage();
		$pdf->SetTitle('Rekapitulasi Per Asisten ' . date('Y'));
		$pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);

		$pagu_total = $this->rekap_asisten_model->get_pagu_total();
		$asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan)->result();
		$asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan)->result();
		$asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan)->result();

		// Font
		$pdf->SetFont('Arial', 'B', 'L');
		$pdf->SetFontSize(5);

		$pdf->cell(93, 2, '', 'T,L,R', 0, 'C'); // Table 1, Columns 1, Row 1
		$pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 1, Columns 2, Row 1
		$pdf->cell(12, 2, '', 'T,L', 1, 'C'); // Table 1, Columns 3, Row 1, New Line

		$pdf->cell(93, 2, 'Asisten Pemerintahan', 'L,R', 0, 'C'); // Table 1, Columns 1, Row 2
		$pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 1, Columns 2, Row 2
		$pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 1, Columns 3, Row 2, New Line
		$pdf->cell(105, 1.9, '', 'R', 1, 'C'); // Table 1, Columns 3, Row 2

		// Asisten Pemerintahan
		$pdf->cell(93, 6, '', 'L', 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 1, 'C');
		// Content Asisten Pemerintahan
		$tertimbang_satu       = 0;
		$total_t_fisik_satu    = 0;
		$total_t_keu_satu      = 0;
		$total_r_fisik_satu    = 0;
		$total_r_keu_satu      = 0;
		$total_tertimbang_satu = 0;
		$jml_skpd_satu         = 0;

		foreach ($asisten_1 as $satu) {
			$pdf->SetFont('Arial', 'B', 'L');
			$pdf->SetFontSize(5);
			$pdf->Cell(93, 6, $satu->nama_instansi, 1, 0, '', false);
			$pdf->Cell(6, 6, $satu->target_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $satu->target_keuangan, 1, 0, '', false);
			$pdf->Cell(6, 6, $satu->realisasi_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $satu->realisasi_keuangan, 1, 1, '', false);
			$total_t_fisik_satu    += $satu->target_fisik;
			$total_t_keu_satu      += $satu->target_keuangan;
			$total_r_fisik_satu    += $satu->realisasi_fisik;
			$total_r_keu_satu      += $satu->realisasi_keuangan;
			$jml_skpd_satu++;
		}


		$total_t_fisik_satu		=  $total_t_fisik_satu / $jml_skpd_satu; 
		$total_t_keu_satu		=  $total_t_keu_satu / $jml_skpd_satu; 
		$total_r_fisik_satu		=  $total_r_fisik_satu / $jml_skpd_satu; 
		$total_r_keu_satu		=  $total_r_keu_satu / $jml_skpd_satu; 
		$pdf->Cell(93, 6, 'Rata-Rata', 1, 0, 'R');
		$pdf->Cell(6, 6, ROUND($total_t_fisik_satu, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_t_keu_satu, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_fisik_satu, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_keu_satu, 2), 1, 0, '', false);

		// ================================================================================ //

		$pdf->SetFont('Arial', 'B', 'L');
		$pdf->SetFontSize(5);
		// Asisten Perekonomian dan Pembangunan
		$pdf->SetY(30);
		$pdf->SetX(127);

		$pdf->cell(71, 2, '', 'T,L,R', 0, 'C'); // Table 2, Columns 1, Row 1
		$pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 2, Columns 2, Row 1
		$pdf->cell(12, 2, '', 'T,L', 1, 'C'); // Table 2, Columns 3, Row 1, New Line

		$pdf->SetX(127);
		$pdf->cell(71, 2, 'Asisten Perekonomian dan Pembangunan', 'L,R', 0, 'C'); // Table 2, Columns 1, Row 2
		$pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 2, Columns 2, Row 2
		$pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 2, Columns 3, Row 2, New Line
		$pdf->SetX(127);
		$pdf->cell(83, 1.9, '', 0, 0, 'C'); // Table 2, Columns 3, Row 2
		$pdf->cell(12, 1.9, '', 'L', 1, 'C'); // Table 2, Columns 3, Row 2

		$pdf->SetX(127);
		$pdf->cell(71, 6, '', 'L', 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 1, 'C');

		$xxx = 42;
		$yyy = 6;
		$tertimbang_dua = 0;
		$total_t_fisik_dua    = 0;
		$total_t_keu_dua      = 0;
		$total_r_fisik_dua    = 0;
		$total_r_keu_dua      = 0;
		$total_tertimbang_dua = 0;
		$jml_skpd_dua         = 0;

		foreach ($asisten_2 as $dua) {
			// Font
			$pdf->SetFont('Arial', 'B', 'L');
			$pdf->SetFontSize(5);
			$pdf->SetX(127);
			$pdf->Cell(71, 6, $dua->nama_instansi, 1, 0, '', false);
			$pdf->Cell(6, 6, $dua->target_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $dua->target_keuangan, 1, 0, '', false);
			$pdf->Cell(6, 6, $dua->realisasi_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $dua->realisasi_keuangan, 1, 1, '', false);

			$total_t_fisik_dua    += $dua->target_fisik;
			$total_t_keu_dua      += $dua->target_keuangan;
			$total_r_fisik_dua    += $dua->realisasi_fisik;
			$total_r_keu_dua      += $dua->realisasi_keuangan;
			$jml_skpd_dua++;
		}
		$pdf->SetX(127);


		$total_t_fisik_dua		=  $total_t_fisik_dua / $jml_skpd_dua; 
		$total_t_keu_dua		=  $total_t_keu_dua / $jml_skpd_dua; 
		$total_r_fisik_dua		=  $total_r_fisik_dua / $jml_skpd_dua; 
		$total_r_keu_dua		=  $total_r_keu_dua / $jml_skpd_dua; 
		$pdf->Cell(71, 6, 'Rata-Rata', 1, 0, 'R');
		$pdf->Cell(6, 6, ROUND($total_t_fisik_dua, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_t_keu_dua, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_fisik_dua, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_keu_dua, 2), 1, 0, '', false);

		// ============================================================================ //

		$pdf->SetFont('Arial', 'B', 'L');
		$pdf->SetFontSize(5);
		// Asisten Perekonomian dan Pembangunan
		$pdf->SetY(30);
		$pdf->SetX(222); //204

		$pdf->cell(71, 2, '', 'T,L,R', 0, 'C'); // Table 3, Columns 1, Row 1
		$pdf->cell(12, 2, '', 'T', 0, 'C'); // Table 3, Columns 2, Row 1
		$pdf->cell(12, 2, '', 'T,L,R', 1, 'C'); // Table 3, Columns 3, Row 1, New Line

		$pdf->SetX(222);
		$pdf->cell(71, 2, 'Asisten Administrasi Umum dan Kesra', 'L,R', 0, 'C'); // Table 3, Columns 1, Row 2
		$pdf->cell(12, 0.1, 'Target', 0, 0, 'C'); // Table 3, Columns 2, Row 2
		$pdf->cell(12, 0.1, 'Realisasi', 'L,R', 1, 'C'); // Table 3, Columns 3, Row 2, New Line
		$pdf->SetX(222);
		$pdf->cell(83, 1.9, '', 0, 0, 'C'); // Table 3, Columns 3, Row 2
		$pdf->cell(12, 1.9, '', 'L,R', 1, 'C'); // Table 3, Columns 3, Row 2

		$pdf->SetX(222);
		$pdf->cell(71, 6, '', 'L', 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 0, 'C');
		$pdf->cell(6, 6, 'F', 1, 0, 'C');
		$pdf->cell(6, 6, 'K', 1, 1, 'C');

		$xxx = 42;
		$yyy = 6;
		$tertimbang_tiga = 0;
		$total_t_fisik_tiga    = 0;
		$total_t_keu_tiga      = 0;
		$total_r_fisik_tiga    = 0;
		$total_r_keu_tiga      = 0;
		$total_tertimbang_tiga = 0;
		$jml_skpd_tiga         = 0;
		foreach ($asisten_3 as $tiga) {
			// Font
			$pdf->SetFont('Arial', 'B', 'L');
			$pdf->SetFontSize(5);
			$pdf->SetX(222);
			$pdf->Cell(71, 6, $tiga->nama_instansi, 1, 0, '', false);
			$pdf->Cell(6, 6, $tiga->target_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $tiga->target_keuangan, 1, 0, '', false);
			$pdf->Cell(6, 6, $tiga->realisasi_fisik, 1, 0, '', false);
			$pdf->Cell(6, 6, $tiga->realisasi_keuangan, 1, 1, '', false);

			$total_t_fisik_tiga    += $tiga->target_fisik;
			$total_t_keu_tiga      += $tiga->target_keuangan;
			$total_r_fisik_tiga    += $tiga->realisasi_fisik;
			$total_r_keu_tiga      += $tiga->realisasi_keuangan;

			$jml_skpd_tiga++;
		}
		$pdf->SetX(222);
		
		$total_t_fisik_tiga		=  $total_t_fisik_tiga / $jml_skpd_tiga; 
		$total_t_keu_tiga		=  $total_t_keu_tiga / $jml_skpd_tiga; 
		$total_r_fisik_tiga		=  $total_r_fisik_tiga / $jml_skpd_tiga; 
		$total_r_keu_tiga		=  $total_r_keu_tiga / $jml_skpd_tiga; 
		$pdf->Cell(71, 6, 'Rata-Rata', 1, 0, 'R');
		$pdf->Cell(6, 6, ROUND($total_t_fisik_tiga, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_t_keu_tiga, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_fisik_tiga, 2), 1, 0, '', false);
		$pdf->Cell(6, 6, ROUND($total_r_keu_tiga, 2), 1, 0, '', false);

		$pdf->Output('Laporan Rekapitulasi.pdf', 'I');
	}

	public function rekap_realisasi_total()
	{
		$breadcrumbs    				= $this->breadcrumbs;
		$rekap_realisasi_total 	= $this->rekap_realisasi_total_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Rekap Realisasi Total', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Rekap Realisasi Total";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan rekap realisasi total";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$page               	= 'laporan/rekap_realisasi_total/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/rekap_realisasi_total/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/rekap_realisasi_total/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/rekap_realisasi_total/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}

	public function realisasi_total()
	{
		$this->load->library('format_rekap_realisasi_total');

		$judul_file = "tes.pdf";
		$url = 'https://export.highcharts.com/';
		$img_chart 	= $this->input->get('tes');

		$pdf = new Format_rekap_realisasi_total('P', 'mm', 'a4');
		$pdf->SetTopMargin(4);
		$pdf->SetLeftMargin(4);
		$pdf->AddPage();
		$pdf->SetTitle('Laporan Realisasi Tahun Anggaran ' . date('Y'));
		$pdf->SetAuthor("nama_user()");
		$pdf->SetCompression(true);

		$pdf->Image($url . $img_chart, 0, 30, 105, 70);



		$pdf->Output($judul_file, 'I');
	}


	public function jumlah_aktivitas()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class().'/'.$this->router->fetch_method()));
		$breadcrumbs->add('Jumlah Aktivitas', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Laporan Paket Pekerjaan Per SKPD";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan Paket Pekerjaan Per SKPD";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$page               	= 'laporan/jumlah_aktivitas/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/jumlah_aktivitas/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/jumlah_aktivitas/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/jumlah_aktivitas/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
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
		 $pdf->SetFontSize(7);













			$opd 	= $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();
			$total_anggaran = 0;
			$total_paket_rutin = 0;
			$total_paket_swakelola = 0;
			$total_paket_penyedia = 0;
			$jumlah_program = 0;
			$jumlah_kegiatan = 0;

			$no = 1;
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


				$id_instansi	= $value->id_instansi;
	
				$nama_instansi	= $value->nama_instansi;
				$pagu_anggaran	= number_format($pagu_anggaran);
				$banyak_program	= number_format($program);
				$banyak_kegiatan	= number_format($kegiatan);
				$paket_rutin	= $p_rutin;
				$paket_swakelola	= $p_swakelola;
				$paket_penyedia	= $p_penyedia;

				$total_program =$jumlah_program += $program ;
				$total_kegiatan =$jumlah_kegiatan += $kegiatan ;


				$pdf->cell(10, 5, $no++, 1, 0,'C');
		$pdf->cell(98, 5, ucwords($nama_instansi), 1, 0 );
		$pdf->cell(25, 5, ($pagu_anggaran), 1, 0, 'R');
		$pdf->cell(15, 5, ($banyak_program), 1, 0, 'C');
		$pdf->cell(15, 5, ($banyak_kegiatan), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_rutin), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_swakelola), 1, 0, 'C');
		$pdf->cell(13, 5, ($paket_penyedia), 1, 0, 'C');
		$pdf->Ln(5);
			
			}
			
			$total_anggaran = number_format($total_anggaran);
			$total_paket_swakelola = number_format($total_paket_swakelola);
			$total_paket_penyedia = number_format($total_paket_penyedia);
			$total_paket_rutin = number_format($total_paket_rutin);
	

			$pdf->cell(108, 5, "Total ", 1, 0);
			$pdf->cell(25, 5, $total_anggaran, 1, 0, 'R');
			$pdf->cell(15, 5, ($total_program), 1, 0, 'C');
			$pdf->cell(15, 5, ($total_kegiatan), 1, 0, 'C');
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



 public function sync_all()
    {

        $opd    = $this->db->query("SELECT id_instansi, kode_opd, nama_instansi FROM master_instansi WHERE kategori = 'OPD' AND id_instansi != 3 ORDER BY kode_opd ASC")->result();
        foreach ($opd as $key => $value) {
            $id_instansi        = $value->id_instansi;
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
                $r_jan  += $value->jan / $t_anggaran * 100;
                $r_feb  += $value->feb / $t_anggaran * 100;
                $r_mar  += $value->mar / $t_anggaran * 100;
                $r_apr  += $value->apr / $t_anggaran * 100;
                $r_mei  += $value->mei / $t_anggaran * 100;
                $r_jun  += $value->jun / $t_anggaran * 100;
                $r_jul  += $value->jul / $t_anggaran * 100;
                $r_agu  += $value->agu / $t_anggaran * 100;
                $r_sep  += $value->sep / $t_anggaran * 100;
                $r_okt  += $value->okt / $t_anggaran * 100;
                $r_nov  += $value->nov / $t_anggaran * 100;
                $r_des  += $value->des / $t_anggaran * 100;
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

            $realisasi_keuangan[]    = $r_jan > 0 ? $r_jan : 0;
            $realisasi_keuangan[]    = $r_feb > 0 ? ROUND($r_feb + $realisasi_keuangan[0], 2) : $realisasi_keuangan[0];
            $realisasi_keuangan[]    = $r_mar > 0 ? ROUND($r_mar + $realisasi_keuangan[1], 2) : $realisasi_keuangan[1];
            $realisasi_keuangan[]    = $r_apr > 0 ? ROUND($r_apr + $realisasi_keuangan[2], 2) : $realisasi_keuangan[2];
            $realisasi_keuangan[]    = $r_mei > 0 ? ROUND($r_mei + $realisasi_keuangan[3], 2) : $realisasi_keuangan[3];
            $realisasi_keuangan[]    = $r_jun > 0 ? ROUND($r_jun + $realisasi_keuangan[4], 2) : $realisasi_keuangan[4];
            $realisasi_keuangan[]    = $r_jul > 0 ? ROUND($r_jul + $realisasi_keuangan[5], 2) : $realisasi_keuangan[5];
            $realisasi_keuangan[]    = $r_agu > 0 ? ROUND($r_agu + $realisasi_keuangan[6], 2) : $realisasi_keuangan[6];
            $realisasi_keuangan[]    = $r_sep > 0 ? ROUND($r_sep + $realisasi_keuangan[7], 2) : $realisasi_keuangan[7];
            $realisasi_keuangan[]    = $r_okt > 0 ? ROUND($r_okt + $realisasi_keuangan[8], 2) : $realisasi_keuangan[8];
            $realisasi_keuangan[]    = $r_nov > 0 ? ROUND($r_nov + $realisasi_keuangan[9], 2) : $realisasi_keuangan[9];
            $realisasi_keuangan[]    = $r_des > 0 ? ROUND($r_des + $realisasi_keuangan[10], 2) : $realisasi_keuangan[10];

            $data = [];
            foreach ($target_fisik as $key => $value) {
                $data[] = array(
                    'id_instansi' => $id_instansi,
                    'bulan' => $key + 1,
                    'target_fisik' => $target_fisik[$key],
                    'target_keuangan' => $target_keuangan[$key],
                    'realisasi_fisik' => $realisasi_fisik[0][$key],
                    'realisasi_keuangan' => $realisasi_keuangan[$key],
                    'last_update' => timestamp()
                );
            }

            $result = $this->db->insert_batch('grafik', $data);


        }
            $output = [];
            $output['status'] = true;
            echo json_encode($output);
    }



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










public function testing(){

    // $data = array(
    //     "dataku" => array(
    //         "nama" => "Petani Kode",
    //         "url" => "http://petanikode.com"
    //     )
    // );

    // $this->load->library('dompdf/pdf');

    // $this->pdf->setPaper('A4', 'landscape');
    // $this->pdf->filename = "laporan-petanikode.pdf";
    // $this->pdf->load_view('laporan/testing', $data);
    $this->load->view('laporan/testing');


}
}
