<?php
require 'admin/config.php';
require 'functions.php';



$conexion = conexion($bd_config);

if (!$conexion){
    header('Location: error.php');
}

$id_articulo = id_articulo($_GET['id']);
if (empty($id_articulo)){
    header('Location: index.php');
}

$post = obtener_post_por_id($conexion,$id_articulo);

if (!$post){
    header('Location: index.php');
}

$post = $post[0];

require 'views/single.view.php';

?>
