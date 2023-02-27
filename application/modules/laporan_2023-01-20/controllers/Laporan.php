<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Laporan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends MY_Controller { 


	public function __construct() {
	parent::__construct(); 
	$this->load->model([
	'realisasi/realisasi_fisik_keuangan_model'    => 'realisasi_fisik_keuangan_model',
	'realisasi/realisasi_keuangan_model'    => 'realisasi_keuangan_model',


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


	'register_kontrak/daftar_kontrak_model' => 'daftar_kontrak_model',


	'laporan/statistika_model' => 'statistika_model',
	'config/config_model' => 'config_model',
	'data_apbd/data_apbd_model'      => 'data_apbd_model',
			]);
	error_reporting(0);
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
	public function perbandingan_pagu_apbd()
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
		$page               	= 'laporan/perbandingan_pagu_apbd/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/perbandingan_pagu_apbd/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/perbandingan_pagu_apbd/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/perbandingan_pagu_apbd/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}
	public function berdasarkan_struktur()
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
		$page               	= 'laporan/realisasi_akumulasi/berdasarkan_struktur';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/realisasi_akumulasi/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/realisasi_akumulasi/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/realisasi_akumulasi/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}
	public function bahan_paparan()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Ringkasan Simbangda Based Evidence";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan Ringkasan Data Simbangda Based Evidence Sebagai bahan Paparan";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$data['config']					= $this->db->get('config')->result_array();
		$page               	= 'laporan/views/bahan_paparan/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/views/bahan_paparan/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/views/bahan_paparan/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/views/bahan_paparan/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}

	public function view_perengkingan_opd()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Perengkingan OPD";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Perengkingan OPD";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$data['config']					= $this->db->get('config')->result_array();
		$page               	= 'laporan/views/tabel_perengkingan_opd/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/views/tabel_perengkingan_opd/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/views/tabel_perengkingan_opd/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/views/tabel_perengkingan_opd/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}


	public function realisasi_akumulasi_batasan()
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
		$page               	= 'laporan/realisasi_akumulasi_batasan/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/realisasi_akumulasi_batasan/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/realisasi_akumulasi_batasan/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/realisasi_akumulasi_batasan/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}


	public function rekap_realisasi_kab_kota()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_per_kab_kota    = $this->realisasi_per_kab_kota;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Realisasi Fisik dan Keuangan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan realisasi fisik dan keuangan";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$id_group				= $this->session->userdata('id_group');
		$data['id_group']		= $id_group;
		$data['config']		= $this->db->get('config')->result_array();
		$data['kota']			= $realisasi_per_kab_kota->data_kota($id_group, 13);
		$page               	= 'laporan/realisasi_per_kab_kota/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/realisasi_per_kab_kota/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/realisasi_per_kab_kota/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/realisasi_per_kab_kota/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}


	public function rekap_gabungan_realisasi_kab_kota()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_per_kab_kota    = $this->realisasi_per_kab_kota;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();
		$data['title']      	= "Realisasi Fisik dan Keuangan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan realisasi fisik dan keuangan";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$id_group				= $this->session->userdata('id_group');
		$data['id_group']		= $id_group;
		$data['kota']			= $realisasi_per_kab_kota->data_kota($id_group, 13);
		$data['tahun']			= $this->db->get('config')->result_array();
		$page               	= 'laporan/rekap_gabungan_realisasi_kab_kota/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/rekap_gabungan_realisasi_kab_kota/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/rekap_gabungan_realisasi_kab_kota/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/rekap_gabungan_realisasi_kab_kota/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}



	public function paket_per_skpd()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Realisasi Akumulasi', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Laporan Paket Pekerjaan SKPD";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan Data Paket Pekerjaan SKPD";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$data['config']					= $this->db->get('config')->result_array();
		$page               	= 'laporan/paket_per_skpd/index';
		$data['link']       	= $this->router->fetch_method();
		$data['jenis_paket']       	= ['Semua Paket','RUTIN','SWAKELOLA','PENYEDIA'];
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/paket_per_skpd/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/paket_per_skpd/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/paket_per_skpd/modal', $data, true);
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

					$kategori_sub_kegiatan = $value_sk->kategori;
					if($kategori_sub_kegiatan =='Unit Pelaksana'){
						$height = 12;
						$nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."\n[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
						$pdf->Cell(10, $height, $no_program . '.' . $no_kegiatan. '.' . $no_sub_kegiatan, 1, 0);
						$pdf->Cell(163, $height, '        ' . utf8_decode($nama_sub_kegiatan.chr(10)), 1);
					}else{
						$height = 6;
						$pdf->Cell(10, $height, $no_program . '.' . $no_kegiatan. '.' . $no_sub_kegiatan, 1, 0);
						$pdf->Cell(163, $height, '        ' . $value_sk->nama_sub_kegiatan, 1, 0);

					}
					
					$pdf->Cell(18, $height, number_format($value_sk->pagu), 1, 0, 'R');

					$sumber_dana = $this->realisasi_akumulasi_model->get_sumber_dana($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $value_sk->kode_rekening_kegiatan, $value_sk->kode_rekening_program, $value_sk->kode_bidang_urusan)->row_array();

					$pdf->Cell(18, $height, number_format(isset($sumber_dana['pad']) ? $sumber_dana['pad'] : 0), 1, 0, 'R');
					$pdf->Cell(18, $height, number_format(isset($sumber_dana['dau']) ? $sumber_dana['dau'] : 0), 1, 0, 'R');
					$pdf->Cell(18, $height, number_format(isset($sumber_dana['dak']) ? $sumber_dana['dak'] : 0), 1, 0, 'R');
					$pdf->Cell(18, $height, number_format(isset($sumber_dana['dbh']) ? $sumber_dana['dbh'] : 0), 1, 0, 'R');
					$pdf->Cell(18, $height, number_format(isset($sumber_dana['lainnya']) ? $sumber_dana['lainnya'] : 0), 1, 0, 'R');

					$target = $this->realisasi_akumulasi_model->get_target($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan)->row_array();
					$realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope)->row_array();

					if ($value_sk->pagu == 0) {
						$persen_target_keuangan 	= 0;
						$persen_realisasi_keuangan 	= 0;
					} else {
						$persen_target_keuangan     = round(($target['target_keuangan'] / $value_sk->pagu) * 100, 2);
						$persen_realisasi_keuangan 	= round(($realisasi_keuangan['total_realisasi'] / $value_sk->pagu) * 100, 2);
					}					
					$pdf->Cell(8, $height, $target['target_fisik'] =='' ? 0: $target['target_fisik']	, 1, 0, 'R');
					$pdf->Cell(8, $height, $persen_target_keuangan, 1, 0, 'R');


					$pdf->Cell(18, $height, number_format($realisasi_keuangan['total_realisasi']), 1, 0, 'R');

					$pdf->Cell(8, $height, round($persen_realisasi_keuangan,2), 1, 0, 'R');


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

					$pdf->Cell(8, $height, $total_fisik, 1, 0, 'R');
					
					$dev_fisik = $total_fisik - $target['target_fisik'];
					$dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;

					$pdf->Cell(8, $height, ROUND($dev_fisik, 2), 1, 0, 'R');
					$pdf->Cell(8, $height, ROUND($dev_keu, 2), 1, 0, 'R');
					$pdf->Ln();
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

		$filenya = $pdf->Output($judul_file, 'I');

		// $this->load->helper('file');
		// $primary_folder         = './sbe_files_support/';
  //           $directory              = [
  //               'laporan',
  //               date('Y-m-d')
  //           ];
  //           $list_directory         = $this->sbe_directory($primary_folder, $directory);
  //            if (!file_exists($list_directory)) {
  //               mkdir($list_directory, 0777, TRUE);
  //           }
         
  //       $save = $list_directory.'/'.$filenya;
		// $pdf->Output(F,$save); 
        // write_file($save, $filenya);
		
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

		$data['config']					= $this->db->get('config')->result_array();
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/rekap_asisten/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/rekap_asisten/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/rekap_asisten/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}
	public function rekap_kegiatan_kab_kota()
	{
		$breadcrumbs    = $this->breadcrumbs;
		$rekap_asisten  = $this->rekap_asisten_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Rekap Asisten', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Rekap Kegiatan / Kab Kota";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan kegiatan berdasarkan kabupaten / kota";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$page               	= 'laporan/rekap_kegiatan_kab_kota/index';
		$data['link']       	= $this->router->fetch_method();
		$data['config']       	= $this->db->query("SELECT tahun_anggaran from config");
		$data['provinsi']      	= $this->db->get('provinsi')->result();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/rekap_kegiatan_kab_kota/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/rekap_kegiatan_kab_kota/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/rekap_kegiatan_kab_kota/modal', $data, true);
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

		$pdf = new Laporan_asisten('L', 'mm','legal');
		$pdf->SetFillColor(67, 187, 70);
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
		$pdf->cell(18, 2, '', 'T', 0, 'C'); // Table 1, Columns 2, Row 1
		$pdf->cell(18, 2, '', 'T,L', 1, 'C'); // Table 1, Columns 3, Row 1, New Line

		$pdf->cell(93, 2, 'Asisten Pemerintahan', 'L,R', 0, 'C'); // Table 1, Columns 1, Row 2
		$pdf->cell(18, 0.1, 'Fisik', 0, 0, 'C'); // Table 1, Columns 2, Row 2
		$pdf->cell(18, 0.1, 'Keuangan', 'L,R', 1, 'C'); // Table 1, Columns 3, Row 2, New Line
		$pdf->cell(111, 1.9, '', 'R', 1, 'C'); // Table 1, Columns 3, Row 2

		// Asisten Pemerintahan
		$pdf->cell(93, 6, '', 'L', 0, 'C');
		$pdf->cell(6, 6, 'T', 1, 0, 'C');
		$pdf->cell(6, 6, 'R', 1, 0, 'C');
		$pdf->cell(6, 6, 'D', 1, 0, 'C');
		$pdf->cell(6, 6, 'T', 1, 0, 'C');
		$pdf->cell(6, 6, 'R', 1, 0, 'C');
		$pdf->cell(6, 6, 'D', 1, 1, 'C');
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
		$data['keuangan']=$this->realisasi_keuangan_model;

        $data_apbd_model   = $this->data_apbd_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
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


		if ($tahap==4) {
			$ski_perubahan = $this->db->query("SELECT kode_sub_kegiatan, kode_tahap from sub_kegiatan_instansi where status=1 and tahun='$tahun' and id_instansi='$id_instansi' order by kode_sub_kegiatan asc");
			$kumpul_pagu =[];
			foreach ($ski_perubahan->result_array() as $k => $v) {
			$ksk_ski_perubahan = $v['kode_sub_kegiatan'];
			$kode_tahap_ski_perubahan = $v['kode_tahap'];
			$q_pagu = $this->db->query("SELECT (bo_bp+bo_bbj+bo_bs+bo_bh+bm_bmt+bm_bmpm+bm_bmgb+bm_bmjji+bm_bmatl+btt+bt_bbh+bt_bbk)  as pagu from anggaran_sub_kegiatan where tahun='$tahun' and id_instansi='$id_instansi' and kode_sub_kegiatan='$ksk_ski_perubahan' and kode_tahap='$kode_tahap_ski_perubahan'")->row_array();
				array_push($kumpul_pagu, $q_pagu['pagu']==''?0: $q_pagu['pagu']);
			}
			$total_pagu_skpd = array_sum($kumpul_pagu)	;
		}else{
			$q_pagu = $this->db->query("SELECT total_anggaran_skpd_awal($id_instansi, $tahun) as pagu_skpd")->row_array();
			$total_pagu_skpd = $q_pagu['pagu_skpd'];

		}
		$data['pagu_skpd'] = $total_pagu_skpd;
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
		    // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_dengan_bobot.php', $data, true);
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi', $data, true);
		    // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_dengan_bobot_rutin_sd_rk', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_akumulasi_data_paket_pekerjaan') {
        	$judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_beserta_paket_pekerjaan', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_akumulasi_terbobot') {
        	$judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_dengan_bobot.php', $data, true);
		    // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_akumulasi_terbobot_rutin_sd_rk') {
        	$judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_dengan_bobot_rutin_sd_rk', $data, true);
		    // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_berdasarakan_kelompok_jenis_belanja') {
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Penampilan data Pagu dan Realisasi Keuangan berdasarkan kelompok jenis belanja";
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_berdasarakan_kelompok_jenis_belanja', $data, true);
		    // $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_berdasarakan_jenis_belanja_detail', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_data_sumber_dana') {
        	$judul_penampilan_laporan = "Data Sumber Dana Per Sub Kegiatan";
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_akumulasi_sumber_dana', $data, true);
        	$mpdf->SetMargins(0, 0, 39);
        }
        elseif ($kategori_penampilan_laporan=='rfk_data_paket_pekerjaan') {
        	$judul_penampilan_laporan = "Data Paket Pekerjaan Per Sub Kegiatan <br>".$judul_laporan;
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_rfk_data_paket_pekerjaan', $data, true);
        	$mpdf->SetMargins(0, 0, 42);
        }else{
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Waitting";
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_dalam_pengembangan', $data, true);
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




	public function pdf_perbandingan_pagu_apbd()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'P',
		    'tempDir' => '/tmp'
		]);
		$data['keuangan']=$this->realisasi_keuangan_model;

        $data_apbd_model   = $this->data_apbd_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		


	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();


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

        if ($tahap==4) {
        	$judul_penampilan_laporan = "Laporan Perbandingan Pagu <br> APBD AWAL Dan APBD PERUBAHAN";
        	if ($kategori=='pagu_total') {
			    $html =  $this->load->view('laporan/pdf/perbandingan_pagu_apbd/perbandingan_awal_perubahan', $data, true);
        	
        	}else{
			    $html =  $this->load->view('laporan/pdf/perbandingan_pagu_apbd/perbandingan_awal_perubahan_per_jenis_belanja', $data, true);

        	}
        	$mpdf->SetMargins(0, 0, 42);
        }else{
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Waitting";
		    $html =  $this->load->view('laporan/pdf/perbandingan_pagu_apbd/content_dalam_pengembangan', $data, true);
		    $mpdf->SetMargins(0, 0, 42);

        }
         $data['judul_laporan']=$judul_penampilan_laporan;
	    $header =  $this->load->view('laporan/pdf/perbandingan_pagu_apbd/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/perbandingan_pagu_apbd/footer', $data, true);


		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($nama_instansi.' - '.$judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}




	public function tabel_laporan_realisasi_akumulasi_batasan()
	{
		
		$data['keuangan']=$this->realisasi_keuangan_model;

        $data_apbd_model   = $this->data_apbd_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		$kategori 		= 'akumulasi';//$this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');


		$data_apbd 				= $this->input->get('data_apbd');
		$pilihan_batasan 				= $this->input->get('pilihan_batasan');
		$batasan 				= $this->input->get('batasan');
		$fisik_keuangan 				= $this->input->get('fisik_keuangan');
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
	    $data['pilihan_batasan']=$pilihan_batasan;
	    $data['data_apbd']=$data_apbd;
	    $data['batasan']=$batasan;
	    $data['nama_instansi']=$nama_instansi;
	    $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

      $keterangan_batasan = 'Data '.$data_apbd.' '.$pilihan_batasan.' '.$batasan.'%';
     $judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan.'<br>'.$keterangan_batasan;
		 
  
         $data['judul_laporan']=$judul_penampilan_laporan;
	    // $header =  $this->load->view('laporan/tabel/realisasi_akumulasi_batasan/header', $data, true);
	    // $footer =  $this->load->view('laporan/tabel/realisasi_akumulasi_batasan/footer', $data, true);

         		


         if ($data_apbd=='Program') {
         		$page               	= 'laporan/tabel/realisasi_akumulasi_batasan/content_rfk_akumulasi_program_'.$fisik_keuangan;
         }
         elseif ($data_apbd=='Kegiatan') {
         		$page               	= 'laporan/tabel/realisasi_akumulasi_batasan/content_rfk_akumulasi_kegiatan_'.$fisik_keuangan;
         }
         elseif ($data_apbd=='Sub kegiatan') {
         		$page               	= 'laporan/tabel/realisasi_akumulasi_batasan/content_rfk_akumulasi_sub_kegiatan_'.$fisik_keuangan;
         	

         }
         else{
         	# code...
         }
		$this->load->view($page, $data);

	
	}





	public function pdf_laporan_paket_per_skpd()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);
		$data['keuangan']=$this->realisasi_keuangan_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		$kategori 		= $this->input->get('kategori');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$metode 				= $this->input->get('metode');
		$bulan 				= bulan_aktif();//$this->input->get('metode');
		$ope 				= '<=';
		
		$judul_laporan = "Laporan Rekapitulasi Paket Pekerjaan ";
	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();
	    $paket_pekerjaan = $this->realisasi_akumulasi_model->get_paket_per_opd($id_instansi);
	    $paket_pekerjaan_group_sub_kegiatan = $this->realisasi_akumulasi_model->get_paket_per_opd_group_sub_kegiatan($id_instansi);
	    $data['identitas']=$identitas;
	    $data['program']=$program;
	    $data['ope']=$ope;
	    $data['bulan']=$bulan;
	    $data['paket']=$paket_pekerjaan;
	    $data['sub_kegiatan_paket']=$paket_pekerjaan_group_sub_kegiatan;
	 
	    $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	    $data['jenis_paket']=$jenis_paket;
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	   	
	   	$judul_ok = $nama_instansi.' - '.$judul_laporan.' - '. pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
	    $data['title']=$judul_ok;
	    $data['nama_instansi']=$nama_instansi;
	    $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        	$judul_penampilan_laporan = $judul_laporan ;//.'<br>'."Realisasi fisik sampai bulan ".bulan_global(bulan_aktif()).' '.$tahun;
		    $html =  $this->load->view('laporan/pdf/paket_per_skpd/content_rfk_data_paket_pekerjaan_group_by_sub_kegiatan', $data, true);

        
         $data['judul_laporan']=$judul_penampilan_laporan;
	    $header =  $this->load->view('laporan/pdf/paket_per_skpd/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/paket_per_skpd/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_ok.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}

	// public function pdf_laporan_paket_per_skpd()
	// {
	// 	$mpdf = new \Mpdf\Mpdf([
	// 	    'mode' => 'utf-8',
	// 	    'format' => 'Legal',
	// 	    'orientation' => 'L',
	// 	    'tempDir' => '/tmp'
	// 	]);
	// 	$data['keuangan']=$this->realisasi_keuangan_model;

	// 	// $mpdf->setFooter('Page {PAGENO}');
	// 	global $id_instansi;
	// 	global $kategori;
	// 	global $bulan;

	// 	$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

	// 	$identitas = $this->db->get('identitas')->row_array();
 //    // $id_instansi = 12;
	// 	$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
	// 	$kategori 		= $this->input->get('kategori');
	// 	$tahun 				= $this->input->get('tahun');
	// 	$tahap 				= $this->input->get('tahap');
	// 	$jenis_paket 				= $this->input->get('jenis_paket');
	// 	$metode 				= $this->input->get('metode');
		 
	// 	$judul_laporan = "Laporan Rekapitulasi Paket Pekerjaan ";
	//     $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();
	//     $paket_pekerjaan = $this->realisasi_akumulasi_model->get_paket_per_opd($id_instansi);
	//     $data['identitas']=$identitas;
	//     $data['program']=$program;
	//     $data['paket']=$paket_pekerjaan;
	 
	//     $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	//     $data['jenis_paket']=$jenis_paket;
	//     $data['tahap']=$tahap;
	//     $data['tahun']=$tahun;
	//     $data['id_instansi']=$id_instansi;
	//     $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	   	
	//    	$judul_ok = $judul_laporan.' '.$nama_instansi.' - '. pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
	//     $data['title']=$judul_ok;
	//     $data['nama_instansi']=$nama_instansi;
	//     $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

	//     $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
 //        $data['tanggal_penarikan'] = $tanggal_penarikan ;

 //        	$judul_penampilan_laporan = $judul_laporan ;//.'<br>'."Realisasi fisik sampai bulan ".bulan_global(bulan_aktif()).' '.$tahun;
	// 	    $html =  $this->load->view('laporan/pdf/paket_per_skpd/content_rfk_data_paket_pekerjaan_terstruktur', $data, true);

        
 //         $data['judul_laporan']=$judul_penampilan_laporan;
	//     $header =  $this->load->view('laporan/pdf/paket_per_skpd/header', $data, true);
	//     $footer =  $this->load->view('laporan/pdf/paket_per_skpd/footer', $data, true);

	//     $mpdf->SetMargins(0, 0, 42);

	// 	$mpdf->SetHTMLHeader($header);
	// 	$mpdf->SetHTMLFooter($footer);
	// 	$mpdf->WriteHTML($html);
	// 	$mpdf->Output($judul_ok.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	// }



	public function pdf_laporan_register_kontrak()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);
		$data['keuangan']=$this->realisasi_keuangan_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');

		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		
	    $kontrak = $this->daftar_kontrak_model->list_kontrak_per_skpd($id_instansi, $tahap, $tahun)->result_array();
	    $data['identitas']=$identitas;
	    $data['kontrak']=$kontrak;
	    $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	   	$judul_laporan = "Daftar Kontrak Pekerjaan";
	    $data['title']=$judul_laporan.' '.$nama_instansi;
	    $data['nama_instansi']=$nama_instansi;

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        
        	$judul_penampilan_laporan = $judul_laporan.'<br>'.$nama_instansi;
		    $html =  $this->load->view('laporan/pdf/daftar_kontrak/content_list_kontrak', $data, true);

     
         $data['judul_laporan']=$judul_penampilan_laporan;
	    $header =  $this->load->view('laporan/pdf/daftar_kontrak/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/daftar_kontrak/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}



	public function pdf_laporan_realisasi_per_kab_kota()
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
		$fisik_keuangan       = $this->realisasi_fisik_keuangan_model;
		$realisasi_per_kab_kota       = $this->realisasi_per_kab_kota;
        $config_model       = $this->config_model;

		$id_kota 	= sbe_crypt($this->input->get('id_kota'), 'D');
		$id_provinsi 	= 13;//$this->input->get('id_provinsi');
		$penampilan_data 	= $this->input->get('penampilan');


		$kategori 		= $this->input->get('kategori');
		$bulan 				= $this->input->get('bulan');
		$tahun 				= $this->input->get('tahun');

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
	    $data['tahun']=$tahun;	
	    $data['nama_tahap']=$nama_tahap[$tahap];	
	    $data['fisik_keuangan']=$fisik_keuangan;	
	    $data['realisasi_per_kab_kota']=$realisasi_per_kab_kota;	
	    $data['skpd']=$skpd;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=$judul_laporan;	
	    $data['config']=$config;	
	    $data['nama_kota']=$nama_kota;	
	    $data['penampilan_data']=$penampilan_data;	

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;
	  	
	  	if ($penampilan_data=='rfk_jenis_belanja') {
		    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/content_laporan_per_jenis_belanja', $data, true);
	  			  	}
	  	// trfkd = target dan realisasi keuangan dengan deviasi
	  	elseif ($penampilan_data=='trfkd') {
		    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/content_laporan_dengan_deviasi', $data, true);
	  	}
	  	// trfkd = target dan realisasi keuangan dengan deviasi
	  	elseif ($penampilan_data=='rea_lra') {
		    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/content_laporan_dengan_lra', $data, true);
	  	}else{
		    $html =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/error', $data, true);
	  	}

	    $header =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_per_kab_kota/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

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

		
		$id_provinsi 	= 13;//$this->input->get('id_provinsi');
		$wilayah 	= $this->input->get('wilayah');
		$tahap 	= $this->input->get('tahap');
		$tahun 	= $this->input->get('tahun');

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
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) Kabupaten / kota se sumatera barat [".$show_nama_tahap."]".$nama_wilayah." <br>sampai dengan bulan ".bulan_global($bulan).' '.$tahun;
				break;
			default:
				$ope = '=';
				$judul_laporan = "Rekapitulasi <br>Laporan realisasi Fisik dan Keuangan (RFK) Kabupaten / kota se sumatera barat [".$show_nama_tahap."]".$nama_wilayah."<br>bulan ".bulan_global($bulan).' '.$tahun;
				break;
		}

		
	    $data['list_kota']=$list_kota;	
	    $data['tahap']=$tahap;	
	    $data['tahun']=$tahun;	
	    $data['nama_tahap']=$nama_tahap[$tahap];	
	    $data['model_realisasi_gabungan']=$model_realisasi_gabungan;	
	    $data['bulan']=$bulan;	
	    $data['judul_laporan']=strtoupper($judul_laporan);	
	    $data['title']=str_replace('<br>', ' ', $judul_laporan);

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');	
	    $data['tanggal_penarikan']=$tanggal_penarikan;
	  
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
		$data['keuangan']=$this->realisasi_keuangan_model;

		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;

		$id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');

		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;

		$tahun 				= $this->input->get('tahun');
		$tahap 				=  $this->input->get('tahap');

	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();
	    $data['identitas']=$identitas;
	    $data['program']=$program;
	    $data['bulan']=$bulan;
	    $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	   
	    $data['title']=$judul_laporan.' '.$nama_instansi;
	    $data['nama_instansi']=$nama_instansi;
	    $data['grafik'] = $this->db->get_where('grafik',['id_instansi'=>$id_instansi, 'bulan'=>$bulan,'tahun'=>$tahun,'kode_tahap'=>$tahap])->row();

	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        


        $judul_penampilan_laporan = "Laporan Data Permasalahan Dan Rencana Tindak Lanjut SKPD".$judul_laporan;
		    $html =  $this->load->view('laporan/pdf/rekap_permasalahan_sub_kegiatan/content_permasalahan_per_skpd', $data, true);



         $data['judul_laporan']=$judul_penampilan_laporan;
	    $header =  $this->load->view('laporan/pdf/realisasi_akumulasi/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_akumulasi/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
	}







	public function pdf_rekap_laporan_permasalahan_sub_kegiatan_error()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
		]);

