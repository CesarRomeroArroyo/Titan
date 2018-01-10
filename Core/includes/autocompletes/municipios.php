<?php require_once '../classes/consultaClass.php';
 
    $municipio[0]='cod_mun';
    $municipio[1]='nom_mun';
    $donde="nom_mun LIKE '%" . $_GET['term']. "%'";

    $SQL= consulta::seleccionar($municipio, 'general_municipios', $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"id":"'.$retorno[$i]['cod_mun'].'|'.str_replace("\"", "", $retorno[$i]['nom_mun']).'","label":"'.$retorno[$i]['cod_mun'].'|'.str_replace("\"", "", $retorno[$i]['nom_mun']).'","value":"'.$retorno[$i]['cod_mun'].'|'.str_replace("\"", "", $retorno[$i]['nom_mun']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>