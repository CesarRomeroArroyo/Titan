<page backtop="25mm" backbottom="60mm" backleft="10mm" backright="20mm" format="letter" style="font-size:7pt;"> 
<?php
require_once 'includes/includes.php';    
$sql="SELECT * FROM invoice_head WHERE idunico='".$_GET["id"]."'";   
$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
$sql="SELECT * FROM invoice_details WHERE idunico='".$_GET["id"]."'";   
$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));


?>

<page_footer>
        <div style="width: 720px">
    <hr/>    
    </div>
    
    <table>
        <tr>
            <td>
                <table style="font-size: 7pt; width:450px; ">
                    <tr>
                        <?php
                        $V=new EnLetras(); 
                        $con_letra=strtoupper($V->ValorEnLetras($cabecera[0]['totaltotales'],"pesos"));
                        ?>
                        <td style="width: 500px;border: 1px solid #000;">SON: <?php echo $con_letra?></td>                 
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000;">OBSERVACIONES</td>            
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000;">Estimado cliente una vez la factura supere la fecha de vencimiento se cargaran intereses de mora a su saldo segun la tasa <br/>autorizada de la Superintendencia Financiera los cuales se pagaran en el siguiente pago o abono. Art884 y 685 del <br/>Codigo de Comercio Colombiano</td>            
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000;">PASADOS 3 DIAS DE RECIBIDO NO SE ACEPTAN RECLAMOS O DEVOLUCIONES SIN AUTORIZACION</td>            
                    </tr>
                </table>
                
            </td>
            <td>
                 <table style="border: 1px solid #000;font-size: 7pt;">
                    <tr align="right">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>                    
                    <tr align="right">
                        <td style="width: 80px">BRUTO</td>
                        <td style="width: 100px"><?php echo number_format($cabecera[0]['totalneto'],0) ?></td>
                    </tr>                    
<!--                    <tr align="right">
                        <td>IVA</td>
                        <td><?php// echo number_format($cabecera[0]['iva'],0) ?></td>
                    </tr>-->
<!--                    <tr align="right">
                        <td>RETFTE</td>
                        <td><?php //echo number_format($cabecera[0]['retefuente'],0) ?></td>
                    </tr>-->
                    <tr align="right">
                        <td>VALOR TOTAL</td>
                        <td><?php echo number_format($cabecera[0]['totaltotales'],0) ?></td>
                    </tr>
                    <tr align="right">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>                    
                </table>
            </td>
            
        </tr>
            
    </table>
    <table style="font-size: 7pt; width:450px; ">
        <tr align="center">
            <td style="border: 1px solid #000;">Elaboro<br/><br/></td>
            <td style="border: 1px solid #000;">Aprobo<br/><br/></td>
            <td style="border: 1px solid #000;" colspan="3">RECIBI A SATISFACCION LA MERCANCIA RELACIONADA EN ESTA FACTURA</td>
        </tr>
        <tr>
            <td align="center" style="width: 100px;border: 1px solid #000;">Hora<br/><br/></td>            
            <td style="width: 100px;"><br/><br/></td>
            <td style="width: 150px;border: 1px solid #000;">Nombre<br/><br/></td>
            <td style="width: 150px;border: 1px solid #000;">Firma<br/><br/></td>
            <td style="width: 150px;border: 1px solid #000;">Fecha<br/><br/></td>
        </tr>
    </table>  
        <table style="font-size: 6pt; width:450px; ">
            <tr>
                <td>LA PRESENTE FACTURA CAMBIARIA DE COMPRAVENTA SE ASIMILA EN SUS EFECTOS A UNA LETRA DE CAMBIO ART. 774 C. DE C.<br/>
        FAVOR NO REALIZAR PAGOS EN EFECTIVO A NUESTROS REPRESENTANTES DE VENTAS<br/>
        AUTORIZACION NUMERACION POR COMPUTADOR RESOLUCION DIAN N° <?php echo $resolucion[0]["num_resolucion"]?> DE <?php echo Utils::formato_fecha_sql_a_normal($resolucion[0]["fecha_resolucion"])?>  DEL <?php echo $resolucion[0]["conse_inicial"]?>  AL <?php echo $resolucion[0]["conse_final"]?> </td>
            </tr>
        </table>
        
