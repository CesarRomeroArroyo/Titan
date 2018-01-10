<?php require_once '../classes/consultaClass.php';
    $cie[0]='id';
    $cie[1]='CONCAT(tip_ide,"|",num_ide,"|",pri_nom, " ", seg_nom , " ", pri_ape," ", seg_ape) as nombre';
    $donde='CONCAT(num_ide, " ",pri_nom, " ", seg_nom , " ", pri_ape, " ", seg_ape)'. "LIKE '%". $_GET['term']. "%'";
      
    $SQL= consulta::seleccionar($cie, 'clinical_pacientes', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","label":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","value":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
