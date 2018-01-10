<?php
    require_once 'includes/includes.php';    
    
    $sql="SELECT * FROM financial_receipt_exit WHERE idunico='".$_GET["id"]."'";   
    $cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["idtercero"]."'";
    $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
?>
<page backtop="45mm" backbottom="60mm" backleft="1mm" backright="5mm" format="letter" > 
    <page_header>
        <table border='0' style="font-size: 7pt;width: 100px">
            <tr>
                <td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
                <td style="text-align: center; font-size: 13px; width: 300px; height: 120px">CALLE 15# 11 88 AV. SAN CARLOS<BR/> TELEFONO 2769068 - 2746796<BR/>SINCELEJO - SUCRE<BR/>REGIMEN SIMPLIFICADO</td>
                <td style="text-align: center; font-size: 13px;   width: 150px; height: 120px">COMPROBANTE DE EGRESO</td>
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
    <br>
    <div style="width: 2000px">
        <table style=" width:100%;">
            <tr>
                <td>
                    <table style="font-size: 10pt;">
                        <tr>
                            <td style="padding-right: 10px;"><b>RAZON SOCIAL: </b></td>
                            <td style="padding-right: 10px;"><?php echo $cliente[0]["raz_soc"]?></td>
                            <!-- <td style="padding-right: 10px;"><b>DOC. REF.</b></td>
                            <td style="padding-right: 10px;"><?php echo $cabecera[0]['docref'] ?></td> -->
                        </tr>
                        <tr>
                            <td style="padding-right: 10px;"><b>PROPIETARIO:</b></td>
                            <td style="padding-right: 10px;"><?php echo $cliente[0]["ape_rep_leg"]?> <?php echo $cliente[0]["nom_rep_leg"]?></td>
                            <!-- <td style="padding-right: 10px;"><b>VALOR: </b></td>
                            <td style="padding-right: 10px;"><?php echo "$".number_format($cabecera[0]['valor'], 0); ?></td> -->
                        </tr>
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>DIRECCION: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php echo $cliente[0]["dir_sede_pri"]?></td>
                            <td style="padding-right: 10px;"><b>FECHA:</b></td>
                            <td style="padding-right: 10px;"><?php echo $cabecera[0]['fecha'] ?>&nbsp;</td>
                        </tr>                 
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>CIUDAD: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php  ?>&nbsp;</td>
                            <td style="padding-right: 10px;"><b>ELABORADO:</b></td>
                            <td style="padding-right: 10px;"><?php echo $_POST['datos_usuario']['Nombre']?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>NIT: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php echo $cliente[0]['num_ide'] ?></td>
                        </tr>                    
                    </table>        
                </td>            
            </tr>
        </table>
        <br/>
        <br/>
        <table style="font-size: 9pt;width:100%;">
                <tr>
                    <td style="padding-rigth:5px; width: 90px;"><b>TIPO</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>NUMERO</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>FECHA</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>VALOR</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>DESCUENTO</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>RETENCION</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>FECHA CRUCE</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>DOC. REF.</b></td>
                </tr>
                <tr>
                    <td>TIPO</td>
                    <td>NUMERO</td>
                    <td>FECHA</td>
                    <td>VALOR</td>
                    <td>DESCUENTO</td>
                    <td>RETENCION</td>
                    <td>FECHA CRUCE</td>
                    <td>123456789</td>
                </tr>
                <tr>
                    <td>TIPO</td>
                    <td>NUMERO</td>
                    <td>FECHA</td>
                    <td>VALOR</td>
                    <td>DESCUENTO</td>
                    <td>RETENCION</td>
                    <td>FECHA CRUCE</td>
                    <td>123456789</td>
                </tr>
        </table>
        <br><br>
        <table style="font-size: 9pt;width:760px">
            <tr style="width: 100%">
                <td style="width: 100%;background: #ccc;padding:5px;">FORMA DE PAGO</td>
            </tr>
            <tr style="width: 100%">
                <td>
                    <table style="width: 100%">
                        <tr style="width: 100%">
                            <td style="width: 25%;"><b>Forma</b></td>
                            <td style="width: 25%;"><b>Banco</b></td>
                            <td style="width: 25%;"><b>#Cheque</b></td>
                            <td style="width: 25%;"><b>Valor</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table style="font-size: 9pt;width:760px">
            <tr style="width: 100%;">
                <td style="width: 100%;"><b>Notas</b></td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 100%;padding: 8px; border: 1px solid #999;">&nbsp;</td>
            </tr>
        </table>
    </div>
</page>     