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

$sql="SELECT * FROM referrals_head WHERE id='".$_GET["id"]."'";   
$cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));  

$sql="SELECT * FROM referrals_details WHERE idunico='".$cabecera[0]["idunico"]."'";   
$detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

$sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idCliente"]."'";
$cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

if($cliente[0]["tipo_factura"]==1)
{
?>
<page orientation="portrait" backtop="5mm" backbottom="5mm" backleft="1mm" backright="2mm" format="LETTER" > 
    
        <table >
            <tr>
                
                <td style="text-align: center; width: 550"><label style="font-size:22px">MARJORIE MONTOYA BAENA</label><br/> 
                LIBRERIA Y PAPELERIA LA MODERNA <br> NIT. <?php echo $empresa[0]["num_ide"] ?> <br>
                <b><label style="font-size: 10px">Tel: <?php echo $empresa[0]["tel_uno"] ?>, Fax: <?php echo $empresa[0]["fax"] ?><br/> <?php echo $empresa[0]["dir"] ?>, BARRIO <?php echo $empresa[0]["bar"] ?> <br/>Sincelejo - Sucre</label></b></td>
                <td style="text-align: center; width: 150">
                <table class="tableborder" style="border: 1px solid black; padding-left: 10px;font-weight: bold; ">
                    <tr>
                        <td style="width: 150px"><label style="font-size: 18px; ">REMISION</label></td>
                    </tr>
                    <tr>
                        <td style="width: 150px"><label style="font-size: 18px; "><?php echo $cabecera[0]["id"]?></label></td>
                    </tr>
                </table>
                 <br>

                </td>
            </tr>
       </table>
   

    
        <table class="tableborder" style="width: 650px; border: 1px solid black; padding-left: 10px;font-weight: bold; ">            
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
    

        <br/>

        <table border="1" cellspacing="0" style="width: 700px;  border-collapse:collapse">
                <thead>
                <tr style="text-align: center;">
                    <td class="tdInicial"  style="width: 150px;">CODIGO</td>
                    <td class="tdNormal" style="width: 220px">DESCRIPCION</td>
                    <td class="tdNormal"  style="width: 70px;">CANT.</td>
                    <td class="tdNormal" style="width: 90px">VR.UNI.</td>
                    <td class="tdFinal" style="width: 90px;">TOTAL</td>
                </tr>
                </thead>

                <tbody>
                    <?php 
                    $totCant= 0;
                    $totNeto =0;
                    $totIVA =0;
                    for ($i=0; $i < count($detalles); $i++) { 
                        $sql="SELECT * FROM general_products_services WHERE id=".$detalles[$i]["idProducto"];
                        $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        $precUni = (int)$detalles[$i]["pneto"]/(1+($detalles[$i]["iva"]/100));
                        $valIva = ($detalles[$i]["pneto"]-$precUni)*$detalles[$i]["cantidad"];
                    ?>
                        
                    
                    <tr>
                        <td style="border:none"><?php echo $prod[0]["codigo_barras"] ?></td>
                        <td style="border:none;overflow: hidden;width: 220px"><?php echo $prod[0]["nombre"] ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["cantidad"],2) ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["pneto"])  ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["vtotal"]);  ?></td>
                    </tr>
                    <?php
                    $iva = ($precUni*($detalles[$i]["iva"]/100))*$detalles[$i]["cantidad"];
                    $totIVA = $totIVA+$valIva;
                    $totCant = $totCant+$detalles[$i]["cantidad"];
                    $totNeto = $totNeto+($detalles[$i]["cantidad"]*$precUni);
                     } ?>
                    <tr>
                        <td style="border:none;" colspan="5"><hr/></td>
                    </tr>

                </tbody>


                
               
                <tfoot>
                    <tr>
                        <th colspan="2" style="font-size: 9px;border:none;"></th>
                        <th style="text-align: right;border:none;"><?php echo number_format($totCant,2); ?></th>
                        <th style="text-align: center;border:none;">SUBTOTAL$</th>
                        <th style="text-align: right;border:none;"><?php echo number_format($cabecera[0]["totaltotales"]-$totIVA,0)?></th>
                    </tr>
                    <tr>
                        <th  style="border:none;" colspan="3">&nbsp;&nbsp;&nbsp;</th>
                        <th style="border:none;">&nbsp;&nbsp;&nbsp;</th>
                        <th style="border:none;">&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                    <tr>
                        <th class="tdInicialAbajo ajustar" colspan="3" style="border:none; vertical-align: text-top; height: 20px">
                        
                        </th>
                        <th class="tdInicial" style="text-align: center; height: 20px">IVA</th>
                        <th class="tdFinal" style="text-align: center; height: 20px"><?php echo number_format($totIVA,0)?></th>
                    </tr>
                    <tr>
                        <th class="tdInicialAbajo ajustar" colspan="3" style="border:none; vertical-align: text-top; height: 20px">No se Aceptan devoluciones despues de 10 dias despachada la mercancia
                        
                        </th>
                        <th class="tdInicialAbajo" style="text-align: center; height: 20px">TOTAL  $</th>
                        <th class="tdFinalAbajo" style="text-align: center; height: 20px"><?php echo number_format($cabecera[0]["totaltotales"],0)?></th>
                    </tr>
                </tfoot>
        </table>



        <table border="1" style="vertical-align: text-top; width: 700px;font-weight: bold; border-collapse: collapse" cellspacing="10">
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 30px">
                    <b>EMPRESA:</b>  <br/>
                    Firma.<br/>
                    Sello.
                </td>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 30px">
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
<?php }
else{
     ?>
<page orientation="portrait" backtop="5mm" backbottom="5mm" backleft="1mm" backright="2mm" format="LETTER" > 
    
        <table >
            <tr>
                
                <td style="text-align: center; width: 550"><label style="font-size:22px">MARJORIE MONTOYA BAENA</label><br/> 
                LIBRERIA Y PAPELERIA LA MODERNA <br> NIT. <?php echo $empresa[0]["num_ide"] ?> <br>
                <b><label style="font-size: 10px">Tel: <?php echo $empresa[0]["tel_uno"] ?>, Fax: <?php echo $empresa[0]["fax"] ?><br/> <?php echo $empresa[0]["dir"] ?>, BARRIO <?php echo $empresa[0]["bar"] ?> <br/>Sincelejo - Sucre</label></b></td>
                <td style="text-align: center; width: 150">
                <table class="tableborder" style="border: 1px solid black; padding-left: 10px;font-weight: bold; ">
                    <tr>
                        <td style="width: 150px"><label style="font-size: 18px; ">REMISION</label></td>
                    </tr>
                    <tr>
                        <td style="width: 150px"><label style="font-size: 18px; "><?php echo $cabecera[0]["id"]?></label></td>
                    </tr>
                </table>
                 <br>

                </td>
            </tr>
       </table>
   

    
        <table class="tableborder" style="width: 650px; border: 1px solid black; padding-left: 10px;font-weight: bold; ">            
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
    

        <br/>

        <table border="1" cellspacing="0" style="width: 700px;  border-collapse:collapse">
                <thead>
                <tr style="text-align: center;">
                    <td class="tdInicial"  style="width: 150px;">CODIGO</td>
                    <td class="tdNormal" style="width: 220px">DESCRIPCION</td>
                    <td class="tdNormal"  style="width: 70px;">CANT.</td>
                    <td class="tdNormal" style="width: 90px">VR.UNI.</td>
                    <td class="tdFinal" style="width: 90px;">TOTAL</td>
                </tr>
                </thead>

                <tbody>
                    <?php 
                    $totCant= 0;
                    $totNeto =0;
                    $totIVA =0;
                    for ($i=0; $i < count($detalles); $i++) { 
                        $sql="SELECT * FROM general_products_services WHERE id=".$detalles[$i]["idProducto"];
                        $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        $precUni = (int)$detalles[$i]["pneto"]/(1+($detalles[$i]["iva"]/100));
                        $valIva = ($detalles[$i]["pneto"]-$precUni)*$detalles[$i]["cantidad"];
                    ?>
                        
                    
                    <tr>
                        <td style="border:none"><?php echo $prod[0]["codigo_barras"] ?></td>
                        <td style="border:none;overflow: hidden;width: 220px"><?php echo $prod[0]["nombre"] ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["cantidad"],2) ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["pneto"])  ?></td>
                        <td style="border:none; text-align: right;"><?php echo number_format($detalles[$i]["vtotal"]);  ?></td>
                    </tr>
                    <?php
                    $iva = ($precUni*($detalles[$i]["iva"]/100))*$detalles[$i]["cantidad"];
                    $totIVA = $totIVA+$valIva;
                    $totCant = $totCant+$detalles[$i]["cantidad"];
                    $totNeto = $totNeto+($detalles[$i]["cantidad"]*$precUni);
                     } ?>
                    <tr>
                        <td style="border:none;" colspan="5"><hr/></td>
                    </tr>

                </tbody>


                
               
                <tfoot>
                    
                    <tr>
                        <th class="tdInicialAbajo ajustar" colspan="3" style="border:none; vertical-align: text-top; height: 20px">No se Aceptan devoluciones despues de 10 dias despachada la mercancia
                        
                        </th>
                        <th class="tdInicialAbajo" style="text-align: center; height: 20px">TOTAL  $</th>
                        <th class="tdFinalAbajo" style="text-align: center; height: 20px"><?php echo number_format($cabecera[0]["totaltotales"],0)?></th>
                    </tr>
                </tfoot>
        </table>



        <table border="1" style="vertical-align: text-top; width: 700px;font-weight: bold; border-collapse: collapse" cellspacing="10">
            <tr>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 30px">
                    <b>EMPRESA:</b>  <br/>
                    Firma.<br/>
                    Sello.
                </td>
                <td class="tdInicial tdInicialAbajo tdFinal tdFinalAbajo" style="padding: 10px;width: 320px; height: 30px">
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