ini_set("pcre.backtrack_limit", "5000000");
		// $mpdf->setFooter('Page {PAGENO}');
		global $id_instansi;
		global $kategori;
		global $bulan;



				$identitas = $this->db->get('identitas')->row_array();
		$tahun 				= $this->input->get('tahun');
		$tahap 				=  $this->input->get('tahap');
 $data['identitas']=$identitas;

 		$id_instansi = sbe_crypt($this->input->get('id_opd'),'D');

	    $instansi = $this->rekap_permasalahan_model->instansi_yang_menyampaikan()->result();
	    $asisten = [
	    	'204'=>'SKPD lingkup Asisten Pemerintahan Dan Kesra',
	    	'205'=>'SKPD lingkup Asisten Pembangunan Dan Perekonomian',
	    	'206'=>'SKPD lingkup Asisten Administrasi Umum',
	    	'semua_opd'=>'Semua SKPD',
	    ];
	    $judul_laporan = 'Rekap laporan permasalahan per sub kegiatan <br> '.$asisten[$id_instansi];
	    $data['judul_laporan']=$judul_laporan;
	    $data['kode_tahap']=tahapan_apbd();
	    	    $data['nama_tahap']= pilihan_nama_tahapan($tahap);
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;
	    $data['title']=$judul_laporan;
	    $data['instansi_yang_menyampaikan']=$instansi;


	    $data['periode']=pilihan_nama_tahapan($tahap).' Tahun '.$tahun;
	    $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;

        
	    $html =  $this->load->view('laporan/pdf/rekap_permasalahan_sub_kegiatan/content_semua_permasalahan_skpd', $data, true);

 	    $header =  $this->load->view('laporan/pdf/rekap_permasalahan_sub_kegiatan/header', $data, true);
	    // $footer =  $this->load->view('laporan/pdf/rekap_permasalahan_sub_kegiatan/footer', $data, true);
	    // $header =  $this->load->view('laporan/pdf/realisasi_akumulasi/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/rekap_permasalahan_sub_kegiatan/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 40);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.'.pdf', 'I');
	}


	public function pdf_laporan_rekap_asisten()
	{
		


		
		global $bulan;
		$bulan 				= $this->input->get('bulan');
		$tahap 				= $this->input->get('tahap');
		$tahun 				= $this->input->get('tahun');
		$kategori 				= $this->input->get('kategori');
		$perhitungan 				= 'Akuntansi'; //$this->input->get('perhitungan');
		$cara_hitung = $perhitungan	;

		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		if ($kategori_penampilan_laporan=='rfk_berdasarakan_jenis_belanja_detail') {
			$orientation ='P';
		}else{
			$orientation ='L';

		}

		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'legal',
		    'orientation' => $orientation,
		    'tempDir' => '/tmp',

		]);

	    

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
        $data['tanggal_penarikan'] = $kategori_penampilan_laporan ;


 if ($kategori_penampilan_laporan=='rfk_akumulasi') {
        	$judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
		    
	    $html =  $this->load->view('laporan/pdf/realisasi_asisten/content', $data, true);
        	// $mpdf->SetMargins(0, 0, 42);
        }
        elseif ($kategori_penampilan_laporan=='rfk_berdasarakan_jenis_belanja_detail') {
        	$judul_penampilan_laporan = "Laporan Realisasi Fisik Dan Keuangan<br>".$judul_laporan;
	    $html =  $this->load->view('laporan/pdf/realisasi_asisten/content_rfk_detail_jenis_belanja', $data, true);

        	// $mpdf->SetMargins(0, 0, 42);
        }
      else{
        	$judul_penampilan_laporan = $judul_laporan.'<br>'."Waitting";
		    $html =  $this->load->view('laporan/pdf/realisasi_akumulasi/content_dalam_pengembangan', $data, true);
		    // $mpdf->SetMargins(0, 0, 42);

        }

	    $header =  $this->load->view('laporan/pdf/realisasi_asisten/header', $data, true);
	    $footer =  $this->load->view('laporan/pdf/realisasi_asisten/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 28);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);


		// $mpdf->AddPage();

		// $cek_instansi_yang_sudah = $this->db->query("SELECT id_instansi from grafik g
		// 	where  g.kode_tahap = '$tahap'
  //                                 and g.tahun = '$tahun'
  //                                 AND g.bulan = {$bulan}
  //                                 ");
		// $kumpul_instansi_sudah = [];
		// foreach ($cek_instansi_yang_sudah->result_array() as $k => $v) {
		// 	array_push($kumpul_instansi_sudah, $v['id_instansi']);
		// }

		// $id_instansi_yang_sudah = join(",",$kumpul_instansi_sudah);
		// $instansi_yang_belum = $this->db->query("SELECT nama_instansi from master_instansi where 
		// 	is_active=1 
		// 	and id_instansi not in ($id_instansi_yang_sudah) ")->result_array();

		// // $mpdf->WriteHTML(json_encode($instansi_yang_belum));
		$mpdf->Output($judul_file.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
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




	public function pdf_laporan_kegiatan_kab_kota()
	{
		$mpdf = new \Mpdf\Mpdf([
		    'mode' => 'utf-8',
		    'format' => 'Legal',
		    'orientation' => 'L',
		    'tempDir' => '/tmp'
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

		$data['id_group']      	= $this->session->userdata('id_group');
		$data['id_instansi']      	= id_instansi();
		$data['bulan'] = bulan_aktif();
		$data['title']      	= "Permasalahan Sub Kegiatan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Laporan permasalahan sub kegiatan berdasarkan deviasi";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['tahun']	= $this->db->get('config')->result_array();
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
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Data APBD', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
        $data['tahun'] = $this->input->get('tahun');
        $data['tahap'] = $this->input->get('tahap');
        $data['input_by']                      = "all";
        $data['title']                      = "Data APBD";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
    	$data['id_instansi']				=$id_instansi;
    	$data['id_group']				=$this->session->userdata('id_group');
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



    public function tabel_bahan_paparan()
    {
        $breadcrumbs     = $this->breadcrumbs;
        $master_paket   = $this->master_paket_model;
        $data_apbd_model   = $this->data_apbd_model;

        $breadcrumbs->add('Home', base_url());
        $breadcrumbs->add('Paparan Biro Administrasi Pembangunan', base_url($this->router->fetch_class()));
        
        $breadcrumbs->render();
        $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
        $tahun= $this->input->get('tahun');
        $tahap= $this->input->get('tahap');
        $bulan= $this->input->get('bulan');
        $data['bulan'] = $bulan;


        $asisten_1 = $this->rekap_asisten_model->get_opd_asisten(204, $bulan, $cara_hitung, $kategori)->result();
		$asisten_2 = $this->rekap_asisten_model->get_opd_asisten(205, $bulan, $cara_hitung, $kategori)->result();
		$asisten_3 = $this->rekap_asisten_model->get_opd_asisten(206, $bulan, $cara_hitung, $kategori)->result();

		$total_opd = $this->db->query("SELECT id_instansi from master_instansi where is_active='1' and kategori='OPD'")->num_rows();








		$opd_dev_f_merah = [];
		$opd_dev_f_kuning = [];
		$opd_dev_f_hijau = [];
		$opd_dev_k_merah = [];
		$opd_dev_k_kuning = [];
		$opd_dev_k_hijau = [];

		$total_target_fisik = 0;
		$total_target_keuangan = 0;
		$total_realisasi_fisik = 0;
		$total_realisasi_keuangan = 0;

		$total_pagu = 0;
		$total_rp_target_keuangan = 0;
		$total_rp_realisasi_keuangan =0;

		 foreach ($asisten_1 as $satu) { 




		$total_target_fisik +=$satu->target_fisik;
		$total_realisasi_fisik +=$satu->realisasi_fisik;
		$total_target_keuangan +=$satu->target_keuangan;

		$total_pagu +=($satu->pagu_total == '' ? 0 : $satu->pagu_total);
		$total_rp_target_keuangan +=($satu->rp_target_keuangan == '' ? 0 : $satu->rp_target_keuangan);
		$total_rp_realisasi_keuangan+= ($satu->rp_realisasi_keuangan == '' ? 0 :  $satu->rp_realisasi_keuangan);
	
		  $dev_fisik = round($satu->realisasi_fisik -$satu->target_fisik ,2);
          $dev_keu = round($satu->realisasi_keuangan - $satu->target_keuangan,2);
          $data = [
          	'skpd'=>$satu->nama_instansi,
          	'tf'=>$satu->target_fisik,
          	'rf'=>$satu->realisasi_fisik == '' ? 0 : $satu->realisasi_fisik,
          	'df'=>$dev_fisik,
          	'tk'=>$satu->target_keuangan,
          	'rk'=>$satu->realisasi_keuangan == '' ? 0 :  $satu->realisasi_keuangan,
          	'dk'=>$dev_keu,
          ];




          if ($dev_fisik < -10) {
             array_push($opd_dev_f_merah, $data);
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
             array_push($opd_dev_f_kuning, $data);
              
            }else{
             array_push($opd_dev_f_hijau, $data);
              
            }

            if ($dev_keu < -10) {
            	array_push($opd_dev_k_merah, $data);
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
            	array_push($opd_dev_k_kuning, $data);
            }else{
            	array_push($opd_dev_k_hijau, $data);
            }
		 }
		 foreach ($asisten_2 as $dua) { 


		$total_target_fisik +=$dua->target_fisik;

		$total_target_keuangan +=$dua->target_keuangan;
		$total_realisasi_fisik +=$dua->realisasi_fisik;

		$total_pagu +=($dua->pagu_total == '' ? 0 : $dua->pagu_total);
		$total_rp_target_keuangan +=($dua->rp_target_keuangan == '' ? 0 : $dua->rp_target_keuangan);
		$total_rp_realisasi_keuangan +=($dua->rp_realisasi_keuangan == '' ? 0 :  $dua->rp_realisasi_keuangan);


		  $dev_fisik = round($dua->realisasi_fisik -$dua->target_fisik ,2);
          $dev_keu = round($dua->realisasi_keuangan - $dua->target_keuangan,2);
          $data = [
          	'skpd'=>$dua->nama_instansi,
          	'tf'=>$dua->target_fisik,
          	'rf'=>$dua->realisasi_fisik == '' ? 0 : $dua->realisasi_fisik,
          	'df'=>$dev_fisik,
          	'tk'=>$dua->target_keuangan,
          	'rk'=>$dua->realisasi_keuangan == '' ? 0 :  $dua->realisasi_keuangan,
          	'dk'=>$dev_keu,
          ];

       
          if ($dev_fisik < -10) {
             array_push($opd_dev_f_merah, $data);
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
             array_push($opd_dev_f_kuning, $data);
              
            }else{
             array_push($opd_dev_f_hijau, $data);
              
            }

            if ($dev_keu < -10) {
            	array_push($opd_dev_k_merah, $data);
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
            	array_push($opd_dev_k_kuning, $data);
            }else{
            	array_push($opd_dev_k_hijau, $data);
            }
		 }
		 foreach ($asisten_3 as $tiga) { 

			$total_target_fisik +=$tiga->target_fisik;
			$total_target_keuangan +=$tiga->target_keuangan;

			$total_realisasi_fisik +=$tiga->realisasi_fisik;

			$total_pagu +=($tiga->pagu_total == '' ? 0 : $tiga->pagu_total);
			$total_rp_target_keuangan +=($tiga->rp_target_keuangan == '' ? 0 : $tiga->rp_target_keuangan);
			$total_rp_realisasi_keuangan +=($tiga->rp_realisasi_keuangan == '' ? 0 :  $tiga->rp_realisasi_keuangan);


		  $dev_fisik = round($tiga->realisasi_fisik -$tiga->target_fisik ,2);
          $dev_keu = round($tiga->realisasi_keuangan - $tiga->target_keuangan,2);
          $data = [
          	'skpd'=>$tiga->nama_instansi,
          	'tf'=>$tiga->target_fisik,
          	'rf'=>$tiga->realisasi_fisik == '' ? 0 : $tiga->realisasi_fisik,
          	'df'=>$dev_fisik,
          	'tk'=>$tiga->target_keuangan,
          	'rk'=>$tiga->realisasi_keuangan == '' ? 0 :  $tiga->realisasi_keuangan,
          	'dk'=>$dev_keu,
          ];

    
          if ($dev_fisik < -10) {
             array_push($opd_dev_f_merah, $data);
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
             array_push($opd_dev_f_kuning, $data);
              
            }else{
             array_push($opd_dev_f_hijau, $data);
              
            }

            if ($dev_keu < -10) {
            	array_push($opd_dev_k_merah, $data);
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
            	array_push($opd_dev_k_kuning, $data);
            }else{
            	array_push($opd_dev_k_hijau, $data);
            }
		 }
		

		 $statistik_dev_fisik_opd = [
		 	'merah'=>count($opd_dev_f_merah),
		 	'kuning'=>count($opd_dev_f_kuning),
		 	'hijau'=>count($opd_dev_f_hijau),
		 ];

		 $statistik_dev_keuangan_opd = [
		 	'merah'=>count($opd_dev_k_merah),
		 	'kuning'=>count($opd_dev_k_kuning),
		 	'hijau'=>count($opd_dev_k_hijau),
		 ];
		 $grafik_deviasi = [
		 	'f_merah'=>$opd_dev_f_merah,
		 	'f_kuning'=>$opd_dev_f_kuning,
		 	'f_hijau'=>$opd_dev_f_hijau,
		 	'k_merah'=>$opd_dev_k_merah,
		 	'k_kuning'=>$opd_dev_k_kuning,
		 	'k_hijau'=>$opd_dev_k_hijau,
		 	'statistika_fisik' =>$statistik_dev_fisik_opd,
		 	'total_opd' =>array_sum($statistik_dev_fisik_opd),
		 	'statistika_keuangan' =>$statistik_dev_keuangan_opd,
		 ];



		 $realisasi_fisik_opd = $this->rekap_asisten_model->realisasi_semua_opd('fisik',$bulan,$kategori)->result();
		 $realisasi_keuangan_opd = $this->rekap_asisten_model->realisasi_semua_opd('keuangan',$bulan,$kategori)->result();

		 $kumpul_realisasi_fisik = [];
		 $kumpul_realisasi_keuangan = [];

		 foreach ($realisasi_fisik_opd as $v) {
		  $data_rf = [
          	'skpd'=>$v->nama_instansi,

          	'singkatan_skpd'=>$v->singkatan_nama_instansi,
          	'rf'=>$v->realisasi_fisik == '' ? 0 : $v->realisasi_fisik,
          ];
          array_push($kumpul_realisasi_fisik, $data_rf);
		  }
		 foreach ($realisasi_keuangan_opd as $v) {
		  $data_rk = [
          	'skpd'=>$v->nama_instansi,
          	'singkatan_skpd'=>$v->singkatan_nama_instansi,
          	'rk'=>$v->realisasi_keuangan == '' ? 0 : $v->realisasi_keuangan,
          ];
          array_push($kumpul_realisasi_keuangan, $data_rk);
		  }




		 $target_fisik_sesumbar = $total_target_fisik / $total_opd;
		 $realisasi_fisik_sesumbar = $total_realisasi_fisik / $total_opd;
		 $deviasi_fisik_sesumbar = $realisasi_fisik_sesumbar - $target_fisik_sesumbar;
		 $target_keuangan_sesumbar = ($total_rp_target_keuangan / $total_pagu) * 100 ;
		 $realisasi_keuangan_sesumbar = ($total_rp_realisasi_keuangan / $total_pagu) * 100 ;
		 $deviasi_keuangan_sesumbar = $realisasi_keuangan_sesumbar - $target_keuangan_sesumbar;
		//   $total_pagu = 0;
		// $total_rp_target_keuangan = 0;
		// $total_rp_realisasi_keuangan = 0;
		  $capaian_provinsi_sumbar = [
		  	'tf'=>round($target_fisik_sesumbar,2),
		  	'rf'=>round($realisasi_fisik_sesumbar,2),
		  	'df'=>round($deviasi_fisik_sesumbar,2),
		  	'tk'=>round($target_keuangan_sesumbar,2),
		  	'rk'=>round($realisasi_keuangan_sesumbar,2),
		  	'dk'=>round($deviasi_keuangan_sesumbar,2),
		  ];


		 $limit = 10;
		$perengkingan_fisik_opd_tertinggi = $this->rekap_asisten_model->perengkingan_realisasi_opd('fisik',$bulan, 'DESC')->result();
		$perengkingan_fisik_opd_terendah = $this->rekap_asisten_model->perengkingan_realisasi_opd('fisik',$bulan, 'ASC')->result();
		$perengkingan_keuangan_opd_tertinggi = $this->rekap_asisten_model->perengkingan_realisasi_opd('keuangan',$bulan, 'DESC')->result();
		$perengkingan_keuangan_opd_terendah = $this->rekap_asisten_model->perengkingan_realisasi_opd('keuangan',$bulan, 'ASC')->result();

        $data['grafik_realisasi_fisik']    = $kumpul_realisasi_fisik;
        $data['grafik_realisasi_keuangan']    = $kumpul_realisasi_keuangan;
        $data['capaian_provinsi_sumbar']    = $capaian_provinsi_sumbar;
        $data['perengkingan_fisik_tertinggi']    = $perengkingan_fisik_opd_tertinggi;
        $data['perengkingan_fisik_terendah']    = $perengkingan_fisik_opd_terendah;
        $data['perengkingan_keuangan_tertinggi']    = $perengkingan_keuangan_opd_tertinggi;
        $data['perengkingan_keuangan_terendah']    = $perengkingan_keuangan_opd_terendah;
        $data['cek']                      = $realisasi_keuangan_opd;
        $data['grafik_deviasi']                      = $grafik_deviasi;
        $data['tahun']                      = $tahun;
        $data['bulan']                      = $bulan;
        $data['tahap']                      = $tahap;
        $data['input_by']                      = "all";
        $data['title']                      = "Bahan Paparan ";
        $data['icon']                       = "metismenu-icon fa fa-list-ul";
        $data['description']                = "Menampilkan Data APBD";
        $data['breadcrumbs']                = $breadcrumbs->render();
    	$data['id_instansi']				=$id_instansi;
    	$data['id_group']				=$this->session->userdata('id_group');
    	$data['nama_instansi']				=$this->db->query("SELECT nama_instansi from master_instansi where id_instansi='$id_instansi'")->row()->nama_instansi;
    	$data['controller']				=$this->router->fetch_class();
        $page                               = 'laporan/tabel/bahan_paparan/tabel_bahan_paparan';
        $data['link']                       = $this->router->fetch_method();
        $data['menu']                       = $this->load->view('layout/menu', $data, true);
        // $data['extra_css']                  = $this->load->view('laporan/tabel/bahan_paparan/css', $data, true);
        // $data['extra_js']                   = $this->load->view('laporan/tabel/bahan_paparan/js', $data, true);
        $data['modal']                      = $this->load->view('laporan/tabel/bahan_paparan/modal', $data, true);
        $this->load->view($page, $data);
    }






	public function desain()
	{
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



	public function statistika()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$realisasi_akumulasi    = $this->realisasi_akumulasi_model;

		 $data['dropdown_option']                      = [
            ['tipe'=>'button', 'caption'=>'Ganti Periode', 'fa'=>'fa fa-bars', 'onclick'=>'ganti_periode()', 'elemen_tambahan'=>'data-toggle="tooltip" title="Ganti tahun dan periode"'],
           
        ];

        $data['config'] = $this->db->get('config')->result_array();
        $data['tahap'] = [2=>'APBD AWAL',4=>'APBD PERUBAHAN'];

		$data['title']      	= "Statistika SKPD";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Menampilkan statistika data SKPD";
		$data['breadcrumbs']	= '';
		$data['opd']					= $realisasi_akumulasi->get_opd();
		$page               	= 'laporan/statistika/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('laporan/statistika/css', $data, true);
		$data['extra_js']   	= $this->load->view('laporan/statistika/js', $data, true);
		$data['modal']      	= $this->load->view('laporan/statistika/modal', $data, true);
		$this->template->load('backend_template', $page, $data);
	}


	 public function pdf_statistika($tahun, $tahap)
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'Legal',
            'orientation' => 'P',
            'tempDir' => '/tmp'
        ]);
        $identitas = $this->db->get('identitas')->row_array();
$data['identitas']=$identitas;

	    // $data['bulan']= $bulan;
		  $data['nama_tahap']=pilihan_nama_tahapan($tahap);
	    $data['tahap']=$tahap;
	    $data['tahun']=$tahun;

        // $mpdf->setFooter('Page {PAGENO}');
        

            $instansi =$this->db->query("SELECT id_instansi, nama_instansi, is_active from
            master_instansi where kategori='OPD' and is_active='1' order by nama_instansi asc"); 
          
      
               $skpd = [];
                foreach ($instansi->result() as $key => $value) {
                    // if ($value->is_active=='1') {
                    $statistika = $this->statistika_model->statistika($value->id_instansi, $tahun, $tahap)->row();
                    $data_skpd = [
                        'is_active'=>$value->is_active,
                        'nama_instansi'=>$statistika->nama_instansi,
                        'helpdesk'=>$statistika->helpdesk,
                        'total_pagu'=>$statistika->total_pagu,
                        'total_program'=>$statistika->total_program,
                        'total_kegiatan'=>$statistika->total_kegiatan,
                        'total_sub_kegiatan'=>$statistika->total_sub_kegiatan,
                        'total_paket_rutin'=>$statistika->total_paket_rutin,
                        'total_paket_swakelola'=>$statistika->total_paket_swakelola,
                        'total_paket_penyedia'=>$statistika->total_paket_penyedia,
                        'total_paket_semua'=>($statistika->total_paket_penyedia +$statistika->total_paket_rutin + $statistika->total_paket_swakelola),
                        'total_kontrak'=>$statistika->total_kontrak,
                   
                        ];
                    array_push($skpd, $data_skpd);
                        # code...
                    // }
                }

               


        $data['skpd'] = $skpd ; 
        $data['tahun'] = $tahun ; 
        $judul_laporan = "Statistika SKPD";
        $tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');
        $data['tanggal_penarikan'] = $tanggal_penarikan ;
        $data['judul_laporan'] = $judul_laporan.' '.pilihan_nama_tahapan($tahap).' Tahun '.$tahun.''; 


        $html =  $this->load->view('laporan/pdf/statistika/content', $data, true);

        $header =  $this->load->view('laporan/pdf/statistika/header', $data, true);
        $footer =  $this->load->view('laporan/pdf/statistika/footer', $data, true);

        $mpdf->SetMargins(0, 0, 30);

        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($html);
        $mpdf->Output($judul_laporan.' - '.str_replace(':', '.', $tanggal_penarikan).'.pdf', 'I');
    }





	public function tabel_perengkingan_rfk_opd()
	{
		

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




	    $page               	= 'laporan/tabel/perengkingan_opd/content_perengkingan';
		$this->load->view($page, $data);
	}




		

























  public function excel_laporan_paket_per_skpd(){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    








		$identitas = $this->db->get('identitas')->row_array();
    // $id_instansi = 12;
	    $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
		$nama_instansi = $this->sbe_nama_instansi($id_instansi);
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		$kategori 		= $this->input->get('kategori');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$jenis_paket 				= $this->input->get('jenis_paket');
		$metode 				= $this->input->get('metode');
		$bulan 				= bulan_aktif();//$this->input->get('metode');
		$ope 				= '<=';


		$total_pagu_paket = 0;
		$total_data_paket = 0;
		$total_data_terkontrak = 0;
		$total_nilai_terkontrak = 0;


		$data_metode = $this->db->get('metode')->result_array();
		$kumpul_metode = [];
		foreach ($data_metode as $k => $v) {
			$kumpul_metode[$v['id_metode']] =$v['metode'];
			
		}

    // Panggil class PHPExcel nya
    $excel = new PHPExcel();

    // Settingan awal fil excel
    // $excel->getProperties()->setCreator('My Notes Code')
    //              ->setLastModifiedBy('My Notes Code')
    //              ->setTitle("Data Siswa")
    //              ->setSubject("Siswa")
    //              ->setDescription("Laporan Semua Data Siswa")
    //              ->setKeywords("Data Siswa");

    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $border = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $fill_sub_kegiatan = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '00FFFF')
        )
    );



      $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(40); // Set width kolom B
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(7); 
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(7); 
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7); 
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(7); 
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20); 
    $excel->getActiveSheet()->getColumnDimension('P')->setWidth(10); 
    $excel->getActiveSheet()->getColumnDimension('O')->setWidth(10); 


    $excel->getActiveSheet()->mergeCells('A1:P1'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('A2:P2'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('A3:P3'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN DATA PAKET PEKERJAAN SKPD"); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('A2', $nama_instansi); // Set kolom A1 dengan tulisan "DATA SISWA"
    $excel->setActiveSheetIndex(0)->setCellValue('A3', pilihan_nama_tahapan($tahap)." Tahun Anggaran ".$tahun); 


	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 


	  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk 
	  $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A2
    $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13); // Set font size 15 untuk 
	  $excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A2
    $excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(13); // Set font size 15 untuk 


    $excel->getActiveSheet()->mergeCells('A5:A8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('B5:E6'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('B7:B8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('C7:C8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('D7:D8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('E7:E8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('F7:F8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('G7:G8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('H7:H8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('F6:H6'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('F5:M5'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('I6:M6'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('I7:J7'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('K7:L7'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('M7:M8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('N5:P6'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('N7:N8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('O7:O8'); // Set Merge Cell pada kolom A1 sampai E1
    $excel->getActiveSheet()->mergeCells('P7:P8'); // Set Merge Cell pada kolom A1 sampai E1
   

    // border cell

	$excel->getActiveSheet()->getStyle('A5:A8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('B5:E6')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('B7:B8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('C7:C8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('D7:D8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('E7:E8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('F7:F8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('G7:G8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('H7:H8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('F6:H6')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('F5:M5')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('I6:M6')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('I7:J7')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('K7:L7')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('M7:M8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('N5:P6')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('N7:N8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('O7:O8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('P7:P8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('I8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('J8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('K8')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('L8')->applyFromArray($border);
    // Buat header tabel nya pada baris ke 3

    $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
    $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 


		$excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('N7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('O7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('P7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('J8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('K8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 





$excel->getActiveSheet()->getStyle('A5:P8')->getAlignment()->setWrapText(true); 


    $excel->setActiveSheetIndex(0)->setCellValue('A5',"No"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('B5',"Data Sub Kegiatan & Paket Pekerjaan"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('B7',"Uraian"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('C7',"Pagu"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('D7',"Jenis"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('E7',"Metode"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('F7',"Target"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('G7',"Realisasi"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('H7',"Deviasi"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('F6',"Fisik"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('F5',"Realisasi Fisik Keuangan"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('I6',"Keuangan"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('I7',"Target"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('K7',"Realisasi"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('M7',"Deviasi"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('N5',"Terkontrak"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('N7',"Mulai"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('O7',"Akhir"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('P7',"Nilai Kontrak"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('I8',"Rp."); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('J8',"%"); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('K8',"Rp."); // Set Merge Cell pada kolom A1 sampai E1
    $excel->setActiveSheetIndex(0)->setCellValue('L8',"%"); // Set Merge Cell pada kolom A1 sampai E1


  


    $total_pagu_ski =0;


		



		 $paket_pekerjaan_group_sub_kegiatan = $this->realisasi_akumulasi_model->get_paket_per_opd_group_sub_kegiatan($id_instansi);
		 $sub_kegiatan_paket = $paket_pekerjaan_group_sub_kegiatan;




		 $no_sub_kegiatan = 0;
		 $baris_mulai_sub_kegiatan = 9;
		 $baris_mulai_paket = 10;
		  foreach ($sub_kegiatan_paket->result() as $key => $value_sk) { 
      $no_sub_kegiatan++;

      $krsk = $value_sk->kode_rekening_sub_kegiatan;

      if ($tahap==2) {
       $where = "where kode_rekening_sub_kegiatan='$krsk' and kode_tahap='$tahap' and tahun='$tahun' and id_instansi='$id_instansi'";
      }else{
       $where = "where kode_rekening_sub_kegiatan='$krsk' and status='1' and tahun='$tahun' and id_instansi='$id_instansi'";

      }

      $q_sub_kegiatan = $this->db->query("SELECT kode_rekening_sub_kegiatan, nama_sub_kegiatan, pagu, kode_tahap, tahun, kategori, jenis_sub_kegiatan, keterangan  from v_sub_kegiatan_apbd $where")->row_array();

      $paket = $this->realisasi_akumulasi_model->get_paket_opd_per_sub_kegiatan($id_instansi, $krsk);

      
      $kategori_sub_kegiatan = $q_sub_kegiatan['kategori'];
      if($kategori_sub_kegiatan =='Unit Pelaksana'){
            $nama_sub_kegiatan = $q_sub_kegiatan['nama_sub_kegiatan']."<br>[".$q_sub_kegiatan['jenis_sub_kegiatan'].' - '.$q_sub_kegiatan['keterangan']."]";
           
          }else{
            $nama_sub_kegiatan = $q_sub_kegiatan['nama_sub_kegiatan'];
          }

          


      $total_pagu_ski += $q_sub_kegiatan['pagu'];

		$excel->setActiveSheetIndex(0)->setCellValue('A'.$baris_mulai_sub_kegiatan, $no_sub_kegiatan);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$baris_mulai_sub_kegiatan, $q_sub_kegiatan['nama_sub_kegiatan']);
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$baris_mulai_sub_kegiatan, $q_sub_kegiatan['pagu']);
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$baris_mulai_sub_kegiatan, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$baris_mulai_sub_kegiatan, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$baris_mulai_sub_kegiatan,round($target_fisik,2) );
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$baris_mulai_sub_kegiatan,round($total_realisasi_fisik,2) );
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$baris_mulai_sub_kegiatan,round($dev_fisik,2) );
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$baris_mulai_sub_kegiatan,$target_keuangan );
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$baris_mulai_sub_kegiatan,round($persen_target_keuangan,2) );
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$baris_mulai_sub_kegiatan,$realisasi_keuangan['total_realisasi'] );
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$baris_mulai_sub_kegiatan,round($persen_realisasi_keuangan,2) );
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$baris_mulai_sub_kegiatan,round($dev_keu,2) );

		$excel->setActiveSheetIndex(0)->setCellValue('N'.$baris_mulai_sub_kegiatan, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$baris_mulai_sub_kegiatan, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$baris_mulai_sub_kegiatan, '-');


		// format cell number
		$excel->getActiveSheet()->getStyle('C'.$baris_mulai_sub_kegiatan)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$excel->getActiveSheet()->getStyle('I'.$baris_mulai_sub_kegiatan)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$excel->getActiveSheet()->getStyle('K'.$baris_mulai_sub_kegiatan)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$excel->getActiveSheet()->getStyle('P'.$baris_mulai_sub_kegiatan)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

		// memberi warna cell
      	$excel->getActiveSheet()->getStyle('A'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_sub_kegiatan)->applyFromArray($fill_sub_kegiatan);


		// memberi border cell
      	$excel->getActiveSheet()->getStyle('A'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_sub_kegiatan)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_sub_kegiatan)->applyFromArray($border);



      	// rata tengah
   
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      	// rata kanan
   		$excel->getActiveSheet()->getStyle('I'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); $excel->getActiveSheet()->getStyle('K'.$baris_mulai_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 




      $target = $this->realisasi_akumulasi_model->get_target($id_instansi, $krsk, $bulan, $q_sub_kegiatan['kode_tahap'], $q_sub_kegiatan['tahun'])->row_array();
          $realisasi_keuangan = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $krsk, $bulan, $ope, $tahun, $tahap)->row_array();

          if ($ope=='=') {
            $target_fisik = $target['target_fisik_bulanan'];
            $target_keuangan = $target['target_keuangan_bulanan'];
            $nilai_persen_target_keuangan = ($target['target_keuangan_bulanan'] / $q_sub_kegiatan['pagu']) * 100 ; 
            
          }else{
            $target_keuangan = $target['target_keuangan'];
            $target_fisik = $target['target_fisik'];
            $nilai_persen_target_keuangan = ($target['target_keuangan'] / $q_sub_kegiatan['pagu']) * 100 ; 

          }

          // $target_fisik_bulanan = $target['target_fisik_bulanan'];

          // 
          if ($q_sub_kegiatan['pagu'] == 0) {
            $persen_target_keuangan   = 0;
            $persen_realisasi_keuangan  = 0;
          } else {
          $persen_target_keuangan = $nilai_persen_target_keuangan; 
            $persen_realisasi_keuangan  = round(($realisasi_keuangan['total_realisasi'] / $q_sub_kegiatan['pagu']) * 100, 2);
          }

          
          $persen_target_keuangan_besar = ($target_keuangan / $pagu_skpd) *100 ; 
          $persen_realisasi_keuangan_besar = ($realisasi_keuangan['total_realisasi'] / $pagu_skpd) *100 ; 
          $total_persen_target_keuangan +=$persen_target_keuangan ;
          $total_persen_realisasi_keuangan +=$persen_realisasi_keuangan ;
          // $target_keuangan_bulanan = $target['target_keuangan_bulanan'];



          $total_paket = $this->realisasi_akumulasi_model->get_total_paket($id_instansi, $krsk, $tahun, $tahap)->num_rows();
          $jenis_rutin = $this->realisasi_akumulasi_model->get_total_paket_perjenis($id_instansi, $krsk, "RUTIN", $tahun, $tahap)->num_rows();
          $swa = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $krsk, $bulan, 'SWAKELOLA', $ope, $tahun, $tahap)->row_array();
          $pen = $this->realisasi_akumulasi_model->get_realisasi_fisik($id_instansi, $krsk, $bulan, 'PENYEDIA', $ope, $tahun, $tahap)->row_array();





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
              if ($ope=='=') {
                $realisasi_rutin = (1/$lama_realisasi) *100;
              }else{
                $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
              }
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

          $total_realisasi_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
          $porsi_realisasi_fisik    = ($total_realisasi_fisik / $angka_pembagi_fisik) * 100 ;
          $total_porsi_realisasi_fisik += $porsi_realisasi_fisik ;
          $total_realisasi_fisik_semua += $total_realisasi_fisik ;



          $dev_fisik = $total_realisasi_fisik - $target_fisik;
          $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;
          // $dev_keu = $persen_realisasi_keuangan - $persen_target_keuangan;


            if ($dev_fisik < -10) {
              $warna_peringatan_dev_fisik = 'background: #f8b2b2'; 
              $total_peringatan_dev_fisik_merah += 1; 
            }
            elseif ($dev_fisik <-5  && $dev_fisik >-10) {
              $warna_peringatan_dev_fisik = 'background: #fcf3cf';
              $total_peringatan_dev_fisik_kuning += 1; 
            }else{
              $warna_peringatan_dev_fisik = 'background: #d5f5e3';
              $total_peringatan_dev_fisik_hijau += 1; 
            }

            if ($dev_keu < -10) {
              $warna_peringatan_dev_keu = 'background: #f8b2b2'; 
              $total_peringatan_dev_keu_merah += 1; 
            }
            elseif ($dev_keu <-5  && $dev_keu >-10) {
              $warna_peringatan_dev_keu = 'background: #fcf3cf';
              $total_peringatan_dev_keu_kuning += 1; 
            }else{
              $warna_peringatan_dev_keu = 'background: #d5f5e3';
              $total_peringatan_dev_keu_hijau += 1; 
            }






 $no_paket = 0;
    foreach ($paket->result_array() as $k_paket => $v_paket) {
      $hitung_paket +=1;
      $no_paket++;
      $id_paket_pekerjaan = $v_paket['id_paket_pekerjaan'];


      $nilai_evidence = $this->db->query("SELECT sum(nilai)as rf FROM realisasi_fisik WHERE id_paket_pekerjaan = '$id_paket_pekerjaan' and bulan<='$bulan'")->row_array();
      $rf_paket =  $v_paket['jenis_paket']=='RUTIN' ?  round($rut,2) : ($nilai_evidence['rf'] =='' ? 0 : $nilai_evidence['rf']);
      $total_pagu_paket += $v_paket['pagu'];
      $total_nilai_kontrak += $v_paket['nilai_kontrak'];

      $jenis_paket = $v_paket['jenis_paket']=='PENYEDIA' ?  $v_paket['jenis_paket'] .' - '. $v_paket['kategori'] : $v_paket['jenis_paket'];


	$excel->setActiveSheetIndex(0)->setCellValue('A'.$baris_mulai_paket, $no_sub_kegiatan.','.$no_paket);
	$excel->setActiveSheetIndex(0)->setCellValue('B'.$baris_mulai_paket, $v_paket['nama_paket']);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$baris_mulai_paket, $v_paket['pagu']);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$baris_mulai_paket, $jenis_paket);
	$excel->setActiveSheetIndex(0)->setCellValue('E'.$baris_mulai_paket, $v_paket['metode']);
	$excel->setActiveSheetIndex(0)->setCellValue('F'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('G'.$baris_mulai_paket, $rf_paket);
	$excel->setActiveSheetIndex(0)->setCellValue('H'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('I'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('J'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('K'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('L'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('M'.$baris_mulai_paket, '-');

	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->getAlignment()->setWrapText(true); 
	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->getAlignment()->setWrapText(true); 
	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->getAlignment()->setWrapText(true); 



	$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 
	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); 


	if ($v_paket['id_kontrak_pekerjaan']=='') { 
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$baris_mulai_paket, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$baris_mulai_paket, '-');
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$baris_mulai_paket, '-');
	}else{ 
		$total_data_terkontrak += 1;
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$baris_mulai_paket, $v_paket['tgl_awal_pelaksanaan']);
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$baris_mulai_paket, $v_paket['tgl_akhir_pelaksanaan']);
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$baris_mulai_paket, $v_paket['nilai_kontrak']);
	}


		// accounting format cell
		$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	
		// memberi border cell
		$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->applyFromArray($border);




      	// rata tengah
   
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 




		$total_pagu_paket += $v_paket['pagu'];
		$total_data_paket++;
		
		$total_nilai_terkontrak += $v_paket['nilai_kontrak'];

	$baris_mulai_paket++;
         $baris_mulai_sub_kegiatan ++ ;

  } //end foreach ($paket->result_array() as $k_paket => $v_paket)
	$baris_mulai_paket++;
         $baris_mulai_sub_kegiatan++ ;
} //end foreach ($sub_kegiatan_paket->result() as $key => $value_sk)




	$baris_mulai_paket-=1;


	 $excel->getActiveSheet()->mergeCells('A'.$baris_mulai_paket.':B'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
	 $excel->getActiveSheet()->mergeCells('D'.$baris_mulai_paket.':E'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
	 $excel->getActiveSheet()->mergeCells('F'.$baris_mulai_paket.':M'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
	 $excel->getActiveSheet()->mergeCells('N'.$baris_mulai_paket.':O'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1


      	$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket.':B'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

      	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 



      	  $excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->getFont()->setBold(TRUE); // Set bold kolom A1

	$excel->setActiveSheetIndex(0)->setCellValue('A'.$baris_mulai_paket, 'Total Pagu Paket '.$jenis_paket);
	$excel->setActiveSheetIndex(0)->setCellValue('C'.$baris_mulai_paket, $total_pagu_paket);
	$excel->setActiveSheetIndex(0)->setCellValue('D'.$baris_mulai_paket, $total_data_paket.' paket pekerjaan ');
	$excel->setActiveSheetIndex(0)->setCellValue('F'.$baris_mulai_paket, '-');
	$excel->setActiveSheetIndex(0)->setCellValue('N'.$baris_mulai_paket, $total_data_terkontrak.' Terkontrak');
	$excel->setActiveSheetIndex(0)->setCellValue('P'.$baris_mulai_paket, $total_nilai_terkontrak);


		$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->applyFromArray($border);
      	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->applyFromArray($border);






		$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	



    // Set width kolom
  // Set width kolom E
    
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

    // Set judul file excel nya
    $nama_sheet = substr($jenis_paket, 0,30);
    $excel->getActiveSheet(0)->setTitle($nama_sheet);
    $excel->setActiveSheetIndex(0);

    // Proses file excel
    @$nama_metode = $kumpul_metode[$metode];
    $download_export = $nama_instansi.' - Laporan Data Paket '.$jenis_paket.' - '.$nama_metode.'.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$download_export.'"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }































  public function download_laporan_excel_data_apbd_jenis_belanja(){
    // Load plugin PHPExcel nya
    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    $excel = new PHPExcel();
		$identitas = $this->db->get('identitas')->row_array();
	    $id_instansi 	= sbe_crypt($this->input->get('id_opd'), 'D');
		$nama_instansi = $this->sbe_nama_instansi($id_instansi);
		$kategori_penampilan_laporan 	= $this->input->get('kategori_penampilan_data');
		$kategori 		= $this->input->get('kategori');
		$tahun 				= $this->input->get('tahun');
		$tahap 				= $this->input->get('tahap');
		$bulan 				= bulan_aktif();//$this->input->get('metode');
		switch ($kategori) {
					case 'akumulasi':
						$ope = '<=';
						$periode_laporan = "Realisasi  sampai dengan bulan ".bulan_global($bulan);
						break;
					default:
						$ope = '=';
						$periode_laporan = "Realisasi  bulan ".bulan_global($bulan);
						break;
				}

		$tanggal_penarikan = date('d').' '.bulan_global(date('n')).' '.date('Y').' - '.date('H:i:s');

    	$judul_konten = "Laporan Realisasi Fisik Dan Keuangan berdasarkan jenis balanja ";

    	$judul_file = $nama_instansi.' '.$periode_laporan.' Berdasarkan Jenis Belanja - '.$tanggal_penarikan;
    	$excel->getSheet(0)->setTitle('Data '.date('Y-m-d H.i.s'));

    // Panggil class PHPExcel nya

    // Settingan awal fil excel
    // $excel->getProperties()->setCreator('My Notes Code')
    //              ->setLastModifiedBy('My Notes Code')
    //              ->setTitle("Data Siswa")
    //              ->setSubject("Siswa")
    //              ->setDescription("Laporan Semua Data Siswa")
    //              ->setKeywords("Data Siswa");

    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(
      'font' => array('bold' => true), // Set font nya jadi bold
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );

    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $border = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $fill_program = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'f0cdf5')
        )
    );
    $fill_kegiatan = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF99CC')
        )
    );




// Untuk judulnya
	$excel->getActiveSheet()->mergeCells('A1:AR1');
	$excel->getActiveSheet()->mergeCells('A2:AR2');
	$excel->getActiveSheet()->mergeCells('A3:AR3');
	$excel->setActiveSheetIndex(0)->setCellValue('A1', $identitas['identitas']);
	$excel->setActiveSheetIndex(0)->setCellValue('A2', $nama_instansi);
	$excel->setActiveSheetIndex(0)->setCellValue('A3', pilihan_nama_tahapan($tahap)." Tahun Anggaran ".$tahun); 
	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 


	$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
	$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13);
	$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
	$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(13);


		$excel->getActiveSheet()->getStyle('A9:AR12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A9:AR12')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
	$excel->getActiveSheet()->getStyle('A9:AR12')->getAlignment()->setWrapText(true); 

// Judul Laporan
	$excel->getActiveSheet()->mergeCells('A6:AR6');
	$excel->getActiveSheet()->mergeCells('A7:AR7');
	$excel->getActiveSheet()->getStyle('A6:A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

	$excel->setActiveSheetIndex(0)->setCellValue('A6', $judul_konten);
	$excel->setActiveSheetIndex(0)->setCellValue('A7', $periode_laporan);


	$excel->getActiveSheet()->getStyle('A9:AR11')->applyFromArray($border);
	$excel->getActiveSheet()->getStyle('A9:AR11')->applyFromArray($border);
	
















			for ($i=9; $i <=13 ; $i++) { 
				# code...
			
			    	$excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('Q'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('R'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('S'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('T'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('U'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('V'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('W'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('X'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('Y'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('Z'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AA'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AB'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AC'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AD'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AE'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AF'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AG'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AH'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AI'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AJ'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AK'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AL'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AM'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AN'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AO'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AP'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AQ'.$i)->applyFromArray($border);
		    	$excel->getActiveSheet()->getStyle('AR'.$i)->applyFromArray($border);

	    	}



// settingan thead


	// $excel->setActiveSheetIndex(0)->setCellValue('D9', "Pagu per jenis belanja");
	// $excel->setActiveSheetIndex(0)->setCellValue('U9', "Realisasi per jenis belanja");
	// $excel->setActiveSheetIndex(0)->setCellValue('D10', "Belanja Operasi");
	// $excel->setActiveSheetIndex(0)->setCellValue('I10', "Belanja Modal");
	// $excel->setActiveSheetIndex(0)->setCellValue('O10', "Belanja Tidak Terduga");
	// $excel->setActiveSheetIndex(0)->setCellValue('Q10', "Belanja Transfer");
	// $excel->setActiveSheetIndex(0)->setCellValue('T10', "Total Pagu");
	// $excel->setActiveSheetIndex(0)->setCellValue('U10', "Belanja Operasi");
	// $excel->setActiveSheetIndex(0)->setCellValue('AA10', "Belanja Modal");
	// $excel->setActiveSheetIndex(0)->setCellValue('AH10', "Belanja Tidak Terduga");
	// $excel->setActiveSheetIndex(0)->setCellValue('AK10', "Belanja Transfer");
	// $excel->setActiveSheetIndex(0)->setCellValue('AO10', "Total Realisasi Keuangan");
	// $excel->setActiveSheetIndex(0)->setCellValue('AR10', "Realisasi Fisik");


	$excel->getActiveSheet()->mergeCells('A9:A12');
	$excel->setActiveSheetIndex(0)->setCellValue('A9', "No");

	$excel->getActiveSheet()->mergeCells('B9:D10');
	$excel->setActiveSheetIndex(0)->setCellValue('B9', "Data APBD");

	$excel->getActiveSheet()->mergeCells('B11:B12');
	$excel->setActiveSheetIndex(0)->setCellValue('B11', "Tahapan APBD");

	$excel->getActiveSheet()->mergeCells('C11:C12');
	$excel->setActiveSheetIndex(0)->setCellValue('C11', "Kode Rekening");

	$excel->getActiveSheet()->mergeCells('D11:D12');
	$excel->setActiveSheetIndex(0)->setCellValue('D11', "Uraian Program, Kegiatan, Sub Kegiatan");


	$excel->getActiveSheet()->mergeCells('E9:U9');
	$excel->setActiveSheetIndex(0)->setCellValue('E9', "Pagu");

	$excel->getActiveSheet()->mergeCells('E10:I10');
	$excel->setActiveSheetIndex(0)->setCellValue('E10', "Belanja Operasi");

	$excel->getActiveSheet()->mergeCells('E11:E12');
	$excel->setActiveSheetIndex(0)->setCellValue('E11', "Belanja Pegawai");

	$excel->getActiveSheet()->mergeCells('F11:F12');
	$excel->setActiveSheetIndex(0)->setCellValue('F11', "Belanja Barang Jasa");

	$excel->getActiveSheet()->mergeCells('G11:G12');
	$excel->setActiveSheetIndex(0)->setCellValue('G11', "Belanja Subsidi");

	$excel->getActiveSheet()->mergeCells('H11:H12');
	$excel->setActiveSheetIndex(0)->setCellValue('H11', "Belanja Hibah");

	$excel->getActiveSheet()->mergeCells('I11:I12');
	$excel->setActiveSheetIndex(0)->setCellValue('I11', "Total");

	$excel->getActiveSheet()->mergeCells('J10:O10');
	$excel->setActiveSheetIndex(0)->setCellValue('J10', "Belanja Modal");

	$excel->getActiveSheet()->mergeCells('J11:J12');
	$excel->setActiveSheetIndex(0)->setCellValue('J11', "Belanja Modal Tanah");

	$excel->getActiveSheet()->mergeCells('K11:K12');
	$excel->setActiveSheetIndex(0)->setCellValue('K11', "Belanja Modal Peralatan Dan Mesin");

	$excel->getActiveSheet()->mergeCells('L11:L12');
	$excel->setActiveSheetIndex(0)->setCellValue('L11', "Belanja Modal Gedung dan Bangunan");

	$excel->getActiveSheet()->mergeCells('M11:M12');
	$excel->setActiveSheetIndex(0)->setCellValue('M11', "Belanja Modal Jalan, Jaringan, dan Irigasi");

	$excel->getActiveSheet()->mergeCells('N11:N12');
	$excel->setActiveSheetIndex(0)->setCellValue('N11', "Belanja Modal dan Aset Tetap Lainnya");

	$excel->getActiveSheet()->mergeCells('O11:O12');
	$excel->setActiveSheetIndex(0)->setCellValue('O11', "Total");

	$excel->getActiveSheet()->mergeCells('P10:Q10');
	$excel->setActiveSheetIndex(0)->setCellValue('P10', "Belanja Tidak Terduga");

	$excel->getActiveSheet()->mergeCells('P11:P12');
	$excel->setActiveSheetIndex(0)->setCellValue('P11', "Belanja Tidak Terduga");

	$excel->getActiveSheet()->mergeCells('Q11:Q12');
	$excel->setActiveSheetIndex(0)->setCellValue('Q11', "Total");

	$excel->getActiveSheet()->mergeCells('R10:T10');
	$excel->setActiveSheetIndex(0)->setCellValue('R10', "Belanja Transfer");

	$excel->getActiveSheet()->mergeCells('R11:R12');
	$excel->setActiveSheetIndex(0)->setCellValue('R11', "Belanja Bagi Hasil");

	$excel->getActiveSheet()->mergeCells('S11:S12');
	$excel->setActiveSheetIndex(0)->setCellValue('S11', "Belanja Bantuan Keuangan");

	$excel->getActiveSheet()->mergeCells('T11:T12');
	$excel->setActiveSheetIndex(0)->setCellValue('T11', "Total");

	$excel->getActiveSheet()->mergeCells('U10:U12');
	$excel->setActiveSheetIndex(0)->setCellValue('U10', "Total Semua Pagu");

	$excel->getActiveSheet()->mergeCells('V9:AR9');
	$excel->setActiveSheetIndex(0)->setCellValue('V9', "Realisasi");

	$excel->getActiveSheet()->mergeCells('V10:AA10');
	$excel->setActiveSheetIndex(0)->setCellValue('V10', "Belanja Operasi");

	$excel->getActiveSheet()->mergeCells('V11:V12');
	$excel->setActiveSheetIndex(0)->setCellValue('V11', "Belanja Pegawai");

	$excel->getActiveSheet()->mergeCells('W11:W12');
	$excel->setActiveSheetIndex(0)->setCellValue('W11', "Belanja Barang Jasa");

	$excel->getActiveSheet()->mergeCells('X11:X12');
	$excel->setActiveSheetIndex(0)->setCellValue('X11', "Belanja Subsidi");

	$excel->getActiveSheet()->mergeCells('Y11:Y12');
	$excel->setActiveSheetIndex(0)->setCellValue('Y11', "Belanja Hibah");

	$excel->getActiveSheet()->mergeCells('Z11:AA11');
	$excel->setActiveSheetIndex(0)->setCellValue('Z11', "Total");

	$excel->setActiveSheetIndex(0)->setCellValue('Z12', "Rp.");
	$excel->setActiveSheetIndex(0)->setCellValue('AA12', "%");

	$excel->getActiveSheet()->mergeCells('AB10:AH10');
	$excel->setActiveSheetIndex(0)->setCellValue('AB10', "Belanja Modal");

	$excel->getActiveSheet()->mergeCells('AB11:AB12');
	$excel->setActiveSheetIndex(0)->setCellValue('AB11', "Belanja Modal Tanah");

	$excel->getActiveSheet()->mergeCells('AC11:AC12');
	$excel->setActiveSheetIndex(0)->setCellValue('AC11', "Belanja Modal Peralatan Dan Mesin");

	$excel->getActiveSheet()->mergeCells('AD11:AD12');
	$excel->setActiveSheetIndex(0)->setCellValue('AD11', "Belanja Modal Gedung dan Bangunan");

	$excel->getActiveSheet()->mergeCells('AE11:AE12');
	$excel->setActiveSheetIndex(0)->setCellValue('AE11', "Belanja Modal Jalan, Jaringan, dan Irigasi");

	$excel->getActiveSheet()->mergeCells('AF11:AF12');
	$excel->setActiveSheetIndex(0)->setCellValue('AF11', "Belanja Modal dan Aset Tetap Lainnya");

	$excel->getActiveSheet()->mergeCells('AG11:AH11');
	$excel->setActiveSheetIndex(0)->setCellValue('AG11', "Total");

	$excel->setActiveSheetIndex(0)->setCellValue('AG12', "Rp.");
	$excel->setActiveSheetIndex(0)->setCellValue('AH12', "%");

	$excel->getActiveSheet()->mergeCells('AI10:AK10');
	$excel->setActiveSheetIndex(0)->setCellValue('AI10', "Belanja Tidak Terduga");

	$excel->getActiveSheet()->mergeCells('AI11:AI12');
	$excel->setActiveSheetIndex(0)->setCellValue('AI11', "Belanja Tidak Terduga");

	$excel->getActiveSheet()->mergeCells('AJ11:AK11');
	$excel->setActiveSheetIndex(0)->setCellValue('AJ11', "Total");

	$excel->setActiveSheetIndex(0)->setCellValue('AJ12', "Rp.");
	$excel->setActiveSheetIndex(0)->setCellValue('AK12', "%");

	$excel->getActiveSheet()->mergeCells('AL10:AO10');
	$excel->setActiveSheetIndex(0)->setCellValue('AL10', "Belanja Transfer");

	$excel->getActiveSheet()->mergeCells('AL11:AL12');
	$excel->setActiveSheetIndex(0)->setCellValue('AL11', "Belanja Bagi Hasil");

	$excel->getActiveSheet()->mergeCells('AM11:AM12');
	$excel->setActiveSheetIndex(0)->setCellValue('AM11', "Belanja Bantuan Keuangan");

	$excel->getActiveSheet()->mergeCells('AN11:AO11');
	$excel->setActiveSheetIndex(0)->setCellValue('AN11', "Total");

	$excel->setActiveSheetIndex(0)->setCellValue('AN12', "Rp.");
	$excel->setActiveSheetIndex(0)->setCellValue('AO12', "%");

	$excel->getActiveSheet()->mergeCells('AP10:AQ11');
	$excel->setActiveSheetIndex(0)->setCellValue('AP10', "Total Realisasi Keuangan");

	$excel->setActiveSheetIndex(0)->setCellValue('AP12', "Rp.");
	$excel->setActiveSheetIndex(0)->setCellValue('AQ12', "%");

	$excel->getActiveSheet()->mergeCells('AR10:AR11');
	$excel->setActiveSheetIndex(0)->setCellValue('AR10', "Realisasi Fisik");
	$excel->setActiveSheetIndex(0)->setCellValue('AR12', "%");

	$excel->setActiveSheetIndex(0)->setCellValue('A13', "1");
	$excel->setActiveSheetIndex(0)->setCellValue('B13', "2");
	$excel->setActiveSheetIndex(0)->setCellValue('C13', "3");
	$excel->setActiveSheetIndex(0)->setCellValue('D13', "4");
	$excel->setActiveSheetIndex(0)->setCellValue('E13', "5");
	$excel->setActiveSheetIndex(0)->setCellValue('F13', "6");
	$excel->setActiveSheetIndex(0)->setCellValue('G13', "7");
	$excel->setActiveSheetIndex(0)->setCellValue('H13', "8");
	$excel->setActiveSheetIndex(0)->setCellValue('I13', "9");
	$excel->setActiveSheetIndex(0)->setCellValue('J13', "10");
	$excel->setActiveSheetIndex(0)->setCellValue('K13', "11");
	$excel->setActiveSheetIndex(0)->setCellValue('L13', "12");
	$excel->setActiveSheetIndex(0)->setCellValue('M13', "13");
	$excel->setActiveSheetIndex(0)->setCellValue('N13', "14");
	$excel->setActiveSheetIndex(0)->setCellValue('O13', "15");
	$excel->setActiveSheetIndex(0)->setCellValue('P13', "16");
	$excel->setActiveSheetIndex(0)->setCellValue('Q13', "17");
	$excel->setActiveSheetIndex(0)->setCellValue('R13', "18");
	$excel->setActiveSheetIndex(0)->setCellValue('S13', "19");
	$excel->setActiveSheetIndex(0)->setCellValue('T13', "20");
	$excel->setActiveSheetIndex(0)->setCellValue('U13', "21");
	$excel->setActiveSheetIndex(0)->setCellValue('V13', "22");
	$excel->setActiveSheetIndex(0)->setCellValue('W13', "23");
	$excel->setActiveSheetIndex(0)->setCellValue('X13', "24");
	$excel->setActiveSheetIndex(0)->setCellValue('Y13', "25");
	$excel->setActiveSheetIndex(0)->setCellValue('Z13', "26");
	$excel->setActiveSheetIndex(0)->setCellValue('AA13', "27 = 26 / 9 *100");
	$excel->setActiveSheetIndex(0)->setCellValue('AB13', "28");
	$excel->setActiveSheetIndex(0)->setCellValue('AC13', "29");
	$excel->setActiveSheetIndex(0)->setCellValue('AD13', "30");
	$excel->setActiveSheetIndex(0)->setCellValue('AE13', "31");
	$excel->setActiveSheetIndex(0)->setCellValue('AF13', "32");
	$excel->setActiveSheetIndex(0)->setCellValue('AG13', "33");
	$excel->setActiveSheetIndex(0)->setCellValue('AH13', "34 = 33 / 15 * 100");
	$excel->setActiveSheetIndex(0)->setCellValue('AI13', "35");
	$excel->setActiveSheetIndex(0)->setCellValue('AJ13', "36");
	$excel->setActiveSheetIndex(0)->setCellValue('AK13', "37 = 36 / 17 * 100");
	$excel->setActiveSheetIndex(0)->setCellValue('AL13', "38");
	$excel->setActiveSheetIndex(0)->setCellValue('AM13', "39");
	$excel->setActiveSheetIndex(0)->setCellValue('AN13', "40");
	$excel->setActiveSheetIndex(0)->setCellValue('AO13', "41 = 40 / 20 * 100");
	$excel->setActiveSheetIndex(0)->setCellValue('AP13', "42");
	$excel->setActiveSheetIndex(0)->setCellValue('AQ13', "43 = 42 / 21 * 100");
	$excel->setActiveSheetIndex(0)->setCellValue('AR13', "44");


	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);




	$total_program = 0;
	$total_kegiatan = 0;
	$total_sub_kegiatan = 0;
	$total_realisasi_fisik_semua =0;





	$total_pagu_bo_bp =0;
	$total_pagu_bo_bbj =0;
	$total_pagu_bo_bs =0;
	$total_pagu_bo_bh =0;
	$total_pagu_bm_bmt =0;
	$total_pagu_bm_bmpm =0;
	$total_pagu_bm_bmgb =0;
	$total_pagu_bm_bmjji =0;
	$total_pagu_bm_bmatl =0;
	$total_pagu_btt =0;
	$total_pagu_bt_bbh =0;
	$total_pagu_bt_bbk =0;
	$total_pagu_bo_total =0;
	$total_pagu_bm_total =0;
	$total_pagu_btt_total =0;
	$total_pagu_bt_total =0;
	$total_pagu_total =0;
	$total_realisasi_bo_bp =0;
	$total_realisasi_bo_bbj =0;
	$total_realisasi_bo_bs =0;
	$total_realisasi_bo_bh =0;
	$total_realisasi_bm_bmt =0;
	$total_realisasi_bm_bmpm =0;
	$total_realisasi_bm_bmgb =0;
	$total_realisasi_bm_bmjji =0;
	$total_realisasi_bm_bmatl =0;
	$total_realisasi_btt =0;
	$total_realisasi_bt_bbh =0;
	$total_realisasi_bt_bbk =0;
	$total_realisasi_bo_total =0;
	$total_realisasi_bm_total =0;
	$total_realisasi_btt_total =0;
	$total_realisasi_bt_total =0;
	$total_realisasi_total =0;



		$no_program = 0;
	    $program = $this->realisasi_akumulasi_model->get_program($id_instansi, $tahap, $tahun)->result();
		$kumpul_program = [];
	    foreach ($program as $k_program => $v_program) {
	    	$total_program++;
	    	$no_program++;
    // $pagu_program += $value->pagu;
		    $kegiatan = $this->realisasi_akumulasi_model->get_kegiatan($id_instansi, $v_program->kode_rekening_program, $v_program->kode_bidang_urusan)->result();
			$kumpul_kegiatan = [];
			$no_kegiatan = 0;

			$total_pagu_bo_bp_program = 0;
			$total_pagu_bo_bbj_program = 0;
			$total_pagu_bo_bs_program = 0;
			$total_pagu_bo_bh_program = 0;
			$total_pagu_bm_bmt_program = 0;
			$total_pagu_bm_bmpm_program = 0;
			$total_pagu_bm_bmgb_program = 0;
			$total_pagu_bm_bmjji_program = 0;
			$total_pagu_bm_bmatl_program = 0;
			$total_pagu_btt_program = 0;
			$total_pagu_bt_bbh_program = 0;
			$total_pagu_bt_bbk_program = 0;
			$total_pagu_bo_total_program = 0;
			$total_pagu_bm_total_program = 0;
			$total_pagu_btt_total_program = 0;
			$total_pagu_bt_total_program = 0;
			$total_pagu_total_program = 0;
			$total_realisasi_bo_bp_program = 0;
			$total_realisasi_bo_bbj_program = 0;
			$total_realisasi_bo_bs_program = 0;
			$total_realisasi_bo_bh_program = 0;
			$total_realisasi_bm_bmt_program = 0;
			$total_realisasi_bm_bmpm_program = 0;
			$total_realisasi_bm_bmgb_program = 0;
			$total_realisasi_bm_bmjji_program = 0;
			$total_realisasi_bm_bmatl_program = 0;
			$total_realisasi_btt_program = 0;
			$total_realisasi_bt_bbh_program = 0;
			$total_realisasi_bt_bbk_program = 0;
			$total_realisasi_bo_total_program = 0;
			$total_realisasi_bm_total_program = 0;
			$total_realisasi_btt_total_program = 0;
			$total_realisasi_bt_total_program = 0;
			$total_realisasi_total_program = 0;
			$total_realisasi_fisik_program = 0;

		    foreach ($kegiatan as $key => $value_kegiatan) {
				$total_kegiatan +=1;
				$banyak_kegiatan +=1;
				$no_kegiatan++;
				$no_sub_kegiatan = 0;
				$sub_kegiatan = $this->realisasi_akumulasi_model->get_sub_kegiatan($id_instansi, $value_kegiatan->kode_rekening_kegiatan, $value_kegiatan->kode_rekening_program, $value_kegiatan->kode_bidang_urusan);


				$total_pagu_bo_bp_kegiatan = 0;
				$total_pagu_bo_bbj_kegiatan = 0;
				$total_pagu_bo_bs_kegiatan = 0;
				$total_pagu_bo_bh_kegiatan = 0;
				$total_pagu_bm_bmt_kegiatan = 0;
				$total_pagu_bm_bmpm_kegiatan = 0;
				$total_pagu_bm_bmgb_kegiatan = 0;
				$total_pagu_bm_bmjji_kegiatan = 0;
				$total_pagu_bm_bmatl_kegiatan = 0;
				$total_pagu_btt_kegiatan = 0;
				$total_pagu_bt_bbh_kegiatan = 0;
				$total_pagu_bt_bbk_kegiatan = 0;
				$total_pagu_bo_total_kegiatan = 0;
				$total_pagu_bm_total_kegiatan = 0;
				$total_pagu_btt_total_kegiatan = 0;
				$total_pagu_bt_total_kegiatan = 0;
				$total_pagu_total_kegiatan = 0;
				$total_realisasi_bo_bp_kegiatan = 0;
				$total_realisasi_bo_bbj_kegiatan = 0;
				$total_realisasi_bo_bs_kegiatan = 0;
				$total_realisasi_bo_bh_kegiatan = 0;
				$total_realisasi_bm_bmt_kegiatan = 0;
				$total_realisasi_bm_bmpm_kegiatan = 0;
				$total_realisasi_bm_bmgb_kegiatan = 0;
				$total_realisasi_bm_bmjji_kegiatan = 0;
				$total_realisasi_bm_bmatl_kegiatan = 0;
				$total_realisasi_btt_kegiatan = 0;
				$total_realisasi_bt_bbh_kegiatan = 0;
				$total_realisasi_bt_bbk_kegiatan = 0;
				$total_realisasi_bo_total_kegiatan = 0;
				$total_realisasi_bm_total_kegiatan = 0;
				$total_realisasi_btt_total_kegiatan = 0;
				$total_realisasi_bt_total_kegiatan = 0;
				$total_realisasi_total_kegiatan = 0;
				$total_realisasi_fisik_kegiatan = 0;


				$kumpul_sub_kegiatan = [];
				foreach ($sub_kegiatan->result() as $key => $value_sk) {
					$total_sub_kegiatan++;

					$kategori_sub_kegiatan = $value_sk->kategori;
					$tahap = $value_sk->kode_tahap;
					$krsk = $value_sk->kode_rekening_sub_kegiatan;
					if($kategori_sub_kegiatan =='Unit Pelaksana'){
			            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan."<br>[".$value_sk->jenis_sub_kegiatan.' - '.$value_sk->keterangan."]";
			           
			          }else{
			            $nama_sub_kegiatan = $value_sk->nama_sub_kegiatan;
			          }

			          $realisasi = $this->realisasi_akumulasi_model->get_realisasi_keuangan($id_instansi, $value_sk->kode_rekening_sub_kegiatan, $bulan, $ope, $tahun, $tahap)->row_array();
			          $pagu = $this->db->query("SELECT 
			          	bo_bp, bo_bbj, bo_bs, bo_bh, bm_bmt, bm_bmpm, bm_bmgb, bm_bmjji, bm_bmatl, btt, bt_bbh, bt_bbk
						from anggaran_sub_kegiatan where id_instansi='$id_instansi' and tahun = '$tahun' and kode_tahap = '$tahap' and kode_sub_kegiatan='$krsk'
						")->row_array();
			   //        $realisasi = $this->db->query("SELECT 
			   //        	bo_bp, bo_bbj, bo_bs, bo_bh, bm_bmt, bm_bmpm, bm_bmgb, bm_bmjji, bm_bmatl, btt, bt_bbh, bt_bbk
						// from realisasi_keuangan where id_instansi='$id_instansi' and tahun = '$tahun' and kode_tahap = '$tahap' and kode_sub_kegiatan='$krsk' AND bulan $ope $bulan
						// ")->row_array();



						$pagu_bo_total = ($pagu['bo_bp'] + $pagu['bo_bbj'] + $pagu['bo_bs'] + $pagu['bo_bh']);
						$pagu_bm_total = ($pagu['bm_bmt'] + $pagu['bm_bmpm'] + $pagu['bm_bmgb'] + $pagu['bm_bmjji'] + $pagu['bm_bmatl']);
						$pagu_btt_total = $pagu['btt'];
						$pagu_bt_total = ($pagu['bt_bbh'] + $pagu['bt_bbk']);
						$pagu_total = ($pagu['bo_bp'] + $pagu['bo_bbj'] + $pagu['bo_bs'] + $pagu['bo_bh'] + $pagu['bm_bmt'] + $pagu['bm_bmpm'] + $pagu['bm_bmgb'] + $pagu['bm_bmjji'] + $pagu['bm_bmatl'] + $pagu['btt'] + $pagu['bt_bbh'] + $pagu['bt_bbk']);


						$realisasi_bo_total = ($realisasi['realisasi_bo_bp'] + $realisasi['realisasi_bo_bbj'] + $realisasi['realisasi_bo_bs'] + $realisasi['realisasi_bo_bh']);
						$realisasi_bm_total = ($realisasi['realisasi_bm_bmt'] + $realisasi['realisasi_bm_bmpm'] + $realisasi['realisasi_bm_bmgb'] + $realisasi['realisasi_bm_bmjji'] + $realisasi['realisasi_bm_bmatl']);
						$realisasi_btt_total = $realisasi['realisasi_btt'];
						$realisasi_bt_total = ($realisasi['realisasi_bt_bbh'] + $realisasi['realisasi_bt_bbk']);
						$realisasi_total = ($realisasi['realisasi_bo_bp'] + $realisasi['realisasi_bo_bbj'] + $realisasi['realisasi_bo_bs'] + $realisasi['realisasi_bo_bh'] + $realisasi['realisasi_bm_bmt'] + $realisasi['realisasi_bm_bmpm'] + $realisasi['realisasi_bm_bmgb'] + $realisasi['realisasi_bm_bmjji'] + $realisasi['realisasi_bm_bmatl'] + $realisasi['realisasi_btt'] + $realisasi['realisasi_bt_bbh'] + $realisasi['realisasi_bt_bbk']);


						$persen_realisasi_bo_total = $pagu_bo_total > 0 ? ($realisasi_bo_total / $pagu_bo_total)  * 100 : 0 ;
						$persen_realisasi_bm_total = $pagu_bm_total > 0 ? ($realisasi_bm_total / $pagu_bm_total)  * 100 : 0 ;
						$persen_realisasi_btt_total = $pagu_btt_total > 0 ? ($realisasi_btt_total / $pagu_btt_total)  * 100 : 0 ;
						$persen_realisasi_bt_total = $pagu_bt_total > 0 ? ($realisasi_bt_total / $pagu_bt_total)  * 100 : 0 ;
						$persen_realisasi_total = $pagu_total > 0 ? ($realisasi_total / $pagu_total)  * 100 : 0 ;










						// fisik
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
				              if ($ope=='=') {
				                $realisasi_rutin = (1/$lama_realisasi) *100;
				              }else{
				                $realisasi_rutin = $realisasi_rutin_bulan[$selisih_bulan][$bulan];
				              }
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

				          $total_realisasi_fisik    = $total_fisik > 100 ? 100 : $total_fisik;
				          // fisik





						// total
				          $total_pagu_bo_bp += $pagu['bo_bp'];
				          $total_pagu_bo_bbj += $pagu['bo_bbj'];
				          $total_pagu_bo_bs += $pagu['bo_bs'];
				          $total_pagu_bo_bh += $pagu['bo_bh'];
				          $total_pagu_bm_bmt += $pagu['bm_bmt'];
				          $total_pagu_bm_bmpm += $pagu['bm_bmpm'];
				          $total_pagu_bm_bmgb += $pagu['bm_bmgb'];
				          $total_pagu_bm_bmjji += $pagu['bm_bmjji'];
				          $total_pagu_bm_bmatl += $pagu['bm_bmatl'];
				          $total_pagu_btt += $pagu['btt'];
				          $total_pagu_bt_bbh += $pagu['bt_bbh'];
				          $total_pagu_bt_bbk += $pagu['bt_bbk'];

				          $total_pagu_bo_total += $pagu_bo_total;
				          $total_pagu_bm_total += $pagu_bm_total;
				          $total_pagu_btt_total += $pagu_btt_total;
				          $total_pagu_bt_total += $pagu_bt_total;
				          $total_pagu_total += $pagu_total;


				          $total_realisasi_bo_bp += $realisasi['realisasi_bo_bp'];
				          $total_realisasi_bo_bbj += $realisasi['realisasi_bo_bbj'];
				          $total_realisasi_bo_bs += $realisasi['realisasi_bo_bs'];
				          $total_realisasi_bo_bh += $realisasi['realisasi_bo_bh'];
				          $total_realisasi_bm_bmt += $realisasi['realisasi_bm_bmt'];
				          $total_realisasi_bm_bmpm += $realisasi['realisasi_bm_bmpm'];
				          $total_realisasi_bm_bmgb += $realisasi['realisasi_bm_bmgb'];
				          $total_realisasi_bm_bmjji += $realisasi['realisasi_bm_bmjji'];
				          $total_realisasi_bm_bmatl += $realisasi['realisasi_bm_bmatl'];
				          $total_realisasi_btt += $realisasi['realisasi_btt'];
				          $total_realisasi_bt_bbh += $realisasi['realisasi_bt_bbh'];
				          $total_realisasi_bt_bbk += $realisasi['realisasi_bt_bbk'];

				          $total_realisasi_bo_total += $realisasi_bo_total;   
				          $total_realisasi_bm_total += $realisasi_bm_total;   
				          $total_realisasi_btt_total += $realisasi_btt_total;   
				          $total_realisasi_bt_total += $realisasi_bt_total;   
				          $total_realisasi_total += $realisasi_total;  

				          $total_realisasi_fisik_semua += $total_realisasi_fisik;  





						$total_pagu_bo_bp_kegiatan += $pagu['bo_bp'];
						$total_pagu_bo_bbj_kegiatan += $pagu['bo_bbj'];
						$total_pagu_bo_bs_kegiatan += $pagu['bo_bs'];
						$total_pagu_bo_bh_kegiatan += $pagu['bo_bh'];
						$total_pagu_bm_bmt_kegiatan += $pagu['bm_bmt'];
						$total_pagu_bm_bmpm_kegiatan += $pagu['bm_bmpm'];
						$total_pagu_bm_bmgb_kegiatan += $pagu['bm_bmgb'];
						$total_pagu_bm_bmjji_kegiatan += $pagu['bm_bmjji'];
						$total_pagu_bm_bmatl_kegiatan += $pagu['bm_bmatl'];
						$total_pagu_btt_kegiatan += $pagu['btt'];
						$total_pagu_bt_bbh_kegiatan += $pagu['bt_bbh'];
						$total_pagu_bt_bbk_kegiatan += $pagu['bt_bbk'];

						$total_pagu_bo_total_kegiatan += $pagu_bo_total;
						$total_pagu_bm_total_kegiatan += $pagu_bm_total;
						$total_pagu_btt_total_kegiatan += $pagu_btt_total;
						$total_pagu_bt_total_kegiatan += $pagu_bt_total;
						$total_pagu_total_kegiatan += $pagu_total;


						$total_realisasi_bo_bp_kegiatan += $realisasi['realisasi_bo_bp'];
						$total_realisasi_bo_bbj_kegiatan += $realisasi['realisasi_bo_bbj'];
						$total_realisasi_bo_bs_kegiatan += $realisasi['realisasi_bo_bs'];
						$total_realisasi_bo_bh_kegiatan += $realisasi['realisasi_bo_bh'];
						$total_realisasi_bm_bmt_kegiatan += $realisasi['realisasi_bm_bmt'];
						$total_realisasi_bm_bmpm_kegiatan += $realisasi['realisasi_bm_bmpm'];
						$total_realisasi_bm_bmgb_kegiatan += $realisasi['realisasi_bm_bmgb'];
						$total_realisasi_bm_bmjji_kegiatan += $realisasi['realisasi_bm_bmjji'];
						$total_realisasi_bm_bmatl_kegiatan += $realisasi['realisasi_bm_bmatl'];
						$total_realisasi_btt_kegiatan += $realisasi['realisasi_btt'];
						$total_realisasi_bt_bbh_kegiatan += $realisasi['realisasi_bt_bbh'];
						$total_realisasi_bt_bbk_kegiatan += $realisasi['realisasi_bt_bbk'];

						$total_realisasi_bo_total_kegiatan += $realisasi_bo_total;   
						$total_realisasi_bm_total_kegiatan += $realisasi_bm_total;   
						$total_realisasi_btt_total_kegiatan += $realisasi_btt_total;   
						$total_realisasi_bt_total_kegiatan += $realisasi_bt_total;   
						$total_realisasi_total_kegiatan += $realisasi_total;  

						$total_realisasi_fisik_kegiatan += $total_realisasi_fisik; 






			           $data_kumpul_sub_kegiatan = [
				          'no_sub_kegiatan'=> $no_program.'.'.$no_kegiatan.'.'.$no_sub_kegiatan,
				          'kode_tahap'=> $value_sk->kode_tahap,
				          'kode_rekening_sub_kegiatan'=> $value_sk->kode_rekening_sub_kegiatan,
				          'nama_sub_kegiatan'=> $nama_sub_kegiatan,
				          'tahapan_apbd'=> pilihan_nama_tahapan($value_sk->kode_tahap),
				          'pagu_bo_bp'=> $pagu['bo_bp'],
				          'pagu_bo_bbj'=> $pagu['bo_bbj'],
				          'pagu_bo_bs'=> $pagu['bo_bs'],
				          'pagu_bo_bh'=> $pagu['bo_bh'],
				          'pagu_bm_bmt'=> $pagu['bm_bmt'],
				          'pagu_bm_bmpm'=> $pagu['bm_bmpm'],
				          'pagu_bm_bmgb'=> $pagu['bm_bmgb'],
				          'pagu_bm_bmjji'=> $pagu['bm_bmjji'],
				          'pagu_bm_bmatl'=> $pagu['bm_bmatl'],
				          'pagu_btt'=> $pagu['btt'],
				          'pagu_bt_bbh'=> $pagu['bt_bbh'],
				          'pagu_bt_bbk'=> $pagu['bt_bbk'],

				          'pagu_bo_total'=> $pagu_bo_total,
				          'pagu_bm_total'=> $pagu_bm_total,
				          'pagu_btt_total'=> $pagu_btt_total,
				          'pagu_bt_total'=> $pagu_bt_total,
				          'pagu_total'=> $pagu_total,


				          'realisasi_bo_bp'=> $realisasi['realisasi_bo_bp'],
				          'realisasi_bo_bbj'=> $realisasi['realisasi_bo_bbj'],
				          'realisasi_bo_bs'=> $realisasi['realisasi_bo_bs'],
				          'realisasi_bo_bh'=> $realisasi['realisasi_bo_bh'],
				          'realisasi_bm_bmt'=> $realisasi['realisasi_bm_bmt'],
				          'realisasi_bm_bmpm'=> $realisasi['realisasi_bm_bmpm'],
				          'realisasi_bm_bmgb'=> $realisasi['realisasi_bm_bmgb'],
				          'realisasi_bm_bmjji'=> $realisasi['realisasi_bm_bmjji'],
				          'realisasi_bm_bmatl'=> $realisasi['realisasi_bm_bmatl'],
				          'realisasi_btt'=> $realisasi['realisasi_btt'],
				          'realisasi_bt_bbh'=> $realisasi['realisasi_bt_bbh'],
				          'realisasi_bt_bbk'=> $realisasi['realisasi_bt_bbk'],

				          'realisasi_bo_total'=> $realisasi_bo_total,   
				          'realisasi_bm_total'=> $realisasi_bm_total,   
				          'realisasi_btt_total'=> $realisasi_btt_total,   
				          'realisasi_bt_total'=> $realisasi_bt_total,   
				          'realisasi_total'=> $realisasi_total,   

				          'persen_realisasi_bo_total'=> round($persen_realisasi_bo_total,2),   
				          'persen_realisasi_bm_total'=> round($persen_realisasi_bm_total,2),   
				          'persen_realisasi_btt_total'=> round($persen_realisasi_btt_total,2),   
				          'persen_realisasi_bt_total'=> round($persen_realisasi_bt_total,2),   
				          'persen_realisasi_total'=> round($persen_realisasi_total,2),   
				          'realisasi_fisik'=> round($total_realisasi_fisik,2),   
				         ];
				         array_push($kumpul_sub_kegiatan, $data_kumpul_sub_kegiatan);
				} // end foreach ($sub_kegiatan->result() as $key => $value_sk) 





					$persen_realisasi_bo_total_kegiatan = $total_pagu_bo_total_kegiatan > 0 ? ($total_realisasi_bo_total_kegiatan / $total_pagu_bo_total_kegiatan)  * 100 : 0 ;
					$persen_realisasi_bm_total_kegiatan = $total_pagu_bm_total_kegiatan > 0 ? ($total_realisasi_bm_total_kegiatan / $total_pagu_bm_total_kegiatan)  * 100 : 0 ;
					$persen_realisasi_btt_total_kegiatan = $total_pagu_btt_total_kegiatan > 0 ? ($total_realisasi_btt_total_kegiatan / $total_pagu_btt_total_kegiatan)  * 100 : 0 ;
					$persen_realisasi_bt_total_kegiatan = $total_pagu_bt_total_kegiatan > 0 ? ($total_realisasi_bt_total_kegiatan / $total_pagu_bt_total_kegiatan)  * 100 : 0 ;
					$persen_realisasi_total_kegiatan = $total_pagu_total_kegiatan > 0 ? ($total_realisasi_total_kegiatan / $total_pagu_total_kegiatan)  * 100 : 0 ;
					
					$tampilkan_total_realisasi_fisik_kegiatan = $total_realisasi_fisik_kegiatan / count($kumpul_sub_kegiatan);










						$total_pagu_bo_bp_program += $total_pagu_bo_bp_kegiatan;
						$total_pagu_bo_bbj_program += $total_pagu_bo_bbj_kegiatan;
						$total_pagu_bo_bs_program += $total_pagu_bo_bs_kegiatan;
						$total_pagu_bo_bh_program += $total_pagu_bo_bh_kegiatan;
						$total_pagu_bm_bmt_program += $total_pagu_bm_bmt_kegiatan;
						$total_pagu_bm_bmpm_program += $total_pagu_bm_bmpm_kegiatan;
						$total_pagu_bm_bmgb_program += $total_pagu_bm_bmgb_kegiatan;
						$total_pagu_bm_bmjji_program += $total_pagu_bm_bmjji_kegiatan;
						$total_pagu_bm_bmatl_program += $total_pagu_bm_bmatl_kegiatan;
						$total_pagu_btt_program += $total_pagu_btt_kegiatan;
						$total_pagu_bt_bbh_program += $total_pagu_bt_bbh_kegiatan;
						$total_pagu_bt_bbk_program += $total_pagu_bt_bbk_kegiatan;

						$total_pagu_bo_total_program += $total_pagu_bo_total_kegiatan;
						$total_pagu_bm_total_program += $total_pagu_bm_total_kegiatan;
						$total_pagu_btt_total_program += $total_pagu_btt_total_kegiatan;
						$total_pagu_bt_total_program += $total_pagu_bt_total_kegiatan;
						$total_pagu_total_program += $total_pagu_total_kegiatan;


						$total_realisasi_bo_bp_program += $total_realisasi_bo_bp_kegiatan;
						$total_realisasi_bo_bbj_program += $total_realisasi_bo_bbj_kegiatan;
						$total_realisasi_bo_bs_program += $total_realisasi_bo_bs_kegiatan;
						$total_realisasi_bo_bh_program += $total_realisasi_bo_bh_kegiatan;
						$total_realisasi_bm_bmt_program += $total_realisasi_bm_bmt_kegiatan;
						$total_realisasi_bm_bmpm_program += $total_realisasi_bm_bmpm_kegiatan;
						$total_realisasi_bm_bmgb_program += $total_realisasi_bm_bmgb_kegiatan;
						$total_realisasi_bm_bmjji_program += $total_realisasi_bm_bmjji_kegiatan;
						$total_realisasi_bm_bmatl_program += $total_realisasi_bm_bmatl_kegiatan;
						$total_realisasi_btt_program += $total_realisasi_btt_kegiatan;
						$total_realisasi_bt_bbh_program += $total_realisasi_bt_bbh_kegiatan;
						$total_realisasi_bt_bbk_program += $total_realisasi_bt_bbk_kegiatan;

						$total_realisasi_bo_total_program += $total_realisasi_bo_total_kegiatan;
						$total_realisasi_bm_total_program += $total_realisasi_bm_total_kegiatan;
						$total_realisasi_btt_total_program += $total_realisasi_btt_total_kegiatan;
						$total_realisasi_bt_total_program += $total_realisasi_bt_total_kegiatan;
						$total_realisasi_total_program += $total_realisasi_total_kegiatan;

						$total_realisasi_fisik_program += $tampilkan_total_realisasi_fisik_kegiatan; 





				    $data_kegiatan = [
			           'no_kegiatan'=>  $no_program.'.'.$no_kegiatan,
			          'kode_rekening_kegiatan'=> $value_kegiatan->kode_rekening_kegiatan,
			          'nama_kegiatan'=> $value_kegiatan->nama_kegiatan,





				          'pagu_bo_bp_kegiatan'=> $total_pagu_bo_bp_kegiatan,
				          'pagu_bo_bbj_kegiatan'=> $total_pagu_bo_bbj_kegiatan,
				          'pagu_bo_bs_kegiatan'=> $total_pagu_bo_bs_kegiatan,
				          'pagu_bo_bh_kegiatan'=> $total_pagu_bo_bh_kegiatan,
				          'pagu_bm_bmt_kegiatan'=> $total_pagu_bm_bmt_kegiatan,
				          'pagu_bm_bmpm_kegiatan'=> $total_pagu_bm_bmpm_kegiatan,
				          'pagu_bm_bmgb_kegiatan'=> $total_pagu_bm_bmgb_kegiatan,
				          'pagu_bm_bmjji_kegiatan'=> $total_pagu_bm_bmjji_kegiatan,
				          'pagu_bm_bmatl_kegiatan'=> $total_pagu_bm_bmatl_kegiatan,
				          'pagu_btt_kegiatan'=> $total_pagu_btt_kegiatan,
				          'pagu_bt_bbh_kegiatan'=> $total_pagu_bt_bbh_kegiatan,
				          'pagu_bt_bbk_kegiatan'=> $total_pagu_bt_bbk_kegiatan,

				          'pagu_bo_total_kegiatan'=> $total_pagu_bo_total_kegiatan,
				          'pagu_bm_total_kegiatan'=> $total_pagu_bm_total_kegiatan,
				          'pagu_btt_total_kegiatan'=> $total_pagu_btt_total_kegiatan,
				          'pagu_bt_total_kegiatan'=> $total_pagu_bt_total_kegiatan,
				          'pagu_total_kegiatan'=> $total_pagu_total_kegiatan,


				          'realisasi_bo_bp_kegiatan'=> $total_realisasi_bo_bp_kegiatan,
				          'realisasi_bo_bbj_kegiatan'=> $total_realisasi_bo_bbj_kegiatan,
				          'realisasi_bo_bs_kegiatan'=> $total_realisasi_bo_bs_kegiatan,
				          'realisasi_bo_bh_kegiatan'=> $total_realisasi_bo_bh_kegiatan,
				          'realisasi_bm_bmt_kegiatan'=> $total_realisasi_bm_bmt_kegiatan,
				          'realisasi_bm_bmpm_kegiatan'=> $total_realisasi_bm_bmpm_kegiatan,
				          'realisasi_bm_bmgb_kegiatan'=> $total_realisasi_bm_bmgb_kegiatan,
				          'realisasi_bm_bmjji_kegiatan'=> $total_realisasi_bm_bmjji_kegiatan,
				          'realisasi_bm_bmatl_kegiatan'=> $total_realisasi_bm_bmatl_kegiatan,
				          'realisasi_btt_kegiatan'=> $total_realisasi_btt_kegiatan,
				          'realisasi_bt_bbh_kegiatan'=> $total_realisasi_bt_bbh_kegiatan,
				          'realisasi_bt_bbk_kegiatan'=> $total_realisasi_bt_bbk_kegiatan,

				          'realisasi_bo_total_kegiatan'=> $total_realisasi_bo_total_kegiatan,
				          'realisasi_bm_total_kegiatan'=> $total_realisasi_bm_total_kegiatan,
				          'realisasi_btt_total_kegiatan'=> $total_realisasi_btt_total_kegiatan,
				          'realisasi_bt_total_kegiatan'=> $total_realisasi_bt_total_kegiatan,
				          'realisasi_total_kegiatan'=> $total_realisasi_total_kegiatan,

				          'persen_realisasi_bo_total_kegiatan'=> round($persen_realisasi_bo_total_kegiatan,2),   
				          'persen_realisasi_bm_total_kegiatan'=> round($persen_realisasi_bm_total_kegiatan,2),   
				          'persen_realisasi_btt_total_kegiatan'=> round($persen_realisasi_btt_total_kegiatan,2),   
				          'persen_realisasi_bt_total_kegiatan'=> round($persen_realisasi_bt_total_kegiatan,2),   
				          'persen_realisasi_total_kegiatan'=> round($persen_realisasi_total_kegiatan,2),  


				          'realisasi_fisik_kegiatan'=> round($tampilkan_total_realisasi_fisik_kegiatan,2),   




			          // 'pagu_kegiatan'=> $pagu_kegiatan,
			          // 'persen_tf_kegiatan'=> $tampilkan_persen_tf_kegiatan,
			          // 'persen_rf_kegiatan'=> $tampilkan_persen_rf_kegiatan,
			          // 'persen_df_kegiatan'=> $tampilkan_persen_df_kegiatan,
			          // 'nilai_tk_kegiatan'=> $nilai_tk_kegiatan,
			          // 'persen_tk_kegiatan'=> $tampilkan_persen_tk_kegiatan,
			          // 'nilai_rk_kegiatan'=> $nilai_rk_kegiatan,
			          // 'persen_rk_kegiatan'=> $tampilkan_persen_rk_kegiatan,
			          // 'persen_dk_kegiatan'=> $tampilkan_persen_dk_kegiatan,
			          // 'sisa_anggaran_kegiatan'=> $sisa_anggaran_kegiatan,
			          'data_sub_kegiatan' =>$kumpul_sub_kegiatan,
			        ];
			       array_push($kumpul_kegiatan, $data_kegiatan);
			} // foreach ($kegiatan as $key => $value_kegiatan)

			// $excel->setActiveSheetIndex(0)->setCellValue('A'.$row_program, $no_program);
			// $excel->setActiveSheetIndex(0)->setCellValue('B'.$row_program, '-');
			// $excel->setActiveSheetIndex(0)->setCellValue('C'.$row_program, $v_program->nama_program);
	    	$row_program++;






					$persen_realisasi_bo_total_program = $total_pagu_bo_total_program > 0 ? ($total_realisasi_bo_total_program / $total_pagu_bo_total_program)  * 100 : 0 ;
					$persen_realisasi_bm_total_program = $total_pagu_bm_total_program > 0 ? ($total_realisasi_bm_total_program / $total_pagu_bm_total_program)  * 100 : 0 ;
					$persen_realisasi_btt_total_program = $total_pagu_btt_total_program > 0 ? ($total_realisasi_btt_total_program / $total_pagu_btt_total_program)  * 100 : 0 ;
					$persen_realisasi_bt_total_program = $total_pagu_bt_total_program > 0 ? ($total_realisasi_bt_total_program / $total_pagu_bt_total_program)  * 100 : 0 ;
					$persen_realisasi_total_program = $total_pagu_total_program > 0 ? ($total_realisasi_total_program / $total_pagu_total_program)  * 100 : 0 ;
					
					$tampilkan_total_realisasi_fisik_program = $total_realisasi_fisik_program / count($kumpul_kegiatan);






	    	 $data_program = [
	           'no_program'=> $no_program,
	          'kode_rekening_program'=> $v_program->kode_rekening_program,
	          'nama_program'=> $v_program->nama_program,












				'pagu_bo_bp_program'=> $total_pagu_bo_bp_program,
				'pagu_bo_bbj_program'=> $total_pagu_bo_bbj_program,
				'pagu_bo_bs_program'=> $total_pagu_bo_bs_program,
				'pagu_bo_bh_program'=> $total_pagu_bo_bh_program,
				'pagu_bm_bmt_program'=> $total_pagu_bm_bmt_program,
				'pagu_bm_bmpm_program'=> $total_pagu_bm_bmpm_program,
				'pagu_bm_bmgb_program'=> $total_pagu_bm_bmgb_program,
				'pagu_bm_bmjji_program'=> $total_pagu_bm_bmjji_program,
				'pagu_bm_bmatl_program'=> $total_pagu_bm_bmatl_program,
				'pagu_btt_program'=> $total_pagu_btt_program,
				'pagu_bt_bbh_program'=> $total_pagu_bt_bbh_program,
				'pagu_bt_bbk_program'=> $total_pagu_bt_bbk_program,

				'pagu_bo_total_program'=> $total_pagu_bo_total_program,
				'pagu_bm_total_program'=> $total_pagu_bm_total_program,
				'pagu_btt_total_program'=> $total_pagu_btt_total_program,
				'pagu_bt_total_program'=> $total_pagu_bt_total_program,
				'pagu_total_program'=> $total_pagu_total_program,


				'realisasi_bo_bp_program'=> $total_realisasi_bo_bp_program,
				'realisasi_bo_bbj_program'=> $total_realisasi_bo_bbj_program,
				'realisasi_bo_bs_program'=> $total_realisasi_bo_bs_program,
				'realisasi_bo_bh_program'=> $total_realisasi_bo_bh_program,
				'realisasi_bm_bmt_program'=> $total_realisasi_bm_bmt_program,
				'realisasi_bm_bmpm_program'=> $total_realisasi_bm_bmpm_program,
				'realisasi_bm_bmgb_program'=> $total_realisasi_bm_bmgb_program,
				'realisasi_bm_bmjji_program'=> $total_realisasi_bm_bmjji_program,
				'realisasi_bm_bmatl_program'=> $total_realisasi_bm_bmatl_program,
				'realisasi_btt_program'=> $total_realisasi_btt_program,
				'realisasi_bt_bbh_program'=> $total_realisasi_bt_bbh_program,
				'realisasi_bt_bbk_program'=> $total_realisasi_bt_bbk_program,

				'realisasi_bo_total_program'=> $total_realisasi_bo_total_program,
				'realisasi_bm_total_program'=> $total_realisasi_bm_total_program,
				'realisasi_btt_total_program'=> $total_realisasi_btt_total_program,
				'realisasi_bt_total_program'=> $total_realisasi_bt_total_program,
				'realisasi_total_program'=> $total_realisasi_total_program,

				'persen_realisasi_bo_total_program'=> round($persen_realisasi_bo_total_program,2),   
				'persen_realisasi_bm_total_program'=> round($persen_realisasi_bm_total_program,2),   
				'persen_realisasi_btt_total_program'=> round($persen_realisasi_btt_total_program,2),   
				'persen_realisasi_bt_total_program'=> round($persen_realisasi_bt_total_program,2),   
				'persen_realisasi_total_program'=> round($persen_realisasi_total_program,2),  


				'realisasi_fisik_program'=> round($tampilkan_total_realisasi_fisik_program,2),   




	          // 'pagu_program'=>$pagu_program,
	          // 'persen_tf_program'=>$tampilkan_persen_tf_program,
	          // 'persen_rf_program'=>$tampilkan_persen_rf_program,
	          // 'persen_df_program'=>$tampilkan_persen_df_program,
	          // 'nilai_tk_program'=>$nilai_tk_program,
	          // 'persen_tk_program'=>$tampilkan_persen_tk_program,
	          // 'nilai_rk_program'=>$nilai_rk_program,
	          // 'persen_rk_program'=>$tampilkan_persen_rk_program,
	          // 'persen_dk_program'=>$tampilkan_persen_dk_program,
	          // 'sisa_anggaran_program'=>$sisa_anggaran_program,
	          'data_kegiatan' =>$kumpul_kegiatan,
	        ];

	        array_push($kumpul_program, $data_program);
	    }  // end foreach ($program as $key => $value_program)





		$row_program =14;
	     foreach ($kumpul_program as $k_program => $v_program) { 

	    	$excel->getActiveSheet()->getStyle('A'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('B'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('C'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('D'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('E'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('F'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('G'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('H'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('I'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('J'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('K'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('L'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('M'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('N'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('O'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('P'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Q'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('R'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('S'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('T'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('U'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('V'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('W'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('X'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Y'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Z'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AA'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AB'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AC'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AD'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AE'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AF'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AG'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AH'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AI'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AJ'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AK'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AL'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AM'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AN'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AO'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AP'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AQ'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AR'.$row_program)->applyFromArray($border);





      		$excel->getActiveSheet()->getStyle('A'.$row_program.':AR'.$row_program)->getAlignment()->setWrapText(true); 
      		$excel->getActiveSheet()->getStyle('A'.$row_program.':AR'.$row_program)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
      		$excel->getActiveSheet()->getStyle('A'.$row_program.':AR'.$row_program)->applyFromArray($fill_program);



	     	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_program, $v_program['no_program']); 
	     	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_program,'-'); 
	     	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_program, $v_program['kode_rekening_program']); 
	     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_program, $v_program['nama_program']); 


















			     	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_program, $v_program['pagu_bo_bp_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_program, $v_program['pagu_bo_bbj_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_program, $v_program['pagu_bo_bs_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_program, $v_program['pagu_bo_bh_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_program, $v_program['pagu_bo_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_program, $v_program['pagu_bm_bmt_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_program, $v_program['pagu_bm_bmpm_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_program, $v_program['pagu_bm_bmgb_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_program, $v_program['pagu_bm_bmjji_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_program, $v_program['pagu_bm_bmatl_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_program, $v_program['pagu_bm_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_program, $v_program['pagu_btt_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row_program, $v_program['pagu_btt_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('R'.$row_program, $v_program['pagu_bt_bbh_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_program, $v_program['pagu_bt_bbk_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('T'.$row_program, $v_program['pagu_bt_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('U'.$row_program, $v_program['pagu_total_program']); 


			     	$excel->setActiveSheetIndex(0)->setCellValue('V'.$row_program, $v_program['realisasi_bo_bp_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_program, $v_program['realisasi_bo_bbj_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('X'.$row_program, $v_program['realisasi_bo_bs_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_program, $v_program['realisasi_bo_bh_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row_program, $v_program['realisasi_bo_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_program, $v_program['persen_realisasi_bo_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row_program, $v_program['realisasi_bm_bmt_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row_program, $v_program['realisasi_bm_bmpm_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row_program, $v_program['realisasi_bm_bmgb_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row_program, $v_program['realisasi_bm_bmjji_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row_program, $v_program['realisasi_bm_bmatl_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_program, $v_program['realisasi_bm_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AH'.$row_program, $v_program['persen_realisasi_bm_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AI'.$row_program, $v_program['realisasi_btt_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row_program, $v_program['realisasi_btt_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AK'.$row_program, $v_program['persen_realisasi_btt_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AL'.$row_program, $v_program['realisasi_bt_bbh_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AM'.$row_program, $v_program['realisasi_bt_bbk_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AN'.$row_program, $v_program['realisasi_bt_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AO'.$row_program, $v_program['persen_realisasi_bt_total_program']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AP'.$row_program, $v_program['realisasi_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$row_program, $v_program['persen_realisasi_total_program']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AR'.$row_program, $v_program['realisasi_fisik_program']); 


		      		$excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('V'.$row_program.':Z'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AB'.$row_program.':AG'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AI'.$row_program.':AJ'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AL'.$row_program.':AN'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AP'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 

				    $excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
















































	     	 foreach ($v_program['data_kegiatan'] as $k_kegiatan => $v_kegiatan) { 
		     	$row_program++;




			    	$excel->getActiveSheet()->getStyle('A'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('B'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('C'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('D'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('E'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('F'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('G'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('H'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('I'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('J'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('K'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('L'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('M'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('N'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('O'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('P'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Q'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('R'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('S'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('T'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('U'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('V'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('W'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('X'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Y'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Z'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AA'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AB'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AC'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AD'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AE'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AF'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AG'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AH'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AI'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AJ'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AK'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AL'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AM'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AN'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AO'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AP'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AQ'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AR'.$row_program)->applyFromArray($border);



		     	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_program, $v_kegiatan['no_kegiatan']); 
		     	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_program, $v_kegiatan['kode_rekening_kegiatan']); 
		     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_program, $v_kegiatan['nama_kegiatan']); 

	     	 	$excel->getActiveSheet()->getStyle('A'.$row_program.':AR'.$row_program)->applyFromArray($fill_kegiatan);
























			     	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_program, $v_kegiatan['pagu_bo_bp_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_program, $v_kegiatan['pagu_bo_bbj_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_program, $v_kegiatan['pagu_bo_bs_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_program, $v_kegiatan['pagu_bo_bh_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_program, $v_kegiatan['pagu_bo_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_program, $v_kegiatan['pagu_bm_bmt_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_program, $v_kegiatan['pagu_bm_bmpm_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_program, $v_kegiatan['pagu_bm_bmgb_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_program, $v_kegiatan['pagu_bm_bmjji_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_program, $v_kegiatan['pagu_bm_bmatl_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_program, $v_kegiatan['pagu_bm_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_program, $v_kegiatan['pagu_btt_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row_program, $v_kegiatan['pagu_btt_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('R'.$row_program, $v_kegiatan['pagu_bt_bbh_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_program, $v_kegiatan['pagu_bt_bbk_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('T'.$row_program, $v_kegiatan['pagu_bt_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('U'.$row_program, $v_kegiatan['pagu_total_kegiatan']); 


			     	$excel->setActiveSheetIndex(0)->setCellValue('V'.$row_program, $v_kegiatan['realisasi_bo_bp_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_program, $v_kegiatan['realisasi_bo_bbj_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('X'.$row_program, $v_kegiatan['realisasi_bo_bs_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_program, $v_kegiatan['realisasi_bo_bh_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row_program, $v_kegiatan['realisasi_bo_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_program, $v_kegiatan['persen_realisasi_bo_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row_program, $v_kegiatan['realisasi_bm_bmt_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row_program, $v_kegiatan['realisasi_bm_bmpm_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row_program, $v_kegiatan['realisasi_bm_bmgb_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row_program, $v_kegiatan['realisasi_bm_bmjji_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row_program, $v_kegiatan['realisasi_bm_bmatl_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_program, $v_kegiatan['realisasi_bm_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AH'.$row_program, $v_kegiatan['persen_realisasi_bm_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AI'.$row_program, $v_kegiatan['realisasi_btt_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row_program, $v_kegiatan['realisasi_btt_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AK'.$row_program, $v_kegiatan['persen_realisasi_btt_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AL'.$row_program, $v_kegiatan['realisasi_bt_bbh_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AM'.$row_program, $v_kegiatan['realisasi_bt_bbk_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AN'.$row_program, $v_kegiatan['realisasi_bt_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AO'.$row_program, $v_kegiatan['persen_realisasi_bt_total_kegiatan']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AP'.$row_program, $v_kegiatan['realisasi_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$row_program, $v_kegiatan['persen_realisasi_total_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AR'.$row_program, $v_kegiatan['realisasi_fisik_kegiatan']); 


		      		$excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('V'.$row_program.':Z'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AB'.$row_program.':AG'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AI'.$row_program.':AJ'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AL'.$row_program.':AN'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AP'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 

				    $excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 













	     	 	 foreach ($v_kegiatan['data_sub_kegiatan'] as $k_ski => $v_sub_kegiatan) { 
			     	$row_program++;





			    	$excel->getActiveSheet()->getStyle('A'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('B'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('C'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('D'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('E'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('F'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('G'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('H'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('I'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('J'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('K'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('L'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('M'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('N'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('O'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('P'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Q'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('R'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('S'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('T'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('U'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('V'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('W'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('X'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Y'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('Z'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AA'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AB'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AC'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AD'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AE'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AF'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AG'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AH'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AI'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AJ'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AK'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AL'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AM'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AN'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AO'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AP'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AQ'.$row_program)->applyFromArray($border);
			    	$excel->getActiveSheet()->getStyle('AR'.$row_program)->applyFromArray($border);


	     	 	 	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_program, $v_sub_kegiatan['no_sub_kegiatan']); 
		     	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_program, $v_sub_kegiatan['tahapan_apbd']); 
		     	$excel->setActiveSheetIndex(0)->setCellValue('C'.$row_program, $v_sub_kegiatan['kode_rekening_sub_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_program, $v_sub_kegiatan['nama_sub_kegiatan']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_program, $v_sub_kegiatan['pagu_bo_bp']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_program, $v_sub_kegiatan['pagu_bo_bbj']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_program, $v_sub_kegiatan['pagu_bo_bs']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_program, $v_sub_kegiatan['pagu_bo_bh']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_program, $v_sub_kegiatan['pagu_bo_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_program, $v_sub_kegiatan['pagu_bm_bmt']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_program, $v_sub_kegiatan['pagu_bm_bmpm']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_program, $v_sub_kegiatan['pagu_bm_bmgb']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_program, $v_sub_kegiatan['pagu_bm_bmjji']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_program, $v_sub_kegiatan['pagu_bm_bmatl']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_program, $v_sub_kegiatan['pagu_bm_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_program, $v_sub_kegiatan['pagu_btt']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row_program, $v_sub_kegiatan['pagu_btt_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('R'.$row_program, $v_sub_kegiatan['pagu_bt_bbh']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_program, $v_sub_kegiatan['pagu_bt_bbk']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('T'.$row_program, $v_sub_kegiatan['pagu_bt_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('U'.$row_program, $v_sub_kegiatan['pagu_total']); 


			     	$excel->setActiveSheetIndex(0)->setCellValue('V'.$row_program, $v_sub_kegiatan['realisasi_bo_bp']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_program, $v_sub_kegiatan['realisasi_bo_bbj']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('X'.$row_program, $v_sub_kegiatan['realisasi_bo_bs']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_program, $v_sub_kegiatan['realisasi_bo_bh']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row_program, $v_sub_kegiatan['realisasi_bo_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_program, $v_sub_kegiatan['persen_realisasi_bo_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row_program, $v_sub_kegiatan['realisasi_bm_bmt']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row_program, $v_sub_kegiatan['realisasi_bm_bmpm']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row_program, $v_sub_kegiatan['realisasi_bm_bmgb']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row_program, $v_sub_kegiatan['realisasi_bm_bmjji']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row_program, $v_sub_kegiatan['realisasi_bm_bmatl']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_program, $v_sub_kegiatan['realisasi_bm_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AH'.$row_program, $v_sub_kegiatan['persen_realisasi_bm_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AI'.$row_program, $v_sub_kegiatan['realisasi_btt']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row_program, $v_sub_kegiatan['realisasi_btt_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AK'.$row_program, $v_sub_kegiatan['persen_realisasi_btt_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AL'.$row_program, $v_sub_kegiatan['realisasi_bt_bbh']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AM'.$row_program, $v_sub_kegiatan['realisasi_bt_bbk']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AN'.$row_program, $v_sub_kegiatan['realisasi_bt_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AO'.$row_program, $v_sub_kegiatan['persen_realisasi_bt_total']); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AP'.$row_program, $v_sub_kegiatan['realisasi_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$row_program, $v_sub_kegiatan['persen_realisasi_total']); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AR'.$row_program, $v_sub_kegiatan['realisasi_fisik']); 


		      		$excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('V'.$row_program.':Z'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AB'.$row_program.':AG'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AI'.$row_program.':AJ'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AL'.$row_program.':AN'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AP'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 

				    $excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
	     	 	 }
	     	 }
	     	$row_program++;
	     }





	    	$excel->getActiveSheet()->getStyle('A'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('B'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('C'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('D'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('E'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('F'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('G'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('H'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('I'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('J'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('K'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('L'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('M'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('N'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('O'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('P'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Q'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('R'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('S'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('T'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('U'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('V'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('W'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('X'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Y'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('Z'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AA'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AB'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AC'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AD'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AE'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AF'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AG'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AH'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AI'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AJ'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AK'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AL'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AM'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AN'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AO'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AP'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AQ'.$row_program)->applyFromArray($border);
	    	$excel->getActiveSheet()->getStyle('AR'.$row_program)->applyFromArray($border);




	$excel->getActiveSheet()->mergeCells('A'.$row_program.':D'.$row_program);
	$excel->setActiveSheetIndex(0)->setCellValue('A'.$row_program, "Total");



	$total_persen_realisasi_bo_total = $total_pagu_bo_total > 0 ? ($total_realisasi_bo_total / $total_pagu_bo_total) * 100 : 0 ;
	$total_persen_realisasi_bm_total = $total_pagu_bm_total > 0 ? ($total_realisasi_bm_total / $total_pagu_bm_total) * 100 : 0 ;
	$total_persen_realisasi_btt_total = $total_pagu_btt_total > 0 ? ($total_realisasi_btt_total / $total_pagu_btt_total) * 100 : 0 ;
	$total_persen_realisasi_bt_total = $total_pagu_bt_total > 0 ? ($total_realisasi_bt_total / $total_pagu_bt_total) * 100 : 0 ;
	$total_persen_realisasi_total = $total_pagu_total > 0 ? ($total_realisasi_total / $total_pagu_total) * 100 : 0 ;

	$total_realisasi_fisik_opd = $total_realisasi_fisik_semua / $total_sub_kegiatan;

			     	$excel->setActiveSheetIndex(0)->setCellValue('E'.$row_program, $total_pagu_bo_bp); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('F'.$row_program, $total_pagu_bo_bbj); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('G'.$row_program, $total_pagu_bo_bs); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('H'.$row_program, $total_pagu_bo_bh); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('I'.$row_program, $total_pagu_bo_total); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('J'.$row_program, $total_pagu_bm_bmt); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('K'.$row_program, $total_pagu_bm_bmpm); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('L'.$row_program, $total_pagu_bm_bmgb); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('M'.$row_program, $total_pagu_bm_bmjji); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('N'.$row_program, $total_pagu_bm_bmatl); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('O'.$row_program, $total_pagu_bm_total); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('P'.$row_program, $total_pagu_btt); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row_program, $total_pagu_btt_total); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('R'.$row_program, $total_pagu_bt_bbh); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('S'.$row_program, $total_pagu_bt_bbk); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('T'.$row_program, $total_pagu_bt_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('U'.$row_program, $total_pagu_total); 


			     	$excel->setActiveSheetIndex(0)->setCellValue('V'.$row_program, $total_realisasi_bo_bp); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('W'.$row_program, $total_realisasi_bo_bbj); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('X'.$row_program, $total_realisasi_bo_bs); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Y'.$row_program, $total_realisasi_bo_bh); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('Z'.$row_program, $total_realisasi_bo_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AA'.$row_program, round($total_persen_realisasi_bo_total,2)); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AB'.$row_program, $total_realisasi_bm_bmt); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AC'.$row_program, $total_realisasi_bm_bmpm); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AD'.$row_program, $total_realisasi_bm_bmgb); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AE'.$row_program, $total_realisasi_bm_bmjji); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AF'.$row_program, $total_realisasi_bm_bmatl); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AG'.$row_program, $total_realisasi_bm_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AH'.$row_program, round($total_persen_realisasi_bm_total,2)); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AI'.$row_program, $total_realisasi_btt); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AJ'.$row_program, $total_realisasi_btt_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AK'.$row_program, round($total_persen_realisasi_btt_total,2)); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AL'.$row_program, $total_realisasi_bt_bbh); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AM'.$row_program, $total_realisasi_bt_bbk); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AN'.$row_program, $total_realisasi_bt_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AO'.$row_program, round($total_persen_realisasi_bt_total,2)); 

			     	$excel->setActiveSheetIndex(0)->setCellValue('AP'.$row_program, $total_realisasi_total); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AQ'.$row_program, round($total_persen_realisasi_total,2)); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('AR'.$row_program, round($total_realisasi_fisik_opd,2)); 


		      		$excel->getActiveSheet()->getStyle('E'.$row_program.':U'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('V'.$row_program.':Z'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AB'.$row_program.':AG'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AI'.$row_program.':AJ'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AL'.$row_program.':AN'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 
		      		$excel->getActiveSheet()->getStyle('AP'.$row_program)->getNumberFormat()->setFormatCode('#,##0'); 






		      		$row_footer = $row_program + 2; 
		      		$row_total_program = $row_footer;
		      		$row_total_kegiatan = $row_footer +1;
		      		$row_total_sub_kegiatan = $row_footer +2;


		      		$excel->getActiveSheet()->mergeCells('B'.$row_footer.':C'.$row_footer);
			     	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_total_program, "Total Program "); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_total_program, $total_program); 
					$excel->getActiveSheet()->getStyle('D'.$row_total_program)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


		      		$excel->getActiveSheet()->mergeCells('B'.$row_total_kegiatan.':C'.$row_total_kegiatan);
			     	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_total_kegiatan, "Total Kegiatan "); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_total_kegiatan, $total_kegiatan); 
					$excel->getActiveSheet()->getStyle('D'.$row_total_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		      		$excel->getActiveSheet()->mergeCells('B'.$row_total_sub_kegiatan.':C'.$row_total_sub_kegiatan);
			     	$excel->setActiveSheetIndex(0)->setCellValue('B'.$row_total_sub_kegiatan, "Total Sub Kegiatan "); 
			     	$excel->setActiveSheetIndex(0)->setCellValue('D'.$row_total_sub_kegiatan, $total_sub_kegiatan); 
					$excel->getActiveSheet()->getStyle('D'.$row_total_sub_kegiatan)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);





// 		// accounting format cell
// 		$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
// 		$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

	
// 		// memberi border cell
// 		$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->applyFromArray($border);




//       	// rata tengah
   
//       	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      
//       	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
      	
//       	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 




// 		$total_pagu_paket += $v_paket['pagu'];
// 		$total_data_paket++;
		
// 		$total_nilai_terkontrak += $v_paket['nilai_kontrak'];

// 	$baris_mulai_paket++;
//          $baris_mulai_sub_kegiatan ++ ;

//   } //end foreach ($paket->result_array() as $k_paket => $v_paket)
// 	$baris_mulai_paket++;
//          $baris_mulai_sub_kegiatan++ ;
// } //end foreach ($sub_kegiatan_paket->result() as $key => $value_sk)




// 	$baris_mulai_paket-=1;


// 	 $excel->getActiveSheet()->mergeCells('A'.$baris_mulai_paket.':B'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
// 	 $excel->getActiveSheet()->mergeCells('D'.$baris_mulai_paket.':E'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
// 	 $excel->getActiveSheet()->mergeCells('F'.$baris_mulai_paket.':M'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1
// 	 $excel->getActiveSheet()->mergeCells('N'.$baris_mulai_paket.':O'.$baris_mulai_paket); // Set Merge Cell pada kolom A1 sampai E1


//       	$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket.':B'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
//       	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

//       	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
//       	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 



//       	  $excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->getFont()->setBold(TRUE); // Set bold kolom A1

// 	$excel->setActiveSheetIndex(0)->setCellValue('A'.$baris_mulai_paket, 'Total Pagu Paket '.$jenis_paket);
// 	$excel->setActiveSheetIndex(0)->setCellValue('C'.$baris_mulai_paket, $total_pagu_paket);
// 	$excel->setActiveSheetIndex(0)->setCellValue('D'.$baris_mulai_paket, $total_data_paket.' paket pekerjaan ');
// 	$excel->setActiveSheetIndex(0)->setCellValue('F'.$baris_mulai_paket, '-');
// 	$excel->setActiveSheetIndex(0)->setCellValue('N'.$baris_mulai_paket, $total_data_terkontrak.' Terkontrak');
// 	$excel->setActiveSheetIndex(0)->setCellValue('P'.$baris_mulai_paket, $total_nilai_terkontrak);


// 		$excel->getActiveSheet()->getStyle('A'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('B'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('D'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('E'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('F'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('G'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('H'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('I'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('J'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('K'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('L'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('M'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('N'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('O'.$baris_mulai_paket)->applyFromArray($border);
//       	$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->applyFromArray($border);






// 		$excel->getActiveSheet()->getStyle('C'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
// 		$excel->getActiveSheet()->getStyle('P'.$baris_mulai_paket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	



    // Set width kolom
  // Set width kolom E
    
    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

    // Set orientasi kertas jadi LANDSCAPE
    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);


    $excel->setActiveSheetIndex(0);

  
    $download_export = $judul_file.'.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$download_export.'"'); // Set nama file excel nya
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }


}
