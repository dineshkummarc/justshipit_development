<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf2/autoload.php');

class Pdf
{
    function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
        $dompdf = new Dompdf\Dompdf();
       
        $dompdf->set_paper($paper, $orientation);
		$dompdf->set_option('isHtml5ParserEnabled', TRUE);
		$dompdf->set_option('isRemoteEnabled', TRUE);
		$dompdf->set_option('isPhpEnabled', TRUE);
		$dompdf->set_option('debugCss', TRUE);
		$dompdf->load_html($html);
		$dompdf->render();
        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }
}

?>