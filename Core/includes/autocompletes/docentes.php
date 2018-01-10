<?php require_once '../classes/consultaClass.php';


    
          $cie[0]='num_ide';
          $cie[1]='CONCAT(nombre, " ",apellido)as nombre';
          $donde="tipo='2' AND ".'CONCAT(num_ide, " ",nombre, " ", apellido)'. "LIKE '%". $_GET['term']. "%'";
          $tabla="general_usuarios";
    
  
    
    $SQL= consulta::seleccionar($cie, $tabla, $donde);
    $consulta=consulta::ejecutar_consulta($SQL);
    $retorno = consulta::convertir_a_array($consulta);
    $cadena="[";
    
    for($i=0;$i<=count($retorno)-1;$i++)
    {
        $cadena.= '{"num_ide":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","label":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'","value":"'.$retorno[$i]['num_ide'].'|'.str_replace("\"", "", $retorno[$i]['nombre']).'"}';
        if($i!=count($retorno)-1)
        {
            $cadena.=',';
        }
    }
    $cadena.=']';
    
    echo $cadena;
?>

