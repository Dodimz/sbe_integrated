<?php

/**
 * Author     : Alfikri, M.Kom
 * Created By : Alfikri, M.Kom
 * E-Mail     : alfikri.name@gmail.com
 * No HP      : 081277337405
 * Class      : Laporan.php
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Filter extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Filter/skpd_model'		=> 'skpd_model',
			'Filter/jenis_belanja'					=> 'jenis_belanja',
			'Laporan/realisasi_akumulasi_model'	=> 'realisasi_akumulasi_model',
			// 'Filter/jumlah_aktivitas_model'	=> 'jumlah_aktivitas_model',
			// 'Filter/rekap_kegiatan_kab_kota'	=> 'rekap_kegiatan_kab_kota',
			// 'Filter/lap_realisasi_fisik_keu'	=> 'lap_realisasi_fisik_keu',
			// 'Filter/target_realisasi_model'	=> 'target_realisasi_model'
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
	public function jenis_belanja()
	{
		$breadcrumbs     		= $this->breadcrumbs;
		$skpd    = $this->skpd_model;

		$breadcrumbs->add('Home', base_url());
		$breadcrumbs->add('Laporan', base_url($this->router->fetch_class()));
		$breadcrumbs->add('Filter Laporan', base_url());
		$breadcrumbs->render();

		$data['title']      	= "Filter Laporan";
		$data['icon']       	= "metismenu-icon fas fa-file-signature";
		$data['description']	= "Berdasarkan Jenis Belanja";
		$data['breadcrumbs']	= $breadcrumbs->render();
		$data['opd']					= $skpd->get_opd();
		$page               	= 'filter/jenis_belanja/index';
		$data['link']       	= $this->router->fetch_method();
		$data['menu']       	= $this->load->view('layout/menu', $data, true);
		$data['extra_css']  	= $this->load->view('filter/jenis_belanja/css', $data, true);
		$data['extra_js']   	= $this->load->view('filter/jenis_belanja/js', $data, true);
		$data['modal']      	= $this->load->view('filter/jenis_belanja/modal', $data, true);
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

	public function pdf_laporan_realisasi_jenis_belanja()
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
		$bulan 				= $this->input->get('bulan');


		$judul_laporan = "Laporan realisasi bulan ";
		$ope = '<=';
	    $program = $this->jenis_belanja->get_program($id_instansi)->result();
	    $data['program']=$program;
	    $data['ope']=$ope;
	    $data['bulan']=$bulan;
	    $data['id_instansi']=$id_instansi;
	    $nama_instansi = $this->sbe_nama_instansi($id_instansi);
	    $data['judul_laporan']=$judul_laporan;
	    $data['title']=$judul_laporan.' '.$nama_instansi;
	    $data['nama_instansi']=$nama_instansi;
	    $html =  $this->load->view('filter/pdf/jenis_belanja/content', $data, true);

	    $header =  $this->load->view('filter/pdf/jenis_belanja/header', $data, true);
	    $footer =  $this->load->view('filter/pdf/jenis_belanja/footer', $data, true);

	    $mpdf->SetMargins(0, 0, 42);

		$mpdf->SetHTMLHeader($header);
		$mpdf->SetHTMLFooter($footer);
		$mpdf->WriteHTML($html);
		$mpdf->Output($judul_laporan.' - '.$nama_instansi.'.pdf', 'I');
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
}
