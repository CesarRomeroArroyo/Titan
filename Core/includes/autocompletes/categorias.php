<?php @session_start();
require_once '../classes/consultaClass.php';
 
    $municipio[0]='id';
    $municipio[1]='nombre';
    $donde="nombre LIKE '%" . $_GET['term']. "%' and idcaja='".$_SESSION['datos_usuario']['caja']."' and idalmacen='".$_SESSION['datos_usuario']['almacen']."'";

    $SQL= consulta::seleccionar($municipio, 'general_category', $donde);
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