<?php

class ControladorClientes{

    public function crear(){
        $json=array(
            "detalle"=>"estas en la vista registro"
          );
    
          echo json_encode($json,true);
          return;
    }
}

?>