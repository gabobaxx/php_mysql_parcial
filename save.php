<?php
// Connecion a la base de datos
include('db.php');
// Archivo de configuracion
include('includes/config.php');

$error_msg = 'ERROR: Producto no guardado';
$success_msg = 'Producto guardado satisfactoriamente';
$color = 'danger';

if (isset($_POST['save'])) {

  $product_name   = $_POST['product_name'];
  $product_brand  = $_POST['product_brand'];
  $product_size   = $_POST['product_size'];  // Contenido Neto 
  $measure_unit   = $_POST['measure_unit']; // Unidades de medida (KG o L)
  $units          = $_POST['units'];
  $buy_price      = $_POST['buy_price'];
  $earn           = $_POST['earn'];

  $query = "INSERT INTO $table(product_name, product_brand, product_size, measure_unit, units, buy_price, earn) VALUES ('$product_name', '$product_brand', '$product_size', '$measure_unit', '$units', '$buy_price', '$earn')";
  $result = mysqli_query($conn, $query);
  
  // Algo fallo
  if(!$result) {
    // Mensajes de alerta 
    $_SESSION['message'] = $error_msg;
    $_SESSION['message_type'] = $color;
    // Redireccion a inicio
    header('Location: index.php');
  }
  // Mensajes de alerta 
  $_SESSION['message'] = $success_msg;
  $_SESSION['message_type'] = 'success';
  // Redireccion a inicio
  header('Location: index.php');

}

?>
