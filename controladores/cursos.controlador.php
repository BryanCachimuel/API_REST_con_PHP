<?php 

class ControladorCursos{

    public function index(){

        $clientes = ModeloClientes::index("clientes");

        // validar credenciales del cliente
        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

            foreach($clientes as $key => $values){
                if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($values["id_cliente"]. ":" .$values["llave_secreta"])){
                    $cursos = ModeloCursos::index("cursos");

                    $json=array(
                        "status"=>200,
                        "total_registros"=>count($cursos),
                        "detalle"=>$cursos
                    );
                
                    echo json_encode($json,true);
                    return;
                }
            }     
        }  
    }

    public function crear($datos){
       // validar credenciales del cliente
    $clientes = ModeloClientes::index("clientes");

    if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){

      foreach ($clientes as $key => $valueCliente) {

        if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueCliente["id_cliente"] .":". $valueCliente["llave_secreta"])){
        // validar datos que van a ingresar para crear un curso
          foreach ($datos as $key => $valueDatos) {
            if(isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)){
				
                $json = array(
					"status"=>404,
					"detalle"=>"Error en el campo ".$key
				);
				echo json_encode($json, true);
				return;
			}

          }
  	
		//Validar que el titulo o la descripcion no estén repetidos		
        $cursos = ModeloCursos::index("cursos");

          foreach ($cursos as $key => $value) {
            if($value->titulo == $datos["titulo"]){
				$json = array(
                    "status"=>404,
				    "detalle"=>"El título ya existe en la base de datos"
                );
                echo json_encode($json, true);	
				return;

				}
            if($value->descripcion == $datos["descripcion"]){
                $json = array(
					"status"=>404,
					"detalle"=>"La descripción ya existe en la base de datos"
				);
                echo json_encode($json, true);	
				return;				
			}
        }	
		//Llevar datos al modelo		
          $datos = array( "titulo"=>$datos["titulo"],
                          "descripcion"=>$datos["descripcion"],
                          "instructor"=>$datos["instructor"],
                          "imagen"=>$datos["imagen"],
                          "precio"=>$datos["precio"],
                          "id_creador"=>$valueCliente["id"],
                          "create_at"=>date('Y-m-d h:i:s'),
                          "update_at"=>date('Y-m-d h:i:s'));

        $create = ModeloCursos::crear("cursos", $datos);

	    //Respuesta del modelo
			if($create == "ok"){
			    $json = array(
			        "status"=>200,
				    "detalle"=>"Registro exitoso, su curso ha sido guardado"
				); 
				echo json_encode($json, true); 
				return;    	

		 }

       }

      }
    }
            $json=array(
             "detalle"=>"estas en la vista create"
            );
            echo json_encode($json,true);
            return;
    }


    public function ver($id){
       // validar credenciales del cliente
       $clientes = ModeloClientes::index("clientes");

       if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
        foreach ($clientes as $key => $valueCliente){
            if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueCliente["id_cliente"] .":". $valueCliente["llave_secreta"])){
                // mostrar todos los cursos
                $curso = ModeloCursos::ver("cursos", $id);

                if(!empty($curso)){
                    $json=array(
                        "status"=>200,
                        "detalle"=> $curso);
                    echo json_encode($json,true);
                    return;
                }else{
                    $json=array(
                        "status"=>200,
                        "total_registros"=>0,
                        "detalle"=> "No hay ningún curso registrado"
                    );
                    echo json_encode($json,true);
                    return; 
                }     
           }
         }
       }
    }

    public function actualizar($datos, $id){
       // validar credenciales del cliente
       $clientes = ModeloClientes::index("clientes");

       if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
         foreach ($clientes as $key => $valueCliente){
            if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueCliente["id_cliente"] .":". $valueCliente["llave_secreta"])){
                // validar datos
                foreach ($datos as $key => $valueDatos) {
                    if(isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)){
                        $json = array(
                            "status"=>404,
                            "detalle"=>"Error en el campo ".$key
                        );
                        echo json_encode($json, true);
                        return;
                    }
                }
                // validar id del creador del curso
                $curso = ModeloCursos::ver("cursos", $id);
                foreach($curso as $key => $valueCurso){
                    if($valueCurso->id_creador == $valueCliente["id"]){
                        // llevar datos al modelo
                        $datos = array("id"=>$id,
									   "titulo"=>$datos["titulo"],
									   "descripcion"=>$datos["descripcion"],
									   "instructor"=>$datos["instructor"],
									   "imagen"=>$datos["imagen"],
									   "precio"=>$datos["precio"],
									   "update_at"=>date('Y-m-d h:i:s')
                                    );
                    $actualizar = ModeloCursos::actualizar("cursos", $datos);
                    
                    if($actualizar == "ok"){
                        $json = array(
                            "status"=>200,
                             "detalle"=>"Registro exitoso, su curso ha sido actualizado"
                        ); 
                        echo json_encode($json, true); 
                        return;  
                    }else{
                        $json = array(
                            "status"=>404,
                            "detalle"=>"No está autorizado para modificar este curso"                   
                          );
                        echo json_encode($json, true);
                        return;
                    }
                  }
                }
            }
         }
       }
    }

    public function eliminar($id){
        // validar credenciales del cliente
        $clientes = ModeloClientes::index("clientes");

        if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
            foreach ($clientes as $key => $valueCliente){
                if(base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == base64_encode($valueCliente["id_cliente"] .":". $valueCliente["llave_secreta"])){
                    // validar id del creador
                    $curso = ModeloCursos::ver("cursos", $id);
                    foreach($curso as $key => $valueCurso){
                        if($valueCurso->id_creador == $valueCliente["id"]){
                            // llevar los datos de un curso hacia el modelo
                            $eliminacion = ModeloCuros::eliminar("cursos", $id);
                            if($delete== "ok"){
                                $json = array(
                                    "status"=>200,
                                    "detalle"=>"se ha borrado el curso"                                   
                                );
                                echo json_encode($json, true);
                                return;
                          }
                        }
                    }
                }
            }
        }
    }
}

?>