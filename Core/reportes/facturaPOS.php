<page backtop="0mm" backbottom="0mm" backleft="0mm" backright="0mm" style="font-family:arial; font-size:7pt;" format="75x297" > 
<?php require_once 'includes/includes.php'; 

?>

<?php        
    $sql="SELECT * FROM general_enterprises";
    $empresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    $sql="SELECT * FROM invoice_head_pos WHERE idunico='".$_GET["idunico"]."'";
    $cabecera= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    $sql="SELECT *, (SELECT nombre from general_products_services gps WHERE gps.idunico=idProducto ) as producto FROM invoice_details_pos WHERE idunico='".$_GET["idunico"]."'";
    $cuerpo= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    $sql="SELECT * FROM invoice_payment_form_pos WHERE idinvoice='".$_GET["idunico"]."'";
    $pago= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));   
    $sql="SELECT * FROM general_tip_doc WHERE prefijo='FP'";
    $resolucion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));    
    $sql="SELECT * FROM general_third WHERE id='".$cabecera[0]["idcliente"]."'"; 
    $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));    
?>
<div style="width:50px; font-size:7pt;" >
    <table  border='0' align='center' style="font-size:7pt;" >
    <tr align="center">
        <td colspan="5">
            <?php echo "<b>".$empresa[0]['razon_social']."</b><br />".$empresa[0]['tip_ide']." ".$empresa[0]['num_ide'];?>
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "Direccion:". $empresa[0]['dir'];?>
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "Telefono:". $empresa[0]['tel_uno']?>
        </td>        
    </tr>
        
    <tr align="center">
        <td colspan="5">
            <?php echo $resolucion[0]["notas"];?>
        </td>        
    </tr>
    
    <tr align="center">
        <td colspan="5">
            <?php 
            
            
                echo "Factura de Venta #: ".$cabecera[0]["numfactura"]." Fecha:".Utils::formato_fecha_sql_a_normal( $cabecera[0]["fecha"]);
            
            
            ?>
        </td>        
    </tr>    
    <tr align="center">
        <td colspan="5">
            <?php echo "Vend.: ";?>
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "--------------------------------------------------";?>
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php                         
                echo "Cliente: ".strtoupper($cliente[0]["raz_soc"])."<br/>";
                echo "NIT: ".$cliente[0]["num_ide"]."<br/>";
                echo "Telef.: ".$cliente[0]["tel_1_sede_pri"]."<br/>";
                echo "Direccion: ".$cliente[0]["dir_sede_pri"]."<br/>";
            ?>            
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "--------------------------------------------------";?>
        </td>        
    </tr>
    <tr  align="center">
        <td style="width: 50px">Producto</td>
        <td>ValUni</td>             
        <td>Cant</td>             
        <td>Total</td>
    </tr>
    <?php
    $TotalFac=0;
    $totalDescuento =0;
    for($i=0;$i<=count($cuerpo)-1;$i++)
    {
        $totalDescuento = $totalDescuento+$cuerpo[$i]["valdesc"];
    ?>
    <tr align="center">        
        <td align="left"><div style="width:70px; font-size: 8px;" ><?php 
         
        echo 
	strtoupper($cuerpo[$i]['producto']);
         ?></div></td>
        <td style="font-size: 8px">
          <?php 


          echo   number_format(($cuerpo[$i]['vtotal']/$cuerpo[$i]['cantidad']),0)?>
        </td>   
        <td style="font-size: 8px">
          <?php echo   $cuerpo[$i]['cantidad']?>
        </td>        
            
        <td align="left" style="font-size: 8px"><?php echo number_format($cuerpo[$i]['vtotal'],0);?></td>
    </tr>
    <?php 
    
    }
    ?>
    
    <tr>
        
        <td><b>Cantidad:</b><label style="font-size: 13px"><?php echo $cabecera[0]["totalcantidad"];?></label></td>
        <td colspan="2"><b>Total Parcial:</b><label style="font-size: 13px"><?php echo number_format($cabecera[0]["totaltotales"],0);?></label></td>
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "--------------------------------------------------";?>
        </td>        
    </tr>
    <tr>    
        
        <td ><b>Total Venta</b></td>
        <td ><b><label style="font-size: 15px"><?php echo  number_format($cabecera[0]["totaltotales"],0);?></label></b></td>
    </tr>
    <tr align="center">
        <td colspan="5">
            <?php echo "--------------------------------------------------<br />";?>
        </td>        
    </tr>
    <tr align="center">
        <td style="font-size: 11px"><b>Pago</b></td>     
        <td colspan="2" style="font-size: 13px"><b>Vueltas</b></td>     
    </tr>
    <tr align="center">
        <td  style="font-size: 11px"><?php echo number_format($cabecera[0]["pago"],0);  ?></td> 
        <td colspan="2"  style="font-size: 13px"><?php echo number_format($cabecera[0]["vueltas"],0);  ?></td>     
    </tr>
    <tr align="center">
        <td colspan="5" >
            <?php echo "--------------------------------------------------<br />";?>
        </td>        
    </tr>
    <tr align="center">
        <td colspan="5"><b>Formas de Pago</b></td>     
    </tr>
