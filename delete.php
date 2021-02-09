<?php
// Connecion a la base de datos
include("db.php");
// Archivo de configuracion
include('includes/config.php');


$error_msg = 'ERROR: Producto no eliminado';
$success_msg = 'SUCCESS: Producto eliminado satisfactoriamente';
$color = 'danger';

if(isset($_GET['id'])) {
  // Consulta para eliminar
  $id = $_GET['id'];
  $query = "DELETE FROM $table WHERE id = $id";
  $result = mysqli_query($conn, $query);
  // Algo ha fallado
  if(!$result) {
    $_SESSION['message'] = $error_msg;
    $_SESSION['message_type'] = $color;
    header('Location: index.php');
  }
  // Mensajes de alerta
  $_SESSION['message'] = $success_msg;
  $_SESSION['message_type'] = $color;
  // Redireccion a inicio
  header('Location: index.php');
}

?>
