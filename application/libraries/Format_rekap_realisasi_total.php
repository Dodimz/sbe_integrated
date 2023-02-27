<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/FPDF/fpdf.php';
class Format_rekap_realisasi_total extends FPDF
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
        $identitas = $this->pdf->GetPageWidth();
        $deskripsi = "tes";
        $judul = "tes";
        $deskripsi = "Tahun Anggaran " . tahun_anggaran();

        // $this->SetAlpha(0.1);
        // $this->pdf->Image('./assets/sbe/image/logo.png', 89, 35, 120, 140);
        $this->pdf->Image('./assets/sbe/image/logo.png', 5, 4, 18, 20);
        // $this->SetAlpha(1);
        $this->pdf->Cell(110);
        $this->pdf->SetFont('Arial', 'B', 15);
        $this->pdf->Cell(2, 10, 'PEMERINTAH PROVINSI SUMATERA BARAT', 0, 1, 'C');
        $this->pdf->Cell(123);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(45, 1, $identitas, 0, 1, 'C');
        $this->pdf->Cell(123);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(45, 10, $deskripsi, 0, 1, 'C');
        $this->pdf->SetLineWidth(1);

        $this->pdf->Line(5, 26, 292, 26); //5,26,292,26
        $this->pdf->SetLineWidth(0);
        $this->pdf->Line(5, 27, 292, 27); //5,27,292,27
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

    protected $extgstates = array();

    // alpha: real value from 0 (transparent) to 1 (opaque)
    // bm:    blend mode, one of the following:
    //          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
    //          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
    function SetAlpha($alpha, $bm = 'Normal')
    {
        // set alpha for stroking (CA) and non-stroking (ca) operations
        $gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
        $this->SetExtGState($gs);
    }

    function AddExtGState($parms)
    {
        $n = count($this->extgstates) + 1;
        $this->extgstates[$n]['parms'] = $parms;
        return $n;
    }

    function SetExtGState($gs)
    {
        $this->_out(sprintf('/GS%d gs', $gs));
    }

    function _enddoc()
    {
        if (!empty($this->extgstates) && $this->PDFVersion < '1.4')
            $this->PDFVersion = '1.4';
        parent::_enddoc();
    }

    function _putextgstates()
    {
        for ($i = 1; $i <= count($this->extgstates); $i++) {
            $this->_newobj();
            $this->extgstates[$i]['n'] = $this->n;
            $this->_put('<</Type /ExtGState');
            $parms = $this->extgstates[$i]['parms'];
            $this->_put(sprintf('/ca %.3F', $parms['ca']));
            $this->_put(sprintf('/CA %.3F', $parms['CA']));
            $this->_put('/BM ' . $parms['BM']);
            $this->_put('>>');
            $this->_put('endobj');
        }
    }

    function _putresourcedict()
    {
        parent::_putresourcedict();
        $this->_put('/ExtGState <<');
        foreach ($this->extgstates as $k => $extgstate)
            $this->_put('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
        $this->_put('>>');
    }

    function _putresources()
    {
        $this->_putextgstates();
        parent::_putresources();
    }
}
