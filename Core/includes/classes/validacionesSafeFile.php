<?php require_once 'consultaClass.php'; 
 

$post = consulta::valida_datos_sql('general_validaciones', $_POST);  

$sql="select * from general_validaciones where formulario ='".$post['formulario']."' AND variable='".$post['variable']."' AND validacion='".$post['validacion']."' AND criterio='".$post['criterio']."'";

$consulta=consulta::ejecutar_consulta($sql);
$retorno = consulta::convertir_a_array($consulta);

if(count($retorno)==0)
{
    $sql=consulta::insertar($post, 'general_validaciones');
    $consulta=consulta::ejecutar_consulta($sql);
    echo "Se Guardo la Validacion";
}
else
{
    echo "Ya existe una Validacion para este campo, criterio y validacion";
}
?>
