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
			if(preg_match("/entry\//", $resource, $matches)){
				
                $datos[0]="iduser";        
                $datos[1]="user";
                $datos[2]="permisos";			
                $datos[3]="Nombre";	
				$datos[4]="codigo";
				$datos[5]="email";			
                $donde="user = '".$_GET['usuario']."' AND pass = '".md5($_GET['pass'])."' AND activo='1'";
                $sql = consulta::seleccionar($datos, 'usuario', $donde);               
                $consulta = consulta::ejecutar_consulta($sql);
				$retorno = consulta::convertir_a_array($consulta);
                if(count($retorno)>0)
                {
					$datosperfil[0]="*";
					$donde="iduser = '".$retorno[0]['iduser']."'";
					$sql = consulta::seleccionar($datosperfil, 'general_perfil_usuario', $donde);               
					$consulta = consulta::ejecutar_consulta($sql);
					$perfil = consulta::convertir_a_array($consulta);
					$retorno[0]['perfil']=$perfil[0]["idperfil"];                    
					$retorno[0]['status']=true;                    					
	                echo json_encode($retorno);
                }
				else
				{
					$retorno[0]['status']=false;
	                echo json_encode($retorno);
				}
            }
            if(preg_match("/buscarPerfiles\//", $resource, $matches)){
                $sql="SELECT * FROM general_perfil";
                $retorno=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($retorno);
            }
            if(preg_match("/buscarMenusActivos\//", $resource, $matches)){
                $sql="SELECT * FROM general_permisos p LEFT JOIN general_menu m ON p.controller=m.id WHERE p.iduser='".$_GET['iduser']."' AND m.state=1";
                $retorno=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                echo json_encode($retorno);
            }
			if(preg_match("/buscarMenusPerfil\//", $resource, $matches)){
                $sql="SELECT * FROM general_permisos p LEFT JOIN general_menu m ON p.controller=m.id WHERE p.iduser='".$_GET['iduser']."'";
                $retorno=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));

                echo json_encode($retorno);
            }
			if(preg_match("/buscarMenus\//", $resource, $matches)){
                $sql="SELECT * FROM general_permisos p LEFT JOIN general_menu m ON p.controller=m.id WHERE m.level='list' OR m.level=''";
                $menu=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                for($i=0; $i<count($menu); $i++)
                {
                    echo $sql="SELECT * FROM general_permisos p LEFT JOIN general_menu m ON p.controller=m.id WHERE m.level='".$menu[$i]["id"]."'";
                    $subMenu=consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                    $menu[$i]['submenus']=$subMenu;
                }
                echo json_encode($menu);
            }
            if(preg_match("/buscarMunicipios\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_municipios");
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($clientes);
            }
            if(preg_match("/buscarGrupoListas\//", $resource, $matches)){
                $datos[0]="*";
                $sql=consulta::seleccionar($datos,"general_grupo_listas");
                $clientes = consulta::convertir_a_array(consulta::ejecutar_consulta($sql));
                echo json_encode($clientes);
            }
        break;
        case 'POST':            
            if(preg_match("/agregarUsuario\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('usuario', $_POST); 
                consulta::ejecutar_consulta(consulta::insertar($post, "usuario"));
            }
            if(preg_match("/actualizarUsuario\//", $resource, $matches)){
                $donde="iduser='".$_POST["iduser"]."'";
                $post = consulta::valida_datos_sql('usuario', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "usuario", $donde));
            }
            if(preg_match("/agregarMenu\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_menu', $_POST); 
                consulta::ejecutar_consulta(consulta::insertar($post, "general_menu"));
            }
            if(preg_match("/actualizarMenu\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_menu', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_menu", $donde));
            }
            if(preg_match("/agregarPermiso\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_permisos', $_POST); 
                consulta::ejecutar_consulta(consulta::insertar($post, "general_permisos"));
            }
            if(preg_match("/actualizarPermiso\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_permisos', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_permisos", $donde));
            }
            if(preg_match("/agregarPerfil\//", $resource, $matches)){
                $post = consulta::valida_datos_sql('general_perfil', $_POST); 
                consulta::ejecutar_consulta(consulta::insertar($post, "general_perfil"));
            }
            if(preg_match("/actualizarPerfil\//", $resource, $matches)){
                $donde="id='".$_POST["id"]."'";
                $post = consulta::valida_datos_sql('general_perfil', $_POST);
                consulta::ejecutar_consulta(consulta::actualizar($post, "general_perfil", $donde));
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
       
	   if($headers['T0k3n1']=='z1nn14')
	   {
		   return true;
	   }
		return true;
   
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