<?php require_once '../classes/consultaClass.php';
    $ocu[0]='cod_ocu';
    $ocu[1]='nom_ocu';
    $donde="nom_ocu LIKE '%" . $_GET['term']. "%'";

    $SQL= consulta::seleccionar($ocu, 'ocupaciones', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['cod_ocu'].'|'.str_replace("\"", "", $retorno[$i]['nom_ocu']).'","label":"'.$retorno[$i]['cod_ocu'].'|'.str_replace("\"", "", $retorno[$i]['nom_ocu']).'","value":"'.$retorno[$i]['cod_ocu'].'|'.str_replace("\"", "", $retorno[$i]['nom_ocu']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>