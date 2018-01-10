<?php
    require_once 'includes/includes.php';   
    $sql = "SELECT ge.*,(SELECT nom_mun FROM general_municipios WHERE cod_mun = ge.ciu) AS ciudad FROM general_enterprises AS ge";
    $empresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    
    $sql="SELECT * FROM invoice_head WHERE idunico='".$_GET["id"]."'";   
    $cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM invoice_details WHERE idunico='".$_GET["id"]."'";   
    $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT *,(SELECT nom_mun FROM general_municipios WHERE cod_mun = gt.ciu_sede_pri) AS ciudad FROM general_third gt WHERE gt.id = '".$cabecera[0]["idcliente"]."'";
    $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $cantTotal=0; // total items
    $subtotal = 0; //sumatoria de netos
    $descuentoTotal = 0; // descuento total
    $totalTotales = 0; // sumatoria totales
    $ivaTotal = 0;

    for ($i=0; $i < count($detalles); $i++) {
        $cantTotal += $detalles[$i]['cantidad'];
        $totalTotales += $detalles[$i]['vtotal'];
        $neto = $detalles[$i]['pneto'] / ( 1 + ($detalles[$i]['iva']/100) );
        $subtotal += $neto * $detalles[$i]['cantidad'];

        $sql = "SELECT * FROM general_price_list_products WHERE producto = ".$detalles[$i]['idProducto'];
        $price_list = consulta::convertir_a_array( consulta::ejecutar_consulta($sql) );
        $price_list = $price_list[0];

        $descuentoTotal += ($price_list['precio_venta_iva'] * $detalles[$i]['cantidad']) - $detalles[$i]['vtotal'];
    }
    $ivaTotal = $totalTotales - $subtotal;    
?>
<style type="text/css">
    hr{
        display: block;
        height: 1px;
        border-bottom: 1px solid #ccc;
        background: transparent;
        margin: 0;
    }
    .table-header{
        border-collapse: collapse;
        width: 750px;
        max-width: 750px;
    }
    .table-header table{
        border-collapse: collapse;
    }
    .table-header tr td{
        /*font-size: 10px;*/
        text-align: center;
        box-sizing: border-box;
        /*border: 1px solid red;*/
    }
    .table-header .table-tercero{
        border-collapse: collapse;
        font-size: 9px;
        margin-left: 30px;        
    }
    .table-header .table-tercero tr td{
        text-align: left;
        white-space: normal;
    }
    .table-datos{
        width: 100%;
    }
    .table-datos td{
        font-size: 9px;
        text-align: left;
        white-space: normal;
        vertical-align: top;
    }


    .table-footer{
        /*border-collapse: collapse;*/
        /*width: 100%;*/
    }
    .table-footer td, .table-footer th{
        border: 1px solid #bbb;
        font-size: 10px;
    }
    .table-footer th{
        /*padding-left: 3px;*/
        background: #bbb;
    }


    .footer{
        padding: 0;
        /*background: lime;*/
    }
    .footer p{
        margin-top: 10px;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
    }
    .footer .legend{
        font-size: 10px;
        text-align: justify;
    }
    .footer .resolucion{
        text-align: center;
        font-weight: bold;
        margin: 15px 0px;
        font-size: 12px;
    }
    .footer .nota{
        font-size: 12px;
    }
    .footer .nota:after{
        content: "NOTA: ";
        font-weight: bold;
    }
    .footer .firmas{
        text-align: center;
    }

    .body{
        width: 100%;
        /*height: 612px;*/
        /*border: 1px solid black;*/
    }
    .body .table{
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
        /*display: block;*/
        height: 100%;
    }
    .body .table td{
        padding: 1px 2px;
    }
    .body .table td p{
        margin-top: 0px;
        margin-bottom: 3px;
        /*padding-top: 1px;*/
        width: 100%;
        max-width: 100%;
        /*background: lime;*/
    }
    .body .table td.td_cod{
        width: 60px;
        max-width: 60px;
        white-space: normal;
        min-width: 60px;
        text-align: left;
        font-size: 10px;
    }
    .body .table td.td_nom{
        width: 250px;
        max-width: 250px;
        min-width: 250px;
        white-space: normal;
        font-size: 10px;
    }
    .body .table td.td_com{
        width: 75px;
        max-width: 75px;
        min-width: 75px;
        white-space: normal; 
        font-size: 10px; 
        padding-left: 10px; 
    }
    .body .table td.td_lab{
        width: 75px;
        max-width: 75px;
        min-width: 75px;
        white-space: normal;
        font-size: 10px;
    }
    .body .table td.cantidad{
        width: 25px;
        max-width: 25px;
        white-space: normal;
        min-width: 25px;
        text-align: right;
        font-size: 10px;
    }
    .body .table td.td_num{
        width: 40px;
        max-width: 40px;
        white-space: normal;
        min-width: 40px;
        text-align: right;
        font-size: 10px;
    }
    .body .table td.td_dt{
        width: 10px;
        max-width: 10px;
        white-space: normal;
        min-width: 10px;
        text-align: center;
        font-size: 10px;
    }
    .body .table td.td_iva{
        width: 10px;
        max-width: 10px;
        white-space: normal;
        min-width: 10px;
        text-align: center;
        font-size: 10px;
    }
    .body .table td.td_neto{
        width: 40px;
        max-width: 40px;
        white-space: normal;
        min-width: 40px;
        text-align: right;
        font-size: 10px;
    }
    .body .table td.t-head{
        border: 1px solid black;
    }
    .body .table .t-head:last-child{
        border.right: none;
    }
    .body .table td.t-head{
        text-align: center;
    }
    .body .table td.t-body{
        border-bottom: 1px dashed #bbb;
        border-left: 1px solid black;
        border-right: 1px solid black;
    }
    .body .table tr.tr-last td{
        border-bottom: 1px solid black;
        /*height: 475px;*/
        /*max-height: 475px;*/
        /*background: lime;*/
    }
