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
                        "stattus"=>200,
                        "total_registros"=>count($cursos),
                        "detalle"=>$cursos
                    );
                
                    echo json_encode($json,true);
                    return;
                }
            }     
        }  
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