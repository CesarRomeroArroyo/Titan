<?php header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once 'includes/includes.php';
//cors();
$method = $_SERVER['REQUEST_METHOD'];
$resource = $_SERVER['REQUEST_URI'];

if(middlewareSecurity()==true){
    switch ($method){
        case 'GET':
            if(preg_match("/buscarCierresCaja\//", $resource, $matches)){
                $sql="SELECT * FROM cashbox_moves WHERE MONTH(fecha)=".$_GET["busqueda"]." AND YEAR(fecha)=".date('Y')." AND tipo =1";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarCodigosBarra\//", $resource, $matches)){
                $sql="SELECT * FROM general_products_services_barcode WHERE idunico='".$_GET["producto"]."'";
                $retorno=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarBodegas\//", $resource, $matches)){
                $sql="SELECT id, descripcion FROM general_bodega";
                $bodegas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($bodegas);
            }
            if(preg_match("/buscarCargarFacturas\//", $resource, $matches)){
                $sql="SELECT q.*, p.codigo as codigo, p.nombre as nombre, p.nombre_comercial as nombre_comercial, CONCAT( p.laboratorio) as nom_prese,
                    q.devuelto as cdevueltas, (q.cantidad-q.devuelto) as cdisponible, q.cantidad as cvendidas, '0' as total, '0' as cdevolver,
                    IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo='presentaciones'), '') as nom_presentacion, 
                    IFNULL((SELECT text FROM general_params WHERE `value`=laboratorio AND grupo='laboratorios'),'') as nom_laboratorio, q.nota as nota 
                    FROM invoice_details q LEFT JOIN general_products_services p ON q.idProducto = p.id 
                    WHERE q.idunico='".$_GET["idunico"]."'";

                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarCargarFacturasCompras\//", $resource, $matches)){
                $sql="SELECT q.*, p.codigo as codigo, p.nombre as nombre, p.nombre_comercial as nombre_comercial , CONCAT(p.laboratorio) as nom_prese,
                    q.devuelto as cdevueltas, (q.cantidad-q.devuelto) as cdisponible, q.cantidad as cvendidas, '0' as total, '0' as cdevolver,
                    IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo='presentaciones'), '') as nom_presentacion, 
                    IFNULL((SELECT text FROM general_params WHERE `value`=laboratorio AND grupo='laboratorios'),'') as nom_laboratorio, q.nota as nota 
                    FROM shopping_suppliers_bills_details q LEFT JOIN general_products_services p ON q.id_producto = p.id 
                    WHERE q.idunico='".$_GET["idunico"]."'";

                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarCargarPedido\//", $resource, $matches)){
                $sql="SELECT q.*, CONCAT(p.codigo, ' ', p.nombre, ' ', p.nombre_comercial) as producto FROM quotation_details q LEFT JOIN general_products_services p ON q.idProducto = p.id WHERE q.idunico='".$_GET["idunico"]."'";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarCargarPedidoFacturar\//", $resource, $matches)){
                $sql="SELECT q.*, CONCAT(p.codigo, ' ', p.nombre, ' ', p.nombre_comercial) as producto FROM order_details q LEFT JOIN general_products_services p ON q.idProducto = p.id WHERE q.idunico='".$_GET["idunico"]."'";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarCargarRemisionFacturar\//", $resource, $matches)){
                $sql="SELECT q.*, CONCAT(p.codigo, ' ', p.nombre, ' ', p.nombre_comercial) as producto FROM referrals_details q LEFT JOIN general_products_services p ON q.idProducto = p.id WHERE q.idunico='".$_GET["idunico"]."'";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarClientes\//", $resource, $matches)){
                $donde="id=".$_GET["cliente"];
                $datos[0]="*";
                $sql= consulta::seleccionar($datos,"general_third", $donde);
                $proveedor= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($proveedor);
            }
            if(preg_match("/buscarCotizaciones\//", $resource, $matches)){
                $sql="SELECT * FROM quotation_head WHERE idCliente='".$_GET["cliente"]."' AND estado =1";
                $cotizaciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($cotizaciones);
            }
            if(preg_match("/buscarDescuentos\//", $resource, $matches)){
                $sql="SELECT *, IF(estado=1, 'ACTIVO', 'INACTIVO') as state FROM general_discounts";
                if(isset($_GET["busqueda"]))
                {
                    $sql.=" WHERE id='".$_GET["busqueda"]."'";
                }
                $retorno=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarDetalleCotizacion\//", $resource, $matches)){
                $sql="SELECT q.*, CONCAT(p.codigo, ' - ', p.nombre, ' - ', p.nombre_comercial) as producto, "
                . "(SELECT text FROM general_params WHERE value= p.laboratorio AND grupo ='laboratorios') as laboratorio,"       
                . " q.desc1 as descu, p.desc1 as desc1, p.desc2 as desc2, q.pneto as precio_uni, q.iva as iva "
                . " FROM "
                . "quotation_details q LEFT JOIN general_products_services p ON q.idProducto = p.id "
                . "WHERE q.idunico='".$_GET["idunico"]."'";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarDetalleFactura\//", $resource, $matches)){
                $sql="SELECT q.*, CONCAT(p.codigo, ' ', p.nombre, ' ', p.nombre_comercial) as producto, "
                . "(SELECT text FROM general_params WHERE value= p.laboratorio AND grupo ='laboratorios') as laboratorio,"
                . " q.desc1 as descu, p.desc1 as desc1, p.desc2 as desc2, q.pneto as precio_uni, q.iva as iva "
                . "FROM invoice_details q LEFT JOIN general_products_services p ON q.idProducto = p.id "
                . "WHERE q.idunico='".$_GET["idunico"]."'";
                $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                for($i=0;$i<count($productos);$i++)
                {
                    $can+=$productos[$i]["cantidad"];
                    $tot+=$productos[$i]["vtotal"];
                    if($productos[$i]["descu"] !=0 || $productos[$i]["descu"]!="")
                    {
                        $desc=$productos[$i]["descu"]/100;
                        $valor = $productos[$i]["precio_uni"] - ($productos[$i]["precio_uni"]*$desc); 
                        $neto=$valor;
                    }

                    if($productos[$i]["iva"] !=0 || $productos[$i]["iva"]!="")
                    {
                        $iva = 1 +  ($productos[$i]["iva"]/100);
                        $base = $productos[$i]["precio_uni"]/$iva;
                        $valIva = $productos[$i]["precio_uni"]-$base;
                    }
                    $productos[$i]["neto"]=$neto-$valIva;
                    $productos[$i]["iva"]=$valIva;
                }
                echo json_encode($productos);
            }
            if(preg_match("/buscarDatelleFacturaCompra\//", $resource, $matches)){
                $sql="SELECT q.*, p.codigo as codigo, p.nombre as nombre, p.nombre_comercial as comercial, "
                . "(SELECT text FROM general_params WHERE value= p.laboratorio AND grupo ='laboratorios') as laboratorio,"
                . "q.desc1 as desc1, q.desc2 as desc2, q.precio_uni as precio_uni FROM "
                . "shopping_suppliers_bills_details q "
                . "LEFT JOIN general_products_services p ON q.id_producto = p.id "
                . "WHERE q.idunico='".$_GET["idunico"]."'";
                $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $tot=0;
                $can=0;
                $neto=0;
                $valor=0;
                $desc=0;
                for($i=0;$i<count($productos);$i++)
                {
                    $can+=$productos[$i]["cantidad"];
                    $tot+=$productos[$i]["preciototal"];
                    if($productos[$i]["desc1"]!="0" ||$productos[$i]["desc1"]!="")
                    {
                        $desc=$productos[$i]["desc1"]/100;
                        $valor = $productos[$i]["precio_uni"] - ($productos[$i]["precio_uni"]*$desc); 
                        $neto=$valor;
                    }
                    if($productos[$i]["desc2"]!="0" ||$productos[$i]["desc2"]!="")
                    {
                        $desc=$productos[$i]["desc2"]/100;
                        $valor = $neto - ($neto*$desc); 
                        $neto=$valor;
                    }
                    $productos[$i]["neto"]=$neto;
                }
                echo json_encode($productos);
            }
            if(preg_match("/buscarDocumentosEgresos\//", $resource, $matches)){
                $retorno = array();
                $sql="SELECT * FROM general_third WHERE id= ".$_GET["cliente"];
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                $sql="SELECT * FROM invoice_head WHERE idcliente=".$_GET["cliente"];
                $sql='SELECT 5 as tipodocumento, CONCAT(tipo," - ", id) as tiponum, fec_exp as fecha, total_fact as totalGrl, (total_fact-aplicado) as total, iva_fact as iva, observaciones as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "COMPROBANTE DE EGRESO" as reciegre , "facturaCompra" as imprimir, idunico as idunicoDoc FROM shopping_suppliers_bills WHERE idproveedor ='.$_GET["cliente"].'  AND (total_fact - aplicado) >0  
                UNION
                SELECT 6 as tipodocumento, CONCAT(tipo, " - ", id) as tiponum, fecha as fecha, totales as totalGrl, (-1*(totales-aplicado)) as total, "0" as iva, observaciones as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "COMPROBANTE DE EGRESO" as reciegre  , "devolucionesCompras" as imprimir, idunico as idunicoDoc FROM purchase_devolution_head WHERE idcliente ='.$_GET["cliente"].' AND (totales - aplicado) >0
                UNION
                SELECT 7 as tipodocumento, CONCAT(tipodoc, " - ", id) as tiponum, fecha as fecha, valor as totalGrl, ((valor-aplicado)) as total, "0" as iva, concepto as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "COMPROBANTE DE EGRESO" as reciegre  , "notaDebitoAcreedor" as imprimir, idunico as idunicoDoc FROM financial_notes WHERE tercero ='.$_GET["cliente"].' AND (valor - aplicado) >0 AND tipo=7
                UNION
                SELECT 8 as tipodocumento, CONCAT(tipodoc, " - ", id) as tiponum, fecha as fecha, valor as totalGrl, (-1*(valor-aplicado)) as total, "0" as iva, concepto as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "COMPROBANTE DE EGRESO" as reciegre, "notaCreditoAcreedor" as imprimir, idunico as idunicoDoc  FROM financial_notes WHERE tercero ='.$_GET["cliente"].' AND (valor - aplicado) >0 AND tipo=8
                UNION
                SELECT 10 as tipodocumento, CONCAT(tipo, " - ", id) as tiponum, fecha as fecha, vaplicar as totalGrl, (-1*(vaplicar-aplicado)) as total, "0" as iva, nota as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "COMPROBANTE DE EGRESO" as reciegre,"abonosCompras" as imprimir, idunico as idunicoDoc FROM financial_receipt_exit WHERE idtercero ='.$_GET["cliente"].' AND (vaplicar - aplicado) >0 AND abono=2
                ';
                $invoice = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                for ($i = 0; $i < count($invoice); $i++) {
                    
                    if($invoice[$i]["totalGrl"]<0)
                    {
                        $total = $invoice[$i]["totalGrl"]*-1;
                    }
                    else
                    {
                        $total = $invoice[$i]["totalGrl"];
                    }
                    if($invoice[$i]["total"]<0)
                    {
                        $invoice[$i]["total2"] = $invoice[$i]["total"]*-1;
                    }
                    else
                    {
                        $invoice[$i]["total2"] = $invoice[$i]["total"];
                    }
                    $difFecha = Utils::dias_transcurridos_entre_fechas($invoice[$i]["fecha"], date("Y-m-d"));
                    $invoice[$i]["diferenciaDias"]=$difFecha;
                    $invoice[$i]["aplicaHoy"]="<label id='lbl".$i."'>0</label>";
                }

                array_push($retorno, $invoice);
                array_push($retorno, $clientes);
                echo json_encode($retorno);
            }
            if(preg_match("/buscarDocumentosRecibosdeCaja\//", $resource, $matches)){
                $retorno = array();
                $sql="SELECT * FROM general_third WHERE id= ".$_GET["cliente"];
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                $sql="SELECT * FROM invoice_head WHERE idcliente=".$_GET["cliente"];
                $sql='SELECT 1 as tipodocumento, CONCAT(tipo," - ", id) as tiponum, fecha as fecha,totaltotales as totalGrl, (totaltotales-aplicado) as total, totaliva as iva, observaciones as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "RECIBO DE CAJA" as reciegre, "facturaVenta" as imprimir, idunico as idunicoDoc FROM invoice_head WHERE idcliente ='.$_GET["cliente"].'  AND CAST((totaltotales - aplicado) AS SIGNED )>0  
                UNION
                SELECT 2 as tipodocumento, CONCAT(tipo, " - ", id) as tiponum, fecha as fecha,totales as totalGrl, (-1*(totales-aplicado)) as total, "0" as iva, observaciones as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "RECIBO DE CAJA" as reciegre, "devolucionVenta" as imprimir, idunico as idunicoDoc  FROM sales_devolution_head WHERE idcliente ='.$_GET["cliente"].' AND (totales - aplicado) >0
                UNION
                SELECT 3 as tipodocumento, CONCAT(tipodoc, " - ", id) as tiponum, fecha as fecha, valor as totalGrl,  ((valor-aplicado)) as total, "0" as iva, concepto as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "RECIBO DE CAJA" as reciegre , "notaDebitoDeudores" as imprimir, idunico as idunicoDoc FROM financial_notes WHERE tercero ='.$_GET["cliente"].' AND (valor - aplicado) >0 AND tipo=3
                UNION
                SELECT 4 as tipodocumento, CONCAT(tipodoc, " - ", id) as tiponum, fecha as fecha, valor as totalGrl, (-1*(valor-aplicado)) as total, "0" as iva, concepto as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "RECIBO DE CAJA" as reciegre , "notaCreditoDeudores" as imprimir, idunico as idunicoDoc FROM financial_notes WHERE tercero ='.$_GET["cliente"].' AND (valor - aplicado) >0 AND tipo=4
                UNION
                SELECT 9 as tipodocumento, CONCAT(tipo, " - ", id) as tiponum, fecha as fecha, vaplicar as totalGrl, (-1*(vaplicar-aplicado)) as total, "0" as iva, nota as observaciones,  aplicado as valaplica, "0" as aplicahoy, "" as docref, id as id, "0" as iddoc, "0" as iter, "0" as idunico, "0" as docref, "0" as cliente, "0" as nota, "0" as subtotal, "0" as descuento, "0" as retencion, "0" as vaplicar, "0" as tdebito, "0" as tcredito, "0" as valhoy, "RECIBO DE CAJA" as reciegre, "abonosVentas" as imprimir, idunico as idunicoDoc  FROM financial_receipt_exit WHERE idtercero ='.$_GET["cliente"].' AND (vaplicar - aplicado) >0 AND abono=1
                ';
                $invoice = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                for ($i = 0; $i < count($invoice); $i++) {
                    
                    if($invoice[$i]["totalGrl"]<0)
                    {
                        $total = $invoice[$i]["totalGrl"]*-1;
                    }
                    else
                    {
                        $total = $invoice[$i]["totalGrl"];
                    }
                    if($invoice[$i]["total"]<0)
                    {
                        $invoice[$i]["total2"] = $invoice[$i]["total"]*-1;
                    }
                    else
                    {
                        $invoice[$i]["total2"] = $invoice[$i]["total"];
                    }
                    $difFecha = Utils::dias_transcurridos_entre_fechas($invoice[$i]["fecha"], date("Y-m-d"));
                    $invoice[$i]["diferenciaDias"]=$difFecha;    
                    $invoice[$i]["aplicaHoy"]="<label id='lbl".$i."'>0</label>";
                }

                array_push($retorno, $invoice);
                array_push($retorno, $clientes);
                echo json_encode($retorno);
            }
            if(preg_match("/buscarFacturas\//", $resource, $matches)){
                $sql="SELECT * FROM invoice_head WHERE idcliente='".$_GET["cliente"]."' AND estado =1";
                $cotizaciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($cotizaciones);
            }
            if(preg_match("/buscarFacturasCompra\//", $resource, $matches)){
                $sql="SELECT fc.*, (SELECT SUM(cantidad) FROM shopping_suppliers_bills_details WHERE idunico= fc.idunico) as totalcantidad, (SELECT CONCAT(nom_rep_leg, ' ', ape_rep_leg) FROM general_third WHERE id = fc.idproveedor) as cliente, (SELECT raz_soc FROM general_third WHERE id = fc.idproveedor) as raz_soc  FROM shopping_suppliers_bills fc WHERE idproveedor='".$_GET["cliente"]."' AND estado =1 AND total_fact - aplicado >0";
                if($_GET["num"]!="")
                {
                    $sql.=" AND fc.id=".$_GET["num"];
                }
                else if($_GET["fec_ini"]!="" && $_GET["fec_fin"]!="")
                {
                    $sql.=" AND fc.fec_creacion BETWEEN '".Utils::formato_fecha_normal_a_sql($_GET["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_GET["fec_fin"])."'";
                }
                $cotizaciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($cotizaciones);
            }
            if(preg_match("/buscarFacturasPOS\//", $resource, $matches)){
                if($_GET["numero"]!="")
                {
                    if($_GET["datos_usuario"]["permisos"]==1)
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE  numfactura=".$_GET["numero"];
                            $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                    }
                    else
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE vendedor='".$_GET["datos_usuario"]["codigo"]."' AND  numfactura=".$_GET["numero"];
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));		
                    }
                    
                }
                if($_GET["mes"]!=0 && $_GET["numero"]=="")
                {
                    if($_GET["datos_usuario"]["permisos"]==1)
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE MONTH(fecha) =".$_GET["mes"];
                        if($_GET["estado"]!=0)
                        {
                            $sql.=" AND estado=".$_GET["estado"];
                        }
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                    }
                    else
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE vendedor='".$_GET["datos_usuario"]["codigo"]."' AND MONTH(fecha) =".$_GET["mes"];
                        if($_GET["estado"]!=0)
                        {
                            $sql.=" AND estado=".$_GET["estado"];
                        }
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                    }
                        
                }
                if($_GET["busqueda"]=="hoy")
                {
                    if($_GET["datos_usuario"]["permisos"]==1)
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE uniqueid_closed=''";
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));		
                    }
                    else
                    {
                        $sql="SELECT *, IF(estado=1,'PAGADA', 'CANCELADA') as state FROM invoice_head_pos WHERE vendedor ='".$_GET["datos_usuario"]["codigo"]."' AND uniqueid_closed=''";
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));			
                    }
                }
                if($_GET["busqueda"]=="pro")
                {
                    $sql="SELECT (SELECT nombre FROM general_products_services WHERE idunico=idProducto) as producto, sum(cantidad) as cantidad, sum(vtotal) as total FROM invoice_details_pos WHERE uniqueid_closed='' GROUP BY idProducto ORDER BY sum(cantidad) DESC LIMIT 0,20";
                    $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));		
                }
                if($_GET["busqueda"]=="ventaDia")
                {
                    if($_GET["datos_usuario"]["permisos"]==1)
                    {
                        $sql="SELECT sum(totaltotales) as total FROM invoice_head_pos WHERE uniqueid_closed='' AND estado=1";
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));		
                    }
                    else
                    {
                        $sql="SELECT sum(totaltotales) as total FROM invoice_head_pos WHERE uniqueid_closed='' AND estado=1 AND vendedor='".$_GET["datos_usuario"]["codigo"]."'";
                        $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));			
                    }
                }

                echo json_encode($retorno);
            }
            if(preg_match("/buscarOrdenesCompra\//", $resource, $matches)){
                $sql="SELECT o.id as id,  p.raz_soc as proveedor, o.fecha as fecha, o.hora as hora,  b.descripcion as bodega, o.totales as total 
                FROM purchase_orders o
                LEFT JOIN general_third p ON o.proveedor = p.id 
                LEFT JOIN general_bodega b ON o.bodega = b.id WHERE o.estado=1";
                $ordenes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                echo json_encode($ordenes);
            }
            if(preg_match("/buscarPedido\//", $resource, $matches)){
                $sql="SELECT * FROM order_head WHERE id='".$_GET["id"]."'";
                $pedido = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT p.codigo as codigo, p.codigo_barras as codbar, p.nombre as nombre, p.nombre_comercial as comercial, "
                        . "(SELECT `text` FROM general_params WHERE grupo='laboratorios' AND `value`=p.laboratorio) as lab, (SELECT CONCAT(raz_soc, ' - ', nom_rep_leg, ' ', ape_rep_leg) FROM general_third WHERE id=(SELECT idCliente FROM order_head WHERE idunico=o.idunico)) as cliente, (SELECT id FROM order_head WHERE idunico=o.idunico) as numpedido,  o.cantidad as cantidad, '0' as despachada, o.cantidad as faltante, o.pneto as valor,"
                        . " o.iva as iva, o.id as idpedido, '0' as totcant, '0' as totneto, '0' as totalGrl, o.id as idOrdenDetalle, p.id as idProducto  FROM order_details o LEFT JOIN general_products_services p ON o.idProducto = p.id WHERE o.idunico='".$pedido[0]["idunico"]."' ORDER BY p.laboratorio, p.nombre ";
                $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
            }
            if(preg_match("/buscarPedidoFacturar\//", $resource, $matches)){
                $sql="SELECT * FROM order_head WHERE idCliente='".$_GET["cliente"]."' AND estado =1";
                $cotizaciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($cotizaciones);
            }
            if(preg_match("/buscarProducto\//", $resource, $matches)){
                $sql="SELECT * FROM general_products_services WHERE id='".$_GET["producto"]."'";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT cantidad FROM general_stock_products WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$_GET["bodega"]."'";
                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["laboratorio"]."' AND grupo='laboratorios'";
                $laboratorio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["presentacion"]."' AND grupo='presentaciones'";
                $presentacion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT * FROM general_tax WHERE id='".$producto[0]["idIva"]."'";
                $impuestos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $retorno["stock"]=$stock;
                $retorno["laboratorio"]=$laboratorio;
                $retorno["presentacion"]=$presentacion;
                $retorno["producto"]=$producto;
                $retorno["impuestos"]=$impuestos;

                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductos\//", $resource, $matches)){
                if($_GET["buscar"]!="")
                {
                    $donde="CONCAT(codigo, ' ', nombre, ' ', nombre_comercial) like '%".$_GET["buscar"]."%'";
                }
                else
                {
                    $donde="estado=1";
                }
                $donde.=" ORDER BY id";
                $sql=consulta::seleccionar("*","general_products_services gps", $donde);
                $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));  
                echo json_encode($productos);
            }
            if(preg_match("/buscarProductosFacturaVenta\//", $resource, $matches)){
                $sql="SELECT * FROM general_third WHERE id='".$_GET["cliente"]."'";
                $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql='SELECT p.*,
                    IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo="presentaciones"), "") as nom_prese, 
                    IFNULL((SELECT text FROM general_params WHERE `value`=laboratorio AND grupo="laboratorios"),"") as nom_lab, 
                    IFNULL((SELECT porc_impu FROM general_tax WHERE id=p.idIva),0) as nom_iva, 
                    IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as cantidad, 
                    IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as solicitada, 
                    IFNULL(((IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))-(IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))),0) as disponible, 
                    IFNULL((SELECT precio_compra FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].'),0) as costo,
                    IFNULL((SELECT idunico FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'" ),(SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].')) as valorventa,
                    "0" as total, (SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as cant, "0" as totcantidad, "0" as totneto,"0" as tottotales, 
                    (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo="laboratorios") as nomlab FROM general_products_services p  WHERE p.estado=1 AND  p.oferta="" ' ;
                    if($_GET["busqueda"]!="")
                    {
                        $sql .=" AND CONCAT(p.codigo, ' ', p.nombre,' ', p.nombre_comercial) LIKE '%".$_GET["busqueda"]."%'";     
                    }
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductoInventario\//", $resource, $matches)){
                $sql='SELECT p.*,
                IFNULL((SELECT text FROM general_params WHERE `value`=laboratorio AND grupo="laboratorios"),"") as nom_lab, 
                IFNULL((SELECT porc_impu FROM general_tax WHERE id=p.idIva),0) as nom_iva, 
                IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as cantidad, 
                IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as solicitada, 
                IFNULL(((IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))-(IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))),0) as disponible, "0" as sol2, "0" as total, (SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="0" AND usuario="'.$_GET["datos_usuario"]["codigo"].'") as cant, (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo="laboratorios") as nomlab, (p.p_costo*(SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="0" AND usuario="'.$_GET["datos_usuario"]["codigo"].'")) as totLbl, (p.p_costo*(SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="0" AND usuario="'.$_GET["datos_usuario"]["codigo"].'")) as total FROM general_products_services p ';
                if($_GET["busqueda"]!="")
                {
                    $sql .=" WHERE CONCAT(p.codigo, ' ', p.nombre,' ', p.nombre_comercial, ' ', codigo_barras) LIKE '%".$_GET["busqueda"]."%'";     
                }
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductoOrdenCompra\//", $resource, $matches)){
                $productos = array();
                $stocks = array();
                $laboratorios = array();
                $presentaciones = array();
                $impuestos = array();


                $sql="SELECT * FROM purchase_orders WHERE id='".$_GET["id"]."'";
                $pedidoCabecera = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT * FROM purchase_orders_details WHERE idunico='".$pedidoCabecera[0]["idunico"]."'";
                $pedidoCuerpo = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT * FROM general_third WHERE id='".$pedidoCabecera[0]["proveedor"]."'";
                $proveedor = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));


                for($i=0;$i<count($pedidoCuerpo);$i++)
                {
                    $sql="SELECT * FROM general_products_services WHERE id='".$pedidoCuerpo[$i]["idproducto"]."'";
                    $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    array_push($productos, $producto);
                    $sql="SELECT cantidad FROM general_stock_products WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$pedidoCabecera[0]["bodega"]."'";
                    $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    array_push($stocks, $stock);
                    $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["laboratorio"]."' AND grupo='laboratorios'";
                    $laboratorio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    array_push($laboratorios, $laboratorio);
                    $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["presentacion"]."' AND grupo='presentaciones'";
                    $presentacion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    array_push($presentaciones, $presentacion);
                    $sql="SELECT * FROM general_tax WHERE id='".$producto[0]["idIva"]."'";
                    $impuesto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    array_push($impuestos, $impuesto);
                }
                $retorno["cabecera"]=$pedidoCabecera;
                $retorno["cuerpo"]=$pedidoCuerpo;
                $retorno["stock"]=$stocks;
                $retorno["laboratorio"]=$laboratorios;
                $retorno["presentacion"]=$presentaciones;
                $retorno["producto"]=$productos;
                $retorno["impuestos"]=$impuestos;
                $retorno["proveedor"]=$proveedor;

                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductosSugeridos\//", $resource, $matches)){
                $sql="SELECT * FROM general_products_services WHERE codigo_barras='".$_GET["producto"]."'";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT cantidad FROM general_stock_products WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$_GET["bodega"]."'";
                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["laboratorio"]."' AND grupo='laboratorios'";
                $laboratorio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT value as id, text as nombre FROM general_params WHERE value='".$producto[0]["presentacion"]."' AND grupo='presentaciones'";
                $presentacion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT * FROM general_tax WHERE id='".$producto[0]["idIva"]."'";
                $impuestos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                $retorno["stock"]=$stock;
                $retorno["laboratorio"]=$laboratorio;
                $retorno["presentacion"]=$presentacion;
                $retorno["producto"]=$producto;
                $retorno["impuestos"]=$impuestos;

                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductoVenta\//", $resource, $matches)){
                $sql="SELECT * FROM general_third WHERE id='".$_GET["cliente"]."'";
                $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));


                    $sql='SELECT p.*,
                    IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo="presentaciones"), "") as nom_prese, 
                    IFNULL((SELECT porc_impu FROM general_tax WHERE id=p.idIva),0) as nom_iva, 
                    IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["datos_usuario"]["idalmacen"].' ),0) as cantidad,
                    IFNULL((SELECT idunico FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'"),(SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].')) as valorventa,
                    (SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].') as valorventa2,
                    "0" as total, 
                    (SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as cant,     
                    (SELECT token FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as token, 
                    "0" as totcantidad, "0" as totneto,"0" as tottotales
                    FROM general_products_services p  WHERE p.estado=1 AND p.oferta="" ' ;
                    if($_GET["busqueda"]!="")
                    {
                        $sql .=" AND CONCAT(p.codigo, ' ', p.nombre,' ', p.nombre_comercial, ' ',codigo_barras) LIKE '%".$_GET["busqueda"]."%'";     
                    }
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductoVentaenTemporal\//", $resource, $matches)){
                $sql="SELECT * FROM general_third WHERE id='".$_GET["cliente"]."'";
                $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    $sql='SELECT p.*,
                    IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo="presentaciones"), "") as nom_prese, 
                    IFNULL((SELECT text FROM general_params WHERE `value`=laboratorio AND grupo="laboratorios"),"") as nom_lab, 
                    IFNULL((SELECT porc_impu FROM general_tax WHERE id=p.idIva),0) as nom_iva, 
                    IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as cantidad, 
                    IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as solicitada, 
                    IFNULL(((IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))-(IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))),0) as disponible, 
                    IFNULL((SELECT precio_compra FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].'),0) as costo,
                    IFNULL((SELECT idunico FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'"),(SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].')) as valorventa,
                    (SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$cliente[0]["listaprecios"].') as valorventa2,
                    "0" as total, 
                    (SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as cant, 
                    (SELECT descuento FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as descuento, 
                    (SELECT token FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'") as token, 
                    "0" as totcantidad, "0" as totneto,"0" as tottotales, 
                    (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo="laboratorios") as nomlab FROM general_products_services p  WHERE p.oferta="" AND p.codigo_barras IN (SELECT producto FROM general_temporal WHERE tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'" ) ' ;
                    if($_GET["busqueda"]!="")
                    {
                        $sql .=" AND CONCAT(p.codigo, ' ', p.nombre,' ', p.nombre_comercial, ' ',codigo_barras) LIKE '%".$_GET["busqueda"]."%'";     
                    }
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarProductoVentaPOS\//", $resource, $matches)){
                $sql="SELECT * FROM general_third WHERE id='".$_GET["cliente"]."'";
                $cliente = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql='SELECT p.*,
                IFNULL((SELECT text FROM general_params WHERE `value`=presentacion AND grupo="presentaciones"), "") as nom_prese, 
                IFNULL((SELECT porc_impu FROM general_tax WHERE id=p.idIva),0) as nom_iva, 
                IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as cantidad, 
                IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0) as solicitada, 
                IFNULL(((IFNULL((SELECT cantidad FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))-(IFNULL((SELECT pedido FROM general_stock_products WHERE id_producto=idunico AND id_almacen='.$_GET["bodega"].' ),0))),0) as disponible, 
                IFNULL((SELECT precio_compra FROM general_price_list_products WHERE producto = p.id AND lista='.$_GET["listap"].'),0) as costo,
                IFNULL((SELECT precio_venta_iva FROM general_price_list_products WHERE producto = p.id AND lista='.$_GET["listap"].'),0) as valorventa,
                "0" as total, (SELECT cantidad FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'" AND idunico="'.$_GET["idunico"].'") as cant,
                (SELECT descuento FROM general_temporal WHERE producto = p.codigo_barras AND tipo="'.$_GET["tipo"].'" AND cliente="'.$_GET["cliente"].'" AND idunico="'.$_GET["idunico"].'") as descuento, 
                "0" as totcantidad, "0" as totneto,"0" as tottotales, 
                (SELECT text FROM general_params WHERE value=p.laboratorio AND grupo="laboratorios") as nomlab FROM general_products_services p  WHERE p.oferta="" ';
                $sql .=" AND codigo_barras IN (SELECT producto FROM general_temporal WHERE producto = p.codigo_barras AND tipo='".$_GET["tipo"]."' AND cliente='".$_GET["cliente"]."' AND idunico='".$_GET["idunico"]."')";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarProveedor\//", $resource, $matches)){
                $donde="id=".$_GET["proveedor"];
                $datos[0]="*";
                $sql= consulta::seleccionar($datos,"general_third", $donde);
                $proveedor= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($proveedor);
            }
            if(preg_match("/buscarRemisionFacturar\//", $resource, $matches)){
                $sql="SELECT * FROM referrals_head WHERE idCliente='".$_GET["cliente"]."' AND estado =1";
                $cotizaciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($cotizaciones);
            }
            if(preg_match("/buscarStockProducto\//", $resource, $matches)){
                $sql="SELECT * FROM general_stock_products WHERE id_producto='".$_GET["producto"]."'";
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarStockProductos\//", $resource, $matches)){
                $sql="SELECT p.*, s.cantidad, (p.p_costo*s.cantidad) as total FROM general_products_services p LEFT JOIN general_stock_products s ON p.idunico = s.id_producto";
                if(isset($_GET["busqueda"]))
                {
                    $sql.=" WHERE CONCAT(p.codigo, ' ', p.nombre, ' ', p.nombre_comercial, ' ', p.codigo_barras) LIKE '%".$_GET["busqueda"]."%' OR idunico IN(SELECT idunico FROM general_products_services_barcode WHERE barcode ='".$_GET["busqueda"]."')";
                }

                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($stock);
            }
            if(preg_match("/buscarSugeridoOrdenCompra\//", $resource, $matches)){
                $sql="SELECT * FROM general_temporal WHERE cliente = ".$_GET["cliente"]." AND tipo='SC' AND usuario=".$_GET["datos_usuario"]["codigo"];
                $retorno = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarTemporalFacturaCompra\//", $resource, $matches)){
                $sql="SELECT * FROM general_temporal WHERE cliente ='".$_GET["cliente"]."' AND tipo='FC'";
                $retorno= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $tempData=$retorno[0]["temp"];
                echo json_encode($tempData);
            }
            if(preg_match("/buscarUsuarios\//", $resource, $matches)){
                $retorno = array();
                $sql="SELECT iduser, Nombre FROM usuario";
                $bodegas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($bodegas);
            }
            if(preg_match("/buscarStockCostoProducto\//", $resource, $matches)){
                $sql="SELECT * FROM general_products_services WHERE id='".$_GET["producto"]."'";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT cantidad FROM general_stock_products WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$_GET["datos_usuario"]["idalmacen"]."'";
                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $retorno["producto"]=$producto;
                $retorno["stock"]=$stock[0]["cantidad"];
                $retorno["costo"]=$producto[0]["p_costo"];
                $retorno["cantidad"]="";
                echo json_encode($retorno);
            }
            if(preg_match("/buscarTodoslosProductos\//", $resource, $matches)){
                $sql="SELECT codigo_barras, id, nombre FROM general_products_services LIMIT 1, 20";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                for ($i=0; $i < count($producto); $i++) { 
                    $producto[i]["nombre"]=utf8_encode($producto[i]["nombre"]);
                }
                echo json_encode($producto);
            }
            if(preg_match("/buscarBodegas\//", $resource, $matches)){
                $sql="SELECT id, descripcion FROM general_bodega";
                $bodegas = Utils::preparar_datos_consulta_combo(consulta::convertir_a_array(consulta::ejecutar_consulta($sql)));
                echo json_encode($bodegas);
            }
            if(preg_match("/reporteDocumentos\//", $resource, $matches)){
                $doc = "shopping_suppliers_bills-FACTURA DE COMPRA-quotation_head-COTIZACIONES-referrals_head-REMISIONES-invoice_head-FACTURAS-invoice_head_pos-FACTURAS POS";

                if(isset($_POST["fec_ini"]))
                {
                    switch ($_POST["documento"]) {
                        case 'shopping_suppliers_bills':
                            $sql="SELECT *, (total_fact-aplicado) as debe,(SELECT raz_soc FROM general_third c WHERE c.id=idproveedor) as cliente FROM shopping_suppliers_bills WHERE estado=1 AND fec_creacion BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idproveedor='".$_POST["tercero"]."'";
                            }
                            if($_POST["pendiente"]==2)
                            {
                                $sql.=" AND total_fact-aplicado!=0";
                            }
                            if($_POST["pendiente"]==1)
                            {
                                $sql.=" AND total_fact-aplicado=0";
                            }
                            $sql.=" ORDER BY idproveedor ASC";
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	   		
                        break;
                        case 'quotation_head':
                            $sql="SELECT *, (SELECT raz_soc FROM general_third c WHERE c.id=idcliente) as cliente FROM quotation_head WHERE estado=1 AND fecha BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idcliente='".$_POST["tercero"]."'";
                            }	 
                            $sql.=" ORDER BY idcliente ASC";   				
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                        break;
                        case 'order_head':
                            $sql="SELECT *, (SELECT raz_soc FROM general_third c WHERE c.id=idcliente) as cliente FROM order_head WHERE estado=1 AND fecha BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idcliente='".$_POST["tercero"]."'";
                            }
                            $sql.=" ORDER BY idcliente ASC";   
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                        break;
                        case 'referrals_head':
                            $sql="SELECT *, (SELECT raz_soc FROM general_third c WHERE c.id=idcliente) as cliente FROM referrals_head WHERE estado=1 AND fecha BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idcliente='".$_POST["tercero"]."'";
                            }	    			
                            $sql.=" ORDER BY idcliente ASC";   
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                            
                        break;
                        case 'invoice_head':
                            $sql="SELECT *, (totaltotales-aplicado) as debe,(SELECT raz_soc FROM general_third c WHERE c.id=idcliente) as cliente FROM invoice_head WHERE estado=1 AND fecha BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idcliente='".$_POST["tercero"]."'";
                            }
                            if($_POST["pendiente"]==2)
                            {
                                $sql.=" AND totaltotales-aplicado!=0";
                            }
                            if($_POST["pendiente"]==1)
                            {
                                $sql.=" AND totaltotales-aplicado=0";
                            }
                            $sql.=" ORDER BY idcliente ASC";   
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	   		
                        break;
                        case 'invoice_head_pos':
                            $sql="SELECT *, (SELECT raz_soc FROM general_third c WHERE c.id=idcliente) as cliente FROM invoice_head_pos WHERE estado=1 AND fecha BETWEEN '".Utils::formato_fecha_normal_a_sql($_POST["fec_ini"])."' AND '".Utils::formato_fecha_normal_a_sql($_POST["fec_fin"])."'";
                            if($_POST["tercero"]!="")
                            {
                                $sql.=" AND idcliente='".$_POST["tercero"]."'";
                            }
                            $sql.=" ORDER BY idcliente ASC";   
                            $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	    		
                                
                        break;
                    }
                    
                }
            }
            if(preg_match("/buscarBancos\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_bancos");
                $bancos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($bancos);
            }
            if(preg_match("/buscarBodegas\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_bodega");
                $bodegas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($bodegas);
            }
            if(preg_match("/buscarCondicionesPago\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_condicion_pago");
                $condicionp = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($condicionp);
            }
            if(preg_match("/buscarGrupos\//", $resource, $matches)){
                $datos[0]="*";
                $donde="grupo='grupo'";
                $sql=consulta::seleccionar($datos,"general_params", $donde);
                $grupos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($grupos);
            }
            if(preg_match("/buscarImpuestos\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_tax");
                $ivas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($ivas);
            }
            if(preg_match("/buscarLaboratorios\//", $resource, $matches)){
                $datos[0]="*";
                $donde="grupo='laboratorios'";
                $sql=consulta::seleccionar($datos,"general_params", $donde);
                $labs = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($labs);
            }
            if(preg_match("/buscarListasPrecios\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_price_list");
                $listprices = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($listprices);
            }
            if(preg_match("/buscarPresentaciones\//", $resource, $matches)){
                $datos[0]="*";
                $donde="grupo='presentaciones'";
                $sql=consulta::seleccionar($datos,"general_params", $donde);
                $presentacion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($presentacion);
            }
            if(preg_match("/buscarRutas\//", $resource, $matches)){
                $datos[0]="*";
                $donde="grupo='rutas'";
                $sql=consulta::seleccionar($datos,"general_params", $donde);
                $rutas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($rutas);
            }
            if(preg_match("/buscarTipoDocumentos\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_tip_doc");
                $tipo_doc = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($tipo_doc);
            }
            if(preg_match("/buscarVendedor\//", $resource, $matches)){
                $datos[0]="*";
                $donde="tipo=4";
                $sql=consulta::seleccionar($datos,"general_third", $donde);
                $vendedor = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($vendedor);
            }
            if(preg_match("/buscarClientes\//", $resource, $matches)){
                $datos[0]="*";
                $donde="tipo <=3";
            
                if($_POST["busqueda"]!="")
                {
                    $donde .=" AND CONCAT(num_ide, \" \",nom_rep_leg, \" \", ape_rep_leg, \" \", raz_soc) LIKE '%".$_POST["busqueda"]."%'";
                }
                $sql=consulta::seleccionar($datos,"general_third", $donde);
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($clientes);
            }
            if(preg_match("/buscarProveedores\//", $resource, $matches)){
                $datos[0]="*";
                $donde="tipo=2";
                $sql=consulta::seleccionar($datos,"general_third", $donde);
                $provedores = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($provedores);
            }
            if(preg_match("/buscarTransportistas\//", $resource, $matches)){
                $datos[0]="*";
                $donde="tipo=3";
                $sql=consulta::seleccionar($datos,"general_third", $donde);
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($clientes);
            }
            if(preg_match("/buscarEmpresa\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar("*","general_enterprises",'1');
                $miempresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($miempresa);
            }
            if(preg_match("/ \//", $resource, $matches)){
                
            }
        break;
    
        case 'POST':
            if(preg_match("/abrirCaja\//", $resource, $matches)){
                $idunico = uniqid();
                $sql="UPDATE cashbox_moves SET state=2 WHERE tipo=1";
                consulta::ejecutar_consulta($sql);
                $move["idalmacen"]=$_POST["idalmacen"];
                $move["idvendedor"]=$_POST["codigo"];
                $move["tipo"]="2";
                $move["fecha"]=date("Y-m-d");
                $move["valor"]=$_POST["valBase"];
                $move["detalle"]="Apertura de Caja con fecha ".date("d/m/Y");
                $move["uniqueid_closed"]="";
                $move["state"]=1;
                $sql=consulta::insertar($move, "cashbox_moves");
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/actualizarDescuento\//", $resource, $matches)){
                $des["descripcion"]=$_POST["descripcion"];
                $des["porcentaje"]=$_POST["porcentaje"];
                $des["categoria"]=$_POST["categoria"];
                $des["fec_fin"]=Utils::formato_fecha_normal_a_sql($_POST["fec_fin"]);
                $des["estado"]=$_POST["estado"];
                $donde="id='".$_POST["id"]."'";
                consulta::ejecutar_consulta(consulta::actualizar($des, "general_discounts", $donde));
            }
            if(preg_match("/agregarMezcla\//", $resource, $matches)){
                for ($i=0; $i < count($_POST["datos"]); $i++) { 
                    $datos["id_mixture"]=$_POST["datos"][$i]["id_mixture"];
                    $datos["id_product"]=$_POST["datos"][$i]["id_product"];
                    $datos["nom_producto"]=$_POST["datos"][$i]["nom_producto"];
                    $datos["cant"]=$_POST["datos"][$i]["cant"];
                    consulta::ejecutar_consulta(consulta::insertar($datos, "general_products_services_mixtures"));
                }
            }
            if(preg_match("/agregarSalidaCaja\//", $resource, $matches)){
                $move["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                $move["idvendedor"]=$_POST["datos_usuario"]["codigo"];
                $move["tipo"]="3";
                $move["fecha"]=date("Y-m-d");
                $move["valor"]=$_POST["valor"];
                $move["detalle"]=$_POST["detalle"].", Salida realizada por usuario: ".$_POST["datos_usuario"]["codigo"]." con fecha ".date(Y-m-d);
                $move["uniqueid_closed"]=$idunico;
                $move["state"]=2;
                $sql=consulta::insertar($move, "cashbox_moves");
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/agregarCodigoBarras\//", $resource, $matches)){
                $barcode["idunico"]=$_POST["producto"];
                $barcode["barcode"]=$_POST["barcode"];
                consulta::ejecutar_consulta(consulta::insertar($barcode, "general_products_services_barcode"));
            }
            if(preg_match("/eliminarCodigoBarras\//", $resource, $matches)){
                $sql="DELETE FROM general_products_services_barcode WHERE id='".$_POST["id"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/eliminarProducto\//", $resource, $matches)){
                $sql="DELETE FROM general_products_services WHERE id=".$_POST["id"];
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/eliminarTemporal\//", $resource, $matches)){
                $sql="DELETE FROM general_temporal WHERE tipo = '".$_POST["tipo"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/actualizarCodigoBarrasProducto\//", $resource, $matches)){
                $sql="UPDATE general_products_services SET `codigo_barras` = '".$_POST["codbar"]."' WHERE `id` = '".$_POST["id"]."';";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/actualizarUsuarioPedido\//", $resource, $matches)){
                echo $sql="UPDATE order_head SET atendio='".$_POST["atendio"]."', nomatendio='".$_POST["nomatendio"]."' WHERE id='".$_POST["id"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/cancelarDocumento\//", $resource, $matches)){
                switch ($_POST["tipo"]) {
                    case '1':
                        $sql="UPDATE invoice_head SET estado=3 WHERE idunico='".$_POST["id"]."'";
                        consulta::ejecutar_consulta($sql);
                        
                    break;
                    case '11':
                        $sql="UPDATE referrals_head SET estado=3 WHERE id='".$_POST["id"]."'";
                        consulta::ejecutar_consulta($sql);
                        $sql="SELECT idunico FROM referrals_head WHERE id='".$_POST["id"]."'";
                        $remision = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        
                        $sql="SELECT * FROM referrals_details WHERE idunico='".$remision[0]["idunico"]."'";
                        $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        for ($i=0; $i < count($productos); $i++) { 
                            $sql="SELECT * FROM general_products_services WHERE id='".$productos[$i]["idProducto"]."'";
                            $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                            $sql="UPDATE general_stock_products SET cantidad = cantidad + ".$productos[$i]["cantidad"]." WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$_POST["datos_usuario"]["idalmacen"]."'";		
                            consulta::ejecutar_consulta($sql);
                        }
                    break;
                    case '5':
                        $sql="UPDATE shopping_suppliers_bills SET estado=3 WHERE idunico='".$_POST["id"]."'";
                        consulta::ejecutar_consulta($sql);
                        $sql="SELECT * FROM shopping_suppliers_bills_details WHERE idunico='".$_POST["id"]."'";
                        $productos = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        for ($i=0; $i < count($productos); $i++) { 
                            $sql="SELECT * FROM general_products_services WHERE id='".$productos[$i]["id_producto"]."'";
                            $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                            $sql="UPDATE general_stock_products SET cantidad = cantidad - ".$productos[$i]["cantidad"]." WHERE id_producto='".$producto[0]["idunico"]."' AND id_almacen='".$_POST["datos_usuario"]["idalmacen"]."'";
                            consulta::ejecutar_consulta($sql);
                        }
                    break;
                }
            }
            if(preg_match("/cancelarFacturaPOS\//", $resource, $matches)){
                $sql="SELECT * FROM invoice_head_pos WHERE idunico='".$_POST["idunico"]."'";
                $head = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	
                $sql="SELECT * FROM invoice_details_pos WHERE idunico='".$_POST["idunico"]."'";
                $details = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));	

                for($i=0; $i<count($details);$i++)
                {
                    $sql="UPDATE general_stock_products SET cantidad=cantidad+".$details[$i]["cantidad"]." WHERE id_producto ='".$details[$i]["idProducto"]."' AND id_almacen='".$_POST["datos_usuario"]["idalmacen"]."'";
                    consulta::ejecutar_consulta($sql);
                }

                $sql="UPDATE invoice_head_pos SET estado=2 WHERE idunico='".$_POST["idunico"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/cerrarCaja\//", $resource, $matches)){
                $idunico = uniqid();
                $sql="UPDATE cashbox_moves SET state=2, uniqueid_closed='".$idunico."' WHERE tipo=2 AND uniqueid_closed=''";
                consulta::ejecutar_consulta($sql);

                $sql="UPDATE cashbox_moves SET state=2, uniqueid_closed='".$idunico."' WHERE tipo=3 AND uniqueid_closed=''";
                consulta::ejecutar_consulta($sql);

                //Se cierran las formas de pago con base a las cabeceras
                $sql="UPDATE invoice_payment_form_pos SET uniqueid_closed='".$idunico."'  WHERE idinvoice IN (SELECT idunico FROM invoice_head_pos WHERE uniqueid_closed='' AND vendedor='".$_POST["datos_usuario"]["codigo"]."') ";
                consulta::ejecutar_consulta($sql);

                //Se cierran los detalles con base a las cabeceras
                $sql="UPDATE invoice_details_pos SET uniqueid_closed='".$idunico."'  WHERE idunico IN (SELECT idunico FROM invoice_head_pos WHERE uniqueid_closed='' AND vendedor='".$_POST["datos_usuario"]["codigo"]."') ";
                consulta::ejecutar_consulta($sql);

                //Se toma el valor de cierre
                $sql="SELECT sum(totaltotales) as total FROM invoice_head_pos WHERE uniqueid_closed='' AND estado=1 AND vendedor='".$_POST["datos_usuario"]["codigo"]."'";
                $valor = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));		

                //SE cierran las cabeceras
                $sql="UPDATE invoice_head_pos SET uniqueid_closed='".$idunico."' WHERE uniqueid_closed='' AND vendedor='".$_POST["datos_usuario"]["codigo"]."'";
                consulta::ejecutar_consulta($sql);

                //Se sienta el movimiento en la caja
                $move["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                $move["idvendedor"]=$_POST["datos_usuario"]["codigo"];
                $move["tipo"]="1";
                $move["fecha"]=date("Y-m-d");
                $move["valor"]=$valor[0]["total"];
                $move["detalle"]="Cierre de Caja con fecha ".date("d/m/Y");
                $move["uniqueid_closed"]=$idunico;
                $move["state"]=1;
                $sql=consulta::insertar($move, "cashbox_moves");
                consulta::ejecutar_consulta($sql);

                $sql="DELETE FROM general_temporal WHERE usuario = '".$_POST["datos_usuario"]["codigo"]."' AND tipo='FP'";
                consulta::ejecutar_consulta($sql);
                echo $idunico;
            }
            if(preg_match("/eliminaMezcla\//", $resource, $matches)){
                $sql="DELETE FROM general_products_services_mixtures WHERE id_mixture=".$_POST["id_mixture"];
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/eliminarTemporalFacturaCompra\//", $resource, $matches)){
                $sql="DELETE FROM general_temporal WHERE cliente='".$_POST["cliente"]."' AND tipo='FC'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/eliminarTemporalFormaPago\//", $resource, $matches)){
                $sql="DELETE FROM invoice_payment_form_pos_temp WHERE idinvoice='".$_POST["idunico"]."' AND forma_pago='".$_POST["formapago"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/guardarCotizacionDetalle\//", $resource, $matches)){
                $postDetalle["idunico"]=$_POST["idunico"];
                $postDetalle["idProducto"]=$_POST["id"];
                $postDetalle["cantidad"]=$_POST["cant"];
                $postDetalle["pcosto"]=$_POST["costo"];
                $postDetalle["pneto"]=$_POST["valorventa"];
                $postDetalle["desc1"]=$_POST["descuento"];
                $postDetalle["incremento"]=$_POST["incremento"];
                $postDetalle["vtotal"]=$_POST["total"];
                $postDetalle["iva"]=$_POST["nom_iva"];
                consulta::ejecutar_consulta(consulta::insertar($postDetalle, "quotation_details"));
                
                
                $post["idunico"]=$_POST["idunico"];
                $post["fecha"]=date("Y-m-d");
                $post["hora"]=date("G:H:s");
                
                
                $sql="SELECT * FROM general_third WHERE id='".$_POST["cliente"]."'";
                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                $sql="SELECT * FROM quotation_head WHERE idunico ='".$post["idunico"]."'";
                $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                if(count($ver)==0)
                {
                    $post["idCliente"]=$_POST["cliente"];
                    $post["vendedor"]=$cli[0]["vendedor"];
                    $post["tipo"]="";
                    $post["cpago"]=$cli[0]["condicion_pago"];
                    $post["bodega"]=$_POST["datos_usuario"]["idalmacen"];
                    $post["observaciones"]=$_POST["observaciones"];
                    $post["estado"]=1;
                    $post["totalcantidad"]=$_POST["cant"];
                    $post["totalneto"]=$_POST["valorventa"];
                    $post["totaltotales"]=$_POST["total"];
                    consulta::ejecutar_consulta(consulta::insertar($post, "quotation_head"));
                }
                else
                {
                    $sql="UPDATE quotation_head SET totalcantidad=totalcantidad+".$_POST["cant"].", totalneto=totalneto+".$_POST["valorventa"].", totaltotales=totaltotales+".$_POST["total"]." WHERE idunico='".$_POST["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                }
                
                $sql="DELETE FROM general_temporal where tipo ='CC'";
                consulta::ejecutar_consulta($sql);
                
                echo $_POST["idunico"];
            }
            if(preg_match("/guardarDescuento\//", $resource, $matches)){
                $des["descripcion"]=$_POST["descripcion"];
                $des["porcentaje"]=$_POST["porcentaje"];
                $des["categoria"]=$_POST["categoria"];
                $des["fec_fin"]=Utils::formato_fecha_normal_a_sql($_POST["fec_fin"]);
                $des["estado"]=1;
                $des["fec_ini"]=date("Y-m-d");
                var_dump($des);
                consulta::ejecutar_consulta(consulta::insertar($des, "general_discounts"));
            }
            if(preg_match("/guardarDevolucionCompra\//", $resource, $matches)){
                $sql="SELECT * FROM shopping_suppliers_bills WHERE idunico = '".$_POST["idunico"]."'";
                $factura = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                //exit(var_dump($factura));
                
                $sql="SELECT * FROM general_third WHERE id='".$factura[0]["idproveedor"]."'";
                $proveedor = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT * FROM purchase_devolution_head WHERE idunico='".$_POST["idunicodevolucion"]."'";
                $verifica = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $neto = intval($_POST["total"]);
                $total = intval($_POST["total"]);
                
                if(count($verifica)>0)
                {
                    $sql="UPDATE purchase_devolution_head SET canttotal = canttotal + ".$_POST["cdevolver"].", netos =  netos + ".$neto.", totales= totales + ".$total.", iva = iva+".intval($_POST["iva"])." WHERE idunico='".$_POST["idunicodevolucion"]."'";    
                    consulta::ejecutar_consulta($sql);
                }
                else
                {
                    $devHead["idunico"]=$_POST["idunicodevolucion"];
                    $devHead["fecha"]=date("d/m/Y");
                    $devHead["hora"]=date("G:H:s");
                    $devHead["numfactura"]=$factura[0]["id"];
                    $devHead["idcliente"]=$factura[0]["idproveedor"];
                    $devHead["cpago"]=$proveedor[0]["term_pago"];
                    $devHead["bodega"]=$factura[0]["idalmacen"];
                    $devHead["observaciones"]=$_POST["observaciones"];
                    $devHead["estado"]=1;
                    $devHead["tipo"]="DEVOLUCION DE COMPRA";
                    $devHead["canttotal"]=$_POST["cdevolver"];   
                    $devHead["netos"]=$neto;    
                    $devHead["totales"]=$total;
                    $iva = ($_POST["iva"]!=0)?"16":"0";
                    $devHead["iva"]=$iva;
                    
                    $sql = consulta::insertar($devHead, "purchase_devolution_head");    
                    consulta::ejecutar_consulta($sql);
                }
                
                $devBody["idunico"]=$_POST["idunicodevolucion"];
                $devBody["idProducto"]=$_POST["id_producto"];
                $devBody["cantdevolver"]=$_POST["cdevolver"];
                $devBody["cantvendida"]=$_POST["cvendidas"];
                $devBody["cantdisponible"]=$_POST["cdisponible"];
                $devBody["pcosto"]=ceil($_POST["pcosto"]);
                $devBody["desc1"]=$_POST["desc1"];
                $devBody["pneto"]=ceil($_POST["precio_uni"]);
                $valTotal = $neto;
                $devBody["vtotal"]=$valTotal;
                $iva = ($_POST["iva"]!=0)?"16":"0";
                $devBody["iva"]=$iva;
                
                $sql = consulta::insertar($devBody, "purchase_devolution_details");
                consulta::ejecutar_consulta($sql);
                
                $sql="UPDATE shopping_suppliers_bills_details SET devuelto = devuelto + ".$_POST["cdevolver"]." WHERE id=".$_POST["id"];
                consulta::ejecutar_consulta($sql);
                
                $sql="SELECT * FROM general_products_services WHERE id=".$_POST["id_producto"];
                $prod= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="UPDATE general_stock_products SET cantidad = cantidad + ".$_POST["cdevolver"]." WHERE id_producto='".$prod[0]["idunico"]."' AND id_almacen=".$factura[0]["idalmacen"];
                consulta::ejecutar_consulta($sql);
                $sql="UPDATE shopping_suppliers_bills SET estado=3 WHERE idunico='".$_POST["idunico"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/guardarDevolucionVenta\//", $resource, $matches)){
                    $sql="SELECT * FROM invoice_head WHERE idunico = '".$_POST["idunico"]."'";
                    $factura = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    
                    $sql="SELECT * FROM sales_devolution_head WHERE idunico='".$_POST["idunicodevolucion"]."'";
                    $verifica = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    
                    $neto = ceil($_POST["pcosto"])*$_POST["cdevolver"];
                    $total = $_POST["pneto"]*$_POST["cdevolver"];
                    //echo count($verifica);
                    if(count($verifica)>0)
                    {
                        $sql="UPDATE sales_devolution_head SET canttotal = canttotal + ".$_POST["cdevolver"].", netos =  netos + ".$neto.", totales= totales + ".$total.", iva = iva+".$_POST["iva"]." WHERE idunico='".$_POST["idunicodevolucion"]."'";
                        consulta::ejecutar_consulta($sql);
                    }
                    else
                    {
                        $devHead["idunico"]=$_POST["idunicodevolucion"];
                        $devHead["fecha"]=date("d/m/Y");
                        $devHead["hora"]=date("G:H:s");
                        $devHead["numfactura"]=$factura[0]["id"];
                        $devHead["idcliente"]=$factura[0]["idcliente"];
                        $devHead["vendedor"]=$factura[0]["vendedor"];
                        $devHead["cpago"]=$factura[0]["cpago"];
                        $devHead["bodega"]=$factura[0]["bodega"];
                        $devHead["observaciones"]=$_POST["observaciones"];
                        $devHead["estado"]=1;
                        $devHead["tipo"]="DEVOLUCION DE VENTA";
                        $devHead["canttotal"]=$_POST["cdevolver"];   
                        $devHead["netos"]=$neto;    
                        $devHead["totales"]=$total;
                        $devHead["iva"]=$_POST["iva"];
                        
                        $sql = consulta::insertar($devHead, "sales_devolution_head");
                        consulta::ejecutar_consulta($sql);
                    }
                    
                    $devBody["idunico"]=$_POST["idunicodevolucion"];
                    $devBody["idProducto"]=$_POST["idProducto"];
                    $devBody["cantdevolver"]=$_POST["cdevolver"];
                    $devBody["cantvendida"]=$_POST["cvendidas"];
                    $devBody["cantdisponible"]=$_POST["cdisponible"];
                    $devBody["pcosto"]=ceil($_POST["pcosto"]);
                    $devBody["desc1"]=$_POST["desc1"];
                    $devBody["pneto"]=ceil($_POST["pneto"]);
                    $valTotal = ceil($_POST["pneto"])*$_POST["cdevolver"];
                    $devBody["vtotal"]=$valTotal;
                    $devBody["iva"]=$_POST["iva"];
                    
                    $sql = consulta::insertar($devBody, "sales_devolution_details");
                    consulta::ejecutar_consulta($sql);
                    
                    $sql="UPDATE invoice_details SET devuelto = devuelto + ".$_POST["cdevolver"]." WHERE id=".$_POST["id"];
                    consulta::ejecutar_consulta($sql);
                    
                    
                    $sql="SELECT * FROM general_products_services WHERE id =".$_POST["idProducto"];
                    $pro = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    
                    $sql="UPDATE general_stock_products SET cantidad=cantidad - ".$_POST["cdevolver"]." WHERE id_producto ='".$pro[0]["idunico"]."' AND id_almacen='".$_POST["datos_usuario"]["idalmacen"]."'";
                    consulta::ejecutar_consulta($sql);
                    
                    $sql="SELECT sum(devuelto) as devolucion FROM invoice_details WHERE idunico = '".$_POST["idunico"]."'";
                    $devoluciones = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    
                    $sql="SELECT totalcantidad FROM invoice_head WHERE idunico = '".$_POST["idunico"]."'";
                    $factura = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    $sql="UPDATE invoice_head SET estado=3 WHERE idunico='".$_POST["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                }
                if(preg_match("/guardarFacturaCompra\//", $resource, $matches)){
                // Se toman los datos de la bodega
                $sql="SELECT * FROM general_bodega WHERE id='".$_POST["bodega"]."'";
                $bodega = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                // Se toman los datos del producto
                $sql="SELECT * FROM general_products_services WHERE id='".$_POST["idproducto"]."'";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                //Se realizan los calculos de ivas y valores de descuento
                $valorcondescuento = $_POST["neto"];

                $valorconiva = $_POST["total"]/$_POST["cantidad"];

                $valordeliva = $valorconiva-$valorcondescuento;

                //$valorconivaydescuento=;

                if($_POST["iva"]!=0)
                {
                    $iva = ($_POST["iva"]/100)+1;
                }
                else
                {
                    $iva = 0;
                }

                $valorsinIva=($_POST["total"]/$iva);
                $valordelIva=$_POST["total"]-$valorsinIva;


                // Se insertan los detalles de la factura de compra
                $detalle["idunico"]=$_POST["idunico"];
                $detalle["idalmacen"]=$_POST["bodega"];
                $detalle["id_proveedor"]=$_POST["proveedor"];
                $detalle["id_producto"]=$_POST["idproducto"];
                $detalle["cantidad"]=$_POST["cantidad"];
                $detalle["nota"]=$_POST["nota"];
                $detalle["precio_uni"]=$valorconiva;
                $detalle["base"]=$_POST["neto"];
                $detalle["desc1"]=$_POST["desc1"];
                $detalle["desc2"]=$_POST["desc2"];
                $detalle["iva"]=$valordelIva;
                $detalle["valor"]=$valorconiva;
                $detalle["preciototal"]=$_POST["total"];
                $detalle["fecha"]=date("d/m/Y");

                consulta::ejecutar_consulta(consulta::insertar($detalle, "shopping_suppliers_bills_details"));


                //Actualiza el precio de compra del producto
                $sql="UPDATE general_products_services SET p_costo='".$_POST["costo"]."', p_costo_pro='".$_POST["valUni"]."' WHERE idunico='".$producto[0]["idunico"]."'";
                consulta::ejecutar_consulta($sql);

                //Se actualizan las cantidades en el stock 
                $sql="UPDATE general_stock_products SET cantidad=(cantidad + ".$_POST["cantidad"].")  WHERE id_almacen='".$_POST["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$_POST["idproducto"]."')";
                consulta::ejecutar_consulta($sql);

                //Si la factura fue generada de una orden se descuentan las cantidades solicitadas del stock
                if($_POST["idorden"]>0 || $_POST["idorden"]!="")
                {
                    $sql="UPDATE general_stock_products SET solicitada=(solicitada - ".$_POST["cantidad"].")  WHERE id_almacen='".$_POST["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$_POST["idproducto"]."')";
                    consulta::ejecutar_consulta($sql);
                }

                // Se ingresan los movimientos
                $mov["fecha"]=date("d/m/Y");
                $mov["tipo"]="compra";
                $mov["detalle"]="Compras del ".date("d-m-Y");
                $mov["caja"]=1;
                $mov["origen"]=$_POST["bodega"];
                $mov["nombre_origen"]=$bodega[0]["descripcion"];
                $mov["id_producto"]=$producto[0]["idunico"];
                $mov["nom_producto"]=$producto[0]["nombre"];
                $mov["n_fact"]=$_POST["num_factura"];
                $mov["cantidad"]=$_POST["cantidad"];
                $mov["idalmacen"]=$_POST["bodega"];
                $mov["idcaja"]="1";
                $mov["precio_costo"]=$valorsinIva;
                $mov["valor_total"]=$_POST["total"];
                consulta::ejecutar_consulta(consulta::insertar($mov, "general_movimientos"));


                // Se verifica si existe la factura, si no es asi se crea
                $sql="SELECT * FROM shopping_suppliers_bills WHERE idunico='".$_POST["idunico"]."'";
                $factura = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                if(!count($factura)>0)
                {
                    $cabecera["idunico"]=$_POST["idunico"];
                    $cabecera["idproveedor"]=$_POST["proveedor"];
                    $cabecera["num_fact"]=$_POST["num_factura"];
                    $cabecera["fec_exp"]=$_POST["fec_factura"];
                    $cabecera["fec_venc"]=$_POST["fec_vencimiento"];
                    $cabecera["fec_creacion"]=date("d/m/Y");
                    $cabecera["iva_fact"]=$_POST["ivatotal"];
                    $cabecera["flete"]=$_POST["flete"];
                    $cabecera["base_fact"]=$_POST["netostotal"];
                    $cabecera["total_fact"]=$_POST["totales"];
                    $cabecera["idorden"]=$_POST["idorden"];
                    $cabecera["idalmacen"]=$_POST["bodega"];
                    $cabecera["tipo"]="FACTURA DE COMPRA";
                    $cabecera["observaciones"]=$_POST["observaciones"];
                    //$cabecera["nota"]=$_POST["nota"];
                    $cabecera["estado"]=1;
                    consulta::ejecutar_consulta(consulta::insertar($cabecera, "shopping_suppliers_bills"));  
                    
                    //Se actualiza el saldo y cupo disponibble para el tercero
                    $sql="UPDATE general_third SET saldo_cartera = saldo_cartera+".$_POST["totales"].", disponible= cupo_credito - saldo_cartera  WHERE id=".$_POST["proveedor"];
                    consulta::ejecutar_consulta($sql);
                    
                    //Se actualizan los descuentos del producto segun la compra
                    $sql="UPDATE general_products_services SET desc1=".$_POST["desc1"].", desc2=".$_POST["desc2"]." WHERE id=".$_POST["idproducto"];
                    consulta::ejecutar_consulta($sql);
                }

                // Se actualiza el estado de la orden para descartarla
                $sql="UPDATE purchase_orders SET estado=2 WHERE id='".$_POST["idorden"]."'";
                consulta::ejecutar_consulta($sql);

                //Se cambian las listas de precio del producto
                $sql="SELECT * FROM general_price_list";
                $lista = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));


                $sql="SELECT * FROM general_price_list_products WHERE producto='".$producto[0]["id"]."'";
                $listas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                if(count($listas)==0)
                {
                    for($i=0;$i<count($lista);$i++)
                    {
                        $list["producto"]=$_POST["idproducto"];
                        $list["precio_compra"]= $_POST["costo"];
                        $list["lista"]=$lista[$i]["id"];
                        $list["margen"]=ceil($lista[$i]["margen"]);         
                        $valMargen=($lista[$i]["margen"]/100)+1;
                        $valConMargen=$_POST["valUni"]*$valMargen;
                        $list["precio_venta"]=ceil($valConMargen);
                        $valconIva=$valConMargen;
                        if($iva!=0)
                        {
                            $valconIva=ceil($valConMargen*$iva);
                        }
                        $val = $j.$_POST["idproducto"];   
                        $list["precio_venta_iva"]=$_POST["listaVal_".$val];
                        $list["idalmacen"]=$_POST["bodega"];
                        consulta::ejecutar_consulta(consulta::insertar($list, "general_price_list_products"));
                    }
                }
                else
                {
                    for($j=0;$j<count($listas);$j++)
                    {
                        $list["precio_compra"]=$_POST["costo"];
                        $valMargen=1+($listas[$j]["margen"]/100);
                        $valConMargen=$_POST["valUni"]*($valMargen);
                        $list["precio_venta"]=$valConMargen;
                        $valconIva=$valConMargen;
                        if($iva!=0)
                        {
                            $valconIva=ceil($valConMargen*$iva);
                        }
                        $val = $j.$_POST["idproducto"];            
                        $list["precio_venta_iva"]=$_POST["listaVal_".$val];
                        $donde="id='".$listas[$j]["id"]."'";

                        consulta::actualizar($list, "general_price_list_products", $donde);
                        consulta::ejecutar_consulta(consulta::actualizar($list, "general_price_list_products", $donde));
                    }
                }

                echo $_POST["idunico"];
            }
            if(preg_match("/guardarFacturaVenta\//", $resource, $matches)){
                $postDetalle["idunico"]=$_POST["idunico"];
                $postDetalle["idProducto"]=$_POST["id"];
                $postDetalle["cantidad"]=$_POST["cant"];
                $postDetalle["pcosto"]=$_POST["costo"];
                $postDetalle["pneto"]=$_POST["valorventa"];
                $postDetalle["desc1"]=$_POST["descuento"];
                $postDetalle["incremento"]=$_POST["incremento"];
                $postDetalle["nota"]=$_POST["nota"];
                $postDetalle["vtotal"]=$_POST["total"];
                $postDetalle["iva"]=$_POST["nom_iva"];
                consulta::ejecutar_consulta(consulta::insertar($postDetalle, "invoice_details"));
                
                // Se toman los datos del producto
                $sql="SELECT * FROM general_products_services WHERE id='".$_POST["id"]."'";
                $producto = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT * FROM general_third WHERE id='".$_POST["cliente"]."'";
                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                $sql="SELECT * FROM invoice_head WHERE idunico ='".$_POST["idunico"]."'";
                $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                // Se ingresan los movimientos
                    $mov["fecha"]=date("d/m/Y");
                    $mov["tipo"]="venta";
                    $mov["detalle"]="Ventas del ".date("d-m-Y");
                    $mov["caja"]=1;
                    $mov["origen"]=$_POST["datos_usuario"]["idalmacen"];
                    $mov["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                    $mov["id_producto"]=$producto[0]["idunico"];
                    $mov["nom_producto"]=$producto[0]["nombre"];
                    
                    $mov["cantidad"]=$_POST["cant"];
                    $mov["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];;
                    $mov["idcaja"]="1";
                    $mov["precio_costo"]=$_POST["costo"];
                    $mov["precio_venta"]=$_POST["valorventa"];
                    $mov["valor_total"]=$_POST["total"];
                    
                
                if(count($ver)==0)
                {
                    $post["idunico"]=$_POST["idunico"];
                    $post["fecha"]=date("Y-m-d");
                    
                    $fechaInicial = date("Y-m-d"); 
                  
                    $MaxDias = $cli[0]["condicion_pago"]; //Cantidad de dias maximo para el prestamo, este sera util para crear el for  
                  
                      
                          
                    for ($i=0; $i<$MaxDias; $i++)  
                    {   
                        $Segundos = $Segundos + 86400;  
                        $caduca = date("D",time()+$Segundos);  
                            if ($caduca == "Sat")  
                            {  
                                $i--;  
                            }  
                            else if ($caduca == "Sun")  
                            {  
                                $i--;  
                            }  
                            else  
                            {                   
                                $FechaFinal = date("Y-m-d",time()+$Segundos);  
                            }  
                    }  
                    $post["fechavence"]=Utils::formato_fecha_sql_a_normal($FechaFinal);
                    
                
                    $sql="SELECT * FROM invoice_head";
                    $facturas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));   
                
                    if(count($facturas)>0)
                    {
                        $sql="SELECT numfactura FROM invoice_head ORDER BY numfactura DESC";
                        $numfac = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));     
                
                        $sql="UPDATE general_tip_doc SET n_actual = ".($numfac[0]["numfactura"]+1). " WHERE prefijo='FV'";
                        consulta::ejecutar_consulta($sql);    
                    }
                
                    $sql="SELECT * FROM general_tip_doc WHERE prefijo='FV'";
                    $resolucion = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));   
                
                    $mov["n_fact"]=$resolucion[0]["n_actual"];
                     
                
                    $post["numfactura"]=$resolucion[0]["n_actual"];
                    $post["hora"]=date("G:H:s");
                    $post["idcliente"]=$_POST["cliente"];
                    $post["vendedor"]=$cli[0]["vendedor"];
                    $post["tipo"]="FACTURA DE VENTA";
                    $post["cpago"]=$cli[0]["condicion_pago"];
                    $post["bodega"]=$_POST["bodega"];
                    $post["observaciones"]=$_POST["observaciones"];
                    $post["estado"]=1;
                    $post["totalcantidad"]=$_POST["cant"];
                    $post["totalneto"]=$_POST["valorventa"];
                    $post["totaltotales"]=$_POST["total"];
                    if($_POST["referenciaTipo"]==1)
                    {
                        $sql="SELECT * FROM order_head WHERE idunico='".$_POST["referencia"]."'";
                        $ped = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        $post["referencia"]="Cotizacion - ".$ped[0]["id"];
                        $sql="UPDATE order_head SET estado =2 WHERE idunico='".$_POST["referencia"]."'";
                        consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    }
                    if($_POST["referenciaTipo"]==2)
                    {
                        $idref = explode("-", $_POST["referencia"]);
                        $post["referencia"]=" Remision(es)  ";
                        for ($k=0; $k < count($idref)-1; $k++) {           
                            $sql="SELECT * FROM referrals_head WHERE idunico='".$idref[$k]."'";
                            $ped = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                            
                            for($w=0; $w < count($ped); $w++)
                            {
                                $post["referencia"].=" - ".$ped[$w]["id"];
                            }
                            $sql="UPDATE referrals_head SET estado =2 WHERE idunico='".$idref[$k]."'";
                            consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        }
                    }
                    
                    consulta::ejecutar_consulta(consulta::insertar($post, "invoice_head"));
                    
                    $sql="UPDATE general_third SET saldo_cartera = saldo_cartera+".$_POST["total"].", disponible= cupo_credito - saldo_cartera  WHERE id=".$_POST["cliente"];
                    consulta::ejecutar_consulta($sql);
                }
                else
                {
                    $sql="UPDATE invoice_head SET totalcantidad=totalcantidad+".$_POST["cant"].", totalneto=totalneto+".$_POST["valorventa"].", totaltotales=totaltotales+".$_POST["total"]." WHERE idunico='".$_POST["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                    $sql="UPDATE general_third SET saldo_cartera = saldo_cartera+".$_POST["total"].", disponible= cupo_credito - saldo_cartera  WHERE id=".$_POST["cliente"];
                    consulta::ejecutar_consulta($sql);
                    $mov["n_fact"]=$ver[0]["numfactura"];
                }
                
                
                consulta::ejecutar_consulta(consulta::insertar($mov, "general_movimientos"));
                
                $sql="SELECT * FROM general_products_services WHERE id=".$_POST["id"];
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                //Se sacan los productos del inventario
                
                //Se verifica que sea una mezcla
                if($prod[0]["mezcla"]=="on")
                {
                    // Si tiene mezcla se buscan los componentes de la misma y se descuentan del inventario
                    $sql ="SELECT * FROM general_products_services_mixtures WHERE id_mixture=".$prod[0]["id"];
                    $mix = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    for($m=0;$m<count($mix);$m++)
                    {
                        if($_POST["referenciaTipo"]!=2)
                        {
                            $sql="SELECT * FROM general_products_services WHERE id=".$mix[$m]["id_product"];
                            $prodmix = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                            $sql="UPDATE general_stock_products SET cantidad=cantidad - ".($mix[$m]["cant"]*$_POST["cant"])." WHERE id_producto ='".$prodmix[0]["idunico"]."' AND id_almacen='".$_POST["bodega"]."'";   
                            consulta::ejecutar_consulta($sql); 
                        }
                    }
                }
                else
                {
                    if($_POST["referenciaTipo"]!=2)
                    {
                        // Si no tiene mezcla se descuenta del inventario directo 
                        $sql="UPDATE general_stock_products SET cantidad=cantidad - ".$_POST["cant"]." WHERE id_producto ='".$prod[0]["idunico"]."' AND id_almacen='".$_POST["bodega"]."'";   
                        consulta::ejecutar_consulta($sql); 
                    }
                }
                $sql="DELETE FROM general_temporal where tipo ='FV'";
                consulta::ejecutar_consulta($sql);
                
                echo $_POST["idunico"];
            }
            if(preg_match("/guardarFormaPagoReciboComprobante\//", $resource, $matches)){
                $post["formaPago"]=$_POST["formaPago"];
                $post["valor"]=$_POST["valor"];
                $post["doc"]=$_POST["doc"];
                $post["banco"]=$_POST["banco"];
                $post["fecha"]=$_POST["fecha"];
                $post["nota"]=$_POST["nota"];
                $post["idunico"]=$_POST["idunico"];
                consulta::ejecutar_consulta(consulta::insertar($post, "financial_receipt_exit_payment_forms"));
            }
            if(preg_match("/ \//", $resource, $matches)){
                $idunico = uniqid();
                $head["fecha"]=date("d/m/Y");
                $head["usuario"]=$_POST["datos_usuario"]["codigo"];
                $head["bodega"]=$_POST["datos_usuario"]["idalmacen"];
                $head["idunico"]=$idunico;
                $head["tipo"]=$_POST["data"][0]["movimiento"];
                $head["detalle"]=$_POST["data"][0]["detalle"];
                
                if($_POST["data"][0]["movimiento"]=="entrada")
                {
                      
                      consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_entry"));      
                }
                if($_POST["data"][0]["movimiento"]=="salida")
                {
                      consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_output"));      
                }
                if($_POST["data"][0]["movimiento"]=="traspaso")
                {
                      consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_transfer"));      
                }
                
                
                $sql="DELETE FROM general_temporal WHERE tipo ='".$_POST["data"][0]["tipotemp"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."'";
                consulta::ejecutar_consulta($sql);
                
                
                for($i=0;$i<count($_POST["data"]);$i++)
                {
                    switch ($_POST["data"][$i]["movimiento"]) {
                        case 'entrada':     
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]=$_POST["data"][$i]["movimiento"];
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                            $post["cantidad"]=$_POST["data"][$i]["cant"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["p_costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunico"];
                            $post["nom_producto"]=$_POST["data"][$i]["nombre"];
                            consulta::insertar($post, "general_movimientos");
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["data"][$i]["cant"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["data"][$i]["idunico"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                        break;       
                        case 'salida':                        
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]=$_POST["data"][$i]["movimiento"];
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                            $post["cantidad"]=$_POST["data"][$i]["cant"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["p_costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunico"];
                            $post["nom_producto"]=$_POST["data"][$i]["nombre"];
                            consulta::insertar($post, "general_movimientos");
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad - ".$_POST["data"][$i]["cant"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["data"][$i]["idunico"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                        break;       
                        case 'traspaso':                                             
                            //salida
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]="salida_traspaso";
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["data"][$i]["destino"];
                            $post["nombre_destino"]=$_POST["data"][$i]["nomdestino"];            
                            $post["cantidad"]=$_POST["data"][$i]["cantidad"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunicopro"];
                            $post["nom_producto"]=$_POST["data"][$i]["productoLbl"];          
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));
                            
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad - ".$_POST["data"][$i]["cantidad"].") WHERE id_almacen='".$post["origen"]."' AND id_producto='".$_POST["data"][$i]["idunicopro"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                            
                            //entrada
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]="entrada_traspaso";
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["origen"]=$_POST["data"][$i]["destino"];
                            $post["nombre_origen"]=$_POST["data"][$i]["nomdestino"];            
                            $post["cantidad"]=$_POST["data"][$i]["cantidad"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunicopro"];
                            $post["nom_producto"]=$_POST["data"][$i]["productoLbl"];        
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["data"][$i]["cantidad"].") WHERE id_almacen='".$post["origen"]."' AND id_producto='".$_POST["data"][$i]["idunicopro"]."'";
                            consulta::ejecutar_consulta($sql);
                            echo "<br/>";
                        break;       
                    }
                }
                echo $idunico;
            }
            if(preg_match("/guardarMovimiento\//", $resource, $matches)){
                $idunico = uniqid();
                $head["fecha"]=date("d/m/Y");
                $head["usuario"]=$_POST["datos_usuario"]["codigo"];
                $head["bodega"]=$_POST["datos_usuario"]["idalmacen"];
                $head["idunico"]=$idunico;
                $head["tipo"]=$_POST["data"][0]["movimiento"];
                $head["detalle"]=$_POST["data"][0]["detalle"];

                if($_POST["data"][0]["movimiento"]=="entrada")
                {
                    
                    consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_entry"));      
                }
                if($_POST["data"][0]["movimiento"]=="salida")
                {
                    consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_output"));      
                }
                if($_POST["data"][0]["movimiento"]=="traspaso")
                {
                    consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_transfer"));      
                }


                $sql="DELETE FROM general_temporal WHERE tipo ='".$_POST["data"][0]["tipotemp"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."'";
                consulta::ejecutar_consulta($sql);


                for($i=0;$i<count($_POST["data"]);$i++)
                {
                    switch ($_POST["data"][$i]["movimiento"]) {
                        case 'entrada':     
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]=$_POST["data"][$i]["movimiento"];
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                            $post["cantidad"]=$_POST["data"][$i]["cant"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["p_costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunico"];
                            $post["nom_producto"]=$_POST["data"][$i]["nombre"];
                            consulta::insertar($post, "general_movimientos");
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            

                            $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["data"][$i]["cant"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["data"][$i]["idunico"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                        break;       
                        case 'salida':                        
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]=$_POST["data"][$i]["movimiento"];
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                            $post["cantidad"]=$_POST["data"][$i]["cant"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["p_costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunico"];
                            $post["nom_producto"]=$_POST["data"][$i]["nombre"];
                            consulta::insertar($post, "general_movimientos");
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            

                            $sql="UPDATE general_stock_products SET cantidad = (cantidad - ".$_POST["data"][$i]["cant"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["data"][$i]["idunico"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                        break;       
                        case 'traspaso':                                             
                            //salida
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]="salida_traspaso";
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["destino"]=$_POST["data"][$i]["destino"];
                            $post["nombre_destino"]=$_POST["data"][$i]["nomdestino"];            
                            $post["cantidad"]=$_POST["data"][$i]["cantidad"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunicopro"];
                            $post["nom_producto"]=$_POST["data"][$i]["productoLbl"];          
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));
                            
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad - ".$_POST["data"][$i]["cantidad"].") WHERE id_almacen='".$post["origen"]."' AND id_producto='".$_POST["data"][$i]["idunicopro"]."'";
                            consulta::ejecutar_consulta($sql);
                            
                            
                            //entrada
                            $post["fecha"]=date("d/m/Y");
                            $post["idunico"]=$idunico;
                            $post["tipo"]="entrada_traspaso";
                            $post["detalle"]=$_POST["data"][$i]["detalle"];
                            $post["caja"]=1;
                            $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];
                            $post["origen"]=$_POST["data"][$i]["destino"];
                            $post["nombre_origen"]=$_POST["data"][$i]["nomdestino"];            
                            $post["cantidad"]=$_POST["data"][$i]["cantidad"];
                            $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                            $post["idcaja"]=1;
                            $post["precio_costo"]=$_POST["data"][$i]["costo"];
                            $post["valor_total"]=$_POST["data"][$i]["total"];
                            $post["id_producto"]=$_POST["data"][$i]["idunicopro"];
                            $post["nom_producto"]=$_POST["data"][$i]["productoLbl"];        
                            consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                            $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["data"][$i]["cantidad"].") WHERE id_almacen='".$post["origen"]."' AND id_producto='".$_POST["data"][$i]["idunicopro"]."'";
                            consulta::ejecutar_consulta($sql);
                        break;       
                    }
                }
                echo $idunico;
            }
            if(preg_match("/guardarNota\//", $resource, $matches)){
                if($_POST["nota"]["tipo"]==3||$_POST["nota"]["tipo"]==7)
                {
                    $_POST["nota"]["tipodoc"]="NOTA DEBITO";
                }
                if($_POST["nota"]["tipo"]==4||$_POST["nota"]["tipo"]==8)
                {
                    $_POST["nota"]["tipodoc"]="NOTA CREDITO";
                }
                $post = consulta::valida_datos_sql('financial_notes', $_POST["nota"]);
                $post["fecha"]=date("Y-m-d");
                $post["idunico"]=  uniqid();
                consulta::ejecutar_consulta(consulta::insertar($post, "financial_notes"));
                echo $post["idunico"];
            }
            if(preg_match("/guardarOrdenCompra\//", $resource, $matches)){
                $post["idunico"]=$_POST["idunico"];
                $post["fecha"]=date('d/m/Y');
                $post["hora"]=date("G:H:s");
                
                $sql="SELECT * FROM general_third WHERE id='".$_POST["proveedor"]."'";
                $proveedor = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $post["cupo"]=$proveedor[0]["cupo_credito"];
                $post["proveedor"]=$proveedor[0]["id"];
                $post["tipo"]="ORDEN DE COMRPA";
                $post["estado"]=1;
                $post["cpago"]=$proveedor[0]["condicion_pago"];
                $post["bodega"]=$_POST["bodega"];
                $post["observaciones"]=$_POST["observaciones"];
                $post["canttotal"]=$_POST["canttotal"];
                $post["netos"]=$_POST["netostotal"];
                $post["totales"]=$_POST["totales"];
                $post["iva"]=$_POST["ivatotal"];
                $post["descuentos"]=$_POST["descuento1"]+$_POST["descuento1"];
                
                $sql="SELECT * FROM purchase_orders WHERE idunico='".$_POST["idunico"]."'";
                $order = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                if(count($order)>0)
                {
                    
                }
                else
                {
                    $sql=consulta::insertar($post, "purchase_orders");
                    consulta::ejecutar_consulta($sql);
                }
                        
                
                $prod["idunico"]=$_POST["idunico"];
                $prod["idproducto"]=$_POST["idproducto"];
                $prod["nomproducto"]=$_POST["producto"];
                $prod["cantidad"]=$_POST["cantidad"];
                $prod["pcosto"]=$_POST["costo"];
                $prod["desc1"]=$_POST["desc1"];
                $prod["desc2"]=$_POST["desc2"];
                $prod["pneto"]=$_POST["costo"];
                $prod["vtotal"]=$_POST["total"];
                $prod["iva"]=$_POST["ivatotal"];
                $sql=consulta::insertar($prod, "purchase_orders_details");
                consulta::ejecutar_consulta($sql);
                
                $sql="UPDATE general_stock_products SET solicitada=(solicitada + ".$_POST["cantidad"].") WHERE id_almacen='".$_POST["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$_POST["idproducto"]."')";
                consulta::ejecutar_consulta($sql);
                
                $sql="DELETE FROM general_temporal WHERE cliente =".$proveedor[0]["id"]." AND tipo='SC' AND usuario=".$_POST["datos_usuario"]["codigo"];
                consulta::ejecutar_consulta($sql);
                
                echo $_POST["idunico"];
            }
            if(preg_match("/guardarPedido\//", $resource, $matches)){
                $postDetalle["idunico"]=$_POST["idunico"];
                $postDetalle["idProducto"]=$_POST["id"];
                $postDetalle["cantidad"]=$_POST["cant"];
                $postDetalle["pcosto"]=$_POST["costo"];
                $postDetalle["pneto"]=$_POST["valorventa"];
                $postDetalle["desc1"]=$_POST["descuento"];
                $postDetalle["incremento"]=$_POST["incremento"];
                $postDetalle["vtotal"]=$_POST["total"];
                $postDetalle["iva"]=$_POST["nom_iva"];
                consulta::ejecutar_consulta(consulta::insertar($postDetalle, "order_details"));
                
                $sql="SELECT * FROM general_third WHERE id='".$_POST["cliente"]."'";
                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                $sql="SELECT * FROM order_head WHERE idunico ='".$_POST["idunico"]."'";
                $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                if(count($ver)==0)
                {
                    $post["idunico"]=$_POST["idunico"];
                    $post["fecha"]=date("d/m/Y");
                    $post["hora"]=date("G:H:s");
                    $post["idCliente"]=$_POST["cliente"];
                    $post["vendedor"]=$cli[0]["vendedor"];
                    $post["tipo"]="";
                    $post["cpago"]=$cli[0]["condicion_pago"];
                    $post["bodega"]=$_POST["bodega"];
                    $post["observaciones"]=$_POST["observaciones"];
                    $post["notapedido"]=$_POST["notapedido"];
                    $post["estado"]=1;
                    $post["totalcantidad"]=$_POST["cant"];
                    $post["totalneto"]=$_POST["valorventa"];
                    $post["totaltotales"]=$_POST["total"];    
                    consulta::ejecutar_consulta(consulta::insertar($post, "order_head"));
                }
                else
                {
                    $sql="UPDATE order_head SET totalcantidad=totalcantidad+".$_POST["cant"].", totalneto=totalneto+".$_POST["valorventa"].", totaltotales=totaltotales+".$_POST["total"]." WHERE idunico='".$_POST["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                }
                
                $sql="UPDATE quotation_head SET estado =2 WHERE idunico='".$_POST["idunicocotiza"]."'";
                consulta::ejecutar_consulta($sql);
                
                $sql="UPDATE general_stock_products SET pedido=(pedido + ".$_POST["cant"].") WHERE id_almacen='".$_POST["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$_POST["id"]."')";
                consulta::ejecutar_consulta($sql);
                
                
                $sql="DELETE FROM general_temporal where tipo ='PD'";
                consulta::ejecutar_consulta($sql);
                
                
                $sql="SELECT * FROM order_head where idunico = '".$_POST["idunico"]."'";
                $p = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                echo $p[0]["id"] ;
            }
            if(preg_match("/guardarReciboCaja\//", $resource, $matches)){
                if($_POST["financial"]["vaplicar"]<0)
                {
                    $_POST["financial"]["vaplicar"] = -1*$_POST["financial"]["vaplicar"];
                }
                if($_POST["financial"]["vaplicar"]>0)
                {
                    $sql="SELECT * FROM financial_receipt_exit WHERE idunico = '".$_POST["financial"]["idunico"]."'";
                    $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    
                    if(count($ver)==0)
                    {
                        $post = consulta::valida_datos_sql('financial_receipt_exit', $_POST["financial"]);
                        $post["id"]=null;
                        $post["bodega"]=$_POST["datos_usuario"]["idalmacen"];
                        $post["fecha"]=date("Y-m-d");   
                        consulta::ejecutar_consulta(consulta::insertar($post, "financial_receipt_exit"));
                    }
                    else
                    {
                        if($_POST["financial"]["tipoDoc"]==1 || $_POST["financial"]["tipoDoc"]==3 || $_POST["financial"]["tipoDoc"]==5 || $_POST["financial"]["tipoDoc"]==7)
                        {
                            $post = consulta::valida_datos_sql('financial_receipt_exit', $_POST["financial"]);
                            $sql="UPDATE financial_receipt_exit SET subtotal = subtotal + ".$post["subtotal"].", descuento = descuento + ".$post["descuento"].", retencion = retencion +".$post["retencion"].", vaplicar= vaplicar +".$post["vaplicar"].", tdebito= tdebito +".$post["tdebito"].", tcredito = tcredito +".$post["tcredito"]." WHERE idunico = '".$post["idunico"]."'";
                            consulta::ejecutar_consulta($sql);                
                        }
                        if($_POST["financial"]["tipoDoc"]==2 || $_POST["financial"]["tipoDoc"]==4 || $_POST["financial"]["tipoDoc"]==6 || $_POST["financial"]["tipoDoc"]==8)
                        {
                            $post = consulta::valida_datos_sql('financial_receipt_exit', $_POST["financial"]);
                            $sql="UPDATE financial_receipt_exit SET subtotal = subtotal + ".$post["subtotal"].", descuento = descuento + ".$post["descuento"].", retencion = retencion +".$post["retencion"].", vaplicar= vaplicar -".$post["vaplicar"].", tdebito= tdebito +".$post["tdebito"].", tcredito = tcredito +".$post["tcredito"]." WHERE idunico = '".$post["idunico"]."'";
                            consulta::ejecutar_consulta($sql);        
                        }
                    }
                    
                    
                    if($_POST["financial"]["tipoDoc"]==1)
                    {
                        $sql="UPDATE invoice_head SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        
                        consulta::ejecutar_consulta($sql);
                        $sql="UPDATE invoice_head SET saldo=totaltotales-aplicado WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql);
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "invoice_head";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));   
                    }
                    if($_POST["financial"]["tipoDoc"]==2)
                    {
                        $sql="UPDATE sales_devolution_head SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql); 
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "sales_devolution_head";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));          
                    }
                    if($_POST["financial"]["tipoDoc"]==5)
                    {
                        $sql="UPDATE shopping_suppliers_bills SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql);   
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "shopping_suppliers_bills";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));      
                    }
                    if($_POST["financial"]["tipoDoc"]==6)
                    {
                        $sql="UPDATE purchase_devolution_head SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql);  
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "purchase_devolution_head";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));        
                    }
                    
                    if($_POST["financial"]["tipoDoc"]==3 || $_POST["financial"]["tipoDoc"]==4|| $_POST["financial"]["tipoDoc"]==7|| $_POST["financial"]["tipoDoc"]==8)
                    {
                        $sql="UPDATE financial_notes SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql);  
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "financial_notes";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));        
                    }
                    
                    if($_POST["financial"]["tipoDoc"]==9||$_POST["financial"]["tipoDoc"]==10)
                    {
                        $sql="UPDATE financial_receipt_exit SET aplicado=aplicado + ".($_POST["financial"]["vaplicar"]+$_POST["financial"]["retencion"]+$_POST["financial"]["descuento"])." WHERE id='".$_POST["financial"]["idoc"]."'";
                        consulta::ejecutar_consulta($sql);     
                
                        $tipoDocu["idunico"]=$_POST["financial"]["idunico"];    
                        $tipoDocu["iddocument"]=$_POST["financial"]["idoc"];   
                        $tipoDocu["aplicado"]= $_POST["financial"]["vaplicar"];   
                        $tipoDocu["tipoDocumento"]= "financial_receipt_exit";
                        consulta::ejecutar_consulta(consulta::insertar($tipoDocu, "financial_receipt_exit_documents"));           
                    }
                }
                echo $_POST["financial"]["idunico"];
            }
            if(preg_match("/guardarRemisiones\//", $resource, $matches)){
                $postDetalle["idunico"]=$_POST["idunico"];
                $postDetalle["idProducto"]=$_POST["id"];
                $postDetalle["cantidad"]=$_POST["cant"];
                $postDetalle["pcosto"]=$_POST["costo"];
                $postDetalle["pneto"]=$_POST["valorventa"];
                $postDetalle["vtotal"]=$_POST["total"];
                $postDetalle["desc1"]=$_POST["descuento"];
                $postDetalle["incremento"]=$_POST["incremento"];
                $postDetalle["iva"]=$_POST["nom_iva"];
                consulta::ejecutar_consulta(consulta::insertar($postDetalle, "referrals_details"));
                
                /// INICIO Comentar este codigo si se quiere que la remision no descuente del inventario
                $sql="SELECT * FROM general_products_services WHERE id='".$_POST["id"]."'";
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                //Se sacan los productos del inventario
                
                    //Se verifica que sea una mezcla
                    if($prod[0]["mezcla"]=="on")
                    {
                        // Si tiene mezcla se buscan los componentes de la misma y se descuentan del inventario
                        $sql ="SELECT * FROM general_products_services_mixtures WHERE id_mixture=".$prod[0]["id"];
                        $mix = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                        for($m=0;$m<count($mix);$m++)
                        {
                            $sql="SELECT * FROM general_products_services WHERE id='".$mix[$m]["id_product"]."'";
                            $prodmix = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                            $sql="UPDATE general_stock_products SET cantidad=cantidad - ".($mix[$m]["cant"]*$_POST["cant"])." WHERE id_producto ='".$prodmix[0]["idunico"]."' AND id_almacen='".$_POST["datos_ususario"]["idalmacen"]."'";   
                            consulta::ejecutar_consulta($sql); 
                        }
                    }
                    else
                    {
                        // Si no tiene mezcla se descuenta del inventario directo 
                        $sql="UPDATE general_stock_products SET cantidad = cantidad-".$_POST["cant"]." WHERE id_almacen=".$_POST["datos_usuario"]["idalmacen"]." AND id_producto='".$prod[0]["idunico"]."'";
                        consulta::ejecutar_consulta($sql);
                    }
                /// FIN Comentar este codigo si se quiere que la remision no descuente del inventario
                
                
                $sql="SELECT * FROM general_third WHERE id='".$_POST["cliente"]."'";
                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                $sql="SELECT * FROM referrals_head WHERE idunico ='".$_POST["idunico"]."'";
                $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                if(count($ver)==0)
                {
                    $post["idunico"]=$_POST["idunico"];
                    $post["fecha"]=date("Y-m-d");
                    $post["hora"]=date("G:H:s");
                    $post["idCliente"]=$_POST["cliente"];
                    $post["vendedor"]=$cli[0]["vendedor"];
                    $post["tipo"]="";
                    $post["cpago"]=$cli[0]["condicion_pago"];
                    $post["bodega"]=$_POST["bodega"];
                    $post["observaciones"]=$_POST["observaciones"];
                    $post["notapedido"]=$_POST["notapedido"];
                    $post["estado"]=1;
                    $post["totalcantidad"]=$_POST["cant"];
                    $post["totalneto"]=$_POST["valorventa"];
                    $post["totaltotales"]=$_POST["total"];    
                    consulta::ejecutar_consulta(consulta::insertar($post, "referrals_head"));
                }
                else
                {
                    $sql="UPDATE referrals_head SET totalcantidad=totalcantidad+".$_POST["cant"].", totalneto=totalneto+".$_POST["valorventa"].", totaltotales=totaltotales+".$_POST["total"]." WHERE idunico='".$_POST["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                }
                
                //INICIO Descomentar si se quiere que no descuente de inventario
                // $sql="UPDATE general_stock_products SET pedido=(pedido + ".$_POST["cant"].") WHERE id_almacen='".$_POST["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$_POST["id"]."')";
                // consulta::ejecutar_consulta($sql);
                //FIN Descomentar si se quiere que no descuente de inventario
                
                $sql="DELETE FROM general_temporal where tipo ='RE'";
                consulta::ejecutar_consulta($sql);
                
                
                $sql="SELECT * FROM referrals_head where idunico = '".$_POST["idunico"]."'";
                $p = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                echo $p[0]["id"] ;
            }
            if(preg_match("/guardarTemporalFormasPago\//", $resource, $matches)){
                $pay["idinvoice"]=$_POST["idunico"];
                $pay["forma_pago"]=$_POST["formapago"];
                $pay["pago"]=$_POST["valor"];
                $pay["fecha_pago"]=date("Y-m-d");
                $sql=consulta::insertar($pay, "invoice_payment_form_pos_temp");
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/procesarOrdenCabecera\//", $resource, $matches)){
                $sql="UPDATE order_head SET estado=3, tiempoatendio='".$_POST["tiempo"]."' WHERE id='".$_POST["id"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/procesarOrdenCuerpo\//", $resource, $matches)){
                $sql="UPDATE order_details SET despachado='".$_POST["despachado"]."', faltante='".$_POST["faltante"]."' WHERE id='".$_POST["id"]."'";
                consulta::ejecutar_consulta($sql);
                $sql="SELECT * FROM order_details WHERE id='".$_POST["id"]."'";
                $pedido= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT * FROM order_head WHERE idunico='".$pedido[0]["idunico"]."'";
                $pedidoCabecera= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="UPDATE general_stock_products SET pedido=(pedido - ".$pedido[0]["cantidad"].") WHERE id_almacen='".$pedidoCabecera[0]["bodega"]."' AND id_producto= (SELECT idunico FROM general_products_services WHERE id='".$pedido[0]["idProducto"]."')";
                consulta::ejecutar_consulta($sql);
                
                $sql="SELECT * FROM general_third WHERE id='".$pedidoCabecera[0]["idCliente"]."'";
                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $pedido[0]["desc1"]=$pedido[0]["desc"];
                $postInvoiceDetails = consulta::valida_datos_sql('invoice_details', $pedido[0]); 
                
                $postInvoiceDetails["id"]=null;
                $postInvoiceDetails["cantidad"]=$pedido[0]["despachado"];
                
                $sql=consulta::insertar($postInvoiceDetails, "invoice_details");
                consulta::ejecutar_consulta($sql);
                
                
                $sql="SELECT * FROM invoice_head WHERE idunico ='".$pedidoCabecera[0]["idunico"]."'";
                $ver = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                if(count($ver)==0)
                {
                    $fechaInicial = date("Y-m-d");   
                    $MaxDias = $cli[0]["condicion_pago"]; //Cantidad de dias maximo para el prestamo, este sera util para crear el for  
                  
                    for ($i=0; $i<$MaxDias; $i++)  
                    {   
                        $Segundos = $Segundos + 86400;  
                        $caduca = date("D",time()+$Segundos);  
                            if ($caduca == "Sat")  
                            {  
                                $i--;  
                            }  
                            else if ($caduca == "Sun")  
                            {  
                                $i--;  
                            }  
                            else  
                            {                   
                                $FechaFinal = date("Y-m-d",time()+$Segundos);  
                            }  
                    }  
                    $pedidoCabecera[0]["fechavence"]=Utils::formato_fecha_sql_a_normal($FechaFinal);    
                    $pedidoCabecera[0]["idcliente"]=$pedidoCabecera[0]["idCliente"];
                    $pedidoCabecera[0]["estado"]=1;
                    $pedidoCabecera[0]["tipo"]="FACTURA DE VENTA";
                    $postInvoice = consulta::valida_datos_sql('invoice_head', $pedidoCabecera[0]); 
                    $postInvoice["id"]=null;
                    $sql=consulta::insertar($postInvoice, "invoice_head");
                    consulta::ejecutar_consulta($sql);
                }
                else
                {
                    $sql="UPDATE invoice_head SET totalcantidad=totalcantidad+".$pedido[0]["cantidad"].", totalneto=totalneto+".$pedido[0]["pneto"].", totaltotales=totaltotales+".$pedido[0]["vtotal"]." WHERE idunico='".$pedido[0]["idunico"]."'";
                    consulta::ejecutar_consulta($sql);
                }
                
                
                $sql="SELECT * FROM general_products_services WHERE id=".$pedido[0]["idProducto"];
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="UPDATE general_stock_products SET cantidad=cantidad - ".$pedido[0]["cantidad"]." WHERE id_producto ='".$prod[0]["idunico"]."' AND id_almacen='".$pedidoCabecera[0]["bodega"]."'";
                consulta::ejecutar_consulta($sql);
                
                echo $pedido[0]["idunico"];
            }
            if(preg_match("/procesarSugerido\//", $resource, $matches)){
                $sql="SELECT *, (SELECT cantidad FROM general_temporal WHERE producto = p.id AND tipo='SC' AND cliente='".$_POST["proveedor"]."') as cant,";

                $sql.=" (SELECT cantidad FROM general_stock_products  ";
                if($_POST["bodega"]!=0)
                {
                    $sql.=" WHERE id_producto=p.idunico AND id_almacen=".$_POST["bodega"];
                }
                $sql.=" ) as stock,";
                $sql.=" (SELECT minima FROM general_stock_products  ";
                if($_POST["bodega"]!=0)
                {
                    $sql.=" WHERE id_producto=p.idunico AND id_almacen=".$_POST["bodega"];
                }
                $sql.=" ) as minima,";
                $sql.=" (SELECT maxima FROM general_stock_products  ";
                if($_POST["bodega"]!=0)
                {
                    $sql.=" WHERE id_producto=p.idunico AND id_almacen=".$_POST["bodega"];
                }
                $sql.=" ) as maxima,";
                $sql.=" (SELECT solicitada FROM general_stock_products  ";
                if($_POST["bodega"]!=0)
                {
                    $sql.=" WHERE id_producto=p.idunico AND id_almacen=".$_POST["bodega"];
                }
                $sql.=" ) as solicitada,";
                $sql.=" (SELECT pedido FROM general_stock_products  ";
                if($_POST["bodega"]!=0)
                {
                    $sql.=" WHERE id_producto=p.idunico AND id_almacen=".$_POST["bodega"];
                }
                $sql.=" ) as pedido";
                
                
                for($j=4;$j>0;$j--)
                {    
                    $fecha = date('Y-m-d');
                    $nuevafecha = strtotime ( '-'.$j.' month' , strtotime ( $fecha ) ) ;
                    $nuevafecha = date ( 'm' , $nuevafecha );   
                    $sql.=", (SELECT SUM(cantidad) FROM invoice_details WHERE idProducto=p.id AND idunico IN (SELECT idunico FROM invoice_head WHERE MONTH(fecha) ='".$nuevafecha."')) as prom".$j;
                }
                
                
                $sql .=" FROM general_products_services p WHERE id IN 
                (SELECT id_producto FROM shopping_suppliers_bills_details 
                WHERE id_proveedor=".$_POST["proveedor"]; 
                if($_POST["bodega"]!=0)
                {
                    $sql.=" AND idalmacen = ".$_POST["bodega"];
                }
                
                $sql.=" GROUP BY id_producto)";
                if($_POST["laboratorio"]!=0)
                {
                    $sql.=" AND laboratorio = ".$_POST["laboratorio"];
                }
                $sugerido = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($sugerido);
            }
            if(preg_match("/agregarTemporal\//", $resource, $matches)){
                $sql="SELECT codigo_barras, id FROM general_products_services WHERE codigo_barras='".$_POST["producto"]."' OR idunico IN(SELECT idunico FROM general_products_services_barcode WHERE barcode='".$_POST["producto"]."') OR codigo='".$_POST["producto"]."'";
                $bCode = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                $sql="SELECT * FROM general_temporal WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$bCode[0]["codigo_barras"]."' AND usuario=".$_POST["datos_usuario"]["codigo"];
                $temp = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT * FROM general_products_services WHERE codigo_barras='".$bCode[0]["codigo_barras"]."' ";
                $pro = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT cantidad FROM general_stock_products WHERE id_producto='".$pro[0]["idunico"]."' AND id_almacen='".$_POST["datos_usuario"]["idalmacen"]."'";
                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                /*if($stock[0]["cantidad"]>0)
                { */   
                    if($_POST["tipo"]!="FP")
                    {
                        if($_POST["cantidad"]==0 || $_POST["cantidad"]=="" )
                        {
                            $sql="DELETE FROM general_temporal WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$_POST["producto"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."'";
                            consulta::ejecutar_consulta($sql);
                        }
                        else 
                        {
                            if(count($temp)>0)
                            {
                                $donde = "tipo = '".$_POST["tipo"]."' AND producto = '".$_POST["producto"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."'";
                                if(isset($_POST["remision"]))
                                {
                                     $sql="UPDATE general_temporal SET cantidad = cantidad + ".$_POST["cantidad"]." WHERE ".$donde;
                                }
                                else
                                {
                                     $sql = consulta::actualizar($_POST, "general_temporal", $donde);
                                }
                                
                                consulta::ejecutar_consulta($sql);
                            }
                            else 
                            { 
                                $sql="SELECT * FROM general_third WHERE id='".$_POST["cliente"]."'";
                                $cli = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                                $sql="SELECT * FROM general_price_list_products WHERE producto='".$bCode[0]["id"]."' AND lista = '".$cli[0]["listaprecios"]."'";
                                $precio = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                                $temp["producto"]=$bCode[0]["codigo_barras"];
                                $temp["cantidad"]=$_POST["cantidad"];
                                $temp["descuento"]=$_POST["descuento"];
                                $temp["tipo"]=$_POST["tipo"];
                                $temp["cliente"]=$_POST["cliente"];
                                if(isset($_POST["precioventa"]))
                                {
                                    $temp["idunico"]=$_POST["precioventa"];    
                                }
                                else
                                {
                                    $temp["idunico"]=$precio[0]["precio_venta_iva"];;
                                }
                                
                                $temp["usuario"]=$_POST["datos_usuario"]["codigo"];
                                 $sql = consulta::insertar($temp, "general_temporal");
                                consulta::ejecutar_consulta($sql);
                            }
                        }    
                    }
                    else
                    {
                        $sql="SELECT codigo_barras FROM general_products_services WHERE codigo_barras='".$bCode[0]["codigo_barras"]."' OR idunico IN(SELECT idunico FROM general_products_services_barcode WHERE barcode='".$bCode[0]["codigo_barras"]."')";
                        $bCode = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                        $sql="SELECT * FROM general_temporal WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$bCode[0]["codigo_barras"]."' AND usuario=".$_POST["datos_usuario"]["codigo"]." AND idunico='".$_POST["idunico"]."'";
                        $temp = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                        if($_POST["cantidad"]==0 || $_POST["cantidad"]=="" )
                        {
                            $sql="DELETE FROM general_temporal WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$bCode[0]["codigo_barras"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."' AND idunico='".$_POST["idunico"]."'";
                            consulta::ejecutar_consulta($sql);
                        }
                        else 
                        {            
                            if(count($temp)>0)
                            {                
                                if($_POST["lector"]==0)
                                {
                                   $sql = "UPDATE general_temporal SET cantidad = ".$_POST["cantidad"].", descuento='".$_POST["descuento"]."' WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$bCode[0]["codigo_barras"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."' AND idunico='".$_POST["idunico"]."'";
                                    consulta::ejecutar_consulta($sql); 
                                }
                                if($_POST["lector"]==1)
                                {
                                    $sql = "UPDATE general_temporal SET cantidad = cantidad+1, descuento='".$_POST["descuento"]."' WHERE tipo = '".$_POST["tipo"]."' AND producto = '".$bCode[0]["codigo_barras"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."' AND idunico='".$_POST["idunico"]."'";
                                    consulta::ejecutar_consulta($sql);
                                }
                                
                            }
                            else 
                            { 
                                $temp["producto"]=$bCode[0]["codigo_barras"];
                                $temp["cantidad"]=$_POST["cantidad"];
                                $temp["tipo"]=$_POST["tipo"];
                                $temp["cliente"]=$_POST["cliente"];
                                $temp["idunico"]=$_POST["idunico"];
                                $temp["descuento"]=$_POST["descuento"];
                                $temp["usuario"]=$_POST["datos_usuario"]["codigo"];
                
                                $post=consulta::valida_datos_sql('general_temporal', $temp);
                                $sql = consulta::insertar($post, "general_temporal");
                                consulta::ejecutar_consulta($sql);
                            }
                        }
                    }
            }
            if(preg_match("/actualizarTemporalValorProducto\//", $resource, $matches)){
                $sql="UPDATE general_temporal SET idunico ='".$_POST["valor"]."' WHERE producto='".$_POST["producto"]."' AND tipo='RE' AND cliente='".$_POST["cliente"]."' AND usuario='".$_POST["datos_usuario"]["codigo"]."'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/generarMovimiento\//", $resource, $matches)){
                $num = count($_POST["movimientos"]);
                $producto= explode("|", $_POST["producto"]);
                $sql="SELECT * FROM general_products_services WHERE id='".$producto[2]."'";
                $products= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                $sql="SELECT * FROM general_stock_products WHERE id_almacen='".$_POST["origen"]."' and id_producto='".$products[0]["idunico"]."'";
                $stock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="SELECT * FROM general_bodega WHERE id='".$_POST["origen"]."'";
                $bodegaorigen= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                
                if(isset($_POST["destino"]))
                {
                    $sql="SELECT * FROM general_bodega WHERE id='".$_POST["destino"]."'";
                    $bodegadestino= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                }
                
                if($_POST["cantidad"]<$stock[0]["cantidad"])
                {
                    if($num==0)
                    {
                        $_POST["movimientos"][0]["tipo"]=$_POST["tipo"];
                        $_POST["movimientos"][0]["detalle"]=$_POST["detalle"];
                        $_POST["movimientos"][0]["id_almacen"]=$_POST["origen"];
                        $_POST["movimientos"][0]["nom_almacen"]=$bodegaorigen[0]["descripcion"];
                        $_POST["movimientos"][0]["codigo"]=$products[0]["codigo"];
                        $_POST["movimientos"][0]["nombre_comercial"]=$products[0]["nombre_comercial"];
                        $_POST["movimientos"][0]["id_producto"]=$producto[2];
                        $_POST["movimientos"][0]["nom_producto"]=$products[0]["nombre"];
                        $_POST["movimientos"][0]["pcosto"]=$products[0]["p_costo"];
                        $_POST["movimientos"][0]["cantidad"]=$_POST["cantidad"];
                        $_POST["movimientos"][0]["stock"]=$stock[0]["cantidad"];
                    }
                    else
                    {
                        $_POST["movimientos"][$num]["tipo"]=$_POST["tipo"];
                        $_POST["movimientos"][$num]["detalle"]=$_POST["detalle"];
                        $_POST["movimientos"][$num]["id_almacen"]=$_POST["origen"];
                        $_POST["movimientos"][$num]["nom_almacen"]=$bodegaorigen[0]["descripcion"];
                        $_POST["movimientos"][$num]["nombre_comercial"]=$products[0]["nombre_comercial"];
                        $_POST["movimientos"][$num]["codigo"]=$products[0]["codigo"];
                        $_POST["movimientos"][$num]["id_producto"]=$producto[2];
                        $_POST["movimientos"][$num]["nom_producto"]=$products[0]["nombre"];
                        $_POST["movimientos"][$num]["pcosto"]=$products[0]["p_costo"];
                        $_POST["movimientos"][$num]["cantidad"]=$_POST["cantidad"];
                        $_POST["movimientos"][$num]["stock"]=$stock[0]["cantidad"];
                    }
                }
            }
            if(preg_match("/guardarAjuste\//", $resource, $matches)){
                $idunico=uniqid();

                $head["usuario"]=$_POST["datos_usuario"]["codigo"];
                $head["fecha"]=date("d/m/Y");
                $head["bodega"]=$_POST["datos_usuario"]["idalmacen"];
                $head["idunico"]=$idunico;
                $head["tipo"]="ajuste";
                $head["detalle"]="Entrada por Ajuste con fecha ".date("d/m/Y");
                consulta::ejecutar_consulta(consulta::insertar($head, "general_movimientos_head_adjustment"));            
                
                
                for ($i=0; $i < count($_POST["datos"]); $i++) { 
                    
                        if($_POST["datos"][$i]["dif"]!=0)
                        {
                            if($_POST["datos"][$i]["dif"]>0)
                            {
                                //Entrada 
                                $post["fecha"]=date("d/m/Y");
                                $post["idunico"]=$idunico;
                                $post["tipo"]="entrada";
                                $post["detalle"]="Entrada por Ajuste con fecha ".date("d/m/Y");
                                $post["caja"]=1;
                                $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                                $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                                $post["cantidad"]=$_POST["datos"][$i]["dif"];
                                $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["idcaja"]=1;
                                $post["precio_costo"]=$_POST["datos"][$i]["p_costo"];
                                $post["valor_total"]=$_POST["datos"][$i]["total"];
                                $post["id_producto"]=$_POST["datos"][$i]["idunico"];
                                $post["nom_producto"]=$_POST["datos"][$i]["nombre"];
                                
                                consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                
                                echo $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["datos"][$i]["dif"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["datos"][$i]["idunico"]."'";
                                consulta::ejecutar_consulta($sql);
                            }	
                            else
                            {
                                //Salida
                                $post["fecha"]=date("d/m/Y");
                                $post["idunico"]=$idunico;
                                $post["tipo"]="salida";
                                $post["detalle"]="Salida por Ajuste con fecha ".date("d/m/Y");
                                $post["caja"]=1;
                                $post["origen"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["nombre_origen"]=$_POST["datos_usuario"]["textalmacen"];
                                $post["destino"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["nombre_destino"]=$_POST["datos_usuario"]["textalmacen"];            
                                $post["cantidad"]=($_POST["datos"][$i]["dif"]*-1);
                                $post["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                                $post["idcaja"]=1;
                                $post["precio_costo"]=$_POST["datos"][$i]["p_costo"];
                                $post["valor_total"]=$_POST["datos"][$i]["total"];
                                $post["id_producto"]=$_POST["datos"][$i]["idunico"];
                                $post["nom_producto"]=$_POST["datos"][$i]["nombre"];
                                
                                consulta::ejecutar_consulta(consulta::insertar($post, "general_movimientos"));            
                
                                echo $sql="UPDATE general_stock_products SET cantidad = (cantidad + ".$_POST["datos"][$i]["dif"].") WHERE id_almacen='".$_POST["datos_usuario"]["idalmacen"]."' AND id_producto='".$_POST["datos"][$i]["idunico"]."'";
                                consulta::ejecutar_consulta($sql);
                            }
                        }
                        
                        
                }
                
                $sql="DELETE FROM general_temporal WHERE tipo='AI'";
                consulta::ejecutar_consulta($sql);
            }
            if(preg_match("/guardarProducto\//", $resource, $matches)){
                $producto = consulta::valida_datos_sql('general_products_services', $_POST);             
                $producto["p_costo"]=$_POST["precio_compra"];
                $producto["p_costo_pro"]=$_POST["p_costo_pro"];
                $producto["embalaje"]=$_POST["embalaje"];
                $modelo->Guardar($producto, "general_products_services");
                
                $sql="SELECT * FROM general_bodega";
                $bo= consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                for ($i=0; $i < count($bo); $i++) { 
                    $stock["id_almacen"]=$bo[$i]["id"];
                    $stock["nom_almacen"]=$bo[$i]["descripcion"];
                    $stock["id_producto"]=$producto["idunico"];
                    if($_POST["datos_usuario"]["idalmacen"]!=$bo[$i]["id"])
                    {
                        $stock["cantidad"]=0;
                    }
                    else
                    {
                        $stock["cantidad"]=$_POST["cantidad"];    
                    }                
                    $stock["minima"]=$_POST["stock_min"];
                    $stock["maxima"]=$_POST["stock_max"];   
                    $modelo->Guardar($stock, "general_stock_products");
                }
                
                
                $sql="SELECT * FROM general_products_services WHERE idunico='".$producto["idunico"]."'";
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    
                $sql="SELECT * FROM general_price_list";
                $pre = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                for ($i = 0; $i < count($pre); $i++) {
                    $lista["producto"]=$prod[0]["id"];
                    $lista["margen"]=$_POST["margen_".$pre[$i]["id"]];
                    $lista["precio_compra"]=$_POST["precio_compra"];
                    $lista["lista"]=$pre[$i]["id"];
                    $lista["precio_venta"]=$_POST["pventa_".$pre[$i]["id"]];
                    $lista["precio_venta_iva"]=$_POST["pventaiva_".$pre[$i]["id"]];
                    $lista["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                    
                    $sql= consulta::insertar($lista, "general_price_list_products");
                    consulta::ejecutar_consulta($sql);
                }
            }
            if(preg_match("/duplicarProducto\//", $resource, $matches)){
                $producto = consulta::valida_datos_sql('general_products_services', $_POST); 
                $producto["p_costo"]=$_POST["precio_compra"];
                $producto["p_costo_pro"]=$_POST["p_costo_pro"];
                $producto["embalaje"]=$_POST["embalaje"];
                $modelo->Guardar($producto, "general_products_services");
                
                $stock["id_almacen"]=$_POST["datos_usuario"]["idalmacen"];
                $stock["nom_almacen"]=$_POST["datos_usuario"]["textalmacen"];
                $stock["id_producto"]=$producto["idunico"];
                $stock["cantidad"]=$_POST["cantidad"];
                $stock["minima"]=$_POST["stock_min"];
                $stock["maxima"]=$_POST["stock_max"];   
                $modelo->Guardar($stock, "general_stock_products");
    
                $sql="SELECT * FROM general_products_services WHERE idunico='".$producto["idunico"]."'";
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
    
                $sql="SELECT * FROM general_price_list";
                $pre = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                for ($i = 0; $i < count($pre); $i++) {
                    $lista["producto"]=$prod[0]["id"];
                    $lista["margen"]=$_POST["margen_".$pre[$i]["id"]];
                    $lista["precio_compra"]=$_POST["precio_compra"];
                    $lista["lista"]=$pre[$i]["id"];
                    $lista["precio_venta"]=$_POST["pventa_".$pre[$i]["id"]];
                    $lista["precio_venta_iva"]=$_POST["pventaiva_".$pre[$i]["id"]];
                    $lista["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                    
                    $sql= consulta::insertar($lista, "general_price_list_products");
                    consulta::ejecutar_consulta($sql);
                }
            }
            if(preg_match("/actualizarProducto\//", $resource, $matches)){
                $producto = consulta::valida_datos_sql('general_products_services', $_POST); 
            
                $producto["p_costo"]=$_POST["precio_compra"];
                $producto["p_costo_pro"]=$_POST["p_costo_pro"];
                $producto["embalaje"]=$_POST["embalaje"];
                
                if($producto["idunico"]=="")
                {
                    $producto["idunico"]=  uniqid();
                }
                $donde ="id='".$producto["id"]."'";            
                $modelo->Actualizar($producto, "general_products_services", $donde);
                
                $sql="SELECT id, descripcion FROM general_bodega";
                $bodegas = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                //Se insertan o actualizan las cantidades de cada bodega            
                for($i=0;$i<count($bodegas);$i++)
                {
                     $sql="SELECT * FROM general_stock_products WHERE id_producto='".$producto["idunico"]."' AND id_almacen =".$bodegas[$i]["id"];
                    
                    $cantStock = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    if(count($cantStock)>0)
                    {
                        
                            $donde="id_almacen='".$bodegas[$i]["id"]."' AND id_producto='".$producto["idunico"]."'";
                            $stock["minima"]=$_POST["minima".$bodegas[$i]["id"]];
                            $stock["maxima"]=$_POST["maxima".$bodegas[$i]["id"]];                        
                            $modelo->Actualizar($stock, "general_stock_products",$donde);                    
                    }
                    else
                    {                    
                            $stock["id_almacen"]=$bodegas[$i]["id"];
                            $stock["nom_almacen"]=$bodegas[$i]["descripcion"];
                            $stock["id_producto"]=$producto["idunico"];
                            $stock["cantidad"]=0;
                            $stock["minima"]=$_POST["minima".$bodegas[$i]["id"]];
                            $stock["maxima"]=$_POST["maxima".$bodegas[$i]["id"]];
                            $modelo->Guardar($stock, "general_stock_products");                    
                    }
                }
    
                //Se insertan las listas de precio
                $sql="SELECT * FROM general_products_services WHERE idunico='".$producto["idunico"]."'";
                $prod = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                $sql="DELETE FROM general_price_list_products WHERE producto = '".$prod[0]["id"]."'";
                consulta::ejecutar_consulta($sql);
                
                $sql="SELECT * FROM general_price_list";
                $pre = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                
                for ($i = 0; $i < count($pre); $i++) {
                    $lista["producto"]=$prod[0]["id"];
                    $lista["margen"]=$_POST["margen_".$pre[$i]["id"]];
                    $lista["precio_compra"]=$_POST["precio_compra"];
                    $lista["lista"]=$pre[$i]["id"];
                    $lista["precio_venta"]=$_POST["pventa_".$pre[$i]["id"]];
                    $lista["precio_venta_iva"]=$_POST["pventaiva_".$pre[$i]["id"]];
                    $lista["idalmacen"]=$_POST["datos_usuario"]["idalmacen"];
                    
                    $sql= consulta::insertar($lista, "general_price_list_products");                
                    consulta::ejecutar_consulta($sql);
                }
            }
            if(preg_match("/agregarBanco\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_bancos', $_POST);
		echo json_encode($_POST); 
		    echo json_encode($post); 
                //consulta::ejecutar_consulta(consulta::insertar($post, "general_bancos"));
		
            }
            if(preg_match("/actualizarBanco\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_bancos', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_bancos", $donde));
            }
            if(preg_match("/eliminarBanco\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_bancos", $donde));
                }
            }
            if(preg_match("/agregarBodega\//", $resource, $matches)){
                $ciu= explode("|", $_POST['ciudad']);
                $post = consulta::valida_datos_sql('general_bodega', $_POST);
                $post["ciudad"]=$ciu[0];
                consulta::ejecutar_consulta(consulta::insertar($post, "general_bodega"));
            }
            if(preg_match("/actualizarBodega\//", $resource, $matches)){
                $ciu= explode("|", $_POST['ciudad']);
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_bodega', $_POST);
                $post["ciudad"]=$ciu[0];
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_bodega", $donde));
            }
            if(preg_match("/eliminarBodega\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_bodega", $donde));
                }
            }
            if(preg_match("/agregarCondicionesPago\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_condicion_pago', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_condicion_pago"));
            }
            if(preg_match("/actualizarCondicionesPago\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_condicion_pago', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_condicion_pago", $donde));
            }
            if(preg_match("/eliminarCondicinesPago\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_condicion_pago", $donde));
                }
            }
            if(preg_match("/agregarGrupo\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_params"));
            }
            if(preg_match("/actualizarGrupo\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_params", $donde));
            }
            if(preg_match("/eliminarGrupo\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_params", $donde));
                }
            }
            if(preg_match("/agregarImpuesto\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_tax', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_tax"));
            }
            if(preg_match("/actualizarImpuesto\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_tax', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_tax", $donde));
            }
            if(preg_match("/eliminarImpuesto\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_tax", $donde));
                }
            }
            if(preg_match("/agregarLaboratorio\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_params"));
            }
            if(preg_match("/actualizarLaboratorio\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_params", $donde));
            }
            if(preg_match("/eliminarLaboratorio\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_params", $donde));
                }
            }
            if(preg_match("/agregarListaPrecios\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_price_list', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_price_list"));
            }
            if(preg_match("/actualizarListaPrecios\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_price_list', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_price_list", $donde));
            }
            if(preg_match("/eliminarListaPrecios\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_price_list", $donde));
                }
            }
            if(preg_match("/agregarPresentacion\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_params"));
            }
            if(preg_match("/actualizarPresentacion\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_params", $donde));
            }
            if(preg_match("/eliminarPresentacion\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_params", $donde));
                }
            }
            if(preg_match("/agregarRuta\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_params"));
            }
            if(preg_match("/actualizarRuta\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_params', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_params", $donde));
            }
            if(preg_match("/eliminarRuta\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_params", $donde));
                }
            }
            if(preg_match("/agregarTipoDocumento\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_tip_doc', $_POST);
                consulta::ejecutar_consulta(consulta::insertar($post, "general_tip_doc"));
            }
            if(preg_match("/actualziarTipoDocumento\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_tip_doc', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_tip_doc", $donde));
            }
            if(preg_match("/eliminarTipoDocumento\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_tip_doc", $donde));
                }
            }
            if(preg_match("/agregarVendedor\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_third', $_POST);
                $post["tipo"]=4;
                $post["estado"]=1;
                consulta::ejecutar_consulta(consulta::insertar($post, "general_third"));
            }
            if(preg_match("/actualizarVendedor\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_third', $_POST);
                $post["tipo"]=4;            
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_third", $donde));
            }
            if(preg_match("/eliminarVendedor\//", $resource, $matches)){
                $id = explode("|", $_POST["id"]);            
                for($i=0;$i<count($id);$i++)
                {
                    $donde="id='".$id[$i]."'";            
                    consulta::ejecutar_consulta(consulta::eliminar("general_third", $donde));
                }
            }
            if(preg_match("/agregarCliente\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_third', $_POST);         
                consulta::ejecutar_consulta(consulta::insertar($post, "general_third"));
            }
            if(preg_match("/actualizarCliente\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_third', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_third", $donde));
            }
            if(preg_match("/agregarProveedor\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_third', $_POST); 
                $post["tipo"]=2;
                consulta::ejecutar_consulta(consulta::insertar($post, "general_third"));
            }
            if(preg_match("/actualizarProveedor\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_third', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_third", $donde));
            }
            if(preg_match("/agregraTransportista\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_third', $_POST); 
                $post["tipo"]=3;
                consulta::ejecutar_consulta(consulta::insertar($post, "general_third"));
            }
            if(preg_match("/actualizarTransportista\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_third', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_third", $donde));
            }
            if(preg_match("/procesarEmpresa\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_enterprises', $_POST); 
                $donde='1';
                $sql=consulta::seleccionar("*","general_enterprises", $donde);
                $miempresa = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                if (count ($miempresa) > 0) {
                    $donde = 'id='.$miempresa[0]['id'];
                    consulta::ejecutar_consulta(consulta::actualizar($post, "general_enterprises", $donde));
                }
                else
                {
                    consulta::ejecutar_consulta(consulta::insertar($post, "general_enterprises"));
                }
            }
            if(preg_match("/ \//", $resource, $matches)){
             
            }
            if(preg_match("/ \//", $resource, $matches)){
             
            }
            if(preg_match("/ \//", $resource, $matches)){
             
            }
        break;
    }
}
else
{
    echo json_encode(array('status' => 'Error', 'message' => 'No posee Permisos para ingresar a esta informacion'));
}


function middlewareSecurity()
{   
       foreach ($_SERVER as $name => $value) 
       { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
               $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))); 
               $headers[$name] = $value; 
           } else if ($name == "CONTENT_TYPE") { 
               $headers["Content-Type"] = $value; 
           } else if ($name == "CONTENT_LENGTH") { 
               $headers["Content-Length"] = $value; 
           } 
       } 
       
	   if($headers['T0k3n1']=='z1nn14' && $headers['T0k3n2']=='4dv4nc3')
	   {
		   return true;
	   }
		return false;
   
}

function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
}

?>
