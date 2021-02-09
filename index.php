<!-- Coneccion a la base de datos -->
<?php include("db.php"); ?>
<!-- Archivo de configuracion -->
<?php include('includes/config.php'); ?>
<!-- Cabecera -->
<?php include('includes/header.php'); ?>


<!-- HTML -->
<main class="container">
  <!-- ENTRADA: Formulario y tabla -->
    <div class="row pt-4">
      <!-- PRIMERA COLUMNA -->
        <div class="col-md-7">
          <!-- MENSAJES DE ALERTA-->
            <?php if (isset($_SESSION['message'])) { ?>
              <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">X</span>
                </button>
              </div>
            <?php session_unset(); } ?>

          <!-- FORMULARIO -->
            <div class="card card-body">
              <form action="save.php" method="POST">
                <!-- PRIMER INPUT -->
                  <div class="mb-3">
                    <label for="name" class="form-label">
                      <strong>*</strong>Nombre del Producto
                    </label>
                    <input type="text" name="product_name"  id="name" class="form-control"  placeholder="Maximo 20 caracteres" maxlength="20" autofocus required>
                  </div>
                <!-- SEGUNDO INPUT -->
                  <div class="mb-3">
                    <label for="brand" class="form-label">
                      <strong>*</strong>Marca del Producto
                    </label>
                    <input type="text" name="product_brand"  id="brand" class="form-control"  
                    placeholder="Maximo 50 caracteres" maxlength="50" required>
                  </div>
                <!-- TERCER INPUT -->
                  <div class="mb-3">
                    <label for="size" class="form-label">
                      Contenido Neto
                    </label>
                    <input type="number" name="product_size"  id="size" class="form-control" 
                    placeholder="Solo enteros positivos" min="1">
                  </div>
                <!-- CUARTO INPUT -->
                  <div>
                    <label class="form-label">
                      Presentación
                    </label> 
                  </div>
                <!-- OPCIONES -->
                  <select name="measure_unit">
                    <option value="1">Kilogramo</option>
                    <option value="2">Litro</option>
                  </select>
                  <!-- <div class="form-check mb-3">  
                    <input class="form-check-input" type="select" name="bolsa_type" id="plastico" value="plastico">
                    <label class="form-check-label" for="plastico">
                      Plastico
                    </label>
                  </div>
                <!-- SEGUNDA OPCION -->
                  <!-- <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="bolsa_type" id="papel" value="papel">
                    <label class="form-check-label" for="papel">
                      Papel
                    </label>
                  </div> -->
                <!-- QUINTO INPUT -->
                  <div class="mb-3">
                    <label for="units" class="form-label">
                      <strong>*</strong>Cantidad Entrante (unidades)
                    </label>
                    <input type="number" name="units"  id="units" class="form-control" placeholder="Solo enteros positivos" min="1" required>
                  </div>
                <!-- SEXTO INPUT -->
                  <div class="mb-3">
                    <label for="price" class="form-label">
                      <strong>*</strong>Precio de Compra
                    </label>
                    <input type="number" name="buy_price"  id="price" class="form-control" placeholder="Precio por unidad" min="1" step="any" required>
                  </div>
                <!-- SEPTIMO INPUT -->
                  <div class="mb-3">
                    <label for="earn" class="form-label">
                     <strong>*</strong> Ganancia (%)
                    </label>
                    <input type="number" name="earn"  id="earn" class="form-control" placeholder="Porcentaje de Ganancia" min="1" step="any" required>
                  </div>
                <!-- BOTON -->
                  <div class="form-group">
                    <input type="submit" name="save" class="btn btn-success btn-block" value="Guardar">
                  </div>
              </form>
            </div>
        </div>
      <!-- SEGUNDA COLUMNA -->
        <div class="col-md-5">
            <table class="table table-bordered">
              <!-- CABECERA DE LA TABLA -->
                <thead>
                  <tr class="text-center">
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Contenido Neto (unidad)</th>
                    <th>Cantidad Entrante (unidad)</th>
                    <th>Precio de Compra (unidad)</th>
                    <th>Porcentaje de Ganancia</th>
                    <th>Precio Total (unidad)</th>
                    <th>Acción</th>
                  </tr>
                </thead>
              <!-- CUERPO DE LA TABLA -->
                <tbody> 
                  <?php 
                    $query = "SELECT id, `product_name` AS PRODUCT, `product_brand` AS BRAND, product_size AS CONTENIDO_NETO, measure_unit AS PRESENTACION, units AS UNITS, buy_price AS BUY_PRICE, earn AS EARN, created_at AS DATE FROM inventario";
                    $resultados = mysqli_query($conn, $query);
                    $price = 0;
                    $units = 0;
                    $earn = 0;
                    $IVA = 0;
                    $total_price = 0;
                    while($row = mysqli_fetch_assoc($resultados)) { 
                      $price = (float)$row['BUY_PRICE']* (int)$row['UNITS'];
                      $earn = $row['EARN']; 
                      $total_price = $price + ($price * $earn) / 100 ;
                      $IVA = $total_price * 0.16;
                      $total_price = $total_price + $IVA; ?>
                      <tr>
                        <td> <?php echo $row['id']; ?> </td>
                        <td> <?php echo $row['PRODUCT']; ?> </td>
                        <td> <?php echo $row['BRAND']; ?> </td>
                        <td> <?php echo $row['CONTENIDO_NETO'], $row['PRESENTACION']; ?> </td>
                        <?php if( (int)$row['UNITS'] > 1){ ?>
                            <td> <?php echo $row['UNITS'];?> unidades</td>
                        <?php }else{ ?>
                            <td> <?php echo $row['UNITS'];?> unidad</td> 
                        <?php }; ?>
                        <td> <?php echo $row['BUY_PRICE'];?> $</td>
                        <td> <?php echo $row['EARN'];?> %</td>
                        <td> <?php echo $total_price  / (int)$row['UNITS']?> $</td>

                        <td>
                          <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                            <i class="bi bi-pencil-fill"></i>
                            ACTUALIZAR
                          </a> 
                          <br><br>
                          <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                            <i class="bi bi-trash-fill"></i>
                            ELIMINAR
                          </a>
                        </td>
                      </tr>
                  <?php }; ?>        
                </tbody>
            </table>  
          <!-- ICONO 1 -->
            <h3 class="mt-5 text-danger text-center">
              <!-- <i class="bi bi-arrow-90deg-left"></i> -->
            </h3>
          <!-- TITULO -->
            <h3 class="mt-5 text-danger text-center">
                <!-- AGREGA LAS BOLSAS DE TU EMPRESA. -->
            </h3>
          <!-- ICONO 2 -->
            <h3 class="mt-5 text-danger text-center">
              <i class="bi bi-arrow-left-circle-fill"></i>
            </h3>    
        </div>
    </div>
  <!-- SEGUNDA: Formularios y tabla -->
    <div class="row mt-10">
      <!-- FILTRO -->
        <form action="index.php/#table" method="POST">
          <!-- OPCIONES -->
            <select name="filtrado">
              <option value="product_name">Nombre del Producto</option>
              <option value="product_brand">Marca del Producto</option>
              <option value="date">Fecha de Ingreso</option>
            </select>
          <!-- BOTON -->
            <div class="form-group">
              <input type="submit" name="filter" class="btn btn-success btn-block" value="Buscar">
            </div>
        </form>
        <?php if(isset($_POST['filter'])){ ?>
        <?php $filter = $_POST['filtrado']; ?>
        <?php if($filter == 'product_name'){ ?>
      <!-- TABLA -->
          <table class="table table-bordered" id="table">
            <caption>Nombre del Producto</caption>
            <!-- CABECERA DE LA TABLA -->
              <thead>
                <tr class="text-center">
                  <th>Producto</th>
                  <th>Marca</th>
                  <th>Contenido Neto (unidad)</th>
                  <th>Cantidad Entrante (unidad)</th>
                  <th>Precio de Compra (unidad)</th>
                  <th>Porcentaje de Ganancia</th>
                  <th>Precio Total (unidad)</th>
                  <th>Acción</th>
                </tr>
              </thead>
            <!-- CUERPO DE LA TABLA -->
              <tbody> 
                <?php 
                  $query = "SELECT id, `product_name` AS PRODUCT, `product_brand` AS BRAND, product_size AS CONTENIDO_NETO, measure_unit AS PRESENTACION, units AS UNITS, buy_price AS BUY_PRICE, earn AS EARN, created_at AS DATE FROM inventario ORDER BY product_name";
                  $resultados = mysqli_query($conn, $query);
                  $price = 0;
                  $units = 0;
                  $earn = 0;
                  $IVA = 0;
                  $total_price = 0;
                  while($row = mysqli_fetch_assoc($resultados)) { 
                    $price = (float)$row['BUY_PRICE']* (int)$row['UNITS'];
                    $earn = $row['EARN']; 
                    $total_price = $price + ($price * $earn) / 100 ;
                    $IVA = $total_price * 0.16;
                    $total_price = $total_price + $IVA; ?>
                    <tr>
                      <td> <?php echo $row['PRODUCT']; ?> </td>
                      <td> <?php echo $row['BRAND']; ?> </td>
                      <td> <?php echo $row['CONTENIDO_NETO'], $row['PRESENTACION']; ?> </td>
                      <?php if( (int)$row['UNITS'] > 1){ ?>
                          <td> <?php echo $row['UNITS'];?> unidades</td>
                      <?php }else{ ?>
                          <td> <?php echo $row['UNITS'];?> unidad</td> 
                      <?php }; ?>
                      <td> <?php echo $row['BUY_PRICE'];?>$</td>
                      <td> <?php echo $row['EARN'];?>%</td>
                      <td> <?php echo $total_price  / (int)$row['UNITS']?>$</td>

                      <td>
                        <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                          <i class="bi bi-pencil-fill"></i>
                          ACTUALIZAR
                        </a> 
                        <br><br>
                        <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                          <i class="bi bi-trash-fill"></i>
                          ELIMINAR
                        </a>
                      </td>
                    </tr>
                <?php }; ?>        
              </tbody>
          </table>
          <form action="index.php/#table" method="POST">
            <!-- OPCIONES -->
              <select name="filtrado">
                <option value="product_name" selected>Nombre del Producto</option>
                <option value="product_brand">Marca del Producto</option>
                <option value="date">Fecha de Ingreso</option>
              </select>
            <!-- BOTON -->
              <div class="form-group">
                <input type="submit" name="filter" class="btn btn-success btn-block" value="Buscar">
              </div>
          </form>
        <?php }else if($filter == 'product_brand'){ ?>
          <table class="table table-bordered" id="table">
           <caption>Marca del Producto</caption>
            <!-- CABECERA DE LA TABLA -->
              <thead>
                <tr class="text-center">
                  <th>Marca</th>
                  <th>Producto</th>
                  <th>Contenido Neto (unidad)</th>
                  <th>Cantidad Entrante (unidad)</th>
                  <th>Precio de Compra (unidad)</th>
                  <th>Porcentaje de Ganancia</th>
                  <th>Precio Total (unidad)</th>
                  <th>Acción</th>
                </tr>
              </thead>
            <!-- CUERPO DE LA TABLA -->
              <tbody> 
                <?php 
                  $query = "SELECT id, `product_name` AS PRODUCT, `product_brand` AS BRAND, product_size AS CONTENIDO_NETO, measure_unit AS PRESENTACION, units AS UNITS, buy_price AS BUY_PRICE, earn AS EARN, created_at AS DATE FROM inventario ORDER BY product_brand";
                  $resultados = mysqli_query($conn, $query);
                  $price = 0;
                  $units = 0;
                  $earn = 0;
                  $IVA = 0;
                  $total_price = 0;
                  while($row = mysqli_fetch_assoc($resultados)) { 
                    $price = (float)$row['BUY_PRICE']* (int)$row['UNITS'];
                    $earn = $row['EARN']; 
                    $total_price = $price + ($price * $earn) / 100 ;
                    $IVA = $total_price * 0.16;
                    $total_price = $total_price + $IVA; ?>
                    <tr>
                      <td> <?php echo $row['BRAND']; ?> </td>
                      <td> <?php echo $row['PRODUCT']; ?> </td>
                      <td> <?php echo $row['CONTENIDO_NETO'], $row['PRESENTACION']; ?> </td>
                      <?php if( (int)$row['UNITS'] > 1){ ?>
                          <td> <?php echo $row['UNITS'];?> unidades</td>
                      <?php }else{ ?>
                          <td> <?php echo $row['UNITS'];?> unidad</td> 
                      <?php }; ?>
                      <td> <?php echo $row['BUY_PRICE'];?>$</td>
                      <td> <?php echo $row['EARN'];?>%</td>
                      <td> <?php echo $total_price  / (int)$row['UNITS']?>$</td>
                      <td>
                        <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                          <i class="bi bi-pencil-fill"></i>
                          ACTUALIZAR
                        </a> 
                        <br><br>
                        <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                          <i class="bi bi-trash-fill"></i>
                          ELIMINAR
                        </a>
                      </td>
                    </tr>
                <?php }; ?>        
              </tbody>
          </table>
          <form action="index.php/#table" method="POST">
            <!-- OPCIONES -->
              <select name="filtrado">
                <option value="product_name">Nombre del Producto</option>
                <option value="product_brand" selected>Marca del Producto</option>
                <option value="date">Fecha de Ingreso</option>
              </select>
            <!-- BOTON -->
              <div class="form-group">
                <input type="submit" name="filter" class="btn btn-success btn-block" value="Buscar">
              </div>
          </form>
        <?php }else if($filter == 'date'){ ?>
          <table class="table table-bordered" id="table">
             <caption>Fecha de Añadido</caption>
            <!-- CABECERA DE LA TABLA -->
              <thead>
                <tr class="text-center">
                  <th>Añadido</th>
                  <th>Producto</th>
                  <th>Marca</th>
                  <th>Contenido Neto (unidad)</th>
                  <th>Cantidad Entrante (unidad)</th>
                  <th>Precio de Compra (unidad)</th>
                  <th>Porcentaje de Ganancia</th>
                  <th>Precio Total (unidad)</th>
                  <th>Acción</th>
                </tr>
              </thead>
            <!-- CUERPO DE LA TABLA -->
              <tbody> 
                <?php 
                  $query = "SELECT id, `product_name` AS PRODUCT, `product_brand` AS BRAND, product_size AS CONTENIDO_NETO, measure_unit AS PRESENTACION, units AS UNITS, buy_price AS BUY_PRICE, earn AS EARN, created_at AS ADDED FROM inventario ORDER BY created_at";
                  $resultados = mysqli_query($conn, $query);
                  $price = 0;
                  $units = 0;
                  $earn = 0;
                  $IVA = 0;
                  $total_price = 0;
                  while($row = mysqli_fetch_assoc($resultados)) { 
                    $price = (float)$row['BUY_PRICE']* (int)$row['UNITS'];
                    $earn = $row['EARN']; 
                    $total_price = $price + ($price * $earn) / 100 ;
                    $IVA = $total_price * 0.16;
                    $total_price = $total_price + $IVA; ?>
                    <tr>
                      <td> <?php echo $row['ADDED']; ?></td>
                      <td> <?php echo $row['BRAND']; ?> </td>
                      <td> <?php echo $row['PRODUCT']; ?> </td>
                      <td> <?php echo $row['CONTENIDO_NETO'], $row['PRESENTACION']; ?> </td>
                      <?php if( (int)$row['UNITS'] > 1){ ?>
                          <td> <?php echo $row['UNITS'];?> unidades</td>
                      <?php }else{ ?>
                          <td> <?php echo $row['UNITS'];?> unidad</td> 
                      <?php }; ?>
                      <td> <?php echo $row['BUY_PRICE'];?>$</td>
                      <td> <?php echo $row['EARN'];?>%</td>
                      <td> <?php echo $total_price  / (int)$row['UNITS']?>$</td>
                      <td>
                        <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary">
                          <i class="bi bi-pencil-fill"></i>
                          ACTUALIZAR
                        </a> 
                        <br><br>
                        <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                          <i class="bi bi-trash-fill"></i>
                          ELIMINAR
                        </a>
                      </td>
                    </tr>
                <?php }; ?>        
              </tbody>
          </table>
          <form action="index.php/#table" method="POST">
            <!-- OPCIONES -->
              <select name="filtrado">
                <option value="product_name">Nombre del Producto</option>
                <option value="product_brand">Marca del Producto</option>
                <option value="date" selected>Fecha de Ingreso</option>
              </select>
            <!-- BOTON -->
            <div class="form-group">
              <input type="submit" name="filter" class="btn btn-success btn-block" value="Buscar">
            </div>
          </form>
        <?php }else{ ?>
          <strong>ERROR: INTERNO</strong>
        <?php };?>
        <?php };?>
    </div>
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
