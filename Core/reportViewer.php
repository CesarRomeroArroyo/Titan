<?php @session_start(); 
require_once 'includes/classes/pdfClass.php';
    
    ob_start();    
    include('reportes/'.$_GET['report'].'.php');
    $html = ob_get_clean();

     $pdf= new pdfClass();
     $pdf->createReport($html);
?>