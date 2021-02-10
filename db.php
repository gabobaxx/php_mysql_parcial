<?php

session_start();
include('includes/config.php');

$conn = mysqli_connect(
  $host,
  $usuario,
  $clave,
  $db
) or die(mysqli_erro($mysqli));
?>