</page_footer>
<page_header>
        <table border='0' style="font-size: 7pt;width: 100px">
            <tr align='center'>
                <td style="width: 300px"><?php 
                echo "DISTRIBUIDORA MAS SALUD";
                ?></td>                                
                <td style="width: 300px"></td>
                <td></td>
            </tr>
            <tr align='center'>
                <td style="width: 300px"><?php 
                echo "123456789 REGIMEN COMUN";
                ?></td>                                
                <td style="width: 300px"></td>
                <td></td>
            </tr>
            <tr align='center'>
                <td>NO SOMOS GRANDES CONTRIBUYENTES NI AGENTES RETENEDORES</td>
                <td style="width: 300px"></td>
                <td><b>Pagina [[page_cu]]/[[page_nb]]</b></td>
            </tr>
            <tr align='center'>
                <td><?php 
                echo  "1231231231 , Barrio: 123123123";
                ?></td>
                <td style="width: 300px"></td>
                <td><b>FACTURA DE VENTA</b></td>
            </tr>
            <tr  align='center'>
                <td><?php 
                echo "Telefonos: 0123123000000000000000000000";
                ?></td>
                <td style="width: 300px"></td>
                <td><b>N° </b></td>                
            </tr>
            <tr  align='center'>
                <td><?php 
                echo "Email: ";
                ?></td>                
            </tr>                       
        </table>
        <hr/>
</page_header>
    
    <br/>
<div style="width: 900px">
    <table style="font-size: 9pt; width:900px;">
        <tr>
            <td>
                <table style="font-size: 9pt; width:450px; border: 1px solid #000;">
                    <tr>
                        <td style='border:hidden; width: 80px'>Cliente</td>
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden; width: 250px'>PRUEBAS</td>
                    </tr>
                    <tr>
                        <td style='border:hidden;width: 80px'>Direccion</td>
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden;width: 250px'>asdasdasdasdasd</td>
                    </tr>
                    <tr>
                        <td style='border:hidden;width: 80px'>NIT</td>
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden;width: 250px'>asdasdasdasdasda</td>
                    </tr>
                </table>        
            </td>
            <td>
                <table style="font-size: 9pt; width:450px; border: 1px solid #000;">
                    <tr>
                        <td style='border:hidden; width: 80px'>Fecha</td>                        
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden; width: 250px'><?php echo date('d/m/Y')?></td>
                    </tr>
                    <tr>
                        <td style='border:hidden; width: 80px'>Vence</td>                        
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden; width: 250px'></td>
                    </tr>
                    <tr>
                        <td style='border:hidden;width: 80px'>VENDEDOR</td>                        
                        <td style='border:hidden;'>:</td>
                        <td style='border:hidden;width: 250px'>asdasdasdasdasd</td>
                    </tr>
                </table>
            </td>
        </tr>            
    </table>
    <table style="font-size: 7pt; width:900px; border: 0px"  >
        <tr align='center'>
            <td style='width: 100px;border: 1px solid #000;'>CODIGO</td>
            <td style='width: 300px;border: 1px solid #000;'>DESCRIPCION</td>            
            <td style='width: 40px;border: 1px solid #000;'>CANT</td>
            <td style='width: 80px;border: 1px solid #000;'>VR. UNITARIO</td>
            <td style='width: 90px;border: 1px solid #000;'>VALOR TOTAL</td>
        </tr>
          
    <?php 
    for($i=0;$i<count($detalles);$i++)
    {
        
        $datospro[0]="*";
        $sql="SELECT * FROM general_products_services WHERE id='".$detalles[$i]['idProducto']."'";
        $product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql)); 
        
        ?>
        <tr align='center'>
            <td style='width: 100px;border: 1px solid #000;'><?php echo $product[0]["codigo"] ?></td>            
            <td style='width: 300px;border: 1px solid #000;'><?php echo $product[0]["nombre"] ?></td>            
            <td style='width: 40px;border: 1px solid #000;'><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
            <td style='width: 80px;border: 1px solid #000;'><?php echo number_format($detalles[$i]['pneto'],0) ?></td>
            <td style='width: 90px;border: 1px solid #000;'><?php echo number_format($detalles[$i]['vtotal'],0) ?></td>
        </tr>
    <?php    
    }
    ?>
    </table>
</div>
</page>     