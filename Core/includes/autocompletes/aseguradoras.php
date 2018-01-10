<?php require_once '../classes/consultaClass.php';
    $cie= array();
    $cie[0]='cod_ase';
    $cie[1]='nom_ase';
    $donde="nom_ase LIKE '%" . $_GET['term']. "%'";

    $SQL= consulta::seleccionar($cie, 'general_aseguradoras', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['cod_ase'].'|'.str_replace("\"", "", $retorno[$i]['nom_ase']).'","label":"'.$retorno[$i]['cod_ase'].'|'.str_replace("\"", "", $retorno[$i]['nom_ase']).'","value":"'.$retorno[$i]['cod_ase'].'|'.str_replace("\"", "", $retorno[$i]['nom_ase']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
