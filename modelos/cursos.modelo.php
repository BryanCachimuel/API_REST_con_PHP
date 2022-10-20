<?php

require_once "conexion.php";

class ModeloCursos{

    static public function index($tabla1, $tabla2){   
        $stmt = Conexion::conectar()->prepare("SELECT $tabla1.id, $tabla1.titulo, $tabla1.descripcion, $tabla1.instructor, 
											  $tabla1.imagen, $tabla1.precio, $tabla1.id_creador, $tabla2.nombre, $tabla2.apellido FROM $tabla1 INNER JOIN $tabla2
											  ON $tabla1.id_creador = $tabla2.id");
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

	static public function ver($tabla1, $tabla2, $id){
		$stmt = Conexion::conectar()->prepare("SELECT $tabla1.id, $tabla1.titulo, $tabla1.descripcion, $tabla1.instructor, 
											   $tabla1.imagen, $tabla1.precio, $tabla1.id_creador, $tabla2.nombre, $tabla2.apellido FROM $tabla1 INNER JOIN $tabla2
											   ON $tabla1.id_creador = $tabla2.id WHERE $tabla1.id=:id");
		$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->close();
        $stmt = null;
	}

	static public function actualizar($tabla, $datos){
		$stmt=Conexion::conectar()->prepare("UPDATE cursos SET titulo=:titulo,descripcion=:descripcion,instructor=:instructor,imagen=:imagen,precio=:precio,update_at=:update_at WHERE id=:id");
		
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
        $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":update_at", $datos["update_at"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			print_r(Conexion::conectar()->errorInfo());
		}
		$stmt-> close();
		$stmt = null;
	}
	
	static public function eliminar($tabla, $id){
		$stmt=Conexion::conectar()->prepare("DELETE  FROM $tabla WHERE id=:id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt->execute()){
            return "ok";
        }else{
           print_r(Conexion::conectar()->errorInfo());
        }
	    $stmt-> close();
		$stmt = null;
	}
}

?>