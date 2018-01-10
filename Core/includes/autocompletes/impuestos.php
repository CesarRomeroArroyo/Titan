<?php require_once '../classes/consultaClass.php';
 
    $impuesto[0]='nom_impu';
    $impuesto[1]='id';
    $donde="nom_impu LIKE '%" . $_GET['term']. "%'";
    $SQL= consulta::seleccionar($impuesto, 'general_tax', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['nom_impu'].'|'.str_replace("\"", "", $retorno[$i]['nom_impu']).'","label":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nom_impu']).'","value":"'.$retorno[$i]['id'].'|'.str_replace("\"", "", $retorno[$i]['nom_impu']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    echo $cadena;
?>