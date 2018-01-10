<style type="text/css"> 
    table
    { 
       
        font-family : Arial, Verdana, Helvetica, sans-serif; 
        font-size : 12px;  
    } 
    .tdInicial{
        border-top-left-radius: 6px
    }
    .tdFinal{
        border-top-right-radius: 6px
    }
    .tdInicialAbajo{
        border-bottom-left-radius: 6px
    }
    .tdFinalAbajo{
        border-bottom-right-radius: 6px
    }
    .tdNormal
    {
        border-radius: 0px 0px 0px 0px
    }
    .tableborder
    {
        border-radius: 5px 5px 5px 5px
    }
    
    .texto-vertical-2 {
        rotate: 90;
        font-size: 9px;          
        position: absolute; 
        left:-10px;
        top:280px;
        font-weight: bold;
    }
    .ajustar{
        width: 300px;
        float: left;
        white-space: pre; /* CSS 2.0 */
        white-space: pre-wrap; /* CSS 2.1 */
        white-space: pre-line; /* CSS 3.0 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        white-space: -moz-pre-wrap; /* Mozilla */
        white-space: -hp-pre-wrap; /* HP */
        word-wrap: break-word; /* IE 5+ */
    }
    tbody {
        display:block;
        height:500px;
    }
</style> 
<?php require_once 'includes/includes.php'; 
$sql="SELECT * FROM general_enterprises";
$empresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM invoice_head WHERE id >=15";
$fac = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

for($k=0; $k<count($fac);$k++)
{

$sql="SELECT * FROM invoice_head WHERE idunico='".$fac[$k]["idunico"]."'";   
$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
$sql="SELECT * FROM general_tip_doc WHERE prefijo='FV'";
$resolucion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));    
$sql="SELECT * FROM invoice_details WHERE idunico='".$fac[$k]["idunico"]."'";   
$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
$sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idcliente"]."'";
$cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

?>
<page orientation="portrait" backtop="62mm" backbottom="5mm" backleft="1mm" backright="5mm" format="LETTER" > 

       <page_header>
        <table >
            <tr>
                
                <td style="text-align: center; width: 500"><label style="font-size:22px">MARJORIE MONTOYA BAENA</label><br/> 
                LIBRERIA Y PAPELERIA LA MODERNA <br> NIT. <?php echo $empresa[0]["num_ide"] ?> <br>
                <b><label style="font-size: 10px">Tel: <?php echo $empresa[0]["tel_uno"] ?>, Fax: <?php echo $empresa[0]["fax"] ?><br/> <?php echo $empresa[0]["dir"] ?>, BARRIO <?php echo $empresa[0]["bar"] ?> <br/>Sincelejo - Sucre</label></b></td>
                <td style="text-align: center; width: 200">
                <table class="tableborder" style="border: 1px solid black; padding-left: 10px;font-weight: bold; ">
                    <tr>
                        <td style="width: 190px"><label style="font-size: 18px; ">FACTURA DE VENTA</label></td>
                    </tr>
                    <tr>
                        <td style="width: 190px"><label style="font-size: 18px; ">CR-<?php echo $cabecera[0]["numfactura"]?></label></td>
                    </tr>
                </table>
                 <br>
    <b>FACTURA Y NUMERACION SISTEMATIZADA  HABILITACION DIAN No.  230000024633
FECHA 2015/09/16 DESDE CR-005155  HASTA CR0045000</b>
                </td>
            </tr>
       </table>
   

    
        <table class="tableborder" style="width: 700px; border: 1px solid black; padding-left: 10px;font-weight: bold; ">            
            <tr>
                <td style="width: 350px">Cliente: <?php echo $cliente[0]["nom_rep_leg"]. " ".$cliente[0]["ape_rep_leg"]?></td>
                <td style="width: 350px">Fecha y Hora Expedicion: </td>
            </tr>
            <tr>
                <td style="width: 350px">Raz Social: <?php echo $cliente[0]["raz_soc"]?></td>
                <td style="width: 350px"><?php echo $cabecera[0]["fecha"]?>, <?php echo $cabecera[0]["hora"]?></td>                
            </tr>
            <tr>
                <td style="width: 350px">Nit: <?php echo $cliente[0]["num_ide"]?></td>
                <td style="width: 350px">SINCELEJO SUCRE</td>
            </tr>
            <tr>
                <td style="width: 350px">Direccion: <?php echo $cliente[0]["dir_sede_pri"]?></td>
                <td style="width: 350px">Vendedor: <?php echo $cabecera[0]["vendedor"]?></td>
            </tr>
            <tr>
                <td style="width: 350px">Telefono: <?php echo $cliente[0]["tel_1_sede_pri"]?></td>
                <td style="width: 350px">Condiciones: <?php echo $cliente[0]["condicion_pago"]?> Dias</td>
            </tr>
        </table>
       
