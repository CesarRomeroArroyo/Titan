<?php
    require_once 'includes/includes.php';    
    
    $sql="SELECT * FROM financial_notes WHERE idunico='".$_GET["id"]."'";   
    $cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM general_third WHERE id = '".$cabecera[0]["tercero"]."'";
    $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql = "SELECT nom_mun AS nombre FROM general_municipios WHERE cod_mun = '".$cliente[0]["ciu_cede_pri"]."'";
    $ciudad = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
?>
<page backtop="45mm" backbottom="60mm" backleft="1mm" backright="5mm" format="letter" > 
    <page_header>
        <table border='0' style="font-size: 7pt;width: 100px">
            <tr>
                <td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
                <td style="text-align: center; font-size: 13px; width: 300px; height: 120px">CALLE 15# 11 88 AV. SAN CARLOS<BR/> TELEFONO 2769068 - 2746796<BR/>SINCELEJO - SUCRE<BR/>REGIMEN SIMPLIFICADO</td>
                <td style="text-align: center; font-size: 13px;   width: 150px; height: 120px">NOTA CREDITO <br> N° <?php echo $cabecera[0]['id'] ?></td>
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
                        </tr>
                        <tr>
                            <td style="padding-right: 10px;"><b>PROPIETARIO:</b></td>
                            <td style="padding-right: 10px;"><?php echo $cliente[0]["ape_rep_leg"]?> <?php echo $cliente[0]["nom_rep_leg"]?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>DIRECCION: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php echo $cliente[0]["dir_sede_pri"]?></td>
                        </tr>                 
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>CIUDAD: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php echo $ciudad[0]['nombre'] ?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 10px; width: 100px"><b>NIT: </b></td>
                            <td style="padding-right: 10px; width: 250px"><?php echo $cliente[0]['num_ide'] ?></td>
                        </tr>                    
                    </table>        
                </td>            
            </tr> 
            <tr>
                <td></td>
            </tr>           
        </table>
        <br/>
        <br/>
        <table style="font-size: 9pt;width:900px;">
            <tr>
                <td style="width: 15%;"><b>DOC. REF.</b></td>
                <td style="width: 15%;"><b>SUBTOTAL</b></td>
                <td style="width: 15%;"><b>IVA</b></td>
                <td style="width: 15%;"><b>DESCUENTO</b></td>
                <td style="width: 15%;"><b>RETENCIONES</b></td>
                <td style="width: 15%;"><b>TOTAL</b></td>
            </tr>
            <tr>
                <td><?php echo $cabecera[0]['docref'] ?></td>
                <td><?php echo "$".number_format($cabecera[0]['subtotal'], 0); ?></td>
                <td><?php echo "$".number_format($cabecera[0]['iva'], 0); ?></td>
                <td><?php echo "$".number_format($cabecera[0]['descuento'], 0); ?></td>
                <td><?php echo "$".number_format($cabecera[0]['retenciones'], 0); ?></td>
                <td><?php echo "$".number_format($cabecera[0]['valor'], 0); ?></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><b>CONCEPTO:</b></td></tr>
            <tr><td colspan="6"><?php echo $cabecera[0]['concepto'] ?></td></tr>
        </table>
    </div>
</page>