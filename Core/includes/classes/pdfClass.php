<?php
require_once 'html2pdf.class.php';
class pdfClass
{
    public static function createReport($html, $nombre="Documento.pdf")
    {
        try
        {
            $html2pdf = new HTML2PDF('P', 'LETTER', 'es');
    //      $html2pdf->setModeDebug();
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($html);
            $html2pdf->Output($nombre);
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
}

?>
