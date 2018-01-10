<?php @session_start();
require_once 'utilsClass.php';

class consulta{

    
    public static function ejecutar_consulta($sql)
    {

    /* Descripcion: Metodo para la ejecucion de consultas sin usar el patron Singleton
     * Parametros : $param $consulta: Sentecia SQL que sera ejecutada(STRING)     
     * Retorno    : Array con el Resultado de la Consulta(Para selecciones), o estado de la consulta(Inserciones, Actualizaciones y Borrado)     
     * Fecha      :3 de Septiembre de 2011
     */
        @session_start();
        $mysqli = new mysqli('localhost','root','root','admin');
        $resultado=$mysqli->query($sql);         
	return $resultado;
    }
    
    public static function ejecutar_consulta_sgi($sql)
    {

    /* Descripcion: Metodo para la ejecucion de consultas sin usar el patron Singleton
     * Parametros : $param $consulta: Sentecia SQL que sera ejecutada(STRING)     
     * Retorno    : Array con el Resultado de la Consulta(Para selecciones), o estado de la consulta(Inserciones, Actualizaciones y Borrado)     
     * Fecha      :3 de Septiembre de 2011
     */
        @session_start();
        $mysqli = new mysqli('localhost','root','root','admin');
        $resultado=$mysqli->query($sql);         
	return $resultado;
    }

    public static function pasar_a_array($consulta)
    {
        /*Descripcion   : Metodo para realizar mostrar los datos de una consulta
         *                por medio de array (mysql_fetch_array)
         * Parametros   : $param $consulta: Consulta ejecutada
         * Retorno      : Array para recorrer por medio de un While
         * Fecha        : 25 de Julio de 2010
         */
        return @$consulta -> fetch_array(MYSQLI_BOTH);
    }


    public static function pasar_a_array_asociativo($consulta)
    {
        /*Descripcion   : Metodo para realizar mostrar los datos de una consulta
         *                por medio de array (mysql_fetch_array)
         * Parametros   : $param $consulta: Consulta ejecutada
         * Retorno      : Array Asociativo para recorrer por medio de un While
         * Fecha        : 25 de Julio de 2010
         */
        return @$consulta -> fetch_array(MYSQL_ASSOC);
    }

    public static function pasar_a_array_numerico($consulta)
    {
        /*Descripcion   : Metodo para realizar mostrar los datos de una consulta
         *                por medio de array (mysql_fetch_array)
         * Parametros   : $param $consulta: Consulta ejecutada
         * Retorno      : Array Asociativo para recorrer por medio de un While
         * Fecha        : 25 de Julio de 2010
         */
        return @$consulta -> fetch_array(MYSQL_NUM);
    }


    public static function numero_col($consulta)
    {
        /* Descripcion  :Metodo para conocer el numero de registros devuelto
         *               en la ejecutacion de una consulta
         * Parametros   :$param $consulta: Consulta ejecutada
         * Retorno      :Numero de registros devuelto por la ejecucion de una
         *               Consulta
         * Fecha        :25 de Julio de 2010
         */
        $retorno = consulta::convertir_a_array($consulta);
	return count($retorno);
    }
    
    public static function nom_col($tabla)
    {
        /* Descripcion  :Metodo para conocer el nombre de las columnas de una tabla
         * Parametros   :$param $tabla: Nombre de la Tabla
         *               $param $conexion: Objeto de Conexion a Base de Datos
         * Retorno      :String con el nombre de las columnas de una tabla
         *               separado por comas(,)
         * Fecha        :25 de Julio de 2010
         */        
         $sql="SHOW COLUMNS FROM ".$tabla;
	 $consulta=consulta::ejecutar_consulta($sql);
	 while($rw=consulta::pasar_a_array($consulta))
	 {
	       	$i= $i + 1;
	       	$num_col=consulta::numero_col($consulta);
            $columnas.=$rw['Field'];
            if($i!=$num_col)
		      {
			     $columnas.=", ";
		      }
	 }
	 return $columnas;
    }

   

    public static function valida_variable_sql($valor)
    {
        /* Descripcion  :Metodo para Validar las variables evitando el SQL Injection
         * Parametros   :$param $var: Variable a ser verificada
         * Retorno      :$var: Variable Verificada
         * Fecha        :25 de Julio de 2010
         */
        
            if (ereg("(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}", $valor)) {
            
                $valor=Utils::formato_fecha_normal_a_sql($valor);
            }
        
            
        
        $valor = str_ireplace("SELECT","",$valor);
	$valor = str_ireplace("COPY","",$valor);
	$valor = str_ireplace("DELETE","",$valor);
	$valor = str_ireplace("DROP","",$valor);
	$valor = str_ireplace("DUMP","",$valor);
	$valor = str_ireplace(" OR ","",$valor);	
	$valor = str_ireplace("LIKE","",$valor);
        
        return $valor;
    }

