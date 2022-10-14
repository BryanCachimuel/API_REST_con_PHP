<?php

// mapea la url
$arrayRutas=explode("/",$_SERVER['REQUEST_URI']);
//echo "<pre>"; print_r($arrayRutas);echo "</pre>";

/*
  cuando no se hace una petición a la api sale este mensaje
*/
if(count(array_filter($arrayRutas)) == 1){
  $json=array(
    "detalle"=>"no encontrado"
  );

  echo json_encode($json,true);
  return;

}else{
  /*
    cuando se hace una petición a la api sale este mensaje siempre y cuando se ponga como parametro 2 en la url cursos (http://localhost/api-rest/cursos/)
  */
  if(count(array_filter($arrayRutas)) == 2){

    if(array_filter($arrayRutas)[2] == "cursos"){

      /* controla que se envie una consulta al servidor de tipo POST */
      if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){

        /* manda a llamar a la clase ControladorCursos que se encuentra en el archivo cursos.controlador.php */
        $cursos = new ControladorCursos;
        $cursos->index();
      }

      else if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST"){
        $cursos = new ControladorCursos;
        $cursos->crear();
      }
    }


    /*
      cuando se hace una petición a la api sale este mensaje siempre y cuando se ponga como parametro 2 en la url registro (http://localhost/api-rest/registro)
    */
    if(array_filter($arrayRutas)[2] == "registro"){

      if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){
        $clientes = new ControladorClientes;
        $clientes->crear();
      }
    }

 }else{
  /* estamos evaluando si la ruta esta en el indice 2 que es cursos se lea también que exista un numero en el indice 3 */
  if(array_filter($arrayRutas)[2] == "cursos" && is_numeric(array_filter($arrayRutas)[3])){
    
    /*=======================================
      Peticion GET
    ========================================*/
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "GET"){
      $cursos = new ControladorCursos;
      $cursos->ver(array_filter($arrayRutas)[3]);
    }

    /*=======================================
      Peticion PUT
    ========================================*/
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "PUT"){
      $editarcursos = new ControladorCursos;
      $editarcursos->actualizar(array_filter($arrayRutas)[3]);
    }

    /*=======================================
      Peticion DELETE
    ========================================*/
    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "DELETE"){
      $eliminarcursos = new ControladorCursos;
      $eliminarcursos->eliminar(array_filter($arrayRutas)[3]);
    }
  }

 }
}

?>
