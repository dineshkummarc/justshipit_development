<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/mpdf/vendor/autoload.php');

class Mpdf
{
    function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
		//echo $html;die();
		
		/* $mpdf = new \Mpdf\Mpdf();
		$mpdf->debug = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output(); */
		
		try {
			ob_clean();
			ob_end_clean();
			$mpdf=new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);
			$mpdf = new \Mpdf\Mpdf();
			$mpdf->debug = t;
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		   
		} catch (\Mpdf\MpdfException $e) { 
			echo $e->getMessage();
		}
        
    }
}

?>