    public static function valida_array_sql($var)
    {
        $n = count($var);
        for($i=0;$i<=$n-1;$i++)
        {
            $var[$i]= consulta::valida_variable_sql($var[$i]);
        }
        return $var;
    }
    
    public static function valida_datos_sql($tabla, $post)
    {
        $sql="SHOW COLUMNS FROM ".$tabla;
        $consulta=consulta::ejecutar_consulta($sql);
        while($rw=consulta::pasar_a_array($consulta))
	{
            if(isset($post[$rw['Field']]) || $post[$rw['Field']]!="" || $post[$rw['Field']]!=null)
            {
                $variable[$rw['Field']]=$post[$rw['Field']];
            }
        }
        return $variable;
    }
    
    public static function valida_datos_sql_sgi($tabla, $post)
    {
        $sql="SHOW COLUMNS FROM ".$tabla;
        $consulta=consulta::ejecutar_consulta_sgi($sql);
        while($rw=consulta::pasar_a_array($consulta))
	{
            $variable[$rw['Field']]=$post[$rw['Field']];
        }
        return $variable;
    }
    
    public static function valida_datos_sql_fecha($tabla, $post, $fec)
    {
        
        $sql="SHOW COLUMNS FROM ".$tabla;
        $consulta=consulta::ejecutar_consulta($sql);
        while($rw=consulta::pasar_a_array($consulta))
	{
            if($rw['Type']=='date')
            {                
               if($post[$rw['Field']]!="")
               {       
                   
                    //$post[$rw['Field']]=$post[$rw['Field']][0].$post[$rw['Field']][1]."/".$post[$rw['Field']][2].$post[$rw['Field']][3]."/".$post[$rw['Field']][4].$post[$rw['Field']][5].$post[$rw['Field']][6].$post[$rw['Field']][7];                    
                    $tiempo = validaciones::tiempo_transcurrido($fec,$post[$rw['Field']]);
                    
                    $meses = (int)($tiempo[0]*12)+ (int)$tiempo[1];
                    $dias = $tiempo[2];
                    if($meses>=0)
                    {
                        $variable[$rw['Field']."_m"]=$meses;
                        $variable[$rw['Field']."_d"]=$dias;                        
                    }
                    else
                    {
                        $variable[$rw['Field']]='';
                    }
                }
            }
       }
        
        return $variable;
    }
    
    public static function insertar($post, $tabla)
    {
     /*Descripcion: Metodo que genera una cadena SQL para insercion de datos a la Base de Datos
     * Parametros : $param $post: Array Asociativo de tipo array[nombre del campo]= "valor a agregar"
      *             $param $tabla: Tabla a la que apunta la insercion
     * Retorno    : Cadena (STRING) de insercion para ser ejecutada por el medoto ejecutar_consulta()
     * Fecha      : 12 de Junio de 2010
     */
        //SE OBTIENEN LOS INDICES Y DATOS DEL ARRAY ENVIADO
        $indices=@array_keys($post);
        $datos=@array_values($post);
        //SE DEFINE EL NUMERO DE DATOS QUE SE VANA INSERTAR
        $num_val=count($datos)-1;
        
        //SE RECORREN LOS DOS ARRAYS DE INDICES Y VALORES PARA CREAR LA CADENA DE INSERCION
        for($i=0;$i<=$num_val;$i++)
        {
            
            @$indice.=$indices[$i];
            if($i!=$num_val)
            {
                $indice.=", ";
            }
        }
        
        $i=0;
        for($i=0;$i<=$num_val;$i++)
        {
            
            @$valor.="'".consulta::valida_variable_sql($datos[$i])."'";
            if($i!=$num_val)
            {
                $valor.=", ";
            }
        }
        
        $sql="INSERT INTO ".$tabla." (".$indice.") VALUES (".$valor.")";
//        consulta::crear_log("Insercion: ".$tabla.", Valores: ".$valor);
        return $sql;
        //return $this->ejecutar_consulta($resultado);
    }

    public static  function actualizar($post, $tabla="", $donde="")
    {
     /*Descripcion: Metodo que genera una cadena SQL para actualizacion de datos a la Base de Datos
     * Parametros : $param $post: Array Asociativo de tipo
      *                           array[nombre del campo]= "valor a actualizar"
      *             $param $tabla:Tabla a la que apunta la actualizacion
      *             $param $donde:Variable con el WHERE de la consulta ej: $donde="id='3'"
     * Retorno    : Cadena (STRING) de actualizacion para ser ejecutada por el medoto ejecutar_consulta()
     * Fecha      :12 de Junio de 2010
     */
        $indices=@array_keys($post);
        $datos=@array_values($post);

        $num_val=count($datos)-1;
        
        
        for($i=0;$i<=$num_val;$i++)
        {            
            @$valores.=$indices[$i]." = '".consulta::valida_variable_sql($datos[$i])."'";
            if($i!=$num_val)
            {
                $valores.=", ";
            }
        }
        
        $sql= "UPDATE ".$tabla." SET ".$valores." WHERE ".$donde;
//        consulta::crear_log("Actualizacion: ".$tabla.", Valores: ".$valores.", Criterio ".$donde);
        return $sql;
        //return $this->ejecutar_consulta($resultado);
    }

