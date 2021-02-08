<!-- Coneccion a la base de datos -->
<?php include("db.php"); ?>
<!-- Archivo de configuracion -->
<?php include('includes/config.php'); ?>
<!-- Cabecera -->
<?php include('includes/header.php'); ?>

<?php 
  $query = "SELECT * FROM $table";
  $resultados = mysqli_query($conn, $query);    				
?>

<!-- HTML -->
<main class="container">
  <!-- ENTRADA: Formularios y tabla -->
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
                    <label for="size" class="form-label">
                      Tamaño de Bolsa:
                    </label>
                    <input type="number" name="bolsa_size" id="size" class="form-control"  placeholder="Solo numeros enteros">
                  </div>
                <!-- SEGUNDO INPUT -->
                  <div class="mb-3">
                    <label for="unit"class="form-label">Cantidad Entrante (unidad):</label>
                    <input type="number" name="units" id="unit" class="form-control"  placeholder="Solo numeros enteros">
                  </div>
                <!-- TERCER INPUT -->
                  <div class="mb-3">
                    <label for="price" class="form-label">Precio:</label>
                    <input type="number" name="price" id="price" class="form-control"  placeholder="Precio por docena" step="any">
                  </div>
                <!-- CUARTO INPUT -->
                  <div>
                    <label class="form-label">
                      Tipo de Bolsa:
                    </label> 
                  </div>
                <!-- PRIMERA OPCION -->
                  <div class="form-check mb-3">  
                    <input class="form-check-input" type="radio" name="bolsa_type" id="plastico" value="plastico">
                    <label class="form-check-label" for="plastico">
                      Plastico
                    </label>
                  </div>
                <!-- SEGUNDA OPCION -->
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="bolsa_type" id="papel" value="papel">
                    <label class="form-check-label" for="papel">
                      Papel
                    </label>
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
          <!-- TABLA -->
            <table class="table table-bordered">
              <!-- CABECERA DE LA TABLA -->
                <thead>
                  <tr class="text-center">
                    <!-- <th>Bolsas de Plastico</th>
                    <th>Bolsas de Papel</th>
                    <th>Bolsas Totales</th>
                    <th>Valo del Inventario</th> -->
                  </tr>
                </thead>
              <!-- CUERPO DE LA TABLA -->
                <tbody>         
                  <tr>
                    <?php 
                      // $query = "SELECT SUM(units) AS UNIDADES, SUM(price) AS PRICE, COUNT(1) AS REPETICIONES FROM inventario GROUP BY bolsa_type HAVING COUNT(1) >= 0";
                      $resultados = mysqli_query($conn, $query); 
                      while($row = mysqli_fetch_assoc($resultados)) { ?>   
                        <!-- <td><?php //echo $row['UNIDADES']; ?></td> -->
                    <?php }; ?>
                  </tr>
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
  <!-- TABLAS -->
    <div class="row mt-10">    
      <!-- TABLA 1 -->
        <div class="pt-4">
          <!-- TITULO -->
            <h2 id="t1">
              <!-- <i class="bi bi-handbag-fill"></i>
              Bolsas Totales -->
            </h2>
            <table class="table table-bordered">
              <caption class="text-danger">
                <!-- Cantidad de bolsas totales: <?php echo $int;?> -->
              </caption>
              <!-- CABECERA DE LA TABLA -->
                <thead>
                  <tr>
                    <!-- <th>ID</th>
                    <th>Tipo de Bolsa</th>
                    <th>Tamaño de Bolsa (litros)</th>
                    <th>Unidades</th>
                    <th>Precio por Docena</th>
                    <th>Agregado</th>
                    <th>Acción</th> -->
                  </tr>
                </thead>
              <!-- CUERPO DE LA TABLA -->
                <tbody>
                  <?php
                    $query = "SELECT * FROM $table";
                    $resultados = mysqli_query($conn, $query); 
                    while($row = mysqli_fetch_assoc($resultados)) { ?>       
                    <tr>  
                        <!-- <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['bolsa_type']; ?></td>
                        <td><?php echo $row['bolsa_size']; ?> L</td>
                        <td><?php echo $row['units']; ?></td>
                        <td><?php echo $row['price']; ?> $</td>
                        <td><?php echo $row['added_at']; ?></td> -->
                      
                      <!-- ICONOS -->
                        <td>
                          <a href="edit.php?id=<?php echo $row['id']?>" class="btn btn-primary"><i class="bi bi-pencil-fill"></i></a> 
                          <br> <br>
                          <a href="delete.php?id=<?php echo $row['id']?>" class="btn btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>
                        </td>
                      
                  
                    </tr>
                  <?php } ?>
                </tbody>
            </table>
        </div>
      <!-- TABLA 2 -->
        <div class="pt-4">
          <!-- TITULO -->
          <h2 id="t2">
            <!-- <i class="bi bi-handbag-fill"></i>
            Bolsas Por Tipo -->
          </h2>
          <table class="table table-bordered">
            <caption class="text-danger">
              <!-- Cantidad de bolsas por tipo -->
            </caption>
            <thead>
              <tr>
                <!-- <th>Tipo</th>
                <th>Plastico</th>
                <th>Papel</th>
                <th>Total</th> -->
              </tr>
            </thead>
            <tbody>  
              <tr>
                  <!-- <th>Cantidad</th> -->
                <?php 
                  // $query = "SELECT SUM(units) AS UNIDADES, SUM(price) AS PRICE, COUNT(1) AS REPETICIONES FROM inventario GROUP BY bolsa_type HAVING COUNT(1) >= 0";
                  $resultados = mysqli_query($conn, $query); 
                  while($row = mysqli_fetch_assoc($resultados)) { ?>   
                    <td><?php //echo $row['UNIDADES']; ?></td>
                <?php }; ?>
                  <td><?php echo $total; ?></td>
              </tr>
              <tr>
                  <!-- <th>Valor</th> -->
                <?php 
                  // $query = "SELECT SUM(price) AS PRICE, COUNT(1) AS REPETICIONES FROM inventario GROUP BY bolsa_type HAVING COUNT(1) >= 0";
                  $resultados = mysqli_query($conn, $query); 
                  while($row = mysqli_fetch_assoc($resultados)) { ?>   
                    <td><?php //echo $row['PRICE']; ?>$</td> 
                <?php }; ?>
              </tr>
            </tbody>
          </table>        
        </div>
      <!-- TABLA 3 -->
        <div class="pt-4">
          <h2 id="hsize">
            <!-- <i class="bi bi-handbag-fill"></i>
            Bolsas Por Tamaño -->
          </h2>
          <table class="table table-bordered">
          <caption class="text-danger">
            <!-- Cantidad de bolsas por tamaño -->
          </caption>
          <thead>
              <tr>
                <!-- <th>Tamaño</th> -->
                <?php 
                  // $query = "SELECT bolsa_size AS VALOR, COUNT(1) AS REPETICIONES FROM $table GROUP BY bolsa_size HAVING COUNT(1) >= 0";
                  $resultados = mysqli_query($conn, $query); 
                  while($row = mysqli_fetch_assoc($resultados)) { ?>          
                    <th><?php //echo $row['VALOR'];?>L</th>
                <?php }; ?>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <!-- <th>Cantidad</th> -->
                  <?php 
                    // $query = "SELECT SUM(units) AS UNIDADES, COUNT(1) AS REPETICIONES FROM $table GROUP BY bolsa_size HAVING COUNT(1) >= 0";
                    $resultados = mysqli_query($conn, $query); 
                    while($row = mysqli_fetch_assoc($resultados)) { ?>   
                      <td><?php //echo $row['UNIDADES']; ?></td>
                  <?php }; ?>
                </tr>
                <tr>
                  <!-- <th>Valor</th> -->
                  <?php 
                    // $query = "SELECT SUM(price) AS PRICE, COUNT(1) AS REPETICIONES FROM $table GROUP BY bolsa_size HAVING COUNT(1) >= 0";
                    $resultados = mysqli_query($conn, $query); 
                    while($row = mysqli_fetch_assoc($resultados)) { ?>   
                      <td><?php //echo $row['PRICE']; ?>$</td>
                  <?php }; ?>
                </tr>
            </tbody>
          </table>        
        </div>     
    </div>
</main>

<!-- Footer -->
<?php include('includes/footer.php'); ?>
