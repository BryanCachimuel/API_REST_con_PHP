<?php

class ControladorClientes{

    public function crear($datos){

        // preg_match sirve para controlar que en el campo nombre solo se ingresen datos alfabeticos
        // validar campo nombre
        if(isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])){
          
            $json=array(
                "status"=>404,
                "detalle"=>"error en el campo de nombre solo se permiten letras"
            );
    
          echo json_encode($json,true);
          return;
        }

        // validar campo apellido
        if(isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["apellido"])){
          
            $json=array(
                "status"=>404,
                "detalle"=>"error en el campo de apellido solo se permiten letras"
            );
    
          echo json_encode($json,true);
          return;
        }

        // validar campo email
        if(isset($datos["email"]) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $datos["email"])){

            $json=array(
                "status"=>404,
                "detalle"=>"error en el campo de email"
            );
    
          echo json_encode($json,true);
          return;
        }

        // validar que un email no se repita
        $clientes = ModeloClientes::index("clientes");

        foreach($clientes as $key =>$value){
            if($value["email"] == $datos["email"]){
             
                $json=array(
                    "status"=>200,
                    "detalle"=> "el email esta repetido"
                );
            echo json_encode($json,true);
            return;
            }
        }   
    }
}

?>