</style>
<style>

    <!-- 

    select {font-size:12px;}

    A:link {text-decoration: none; color: blue}

    A:visited {text-decoration: none; color: purple}

    A:active {text-decoration: red}

    A:hover {text-decoration: underline; color:red}

    -->

    /*.table td {
        background: lime;
        border: 1px solid red;
    }*/
</style>
<style type="text/css">

    <!--

    .ft0{font-style:normal;font-weight:normal;font-size:16px;font-family:Arial;color:#000000;}

    .ft1{font-style:normal;font-size:9px;font-family:Arial;color:#000000;}

    .ft2{font-style:normal;font-size:13px;font-family:Arial;color:#000000;}

    .ft3{font-style:normal;font-size:10px;font-family:Arial;color:#000000;}

    .ft4{font-style:normal;font-size:11px;font-family:Arial;color:#000000;}

    .ft5{font-style:normal;font-size:20px;font-family:Arial;color:#000000;}

    .ft6{font-style:normal;font-weight:normal;font-size:6px;font-family:Arial;color:#000000;}

    .ft7{font-style:normal;font-weight:normal;font-size:9px;font-family:Arial;color:#000000;}

    .ft8{font-style:normal;font-weight:normal;font-size:11px;font-family:Arial;color:#000000;}

    .ft9{font-style:normal;font-weight:normal;font-size:11px;font-family:Courier;color:#000000;}

    .ft10{font-style:normal;font-weight:normal;font-size:8px;font-family:Courier;color:#000000;}

    /*.ft0, .ft1, .ft2, .ft3, .ft4, .ft5, .ft6, .ft7, .ft8, .ft9, .ft10 {background: lime;}*/

    -->
</style>
<page backtop="40mm" backbottom="90mm" backleft="0mm" backright="5mm" format="letter" > 
    <page_footer>
        <table style="font-size: 11pt;text-align: center" class="table-footer">
            <thead>
                <tr>
                    <th style="width: 100px;text-align: center"><b>GRAVADO</b></th>
                    <th style="width: 100px;text-align: center"><b>EXCENTO</b></th>
                    <th style="width: 50px;text-align: center"><b>LINEAS</b></th>
                    <th style="width: 50px;text-align: center"><b>ITEMS</b></th>
                    <th style="width: 120px;text-align: center"><b>SUBTOTAL</b></th>
                    <th style="width: 100px;text-align: center"><b>DESCUENTO</b></th>
                    <th style="width: 90px;text-align: center"><b>IVA</b></th>
                    <th style="width: 120px;text-align: center"><b>TOTAL</b></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center">&nbsp;</td>
                    <td style="text-align: center"><?php echo count($detalles); ?></td>
                    <td style="text-align: center"><?php echo $cantTotal; ?></td>
                    <td style="text-align: center"><?php echo "$ ".number_format($subtotal,0)?></td>
                    <td style="text-align: center"><?php echo "$ ".number_format($descuentoTotal,0)?></td>
                    <td style="text-align: center"><?php echo "$ ".number_format($ivaTotal,0)?></td>
                    <td style="text-align: center"><?php echo "$ ".number_format($totalTotales,0)?></td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p class="legend">
                Para efectos legales esta factura de venta no requiere protesto, ni requerimientos previos. El no pago oportuno de esta factura genera intereses de mora al maximo legal autorizado. 
                Favor consignar el la cuenta de ahorro <b>BANCOLOMBIA 55046209299</b><br>
                Autorizo a <b>LAUREN BAIZ VERBEL,</b> para incluirme en cualquier banco de datos en caso de no pago oportuno presente factura. En caso de inconsistencias relacionadas con faltantes y/o fechas de recibo, 
                la guia es el unico documento valido para sus reclamaciones. No se aceptan devoluciones totales ni parciales sin previa autorizacion. <br>
                EL COMPRADOR DEL BIEN O BENEFICIARIO DEL SERVICIO NO PODRA ALEGAR FALTA DE REPRESENTACION O INDEBIDA REPRESENTACION POR RAZON DE LA PERSONA QUE LA MERCANCIA O EL SERVICIO EN SUS DEPENDENCIAS, 
                PARA EFECTOS DE LA ACEPTACION DEL TITULO. ESTA FACTURA SE ENTENDERA IRREBOCABLEMENTE ACEPTADA POR EL COMPRADOR O BENEFICIARIO DEL SERVICIO, SI NO RECLAMARE EN CONTRA DE SU CONTENIDO, BIEN SEA MEDIANTE DEVOLUCION DE ESTA FACTURA 
                Y DE LOS DOCUMENTOS DESPACHO SEGUN SEA EL CASO, O BIEN RECLAMO ESCRITO DIRIGIDO AL EMISOR O TENEDOR DE ESTE TITULO, DENTRO DE LOS DIEZ (10) DIAS CALENDARIOS SIGUIENTES A SU RECEPCION. <br>
                Despues de 72 horas de recibida la mercancia no se aceptan reclamos por cualquier otra eventualidad a la anterior.
            </p>
            <p class="resolucion">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis laboriosam, ipsa nostrum est maiores numquam officiis quas eaque delectus aliquam.
            </p>
            <p class="nota"><span><b>NOTA: </b></span><?php echo $cabecera[0]['observaciones']; ?></p>
            <br><br>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;padding-left: 20px; white-space: normal;vertical-align: middle;">
                        Hora: <?php echo date("d/m/Y h:i:s A") ?><br>
                        Elaborado por:  
                    </td>
                    <td style="width: 50%;padding-left: 20px; white-space: normal;text-align: right;vertical-align: middle;">
                        <span style="font-size: 10px">
                            _________________________________________<br>
                            Aceptado a satisfaccion y acepto contenido factura<br>
                            NOMBRE O FORMA Y SELLO QUIEN RECIBE <br>
                            C.C. _____________________________________<br>
                            Fecha de Recibido _________________________
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </page_footer>
    <page_header>
        <div style="position:absolute;top:10;left:10"><span class="ft0"><img src="images/mustralogo.png" width="210" height="80" alt=""></span></div>

        <div style="position:absolute;top:90;left:10;width:210;text-align: center;font-weight:bold;"><span class="ft1" style="font-size:12px;"><?php echo $empresa[0]['razon_social'] ?></span></div>

        <div style="position:absolute;top:104;left:10;width:210;text-align: center;"><span class="ft1">Nit: <?php echo $empresa[0]['num_ide']."-".$empresa[0]['dig_ver'] ?></span></div>

        <div style="position:absolute;top:114;left:10;width:210;text-align: center;"><span class="ft1"><?php echo $empresa[0]['dir']." - ".$empresa[0]['ciudad'] ?> </span></div>

        <div style="position:absolute;top:124;left:10;width:210;text-align: center;"><span class="ft1">PBX <?php echo $empresa[0]['tel_uno']." - ".$empresa[0]['tel_dos'] ?></span></div>
        
        <div style="position:absolute;top:134;left:10;width:210;text-align: center;"><span class="ft1">IVA REGIMEN COMÚN</span></div>

        <div style="position:absolute;top:6;left:300;"><span class="ft2" style="font-size:20px;font-weight: bold;">FACTURA DE VENTA</span></div>

        <div style="position:absolute;top:39;left:251"><span class="ft1">Comprador:</span></div>

        <div style="position:absolute;top:39;left:311;font-weight:bold;"><span class="ft3"><?php echo $cliente[0]["ape_rep_leg"]?> <?php echo $cliente[0]["nom_rep_leg"]?></span></div>
        
        <div style="position:absolute;top:59;left:311;font-weight:bold;"><span class="ft3"><?php echo $cliente[0]["raz_soc"]?></span></div>

        <div style="position:absolute;top:77;left:251"><span class="ft1">Nit:</span></div>

        <div style="position:absolute;top:77;left:311"><span class="ft4"><?php echo $cliente[0]["num_ide"]?></span></div>

        <div style="position:absolute;top:96;left:251"><span class="ft1">Direccion:</span></div>

        <div style="position:absolute;top:96;left:311"><span class="ft3"><?php echo $cliente[0]["dir_sede_pri"]?></span></div>

        <div style="position:absolute;top:114;left:251"><span class="ft1">Ciudad:</span></div>

        <div style="position:absolute;top:114;left:311"><span class="ft3"><?php echo $cliente[0]['ciudad']; ?></span></div>

        <div style="position:absolute;top:130;left:251"><span class="ft1">Telefono:</span></div>

        <div style="position:absolute;top:130;left:311"><span class="ft3"><?php echo $cliente[0]["tel_1_sede_pri"]?></span></div>

        <!-- <div style="position:absolute;top:163;left:221"><span class="ft1">SOMOS AUTORRETENEDORES SEGUN RES. 002146 MAY 18/2012</span></div> -->

        <div style="position:absolute;top:39;left:576"><span class="ft5"> <!-- 80 --></span></div>

        <div style="position:absolute;top:9;left:678;width:100px;padding: 1px;background: #bbb;text-align: center;"><span class="ft5" style="font-weight: bold;"><?php echo $cabecera[0]["id"] ?></span></div>

        <div style="position:absolute;top:50;left:605"><span class="ft1">Fecha Fact:</span></div>

        <div style="position:absolute;top:50;left:678"><span class="ft4"><?php echo $cabecera[0]['fecha'] ?></span></div>

        <div style="position:absolute;top:69;left:605"><span class="ft1">Fecha Venc:</span></div>

        <div style="position:absolute;top:70;left:678"><span class="ft4"><?php echo $cabecera[0]['fechavence'] ?></span></div>

        <div style="position:absolute;top:90;left:605"><span class="ft1">Numero Ped:</span></div>

        <div style="position:absolute;top:89;left:678"><span class="ft3"><?php echo $empresa[0]['referencia'] ?></span></div>

        <div style="position:absolute;top:108;left:605;font-weight:bold;"><span class="ft1">Vendedor:</span></div>

        <div style="position:absolute;top:108;left:678;width: 100;white-space: normal;font-weight:bold;"><span class="ft3">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING.</span></div>

        <!-- <div style="position:absolute;top:171;left:628"><span class="ft3">ALBERTO</span></div> -->
    </page_header>
    <br>
    <div class="body">
        <!-- <hr>  -->
        <table style="width: 100%" class="table">
            <tr>          
                <td class="t-head td_cod"><b>Codigo</b></td>
                <td class="t-head td_nom"><b>Descripcion</b></td>            
                <td class="t-head td_com"><b>Comercial</b></td>            
                <td class="t-head td_lab"><b>Laboratorio</b></td>
                <td class="t-head cantidad"><b>Cant</b></td>
                <td class="t-head td_num"><b>P.lista</b></td>
                <td class="t-head td_dt"><b>D1</b></td>
                <td class="t-head td_dt"><b>D2</b></td>
                <td class="t-head td_iva"><b>Iva</b></td>
                <td class="t-head td_neto"><b>P.neto</b></td>
                <td class="t-head td_num"><b>Total</b></td>
            </tr>
              
            <?php
                $codigo = "";
                $nombre = "";
                $comercial = "";
                $laboratorio = "";
                $cantidad = "";
                $plista = "";
                $dt1 = "";
                $dt2 = "";
                $iva = "";
                $neto = "";
                $total = "";
                for($i=0;$i<count($detalles);$i++){
                    $datospro[0]="*";
                    $sql="SELECT * FROM general_products_services WHERE id='".$detalles[$i]['idProducto']."'";
                    $product= consulta::convertir_a_array(consulta::ejecutar_consulta($sql)); 
                    $last = ($i == (count($detalles) -1) ? true : false); // verifica si es el ultimo elemento

                    $sql="SELECT text as nombre FROM general_params WHERE value='".$product[0]["laboratorio"]."' AND grupo='laboratorios'";
                    $lab = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                    $codigo = "<p>".$product[0]['codigo']."</p>";
                    $nombre = "<p>".$product[0]['nombre']."</p>";
                    $comercial = "<p>".$product[0]['nombre_comercial']."</p>";
                    $laboratorio = "<p>".$lab[0]['nombre']."</p>";
                    $cantidad = "<p>".number_format($detalles[$i]['cantidad'],0)."</p>";
                    $plista = "<p>".number_format($detalles[$i]['pneto'],0)."</p>";
                    $dt1 = "<p>".number_format($detalles[$i]['desc1'],0)."</p>";
                    $dt2 = "<p>".number_format($detalles[$i]['desc2'],0)."</p>";
                    $iva = "<p>".number_format($detalles[$i]['iva'],0)."</p>";
                    $neto = "<p> </p>";
                    $total = "<p>".number_format($detalles[$i]['vtotal'],0)."</p>";
                ?>
            <tr class="<?php echo ($last ? 'tr-last' : ''); ?>">
                <td class="t-body td_cod"><?php echo $codigo; ?></td>
                <td class="t-body td_nom"><?php echo $nombre; ?></td>            
                <td class="t-body td_com"><?php echo $comercial; ?></td>
                <td class="t-body td_lab"><?php echo $laboratorio; ?></td>            
                <td class="t-body cantidad"><?php echo $cantidad; ?></td>
                <td class="t-body td_num"><?php echo $plista; ?></td>
                <td class="t-body td_dt"><?php echo $dt1; ?></td>
                <td class="t-body td_dt"><?php echo $dt2; ?></td>
                <td class="t-body td_iva"><?php echo $iva; ?></td>
                <td class="t-body td_neto"><?php echo $neto; ?></td>
                <td style="width: 45px;min-width: 45px;max-width: 45px;" class="t-body td_num"><?php echo $total; ?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</page> 
