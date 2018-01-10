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
                <td style="text-align: center; font-size: 13px;   width: 150px; height: 120px"><?php echo $cabecera[0]["tipo"] ?><br/>
                <?php echo $cabecera[0]["id"] ?>
                </td>
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
                            <td style="padding-right: 10px;"><?php echo "CLIENTES CONTADO"?></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 10px;"><b>PROPIETARIO:</b></td>
                            <td style="padding-right: 10px;"><?php echo "CLIENTES CONTADO"?></td>
                            <!-- <td style="padding-right: 10px;"><b>VALOR: </b></td>
                            <td style="padding-right: 10px;"><?php echo "$".number_format($cabecera[0]['valor'], 0); ?></td> -->
                        </tr>
                        <tr>
                            
                            <td style="padding-right: 10px;"><b>FECHA:</b></td>
                            <td style="padding-right: 10px;"><?php echo Utils::formato_fecha_sql_a_normal($cabecera[0]['fecha']) ?>&nbsp;</td>
                        </tr>                 
                                           
                    </table>        
                </td>            
            </tr>
        </table>
        <br/>
        <br/>
        <table style="font-size: 9pt;width:100%;">
                <tr style="text-align: center">
                    
                    <td style="padding-rigth:5px; width: 90px;"><b>TERCERO</b></td>
                    <td style="padding-rigth:5px; width: 50px;"><b>NUMERO</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>FECHA</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>VALOR</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>APLICADO</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>FECHA CRUCE</b></td>
                    <td style="padding-rigth:5px; width: 90px;"><b>DOC. REF.</b></td>
                </tr>


                <?php 
                $sql="SELECT * FROM financial_receipt_exit_documents WHERE idunico='".$_GET["id"]."'";
                $docs = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                for ($d=0; $d < count($docs); $d++) 
                { 
                    $sql="SELECT *, (SELECT raz_soc FROM general_third WHERE id=(SELECT idcliente FROM invoice_head WHERE id='".$docs[$d]["iddocument"]."')) as tercero FROM ".$docs[$d]["tipoDocumento"]." WHERE id='".$docs[$d]["iddocument"]."'";
                    $docu= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    if($docs[$d]["tipoDocumento"]=="invoice_head")
                    {
                        echo '<tr style="text-align: center">';
                        echo "<td>".$docu[0]["tercero"]."</td>";
                        echo "<td>".$docu[0]["id"]."</td>";
                        echo "<td>".$docu[0]["fecha"]."</td>";
                        echo "<td>".number_format($docu[0]["totaltotales"],0)."</td>";
                        echo "<td>".number_format($docs[$d]["aplicado"],0)."</td>";
                        echo "<td>".$cabecera[0]["fecha"]."</td>";
                        echo "<td>".$cabecera[0]["docref"]."</td>";
                        echo "</tr>";
                    }
                }

                    
                    
                ?>
                
                
        </table>
         <br><br>
         <table style="font-size: 9pt;width:760px">
            <tr style="width: 100%">
                <td style="width: 100%;background: #ccc;padding:5px;">DESCUENTOS Y RETENCIONES</td>
            </tr>
            <tr>
                <td>RETENCIONES:  <?php echo number_format($cabecera[0]['retencion'],0) ?></td>
            </tr>
            <tr>
                <td>DESCUENTO:  <?php echo number_format($cabecera[0]['descuento'],0) ?></td>
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
                            <td style="width: 25%;"><b>#Documento</b></td>
                            <td style="width: 25%;"><b>Valor</b></td>
                        </tr>
                        <?php 
                        $sql="SELECT *, (SELECT nombre FROM general_bancos b WHERE b.id=banco) as nombanco FROM financial_receipt_exit_payment_forms WHERE idunico='".$_GET["id"]."'";
                        $fp=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        //var_dump($fp);
                        for ($f=0; $f < count($fp); $f++) {                             
                            echo '<tr style="width: 100%">';
                            echo '<td style="width: 25%;">'.$fp[$f]["formaPago"].'</td>';
                            echo '<td style="width: 25%;">'.$fp[$f]["nombanco"].'</td>';
                            echo '<td style="width: 25%;">'.$fp[$f]["doc"].'</td>';
                            echo '<td style="width: 25%;">'.number_format($fp[$f]["valor"],0).'</td>';
                            echo '</tr>';
                        }
                        ?>
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
                <td style="width: 100%;padding: 8px; border: 1px solid #999;">
                    
                    <?php echo $cabecera[0]["nota"] ?>
                </td>
            </tr>
        </table>
    </div>
</page>