<?php @session_start(); 
    require_once '../classes/consultaClass.php';
    $cie[0]='id';
    $cie[1]='CONCAT(idprocserv," - ", descprocserv) as nombre';
    $donde="descprocserv LIKE '%" . $_GET['term']. "%' AND idcontrato = '".$_SESSION['contratoPac']."'";
    $SQL= consulta::seleccionar($cie, 'general_procserv', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", utf8_encode($retorno[$i]['nombre'])).'","label":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", utf8_encode($retorno[$i]['nombre'])).'","value":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", utf8_encode($retorno[$i]['nombre'])).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
