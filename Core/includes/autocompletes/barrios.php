<?php require_once '../classes/consultaClass.php';
    $cie[0]='cod_sec';
    $cie[1]='nom_sec';
    $donde="nom_sec LIKE '%" . $_GET['term']. "%'";

    $SQL= consulta::seleccionar($cie, 'sectores', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['cod_sec'].'|'.str_replace("\"", "", $retorno[$i]['nom_sec']).'","label":"'.$retorno[$i]['cod_sec'].'|'.str_replace("\"", "", $retorno[$i]['nom_sec']).'","value":"'.$retorno[$i]['cod_sec'].'|'.str_replace("\"", "", $retorno[$i]['nom_sec']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>
