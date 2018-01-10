<?php
    require_once 'includes/includes.php';    
    $sql="SELECT * FROM shopping_suppliers_bills";   
    $fac = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
for ($k=0; $k < count($fac); $k++) 
{ 
    

    $sql="SELECT * FROM shopping_suppliers_bills WHERE idunico='".$fac[$k]["idunico"]."'";   
    $cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM shopping_suppliers_bills_details WHERE idunico='".$fac[$k]["idunico"]."'";   
    $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    $sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idproveedor"]."'";
    $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM general_params where grupo ='term_pago' AND value='".$cliente[0]["condicion_pago"]."'";
    $termPago = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $cantTotal=0; // total items
    $subtotal = 0; //sumatoria de netos
    $descuentoTotal = 0; // descuento total
    $totalTotales = 0; // sumatoria totales
    $ivaTotal = 0;
    for($i=0;$i<count($detalles);$i++)
    {

        $cantTotal = $cantTotal+$detalles[$i]['cantidad'];
        $totalTotales += $detalles[$i]['preciototal'];
        $subtotal += $detalles[$i]['base'] * $detalles[$i]['cantidad'];
        $cantTotal = $cantTotal + $detalles[$i]['cantidad'];
        $ivaTotal += (($detalles[$i]['preciototal'] / $detalles[$i]['cantidad']) - $detalles[$i]['base']) * $detalles[$i]['cantidad'];
        $descuentoTotal += ($detalles[$i]['precio_uni'] * $detalles[$i]['cantidad'])*(1 + ($detalles[$i]['iva']/100)) - $detalles[$i]['preciototal'];
    }
?>
<page backtop="45mm" backbottom="5mm" backleft="1mm" backright="5mm" format="letter" > 

<page_header>
        <table border='0' style="font-size: 7pt;width: 100px">
            <tr>
                <td style="width: 370px; height: 100px; text-align: center"><img src="images/mustralogo2.png" style="width: 100px; height: 100px ;" alt=""/></td>
                <td rowspan="3" style="text-align: center; font-size: 13px; width: 200px; height: 120px"><?php echo $empresa[0]["dir"] ?><BR/> TELEFONO <?php echo $empresa[0]["tel_uno"] ?> - <?php echo $empresa[0]["tel_uno"] ?><BR/>SINCELEJO - SUCRE<BR/><?php echo $regimen ?></td>
                <td rowspan="3" style="text-align: center; font-size: 14px;   width: 150px; height: 120px"><b>FACTURA COMPRA RECIBIDA</b><BR/>No <b><?php echo $cabecera[0]["id"] ?></b></td>
            
            </tr>
            <tr align='center'>
                <td style="text-align: center; font-size: 13px;width: 370px;"><?php 
                echo $empresa[0]["razon_social"];
                ?></td>                                
            </tr>
            <tr align='center'>
                <td style="text-align: center; font-size: 13px;"><?php 
                echo "NIT ".$empresa[0]["num_ide"];
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
    <table style="font-size: 9pt; width:900px;">
        <tr>          
            <td style='width: 600px;text-align: center'><b>DESCRIPCION</b></td>  
            <td style='width: 40px;text-align: right;'><b>CANT</b></td>
            <td style='width: 100px;text-align: right;'><b>TOTAL</b></td>
        </tr>
    <?php 
    $totC=0;
    $totP=0;
    for($i=0;$i<count($detalles);$i++)
    {
        $datospro[0]="*";
        $sql="SELECT * FROM general_products_services WHERE id='".$detalles[$i]['id_producto']."'";
        $product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql)); 
        $totC= $totC + $detalles[$i]['cantidad'];
        $totP= $totP + $detalles[$i]['preciototal'];
    ?>
        <tr>
            <td><?php echo $product[0]["nombre"] ?></td>                                
            <td style="text-align: right;"><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>            
            <td style="text-align: right;"><?php echo number_format($detalles[$i]['preciototal'],0) ?></td>
        </tr>
    <?php    
        }
    ?>
        <tr>
            <td colspan="3"><hr></td>
        </tr>
        <tfoot>
            <tr>
                <td>TOTALES: </td>
                <td  style="text-align: right;"><?php echo $totC; ?></td>
                <td  style="text-align: right;"><?php echo number_format($totP); ?></td>            
            </tr>
        </tfoot>
    </table>
</div>
</page>     
<?php } ?>