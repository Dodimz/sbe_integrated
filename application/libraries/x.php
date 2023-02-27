<?php defined('BASEPATH') OR exit('No direct script access allowed');
// Dompdf namespace use Dompdf\Dompdf;
class x{ 
    public function __construct(){
    require_once APPPATH.'/third_party/dompdf/autoload.inc.php';
    $pdf = new Dompdf(); $CI = & get_instance();
    $CI->dompdf = $pdf; 
} } ?>