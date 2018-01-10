<?php
require_once 'formBuilderClass.php';

for($j=1;$j<=$_POST["iterador"];$j++)            
{
    $array[$j]["variable"]=$_POST["variable_".$j];
    $array[$j]["seccion"]=$_POST["seccion_".$j];
    $array[$j]["titulosec"]=$_POST["titulosec_".$j];                                
    $array[$j]["titulo"]=$_POST["titulo_".$j];
    $array[$j]["tipo"]=$_POST["tipo_".$j];
    $array[$j]["valores"]=$_POST["valores_".$j];
    $array[$j]["archivo"]=$_POST["archivo_".$j];  
    $array[$j]["mostrar"]=$_POST["mostrar_".$j];  
}
formBuilder::generar_formulario_preeliminar($array);
//var_dump($array);
?>
