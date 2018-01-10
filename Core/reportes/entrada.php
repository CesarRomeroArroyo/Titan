<page backtop="45mm" backbottom="60mm" backleft="1mm" backright="5mm" format="letter" > 
<?php
require_once 'includes/includes.php';    
$sql="SELECT * FROM invoice_head WHERE idunico='".$_GET["id"]."'";   
$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM invoice_details WHERE idunico='".$_GET["id"]."'";   
$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
$sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idcliente"]."'";
$cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
?>

<page_footer>
    <table border='0' style="font-size: 11pt;width: 100px; text-align: center">
        <tr>
            <td style="width: 200px;text-align: center"><b>CONDICION</b></td>
            <td style="width: 50px;text-align: center"><b>LINEAS</b></td>
            <td style="width: 50px;text-align: center"><b>ITEMS</b></td>
            <td style="width: 120px;text-align: center"><b>SUBTOTAL</b></td>
            <td style="width: 100px;text-align: center"><b>DESCUENTO</b></td>
            <td style="width: 90px;text-align: center"><b>IVA</b></td>
            <td style="width: 120px;text-align: center"><b>TOTAL</b></td>
        </tr>
        <tr>
            <td style="text-align: center"><?php echo $cliente[0]["condicion_pago"] ?></td>
            <td style="text-align: center"><?php echo count($detalles) ?></td>
            <td style="text-align: center"><?php echo $cabecera[0]["totalcantidad"]?></td>
            <td style="text-align: center"><?php ?></td>
            <td style="text-align: center"><?php echo "$ ".number_format($cabecera[0]["totaldesc"], 0)?></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo "$ ".number_format($cabecera[0]["totaltotales"], 0)?></td>
        </tr>
    </table>
</page_footer>
<page_header>
        <table border='0' style="font-size: 7pt;width: 100px">
            <tr>
                <td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
                <td style="text-align: center; font-size: 13px; width: 300px; height: 120px">CALLE 15# 11 88 AV. SAN CARLOS<BR/> TELEFONO 2769068 - 2746796<BR/>SINCELEJO - SUCRE<BR/>REGIMEN SIMPLIFICADO</td>
                <td style="text-align: center; font-size: 13px;   width: 150px; height: 120px">ENTRADA INVENTARIO<BR/>No <b><?php echo $cabecera[0]["id"] ?></b></td>
            
            </tr>
            <tr align='center'>
                <td style="text-align: center; font-size: 13px;"><?php 
                echo "DISTRIBUIDORA MAS SALUD";
                ?></td>                                
            </tr>
            <tr align='center'>
                <td style="text-align: center; font-size: 13px;"><?php 
                echo "NIT 64.701.076-0";
                ?></td>                                
            </tr>
                                 
        </table>
       
</page_header>
    
<div style="width: 900px">
    <table style=" width:900px;">
        <tr>
            <td>
                <table style="font-size: 11pt;">
                    <tr>
                        <td style='width: 100px'><b>SEÑORES: </b></td>
                        <td style='width: 250px'><?php echo $cliente[0]["raz_soc"]?><br/><?php echo $cliente[0]["ape_rep_leg"]?> <?php echo $cliente[0]["nom_rep_leg"]?></td>
                        <td style='width: 100px'></td>
                        <td style='width: 200px'></td>
                        <td style='width: 100px'></td>
                        <td style='width: 150px'></td>
                       
                    </tr>                    
                    <tr>
                        <td style='width: 100px'><b>DIRECCION: </b></td>
                        <td style='width: 250px'><?php echo $cliente[0]["dir_sede_pri"]?></td>
                        <td style='width: 100px'><b>TELEFONO: </b></td>
                        <td style='width: 200px'><?php echo $cliente[0]["tel_1_sede_pri"]?></td>
                       
                    </tr>                    
                    <tr>
                        <td style='width: 100px'><b>CIUDAD: </b></td>
                        <td style='width: 250px'></td>
                        
                       
                    </tr>                    
                </table>        
            </td>            
        </tr>            
    </table>
    <br/>
    <br/>
    
    <table style="font-size: 9pt; width:900px;"  >
        <tr>          
            <td style='width: 250px;'><b>DESCRIPCION</b></td>            
            <td style='width: 130px;'><b>COMERCIAL</b></td>            
            <td style='width: 100px;'><b>LABORATORIO</b></td>
            <td style='width: 40px;'><b>CANT</b></td>
            <td style='width: 50px;'><b>P.LISTA</b></td>
            <td style='width: 40px;'><b>DTO</b></td>
            <td style='width: 30px;'><b>IVA</b></td>            
            <td style='width: 100px;'><b>TOTAL</b></td>
        </tr>
          
    <?php 
    for($i=0;$i<count($detalles);$i++)
    {
        
        
        $datospro[0]="*";
        $sql="SELECT * FROM general_products_services WHERE id='".$detalles[$i]['idProducto']."'";
        $product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql)); 
        
        ?>
        <tr>
            <td><?php echo $product[0]["nombre"] ?></td>            
            <td><?php echo $product[0]["nombre_comercial"] ?></td>            
            <?php
            
            $sql="SELECT text as nombre FROM general_params WHERE value='".$product[0]["laboratorio"]."' AND grupo='laboratorios'";
            $laboratorio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
            ?>
            <td><?php echo $laboratorio[0]["nombre"] ?></td>            
            <td><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
            <td><?php echo number_format($detalles[$i]['pneto'],0) ?></td>
            <td><?php echo number_format($detalles[$i]['desc1'],0) ?></td>
            <td><?php echo $detalles[$i]['iva'] ?></td>
            <td><?php echo number_format($detalles[$i]['vtotal'],0) ?></td>
        </tr>
    <?php    
    }
    ?>
    </table>
</div>
</page>     