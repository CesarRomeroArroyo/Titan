<?php require_once '../classes/consultaClass.php';
    $cie[0]='cod_cie';
    $cie[1]='nom_cie';
    $donde="CONCAT(cod_cie,\" \",nom_cie) LIKE '%" . $_GET['term']. "%'";

    $SQL= consulta::seleccionar($cie, 'general_cie10', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['cod_cie'].'|'.str_replace("\"", "", $retorno[$i]['nom_cie']).'","label":"'.$retorno[$i]['cod_cie'].'|'.str_replace("\"", "", $retorno[$i]['nom_cie']).'","value":"'.$retorno[$i]['cod_cie'].'|'.str_replace("\"", "", $retorno[$i]['nom_cie']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
