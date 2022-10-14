<?php 

class ControladorCursos{

    public function index(){

        $cursos = ModeloCursos::index("cursos");

        $json=array(
            "detalle"=>$cursos
          );
    
          echo json_encode($json,true);
          return;
    }

    public function crear(){
        $json=array(
            "detalle"=>"estas en la vista de crear"
          );
    
          echo json_encode($json,true);
          return;
    }

    public function ver($id){
        $json=array(
            "detalle"=>"este es el curso con el id: ".$id
          );
    
          echo json_encode($json,true);
          return;
    }

    public function actualizar($id){
        $json=array(
            "detalle"=>"curso actualizado correctamente con el id: ".$id
          );
    
          echo json_encode($json,true);
          return;
    }

    public function eliminar($id){
        $json=array(
            "detalle"=>"curso eliminado correctamente con el id: ".$id
          );
    
          echo json_encode($json,true);
          return;
    }

}

?>