</page_header> 
    

        <br/>

       <table border="1" cellspacing="0" style="width: 700px;  border-collapse:collapse">
                
                <tbody>
                <tr style="text-align: center;">
                    <td class="tdInicial"  style="width: 100px;">CODIGO</td>
                    <td class="tdNormal" style="width: 200px">DESCRIPCION</td>
                    <td class="tdNormal"  style="width: 50px;">CANT.</td>
                    <!-- <td class="tdNormal"  style="width: 40px;">DESC.</td> -->
                    <td class="tdNormal"  style="width: 50px;">IMP%.</td>
                    <td class="tdNormal" style="width: 60px">VR.UNI.</td>
                    <td class="tdFinal" style="width: 80px;">TOTAL</td>
                </tr>
                    <?php 
                    $totCant= 0;
                    $totBase =0;
                    $totIVA =0;
                    for ($i=0; $i < count($detalles); $i++) { 
                    
                        $sql="SELECT * FROM general_products_services WHERE id=".$detalles[$i]["idProducto"];
                        $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                        $sql="SELECT * FROM general_price_list_products WHERE producto ='".$prod[0]["id"]."' AND idalmacen='".$cabecera[0]["bodega"]."'";
                        $pre=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        
                        $ivacal= 1+($detalles[$i]["iva"]/100);
                        $base= $detalles[$i]["vtotal"]/$ivacal;
                        $totBase +=$base;
                        $impu = $detalles[$i]["vtotal"]-$base;
                        $totIVA +=$impu;
                    ?>
                        
                    
                    <tr>
                        <td style="border:none"><?php echo $prod[0]["codigo_barras"] ?></td>
                        <td style="border:none;overflow: hidden;width: 330px"><?php echo $prod[0]["nombre"]?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["cantidad"]) ?></td>
                        <!-- <td style="border:none; text-align: right;"><?php //echo number_format($detalles[$i]["desc1"]) ?></td> -->
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["iva"]) ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["pneto"])  ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["vtotal"]);  ?></td>
                    </tr>
                    <?php
                        $desc += ($pre[0]["precio_venta_iva"]*(1+($detalles[$i]["incremento"]/100))*$detalles[$i]["cantidad"])-($detalles[$i]["vtotal"]);
                     } ?>
                    <tr>
                        <td style="border:none;" colspan="7"><hr/></td>
                    </tr>
                </tbody>
        </table>
        <table border="1" style="vertical-align: text-top; width: 700px;font-weight: bold; border-collapse: collapse" cellspacing="10">
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 30px">
                    La presente factura para todos sus efectos legales se asimila
                    a una letra de cambio (Art. 772,773,774 y 775 del C.C).
                    Causará intereses del 4% mensual sin perjuicio de las acciones.
                </td>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 330px; height: 30px; text-align: right;">
                    <b>MONTO BASE: </b> <?php echo number_format($totBase); ?><br/>
                    <b>VAL.IMP:</b> <?php echo number_format($totIVA); ?><br/>

                </td>               
            </tr>
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 3px">
                    <b>OBSERVACIONES:</b>  
                    <?php echo $cabecera[0]["referencia"] ?>
                    <?php if($desc>100){
                        echo "<BR/>Descuento en esta Factura: $".number_format($desc);
                    } ?>
                </td>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 330px; height: 3px; text-align: right; font-size: 16px">
                    <b>TOTAL: </b> <?php echo number_format($cabecera[0]["totaltotales"]); ?><br/>
                    

                </td>               
            </tr>
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" colspan="2" style="padding: 10px;width: 650px; height: 3px">
                    <b>SON:</b>
                    <?php 
                        $V=new EnLetras(); 
                        $con_letra=strtoupper($V->ValorEnLetras($cabecera[0]["totaltotales"],"pesos"));
                        echo $con_letra;?>
                </td>
                            
            </tr>
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 3px">
                    <b>EMPRESA:</b>  <br/>
                    Firma.<br/>
                    Sello.
                </td>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 330px; height: 3px;">
                    <b>CLIENTE:</b>  <br/>
                    Firma.<br/>
                    Sello.
                </td>               
            </tr>
        </table>
        <div style="width: 700px;font-weight: bold; text-align: center; ">
            - ORIGINAL -
        </div>
</page>

<?php } ?>