<!--    <tr align="center">
        <td colspan="2"><b>Tipo</b></td>
        <td colspan="3"><b>Valor</b></td>
    </tr>-->
    <?php
    for($i=0;$i<=count($pago)-1;$i++)
    {
    ?>
    <tr align="center">
        <td><?php echo $pago[$i]['forma_pago'];?></td>
        <td colspan="2" style="font-size: 13px"><?php echo number_format($pago[$i]['pago'],0);?></td>
    </tr>
    <?php     
    }
     
    if($empresa[0]['tip_cont']!="RS")
    {
    ?>
 <tr align="center">
        <td colspan="5">
            <?php echo "--------------------------------------------------<br />";?>
        </td>        
    </tr>  
    
    <tr align="center">
        <td colspan="5">
            <b>Impuestos</b>
        </td>        
    </tr>    
    <tr align="center">        
        <td><b>Impuesto</b></td>
        <td><b>Base</b></td>
        <td><b>Valor</b></td>
    </tr>
          
        <?php 
        $sql="SELECT (SELECT nom_impu FROM general_tax WHERE porc_impu=iva) as nomiva, SUM(valiva) as valiva, SUM(pneto) as neto FROM invoice_details_pos WHERE idunico='".$_GET["idunico"]."' GROUP BY iva";
        $tax=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
        for($t=0;$t<=count($tax)-1;$t++)
        {     
                    
            if($tax[$t]['nomiva']!="EXCENTO")
            {            
        ?>
        <tr align="center">  
            <td><?php echo strtoupper($tax[$t]['nomiva']); ?></td>
            <td style="font-size: 13px">
                <?php                        
                echo number_format($tax[$t]["neto"], 0);                                    
                ?>
            </td>
            <td style="font-size: 13px">
                <?php 
                   echo number_format($tax[$t]['valiva'], 0);      
                ?>
            </td>
        </tr> 
        <?php } 
    }
}

if($totalDescuento>0)
{?>
<tr align="center">
    <td colspan="5">
        <b>Descuento en esta Venta <?php echo $cuerpo[0]["desc1"] ?>%</b>
    </td>        
</tr> 
<tr align="center">
    <td colspan="5">
        <b><?php echo "$ ". number_format($totalDescuento) ?></b>
    </td>        
</tr>
<?php
}
    ?>
    
   
    <tr align="center">
        <td colspan="5">            
            <?php 
            echo "--------------------------------------------------<br />";

            if($empresa[0]["tip_cont"]=="RS")
            {
                echo "REGIMEN SIMPLIFICADO - ";
            }
            else
            {
                echo "IVA REGIMEN COMUN - ";
            }
            if($empresa[0]["auto_retenedor"]==2)
            {
                echo "NO SOMOS AGENTES RETENEDORES";
            }
            else
            {
                echo "SOMOS AGENTES RETENEDORES";
            }
            echo "<BR/>*NO SE HACE DEVOLUCION DE DINERO*<BR/>";
            echo "CAMBIOS ANTES DE 25 DIAS";
            echo "<br/><br/><b>GRACIAS POR SU COMPRA</b>.<br />";?>
        </td>        
    </tr>    
</table>
    
</div>
</page>