<?php

// mapea la url
$arrayRutas=explode("/",$_SERVER['REQUEST_URI']);
echo "<pre>"; print_r($arrayRutas);echo "</pre>";

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
      $json=array(
        "detalle"=>"estas en la vista cursos"
      );

      echo json_encode($json,true);
      return;
    }
    /*
      cuando se hace una petición a la api sale este mensaje siempre y cuando se ponga como parametro 2 en la url registro (http://localhost/api-rest/registro)
    */
    if(array_filter($arrayRutas)[2] == "registro"){
      $json=array(
        "detalle"=>"estas en la vista registro"
      );

      echo json_encode($json,true);
      return;
    }

 }
}

?>
