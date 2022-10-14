<?php

  require_once "controladores/rutas.controlador.php";
  require_once "controladores/cursos.controlador.php";
  
  // instancia de la clase creada en el archivo rutas.controlador.php
  $rutas = new ControladorRutas();
  $rutas->inicio();

?>
