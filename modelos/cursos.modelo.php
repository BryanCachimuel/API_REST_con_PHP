<?php

require_once "conexion.php";

class ModeloCursos{

    static public function index($tabla){   
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->close();
        $stmt = null;
    }

    static public function crear($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(titulo, descripcion, instructor, imagen, precio, id_creador, create_at, update_at) VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :id_creador, :create_at, :update_at)");
        
        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_creador", $datos["id_creador"], PDO::PARAM_STR);
		$stmt -> bindParam(":create_at", $datos["create_at"], PDO::PARAM_STR);
		$stmt -> bindParam(":update_at", $datos["update_at"], PDO::PARAM_STR);

        if($stmt -> execute()){
			return "ok";
		}else{
			print_r(Conexion::conectar()->errorInfo());
		}
		$stmt-> close();
		$stmt = null;
    }
}

?>