    public static function eliminar($tabla="", $donde='1')
    {
    /*Descripcion: Metodo que genera una cadena SQL para eliminacion de datos a la Base de Datos
     * Parametros : $param $tabla: Tabla a la que apunta la eliminacion
     *              $param $donde: Variable con el WHERE de la consulta.
     * Retorno    : Cadena (STRING) de seleccion para ser ejecutada por el medoto AdminConsulta::ejecutar_consulta()
     * Fecha      :12 de Junio de 2010
     */
        
        $sql="DELETE FROM ".$tabla." WHERE ".$donde;
//        consulta::crear_log("Eliminacion: ".$tabla.", Criterio: ".$donde);
        return $sql;
    }

    public static function seleccionar($datos, $tabla="", $donde='1', $ordenar='')
    {
    /*Descripcion: Metodo que genera una cadena SQL para seleccion de datos a la Base de Datos
     * Parametros : $param $datos: Array con los datos a Seleccionar
     *              $param $tabla: Tabla a la que apunta la seleccion
     *              $param $donde: variable con el WHERE de la consulta.
     *              $param $ordenar: variable ORDER BY o GROUP BY de la consulta.
     * Retorno    : Cadena (STRING) de seleccion para ser ejecutada por el medoto ejecutar_consulta()
     * Fecha      :12 de Junio de 2010
     */
        $i=0;
		$valores="";
        $num=count($datos);
        for($i=0;$i<=$num;$i++)
        {
            @$valores.=consulta::valida_variable_sql($datos[$i]);

            if($i<$num)
            {
                $valores.=", ";
            }
        }
        $valores = substr ($valores, 0, -2);
        $sql="SELECT ".$valores." FROM ".$tabla." WHERE ".$donde ." ". $ordenar;
        //consulta::crear_log("Seleccion: ".$tabla.", Valores: ".$valores. ", Criterio: ".$donde);
        
        return $sql;
    }
    
   public static function convertir_a_array($consulta)
   {
     /*Descripcion: Metodo que Convierte a un array del tipo a[1][fila][dato] el resultado de una consulta
     * Parametros : Array de resultado de una consulta de seleccion     
     * Fecha      : 3 de Septiembre de 2011
     */
       $i=0;
       
       while($row=consulta::pasar_a_array_asociativo($consulta))
       {
           $return[$i]=$row;
           $i++;
       }       
       return $return;
   }
   
   public static function crear_log($accion)
    {
     /*Descripcion: Metodo que crea una entrada a una tabla de log (logs) 
     * Parametros : Accion realizada que se registrara
     * Fecha      : 3 de Septiembre de 2011
     */
        $sql= "insert into logs values('','".consulta::valida_variable_sql($accion)."', '".$_SESSION['datos_usuario']['nombre']." : ".$_SESSION['datos_usuario']['codigo']."', '".date('Y-m-d')."', '".date('h:i:s A')."')";
        $consulta= consulta::ejecutar_consulta($sql);
    }
    
        public static function maximo($post, $tabla="")
    {
     /*Descripcion: Metodo que genera el maximo dato de un campo en una tabla
     * Parametros : $param $post: Array Asociativo de tipo
      *                           array[nombre del campo]= "valor a buscar el maximo"
      *             $param $tabla:Tabla a la que apunta la actualizacion
     * Retorno    : el ultimo dato de un campo
     * Fecha      :16 de Abril de 2012
     */
        $sql= "Lock tables ".$tabla." write";                   
	$consulta= consulta::ejecutar_consulta($sql);

        $sql= "SELECT max(".$post.") as ultimo FROM ".$tabla;
	$consulta= consulta::ejecutar_consulta($sql);
        
        $ultimo_id= consulta::convertir_a_array($consulta);
        
        $sql= "unlock tables";
	$consulta= consulta::ejecutar_consulta($sql);       
           
       return $ultimo_id;
    }
	
	public static function siguiente($post, $tabla="")
    {
     /*Descripcion: Metodo que genera el maximo dato de un campo en una tabla
     * Parametros : $param $post: Array Asociativo de tipo
      *                           array[nombre del campo]= "valor a buscar el maximo"
      *             $param $tabla:Tabla a la que apunta la actualizacion
     * Retorno    : el ultimo dato de un campo
     * Fecha      :16 de Abril de 2012
     */

        echo $sql= "Lock tables ".$tabla." write";                   
	   $consulta= consulta::ejecutar_consulta($sql);

        echo $sql= "SELECT max(".$post.")+1 as siguiente FROM ".$tabla;
	   $consulta= consulta::ejecutar_consulta($sql);
           
        echo $sql= "unlock tables";
	   $consulta= consulta::ejecutar_consulta($sql);       
           
       return $consulta;

    }

}

?>
