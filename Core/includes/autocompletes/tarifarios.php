<?php @session_start(); 
    require_once '../classes/consultaClass.php';
    $cie[0]='id';
    $cie[1]='CONCAT(codigo," - ", descripcion) as nombre';
    
    if($_SESSION['donde']=="tarifario='PARTICULAR'")
    {
       $donde="CONCAT(codigo,\" \", descripcion) LIKE '%" . $_GET['term']. "%' AND tipo = '".$_SESSION['tipotarifario']."' AND ".$_SESSION['donde']." AND medico ='".$_SESSION["medico"][0]["id"]."' AND especialidad='".$_SESSION['especialidades'][0]["seleccion"]."'"; 
    }
    else
    {
        $donde="CONCAT(codigo,\" \", descripcion) LIKE '%" . $_GET['term']. "%' AND tipo = '".$_SESSION['tipotarifario']."' AND ".$_SESSION['donde'];
    }
    

    $SQL= consulta::seleccionar($cie, 'general_tarifario', $donde);
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
