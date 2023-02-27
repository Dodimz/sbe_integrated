<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/FPDF/fpdf.php';
class Format_realisasi extends FPDF
{
    public $pdf;
    function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->pdf = $this;
    }

    function Header()
    {
        global $id_instansi;
        global $kategori;
        global $bulan;

        switch ($kategori) {
            case 'akumulasi':
                $judul = 'Laporan realisasi sampai dengan ' . bulan_global($bulan);
                break;
            case 'per_bulan':
                $judul = 'Laporan realisasi bulan ' . bulan_global($bulan);
                break;
        }

        $CI = &get_instance();
        $identitas = $CI->db->query("SELECT nama_instansi FROM master_instansi WHERE id_instansi={$id_instansi}")->row()->nama_instansi;
        $deskripsi = "Tahun Anggaran " . tahun_anggaran();
        $this->pdf->Image('./assets/sbe/image/logo.png', 5, 4, 18, 20);
        $this->pdf->Cell(161);
        $this->pdf->SetFont('Arial', 'B', 15);
        $this->pdf->Cell(45, 10, 'PEMERINTAH PROVINSI SUMATERA BARAT', 0, 1, 'C');
        $this->pdf->Cell(161);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(45, 1, $identitas, 0, 1, 'C');
        $this->pdf->Cell(161);
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->Cell(45, 10, $deskripsi, 0, 1, 'C');
        $this->pdf->SetLineWidth(1);

        $this->pdf->Line(5, 26, 350, 26); //5,26,292,26
        $this->pdf->SetLineWidth(0);
        $this->pdf->Line(5, 27, 350, 27); //5,27,292,27
        $this->pdf->Ln(5);

        $this->pdf->Cell(161);
        $this->pdf->SetFontSize(8);
        $this->pdf->SetFont('Arial', '', 'L');
        $this->pdf->Cell(45, 5, $judul, 0, 1, 'C');
        $this->pdf->Cell(10, 6, '', 0, 1);

        $this->pdf->SetFont('Arial', 'B', 'L');
        $this->pdf->SetFontSize(6);

        $this->pdf->cell(10, 15, 'NO', 1, 0);
        $this->pdf->cell(163, 15, 'Program, Kegiatan, dan Sub Kegiatan', 1, 0, 'C');
        $this->pdf->cell(18, 15, 'Pagu (Rp)', 1, 0, 'C');
        $this->pdf->cell(90, 10, 'Sumber Dana (Rp)', 1, 0, 'C');
        $this->pdf->cell(16, 10, 'Target (%)', 1, 0, 'C');
        $this->pdf->cell(34, 5, 'Realisasi', 1, 0, 'C');
        $this->pdf->cell(16, 10, 'Deviasi (%)', 1, 0, 'C');
        $this->pdf->cell(0, 5, '', 0, 1);
        $this->pdf->cell(297, 15, '', 0, 0);
        $this->pdf->cell(26, 5, 'Keuangan', 1, 0, 'C');
        $this->pdf->cell(8, 10, 'Fisik', 1, 0, 'C');
        

        $this->pdf->Cell(10, 5, '', 0, 1);

        $this->pdf->cell(191, 5, '', 0, 0);
        $this->pdf->cell(18, 5, 'PAD', 1, 0, 'C');
        $this->pdf->cell(18, 5, 'DAU', 1, 0, 'C');
        $this->pdf->cell(18, 5, 'DAK', 1, 0, 'C');
        $this->pdf->cell(18, 5, 'DBH', 1, 0, 'C');
        $this->pdf->cell(18, 5, 'Lainnya', 1, 0, 'C');
        $this->pdf->cell(8, 5, 'Fisik', 1, 0, 'C');
        $this->pdf->cell(8, 5, 'Keu', 1, 0, 'C');
        $this->pdf->cell(18, 5, 'Rp', 1, 0, 'C');
        $this->pdf->cell(8, 5, '%', 1, 0, 'C');
        $this->pdf->cell(8, 5, '( % )', 0, 0, 'C');
        
        $this->pdf->cell(8, 5, 'F', 1, 0, 'C');
        $this->pdf->cell(8, 5, 'K', 1, 0, 'C');
        $this->pdf->Cell(10, 5, '', 0, 1);
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




    function WordWrap(&$text, $maxwidth)
    {
        $text = trim($text);
        if ($text==='')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line)
        {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word)
            {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth)
                {
                    // Word is too long, we cut it
                    for($i=0; $i<strlen($word); $i++)
                    {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if($width + $wordwidth <= $maxwidth)
                        {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        }
                        else
                        {
                            $width = $wordwidth;
                            $text = rtrim($text)."\n".substr($word, $i, 1);
                            $count++;
                        }
                    }
                }
                elseif($width + $wordwidth <= $maxwidth)
                {
                    $width += $wordwidth + $space;
                    $text .= $word.' ';
                }
                else
                {
                    $width = $wordwidth + $space;
                    $text = rtrim($text)."\n".$word.' ';
                    $count++;
                }
            }
            $text = rtrim($text)."\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }
}
