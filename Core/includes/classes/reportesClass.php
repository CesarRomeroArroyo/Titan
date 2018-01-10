
<?php
/* 
 * Clase para la implementacion de reportes y graficas
 * Elaborada por Cesar Romero Arroyo
 */

class reportes
{
	 /*
     * Metodo que crea la cabecera de una Tabla
     * @param int $borde -> Tamano del borde de la tabla
     * @param int tam -> Tamano de la tabla
     */
    public static function abrir_tabla(){
        return "<table border=1 cellspacing=0 cellpadding=0
                style='border-collapse:collapse;border:none'>";
    }

    /*
     * Metodo que genera el Cierre de una Tabla
     */
    public static function cerrar_tabla()
    {
        return "</table>";
    }
    
    
    /*
     * Metodo que genera una o varias Columnas de una Tabla
     * @param string $dato -> Dato que se mostrara en la Columna
     * @param int $col -> Reliza el ColSpan de la Columna
     */
    public static function crear_columna_titulo($dato="")
    {
        return "<td width=196 valign=top style='border:solid #A5A5A5 1.0pt;
                border-right:none;background:#A5A5A5;padding:0cm 5.4pt 0cm 5.4pt'>
                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                normal'><b><span style='color:white'>".$dato."</span></b></p>
                </td>";
    }
    
    
    
    /*
     * Metodo que genera una o varias Columnas de una Tabla
     * @param string $dato -> Dato que se mostrara en la Columna
     * @param int $col -> Reliza el ColSpan de la Columna
     */
    public static function crear_columna($dato="")
    {
        return "<td width=196 valign=top style='width:100pt;border:solid #C9C9C9 1.0pt;
                border-top:none;background:#EDEDED;padding:0cm 5.4pt 0cm 5.4pt'>
                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                normal'>".$dato."</p>
                </td>";
    }
    public static function crear_columna2($dato="")
    {
        return "<td width=196 valign=top style='width:100pt;border:solid #C9C9C9 1.0pt;
                border-top:none;padding:0cm 5.4pt 0cm 5.4pt'>
                <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
                normal'>".$dato."</p>
                </td>";
    }

}

?>