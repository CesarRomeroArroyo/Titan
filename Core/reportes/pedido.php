<?php
    require_once 'includes/includes.php';
    $sql = "SELECT ge.*,(SELECT nom_mun FROM general_municipios WHERE cod_mun = ge.ciu) AS ciudad FROM general_enterprises AS ge";
    $empresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM order_head WHERE id='".$_GET["id"]."'";   
    $cabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql="SELECT * FROM order_details WHERE idunico='".$cabecera[0]["idunico"]."'";
    $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

    $sql = "SELECT *,(SELECT nom_mun FROM general_municipios WHERE cod_mun = gt.ciu_sede_pri) AS ciudad FROM general_third gt WHERE gt.id = ".$cabecera[0]['idCliente'];
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
        width: 240px;
        max-width: 240px;
        min-width: 240px;
        white-space: normal;
        font-size: 10px;
    }
    .body .table td.td_com{
        width: 120px;
        max-width: 120px;
        min-width: 120px;
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
                <td style="text-align: center"><?php echo count($detalles); ?></td>
                <td style="text-align: center"><?php echo $cantTotal; ?></td>
                <td style="text-align: center"><?php echo "$ ".number_format($subtotal,0)?></td>
                <td style="text-align: center"><?php echo "$ ".number_format($descuentoTotal,0)?></td>
                <td style="text-align: center"><?php echo "$ ".number_format($ivaTotal,0)?></td>
                <td style="text-align: center"><?php echo "$ ".number_format($totalTotales,0)?></td>
            </tr>
        </table>
    </page_footer>
    <!-- <page_header>
            <table border='0' style="font-size: 7pt;width: 100px">
                <tr>
                    <td style="width: 300px; height: 120px"><img src="images/mustralogo.png" style="width: 100%; height: 100% ;" alt=""/></td>
                    <td style="text-align: center; font-size: 13px; width: 300px; height: 120px">CALLE 15# 11 88 AV. SAN CARLOS<BR/> TELEFONO 2769068 - 2746796<BR/>SINCELEJO - SUCRE<BR/>REGIMEN SIMPLIFICADO</td>
                    <td style="text-align: center; font-size: 13px;   width: 150px; height: 120px">PEDIDO<BR/>No <b><?php echo $_GET["id"] ?></b></td>
                
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
    </page_header> -->
    <page_header>
        <div style="position:absolute;top:10;left:10"><span class="ft0"><img src="images/mustralogo.png" width="210" height="80" alt=""></span></div>

        <div style="position:absolute;top:90;left:10;width:210;text-align: center;font-weight:bold;"><span class="ft1" style="font-size:12px;"><?php echo $empresa[0]['razon_social'] ?></span></div>

        <div style="position:absolute;top:104;left:10;width:210;text-align: center;"><span class="ft1">Nit: <?php echo $empresa[0]['num_ide']."-".$empresa[0]['dig_ver'] ?></span></div>

        <div style="position:absolute;top:114;left:10;width:210;text-align: center;"><span class="ft1"><?php echo $empresa[0]['dir']." - ".$empresa[0]['ciudad'] ?> </span></div>

        <div style="position:absolute;top:124;left:10;width:210;text-align: center;"><span class="ft1">PBX <?php echo $empresa[0]['tel_uno']." - ".$empresa[0]['tel_dos'] ?></span></div>
        
        <div style="position:absolute;top:134;left:10;width:210;text-align: center;"><span class="ft1">IVA REGIMEN COMÚN</span></div>

        <div style="position:absolute;top:6;left:300;"><span class="ft2" style="font-size:20px;font-weight: bold;">PEDIDO DE CLIENTES</span></div>

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

        <div style="position:absolute;top:50;left:605"><span class="ft1">Fecha:</span></div>

        <div style="position:absolute;top:50;left:678"><span class="ft4"><?php echo $cabecera[0]['fecha'] ?></span></div>

        <!-- <div style="position:absolute;top:69;left:605"><span class="ft1">Fecha Venc:</span></div>

        <div style="position:absolute;top:70;left:678"><span class="ft4"><?php echo $cabecera[0]['fechavence'] ?></span></div> -->

        <!-- <div style="position:absolute;top:90;left:605"><span class="ft1">Numero Ped:</span></div>

        <div style="position:absolute;top:89;left:678"><span class="ft3"><?php echo $empresa[0]['referencia'] ?></span></div> -->

        <div style="position:absolute;top:69;left:605;font-weight:bold;"><span class="ft1">Vendedor:</span></div>

        <div style="position:absolute;top:69;left:678;width: 100;white-space: normal;font-weight:bold;"><span class="ft3">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISICING.</span></div>

        <!-- <div style="position:absolute;top:171;left:628"><span class="ft3">ALBERTO</span></div> -->
    </page_header>
    <div class="body">
        <?php 
            $sql="SELECT p.nombre, (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo='laboratorios') as laboratorio, d.* FROM order_details d LEFT JOIN general_products_services p ON d.idProducto = p.id WHERE d.idunico='".$cabecera[0]["idunico"]."' AND  p.institucional='' AND p.controlado='' ORDER BY p.laboratorio";
            $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
            if(count($detalles)>0)
            {
        ?>
                <table style="width: 100%" class="table">
                    <!-- <tr><td colspan="10" style='text-align: left'><b></b></td></tr> -->
                    <tr>
                        <td class="t-head td_nom"><b>Descripcion</b></td>            
                        <td class="t-head td_com"><b>Comercial</b></td>            
                        <td class="t-head td_lab"><b>Laboratorio</b></td>
                        <td class="t-head cantidad"><b>Cant</b></td>
                        <td class="t-head td_num"><b>P.lista</b></td>
                        <td class="t-head td_dt"><b>D1</b></td>
                        <td class="t-head td_dt"><b>D2</b></td>
                        <td class="t-head td_iva"><b>Iva</b></td>
                        <td class="t-head td_neto"><b>P.neto</b></td>
                        <td class="t-head td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><b>Total</b></td>
                    </tr>
                    <?php     
                        for($i=0;$i<count($detalles);$i++)
                        {     
                            $last = ($i == (count($detalles) -1) ? true : false); // verifica si es el ultimo elemento                   
                    ?>
                    <tr class="<?php echo ($last ? 'tr-last' : ''); ?>">
                        <td class="t-body td_nom"><?php echo $detalles[$i]["nombre"] ?></td>            
                        <td class="t-body td_com"><?php echo $detalles[$i]["nombre_comercial"] ?></td>        
                        <td class="t-body td_lab"><?php echo $detalles[$i]["laboratorio"] ?></td>        
                        <td class="t-body cantidad"><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
                        <td class="t-body td_num"><?php  ?></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc1'],0) ?></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc2'],0) ?></td>
                        <td class="t-body td_iva"><?php echo $detalles[$i]['iva'] ?></td>
                        <td class="t-body td_neto"><?php echo $detalles[$i]['pneto'] ?></td>
                        <td class="t-body td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><?php echo number_format($detalles[$i]['vtotal'],0) ?></td>
                    </tr>
                    <?php    
                        }//fin for
                    ?>
                </table>
        <?php 
            } //fin if
            $sql="SELECT p.nombre, (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo='laboratorios') as laboratorio, d.* FROM order_details d LEFT JOIN general_products_services p ON d.idProducto = p.id WHERE d.idunico='".$cabecera[0]["idunico"]."' AND  p.institucional='on' AND p.controlado='' ORDER BY p.laboratorio";
            $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
            $sql="SELECT p.nombre, (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo='laboratorios') as laboratorio, d.* FROM order_details d LEFT JOIN general_products_services p ON d.idProducto = p.id WHERE d.idunico='".$cabecera[0]["idunico"]."' AND  p.institucional='on' AND p.controlado='on' ORDER BY p.laboratorio";
            $detalles2 = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
        
            if(count($detalles)>0 || count($detalles2)>0 )
            {
        ?>
                <table style="width: 100%" class="table">
                    <!-- <tr><td colspan="10" style='text-align: left;'><b></b></td></tr> -->
                    <tr>          
                        <td class="t-head td_nom"><b>Descripcion</b></td>            
                        <td class="t-head td_com"><b>Comercial</b></td>            
                        <td class="t-head td_lab"><b>Laboratorio</b></td>
                        <td class="t-head cantidad"><b>Cant</b></td>
                        <td class="t-head td_num"><b>P.lista</b></td>
                        <td class="t-head td_dt"><b>D1</b></td>
                        <td class="t-head td_dt"><b>D2</b></td>
                        <td class="t-head td_iva"><b>Iva</b></td>
                        <td class="t-head td_neto"><b>P.neto</b></td>
                        <td class="t-head td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><b>Total</b></td>
                    </tr>          
                    <?php 
                        for($i=0;$i<count($detalles);$i++)
                        {  
                            $last = ($i == (count($detalles) -1) ? true : false); // verifica si es el ultimo elemento
                    ?>
                    <tr class="<?php echo ($last ? 'tr-last' : ''); ?>">
                        <td class="t-body td_nom"><?php echo $detalles[$i]["nombre"] ?></td>            
                        <td class="t-body td_com"><?php echo $detalles[$i]["nombre_comercial"] ?></td>        
                        <td class="t-body td_lab"><?php echo $detalles[$i]["laboratorio"] ?></td>        
                        <td class="t-body cantidad"><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
                        <td class="t-body td_num"><?php echo number_format($detalles[$i]['pneto'],0) ?></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc1'],0) ?></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc2'],0) ?></td>
                        <td class="t-body td_iva"><?php echo $detalles[$i]['iva'] ?></td>
                        <td class="t-body td_neto"><?php echo $detalles[$i]['pneto'] ?></td>
                        <td class="t-body td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><?php echo number_format($detalles[$i]['vtotal'],0) ?></td>
                    </tr>
                    <?php    
                        } // fin for
                    ?>
                </table>
        <?php 
            }// fin if
            $sql="SELECT p.nombre, (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo='laboratorios') as laboratorio, d.* FROM order_details d LEFT JOIN general_products_services p ON d.idProducto = p.id WHERE d.idunico='".$cabecera[0]["idunico"]."' AND  p.institucional='' AND p.controlado='on' ORDER BY p.laboratorio";
            $detalles = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
            if(count($detalles)>0)
            {
        ?>
                <table style="width: 100%" class="table">
                    <!-- <tr><td colspan="10" style='text-align: left'><b></b></td></tr> -->
                    <tr>          
                        <td class="t-head td_nom"><b>Descripcion</b></td>            
                        <td class="t-head td_com"><b>Comercial</b></td>            
                        <td class="t-head td_lab"><b>Laboratorio</b></td>
                        <td class="t-head cantidad"><b>Cant</b></td>
                        <td class="t-head td_num"><b>P.lista</b></td>
                        <td class="t-head td_dt"><b>D1</b></td>
                        <td class="t-head td_dt"><b>D2</b></td>
                        <td class="t-head td_iva"><b>Iva</b></td>
                        <td class="t-head td_neto"><b>P.neto</b></td>
                        <td class="t-head td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><b>Total</b></td>
                    </tr>
                    <?php 
                        for($i=0;$i<count($detalles);$i++)
                        {
                            $last = ($i == (count($detalles) -1) ? true : false); // verifica si es el ultimo elemento                        
                    ?>
                    <tr class="<?php echo ($last ? 'tr-last' : ''); ?>">
                        <td class="t-body td_nom"><?php echo $detalles[$i]["nombre"] ?></td>            
                        <td class="t-body td_com"><?php echo $detalles[$i]["nombre_comercial"] ?></td>        
                        <td class="t-body td_lab"><?php echo $detalles[$i]["laboratorio"] ?></td>        
                        <td class="t-body cantidad"><?php echo number_format($detalles[$i]['cantidad'],0) ?></td>
                        <td class="t-body td_num"></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc1'],0) ?></td>
                        <td class="t-body td_dt"><?php echo number_format($detalles[$i]['desc2'],0) ?></td>
                        <td class="t-body td_iva"><?php echo $detalles[$i]['iva'] ?></td>
                        <td class="t-body td_neto"><?php echo $detalles[$i]['pneto'] ?></td>
                        <td class="t-body td_num" style="width: 45px;min-width: 45px;max-width: 45px;"><?php echo number_format($detalles[$i]['vtotal'],0) ?></td>
                    </tr>
                    <?php 
                        }// fin for
                    ?>
                </table>
            <?php 
                } // fin if
            ?>
    </div>
</page>     