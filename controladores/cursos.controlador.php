<?php 

class ControladorCursos{

    public function index(){
        $json=array(
            "detalle"=>"estas en la vista cursos"
          );
    
          echo json_encode($json,true);
          return;
    }

}

?>