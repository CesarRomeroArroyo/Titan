<page backtop="5mm" backbottom="5mm" backleft="1mm" backright="5mm" format="letter" > 
    <?php 
    require_once 'includes/includes.php';  
         $documento = $_SESSION["documento"];
     $facturas = $_SESSION["factura"];

    if($documento=="invoice_head_pos"){ ?>
    <h3>FACTURAS POS</h3>
    <table id="jqGrid" style="width: 100%;" class="pure-table pure-table-bordered">
        <thead>
            <tr class="bg-massalud">
                <th style="border:1px solid white;" class="t-center">Documento</th>
                <th style="border:1px solid white;" class="t-center">Fecha</th>
                <th style="border:1px solid white;" class="t-center">Cliente</th>           
                <th style="border:1px solid white;" class="t-center">Total</th>           
            </tr>
        </thead>
        <tbody>
            <?php 
            $totCant=0;
            $totIva=0;
            $totNeto=0;
            $totTotal=0;
            for ($i=0; $i < count($facturas); $i++) { 
            ?>
            <tr>
                <td><?php echo $facturas[$i]["numfactura"];?></td>
                <td><?php echo Utils::formato_fecha_sql_a_normal($facturas[$i]["fecha"]);?></td>
                <td><?php echo $facturas[$i]["cliente"];?></td>             
                <td><?php echo number_format($facturas[$i]["totaltotales"]);?></td>              
            </tr>
            <?php
            $totCant += $facturas[$i]["totalcantidad"];
            $totIva += $facturas[$i]["totaliva"];
            $totNeto += $facturas[$i]["totalneto"];
            $totTotal += $facturas[$i]["totaltotales"];
            } ?>
        </tbody>
        <tfoot class="bg-massalud">
            <tr>
                <td colspan="3" style="text-align: center"><b>Totales: </b></td>                
                <td colspan="2" style="text-align: left;"><?php echo number_format($totTotal)?></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<?php if($documento=="invoice_head"){ ?>
<h3>FACTURAS DE VENTA</h3>
    <table id="jqGrid" style="width: 100%;" class="pure-table pure-table-bordered">
        <thead>
            <tr class="bg-massalud">
                <th style="border:1px solid white;" class="t-center">Documento</th>
                <th style="border:1px solid white;" class="t-center">Fecha</th>
                <th style="border:1px solid white;" class="t-center">Cliente</th>
                <th style="border:1px solid white;" class="t-center">Saldo</th>
                <th style="border:1px solid white;" class="t-center">Total</th>          
            </tr>
        </thead>
        <tbody>
            <?php 
            $totCant=0;
            $totIva=0;
            $totNeto=0;
            $totTotal=0;
            for ($i=0; $i < count($facturas); $i++) { 
            ?>
            <tr>
                <td><?php echo $facturas[$i]["numfactura"];?></td>
                <td><?php echo Utils::formato_fecha_sql_a_normal($facturas[$i]["fecha"]);?></td>
                <td><?php echo $facturas[$i]["cliente"];?></td>
                <td><?php echo number_format($facturas[$i]["debe"]);?></td>
                <td><?php echo number_format($facturas[$i]["totaltotales"]);?></td>
                
            </tr>
            <?php
            $totCant += $facturas[$i]["totalcantidad"];
            $totIva += $facturas[$i]["totaliva"];
            $totDebe += $facturas[$i]["debe"];
            $totTotal += $facturas[$i]["totaltotales"];
            } ?>
        </tbody>
        <tfoot class="bg-massalud">
            <tr>
                <td colspan="3" style="text-align: center"><b>Totales: </b></td>
                <td style="text-align: left;"><?php echo number_format($totDebe)?></td>
                <td style="text-align: left;"><?php echo number_format($totTotal)?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<?php if($documento=="shopping_suppliers_bills"){ ?>
<h3>FACTURAS DE COMPRA</h3>
    <table id="jqGrid" style="width: 100%;" class="pure-table pure-table-bordered">
        <thead>
            <tr class="bg-massalud">
                <th style="border:1px solid white;" class="t-center">Documento</th>
                <th style="border:1px solid white;" class="t-center">Fecha</th>
                <th style="border:1px solid white;" class="t-center">Cliente</th>
                <th style="border:1px solid white;" class="t-center">Saldo</th>
                <th style="border:1px solid white;" class="t-center">Total</th>            
            </tr>
        </thead>
        <tbody>
            <?php 
            $totCant=0;
            $totIva=0;
            $totNeto=0;
            $totTotal=0;
            for ($i=0; $i < count($facturas); $i++) { 
            ?>
            <tr>
                <td><?php echo $facturas[$i]["num_fact"];?></td>
                <td><?php echo Utils::formato_fecha_sql_a_normal($facturas[$i]["fec_creacion"]);?></td>
                <td><?php echo $facturas[$i]["cliente"];?></td>
                <td><?php echo number_format($facturas[$i]["debe"]);?></td>
                <td><?php echo number_format($facturas[$i]["total_fact"]);?></td>
                
            </tr>
            <?php
            $totCant += $facturas[$i]["totalcantidad"];
            $totIva += $facturas[$i]["totaliva"];
            $totDebe += $facturas[$i]["debe"];
            $totTotal += $facturas[$i]["total_fact"];
            } ?>
        </tbody>
        <tfoot class="bg-massalud">
            <tr>
                <td colspan="3" style="text-align: center"><b>Totales: </b></td>
                <td style="text-align: left;"><?php echo number_format($totDebe)?></td>
                <td style="text-align: left;"><?php echo number_format($totTotal)?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<?php if($documento=="quotation_head"){ ?>
<h3>COTIZACIONES</h3>
    <table id="jqGrid" style="width: 100%;" class="pure-table pure-table-bordered">
        <thead>
            <tr class="bg-massalud">
                <th style="border:1px solid white;" class="t-center">Documento</th>
                <th style="border:1px solid white;" class="t-center">Fecha</th>
                <th style="border:1px solid white;" class="t-center">Cliente</th>
                <th style="border:1px solid white;" class="t-center">Saldo</th>
                <th style="border:1px solid white;" class="t-center">Total</th>           
            </tr>
        </thead>
        <tbody>
            <?php 
            $totCant=0;
            $totIva=0;
            $totNeto=0;
            $totTotal=0;
            for ($i=0; $i < count($facturas); $i++) { 
            ?>
            <tr>
                <td><?php echo $facturas[$i]["id"];?></td>
                <td><?php echo Utils::formato_fecha_sql_a_normal($facturas[$i]["fecha"]);?></td>
                <td><?php echo $facturas[$i]["cliente"];?></td>
                <td><?php echo number_format($facturas[$i]["debe"]);?></td>
                <td><?php echo number_format($facturas[$i]["totaltotales"]);?></td>
                
            </tr>
            <?php
            $totCant += $facturas[$i]["totalcantidad"];
            $totIva += $facturas[$i]["totaliva"];
            $totDebe += $facturas[$i]["debe"];
            $totTotal += $facturas[$i]["totaltotales"];
            } ?>
        </tbody>
        <tfoot class="bg-massalud">
            <tr>
                <td colspan="3" style="text-align: center"><b>Totales: </b></td>
                <td style="text-align: left;"><?php echo number_format($totDebe)?></td>
                <td style="text-align: left;"><?php echo number_format($totTotal)?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<?php if($documento=="referrals_head"){ ?>
<h3>REMISIONES</h3>
    <table id="jqGrid" style="width: 100%;" class="pure-table pure-table-bordered">
        <thead>
            <tr class="bg-massalud">
                <th style="border:1px solid white;" class="t-center">Documento</th>
                <th style="border:1px solid white;" class="t-center">Fecha</th>
                <th style="border:1px solid white;" class="t-center">Cliente</th>
                <th style="border:1px solid white;" class="t-center">Saldo</th>
                <th style="border:1px solid white;" class="t-center">Total</th>           
            </tr>
        </thead>
        <tbody>
            <?php 
            $totCant=0;
            $totIva=0;
            $totNeto=0;
            $totTotal=0;
            for ($i=0; $i < count($facturas); $i++) { 
            ?>
            <tr>
                <td><?php echo $facturas[$i]["id"];?></td>
                <td><?php echo Utils::formato_fecha_sql_a_normal($facturas[$i]["fecha"]);?></td>
                <td><?php echo $facturas[$i]["cliente"];?></td>
                <td><?php echo number_format($facturas[$i]["debe"]);?></td>
                <td><?php echo number_format($facturas[$i]["totaltotales"]);?></td>
                
            </tr>
            <?php
            $totCant += $facturas[$i]["totalcantidad"];
            $totIva += $facturas[$i]["totaliva"];
            $totDebe += $facturas[$i]["debe"];
            $totTotal += $facturas[$i]["totaltotales"];
            } ?>
        </tbody>
        <tfoot class="bg-massalud">
            <tr>
                <td colspan="3" style="text-align: center"><b>Totales: </b></td>
                <td style="text-align: left;"><?php echo number_format($totDebe)?></td>
                <td style="text-align: left;"><?php echo number_format($totTotal)?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
    
</page>