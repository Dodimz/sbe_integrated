<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/FPDF/fpdf.php';
class Pdf_laporan_realisasi_fisik_keuangan extends FPDF
{
    public $pdf;
    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->pdf = $this;
    }

 

    function Header()
    {
        $namabulan = [
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
        global $id_instansi;
        global $kategori;
        global $bulan;

$judul = "Laporan Fisik Dan Keuangan / SKPD Tahun ". tahun_anggaran();

        $CI = &get_instance();
        // $identitas = "Ini adalah identitas";
        // $deskripsi = "Tahun Anggaran " . tahun_anggaran();
        // $this->pdf->Image('./assets/sbe/image/logo.png', 5, 4, 18, 20);
        // $this->pdf->Cell(90);
        // $this->pdf->SetFont('Arial', 'B', 15);
        // $this->pdf->Cell(45, 10, 'PEMERINTAH PROVINSI SUMATERA BARAT', 0, 1, 'C');
        // $this->pdf->Cell(90);
        // $this->pdf->SetFont('Arial', 'B', 11);
        // $this->pdf->Cell(45, 1, $identitas, 0, 1, 'C');
        // $this->pdf->Cell(90);
        // $this->pdf->SetFont('Arial', 'B', 10);
        // $this->pdf->Cell(45, 10, $deskripsi, 0, 1, 'C');
        // $this->pdf->SetLineWidth(1);

        // $this->pdf->Line(5, 26, 206, 26); //5,26,206,26
        // $this->pdf->SetLineWidth(0);
        // $this->pdf->Line(5, 27, 206, 27); //5,27,206,27
        $this->pdf->Ln(5);
        $this->pdf->Cell(90);
        $this->pdf->SetFontSize(8);
        $this->pdf->SetFont('Arial', '', 'L');
        $this->pdf->Cell(45, 5, $judul, 0, 1, 'C');
        $this->pdf->Cell(10, 6, '', 0, 1);

        $this->pdf->SetFont('Arial', 'B', 'L');
        $this->pdf->SetFontSize(7);

        $this->pdf->cell(10, 7, 'NO', 1, 0,'C');
        $this->pdf->cell(130, 7, 'SKPD', 1, 0, 'C');
        $this->pdf->cell(30, 7, 'Realisasi Fisik', 1, 0, 'C');
        $this->pdf->cell(30, 7, 'Realisasi Keuangan', 1, 0, 'C');


        $this->pdf->Cell(10, 2, '', 0, 1);

        $this->pdf->cell(163, 2, '', 0, 0);
   
        $this->pdf->Ln(5);
      

    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->pdf->SetY(-22);
        // Print current and total page numbers
        $this->pdf->AliasNbPages();
        // Select Arial italic 8
        $this->pdf->SetFont('Arial', 'I', 6);
        $this->pdf->Cell(0, 10, 'Powered By IT Biro Kerjasama, Pembangunan dan Rantau Tahun ' . tahun_anggaran(), 0, 0);
        $this->pdf->SetFont('Arial', '', 6);
        $this->pdf->Cell(0, 10, 'Page ' . $this->pdf->PageNo() . '/{nb}', 0, 1, 'R');
    
    }
}
