<?php

class Conexion{

    static public function conectar(){
        $urlconexion = new PDO("mysql:host=localhost;dbname=api_rest","root","");
        $urlconexion->exec("set names utf8");
        return $urlconexion;
    }

}

?>