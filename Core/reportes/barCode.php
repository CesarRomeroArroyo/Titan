<?php 
require_once 'includes/includes.php';
?>
<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm" style="font-family:arial;"> 
<table >

    <?php
/*
array(1) { ["datos"]=> array(3) { [0]=> array(3) { ["id"]=> string(1) "1" ["nombre"]=> string(23) "ESFERA AMARILLA 65-2800" ["cantidad"]=> string(1) "6" } [1]=> array(3) { ["id"]=> string(2) "11" ["nombre"]=> string(18) "FRUTA CEREZA 74 13" ["cantidad"]=> string(1) "4" } [2]=> array(3) { ["id"]=> string(1) "8" ["nombre"]=> string(20) "ESFERA VERDE 65-2800" ["cantidad"]=> string(1) "6" } } }
 */

echo "<tr>";
$j=0;
for($k=0; $k<count($_POST["barCodePro"]["datos"]);$k++)
{
    $datos = $_POST["barCodePro"]["datos"][$k];
    
    
    $sql="SELECT * FROM general_products_services WHERE id=".$datos["id"];
    $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
?>


    
    <?php 
    
    
    for($i=0; $i<$datos["cantidad"];$i++)
    {
        if($j==5)
        {
            $j=0;
            echo "</tr><tr>";
        }  
        $j++;  
        
    ?>
        <td>
    &nbsp;&nbsp;&nbsp;
        <barcode type="C93" value="<?php echo $producto[0]["codigo_barras"] ?>" label="label" style="width:35mm; height:25mm; color: #000; font-size: 2mm; bottom: 50px"></barcode>
        <br/><div style="width: 100%; text-align: center"><small><?php echo $producto[0]["nombre"] ?></small></div>
        &nbsp;&nbsp;&nbsp;<br/><br/>
        </td>
        <?php 
        
        
    }
    
} 
echo "</tr>";
?>


    </table>
</page>

