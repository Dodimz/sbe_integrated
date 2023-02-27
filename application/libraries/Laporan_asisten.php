<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/FPDF/fpdf.php';
class Laporan_asisten extends FPDF
{
  public $pdf;
  function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
  {
    parent::__construct($orientation, $unit, $size);
    $this->pdf = $this;
  }

  function Header()
  {
    global $bulan;

    $CI = &get_instance();
    $identitas = "Rekapitulasi SIMBANGDA Based Evidence Per SKPD";
    $deskripsi = 'Per ' . jml_hari_dalam_bulan($bulan, tahun_anggaran()) . ' ' . bulan_global($bulan) . ' ' . tahun_anggaran();
    $this->pdf->Image('./assets/sbe/image/logo.png', 10, 4, 18, 20);
    $this->pdf->Cell(133);
    $this->pdf->SetFont('Arial', 'B', 15);
    $this->pdf->Cell(45, 10, 'PEMERINTAH PROVINSI SUMATERA BARAT', 0, 1, 'C');
    $this->pdf->Cell(133);
    $this->pdf->SetFont('Arial', 'B', 11);
    $this->pdf->Cell(45, 1, $identitas, 0, 1, 'C');
    $this->pdf->Cell(133);
    $this->pdf->SetFont('Arial', 'B', 10);
    $this->pdf->Cell(45, 10, $deskripsi, 0, 1, 'C');
    $this->pdf->SetLineWidth(1);

    $this->pdf->Line(10, 26, 317, 26); //5,26,292,26
    $this->pdf->SetLineWidth(0);
    $this->pdf->Line(10, 27, 317, 27); //5,27,292,27
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
    $this->pdf->Cell(0, 10, 'Powered By IT Biro Kerjasama, Pembangunan dan Rantau Tahun ' . date('Y'), 0, 0);
    $this->pdf->SetFont('Arial', '', 6);
    $this->pdf->Cell(0, 10, 'Page ' . $this->pdf->PageNo() . '/{nb}', 0, 1, 'R');
    // $this->pdf->Cell(0, 2, 'Powered By IT Biro Kerjasama, Pembangunan dan Rantau Tahun '.date('Y'), 0,0);
    // $this->pdf->MultiCell(0,1,'Powered By IT Biro Kerjasama, Pembangunan dan Rantau Tahun');
    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->Cell(0, 3, 'UU ITE No 11 Tahun 2018 Pasal 5 ayat 1 :', 0, 1);
    $this->pdf->SetFont('Arial', 'I', 5);
    $this->pdf->MultiCell(0, 3, '"Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah"');
    $this->pdf->SetFont('Arial', '', 5);
    $this->pdf->MultiCell(0, 2, 'Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE. Dokumen ini dicetak melalui aplikasi SIMBANGDA Based Evidence dan dapat dipergunakan sebagai bukti yang sah. Cetakan ini merupakan salinan dan dapat dibuktikan keasliannya melalui scan QRCode yang terdapat pada dokumen ini.');
  }
}
