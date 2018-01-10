<?php require_once '../classes/consultaClass.php';
    $datos[0]="codigo as cod_cie";
    $datos[1]="nombre as nom_cie";
    $donde="nombre LIKE '%".$_GET['term']."%' ORDER BY nombre";
    $sql = consulta::seleccionar($datos, "general_cups",$donde);
    $consulta = consulta::ejecutar_consulta($sql);

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
