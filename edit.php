<?php
  // Conneccion a la base de datos
  include("db.php");
  // Archivo de configuracion
  include('includes/config.php');

  $product_name   = '';
  $product_brand  = '';
  $product_size   = '';
  $measure_unit   = '';
  $units          = '';
  $buy_price      = '';
  $earn           = '';
  $success_msg = 'SUCCESS: Producto actualizado satisfactoriamente';


  if  (isset($_GET['id'])) {
    // Consulta a la tabla task
    $id = $_GET['id'];
    $query = "SELECT * FROM $table WHERE id=$id";
    $result = mysqli_query($conn, $query);
    
    // La consulta fue existosa
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_array($result);
      
      // Actualiza los valores de las variables de ayuda 
      $product_name  = $row['product_name'];
      $product_brand = $row['product_brand'];
      $product_size  = $row['product_size'];
      $measure_unit  = $row['measure_unit'];
      $units         = $row['units'];
      $buy_price     = $row['buy_price'];
      $earn          = $row['earn'];
    }
  }

  if (isset($_POST['update'])) {
    
    // Actualiza variables de ayuda con valores nuevos
    $id = $_GET['id'];
    $product_name  = $_POST['product_name'];
    $product_brand = $_POST['product_brand'];
    $product_size  = $_POST['product_size'];
    $measure_unit  = $_POST['measure_unit'];
    $units         = $_POST['units'];
    $buy_price     = $_POST['buy_price'];
    $earn          = $_POST['earn'];
    
    // Consulta para actualizar
    $query = "UPDATE $table set product_name = '$product_name', product_brand = '$product_brand', product_size = '$product_size', measure_unit = '$measure_unit', units = '$units', buy_price = '$buy_price', earn = '$earn' WHERE id=$id";
    mysqli_query($conn, $query);
    
    // Mensajes de alerta
    $_SESSION['message'] = $success_msg;
    $_SESSION['message_type'] = 'warning';
    
    // Redireccion al inicio
    header('Location: index.php');
  }

?>
<?php include('includes/header.php'); ?>

<!-- FORMULARIO DE ACTUALIZACION -->
<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto">
      <div class="card card-body">
        <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
          <!-- PRIMER INPUT -->
            <div class="mb-3">
              <label for="name" class="form-label">
                <strong>*</strong>Nombre del Producto
              </label>
              <input type="text" name="product_name"  id="name" class="form-control"  placeholder="Maximo 20 caracteres" value="<?php echo $product_name ?>" maxlength="20" autofocus required>
            </div>
          <!-- SEGUNDO INPUT -->
            <div class="mb-3">
              <label for="brand" class="form-label">
                <strong>*</strong>Marca del Producto
              </label>
              <input type="text" name="product_brand"  id="brand" class="form-control"  placeholder="Maximo 50 caracteres" value="<?php echo $product_brand ?>" maxlength="50" required>
            </div>
          <!-- TERCER INPUT -->
            <div class="mb-3">
              <label for="size" class="form-label">
                Contenido Neto
              </label>
              <input type="number" name="product_size"  id="size" class="form-control" placeholder="Solo enteros positivos" min="1" 
              value="<?php echo $product_size ?>" >
            </div>
          <!-- CUARTO INPUT -->
            <div>
              <label class="form-label">
                Presentación
              </label> 
            </div>
          <!-- OPCIONES -->
            <?php if($measure_unit == "KG"){ ?>
              <select name="measure_unit">
                <option value="1" selected>Kilogramo</option>
                <option value="2">Litro</option>
              </select>
            <?php }else{ ?>
              <select name="measure_unit">
                <option value="1" >Kilogramo</option>
                <option value="2" selected>Litro</option>
              </select>
            <?php }; ?>
          <!-- QUINTO INPUT -->
            <div class="mb-3">
              <label for="units" class="form-label">
                <strong>*</strong>Cantidad Entrante (unidades)
              </label>
              <input type="number" name="units"  id="units" class="form-control" placeholder="Solo enteros positivos" value="<?php echo $units ?>"  min="1" required>
            </div>
          <!-- SEXTO INPUT -->
            <div class="mb-3">
              <label for="price" class="form-label">
                <strong>*</strong>Precio de Compra
              </label>
              <input type="number" name="buy_price"  id="price" class="form-control" placeholder="Precio por unidad" value="<?php echo $buy_price ?>"  min="1" step="any" required>
            </div>
          <!-- SEPTIMO INPUT -->
            <div class="mb-3">
              <label for="earn" class="form-label">
                <strong>*</strong> Ganancia (%)
              </label>
              <input type="number" name="earn"  id="earn" class="form-control" placeholder="Porcentaje de Ganancia" value="<?php echo $earn ?>"  min="1" step="any" required>
            </div>
          <!-- BOTON -->
            <div class="form-group">
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
