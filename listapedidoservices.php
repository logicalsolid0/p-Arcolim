<?php
session_start();
include("conexion.php");
include("sesion.php");
$sesion = new sesion ();
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser;





  }
 } catch(PDOException $e) {
   echo 'Error: ' . $e->getMessage();
 }
 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <header>
      <a href="home.php"><img src="img/arcolim_Logo.jpg" id="logo_Home" alt=""></a>
      <div class="user">


         <a href="logout.php"> Salir</a>
      </div>
    </header>

    <div class="work_Section">
      <div class="NavBar">
        <nav class="menuMain">
          <ul>
            <li> <a>Productos</a>
                <ul>
                  <li><a href="listadoproducts.php">Listado</a></li>
                  <li><a href="nproducts.php">Registrar</a></li>
                </ul>
            </li>
            <li> <a>Venta</a>
              <ul>
                <li><a href="registroventa.php">Registrar Venta</a></li>
                <li><a href="listadopedido.php"> Listado de Ventas</a></li>
                <li><a href="servicio.php">Registrar Servicio</a> </li>
                <li> <a href="listapedidoservices.php">Listado de Servicios</a> </li>
              </ul>
            </li>
            <li> <a>Proveedores</a>
              <ul>
                <li><a href="listadoproveedores.php">Listado</a></li>
                <li><a href="nproveedor.php">Registrar</a></li>
              </ul>
            </li>
            <li> <a>Clientes</a>
              <ul>
                <li><a href="listadoclientes.php">Listado</a></li>
                <li><a href="ncliente.php">Registrar</a></li>
              </ul>
            </li>
            <li> <a href="">Reportes</a></li>
            <li> <a href="usuarios.php">Usuarios</a></li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Listado de Servicios</h1>
        <form class="" action="" method="post">
          <div id="horizontal">
            <input id="" class="inputShort" type="text" name="nombre_Cliente" placeholder="Nombre" value="<?php if(isset($numeroServicio)){echo $numeroServicio;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
            <input id="" class="inputShort" type="text" name="fecha_Servicio" placeholder="Fecha" value="<?php if(isset($fechaServicio)){echo $fechaServicio;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> />
          </div>

          <div id='horizontal'>
            <button type="submit" class="botonLista"name="btn-search">Filtrar Por nombre</button>
            <button type="submit" class="botonLista"name="btn-searchNF">Filtrar por nombre y fecha</button>
            <button type="submit" class="botonLista"name="btn-searchF">Filtrar por Fecha</button>
            <button type="submit" class="botonLista"name="btn-todos">Mostrar Todos</button>
          </div>

        </form>

        <?php
            //Boton para buscar registros por clientes


            if (isset($_POST['btn-search'])) {
              $nombreCliente=(trim($_POST['nombre_Cliente']));

              $data=[
                'nombreCliente'=>$nombreCliente,
              ];
              $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
              $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE c.nombre_Cliente = :nombreCliente AND s.estado_Servicio!=3";

              $statement = $connect->prepare($query);
              $statement->execute($data);
              echo "<table>
              <tr>
              <td width='150'>Folio</td>
              <td width='150'>Nombre</td>
              <td width='150'>Tipo</td>
              <td width='150'>Descripcion</td>
              <td width='150'>Precio Servicio</td>
              <td width='150'>ID Cliente</td>
              <td width='150'>Nombre Cliente</td>
              <td width='150'>Fecha de realizacion</td>
              <td width='300'></td>
              </tr>";
              while($registro = $statement->fetch())
          {
            echo"
            <tr>
            <td width='150'>".$registro['id_Servicio']."</td>
            <td width='150'>".$registro['nombre_Servicio']."</td>
            <td width='150'>".$registro['tipo_Servicio']."</td>
            <td width='150'>".$registro['descripcion_Servicio']."</td>
            <td width='150'>".$registro['precio_Servicio']."</td>
            <td width='150'>".$registro['id_Cliente']."</td>
            <td width='150'>".$registro['nombre_Cliente']."</td>
            <td width='150'>".$registro['fecha_Realizacion']."</td>
            </tr>
            ";
          }

          echo "</table>";
        }

        if (isset($_POST['btn-searchF'])) {
          $fechaServicio=(trim($_POST['fecha_Servicio']));
          $data=[
            'fechaServicio'=>$fechaServicio,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE s.fecha_Realizacion =:fechaServicio AND s.estado_Servicio!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Nombre</td>
          <td width='150'>Tipo</td>
          <td width='150'>Descripcion</td>
          <td width='150'>Precio Servicio</td>
          <td width='150'>ID Cliente</td>
          <td width='150'>Nombre Cliente</td>
          <td width='150'>Fecha de realizacion</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['id_Servicio']."</td>
        <td width='150'>".$registro['nombre_Servicio']."</td>
        <td width='150'>".$registro['tipo_Servicio']."</td>
        <td width='150'>".$registro['descripcion_Servicio']."</td>
        <td width='150'>".$registro['precio_Servicio']."</td>
        <td width='150'>".$registro['id_Cliente']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['fecha_Realizacion']."</td>
        </tr>
        ";
      }

      echo "</table>";
        }

        if (isset($_POST['btn-searchNF'])) {
          $nombreCliente=(trim($_POST['nombre_Cliente']));
          $fechaServicio=(trim($_POST['fecha_Servicio']));
          $data=[
            'nombreCliente'=>$nombreCliente,
            'fechaServicio'=>$fechaServicio,
          ];
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE c.nombre_Cliente = :nombreCliente AND s.fecha_Realizacion =:fechaServicio AND s.estado_Servicio!=3";

          $statement = $connect->prepare($query);
          $statement->execute($data);
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Nombre</td>
          <td width='150'>Tipo</td>
          <td width='150'>Descripcion</td>
          <td width='150'>Precio Servicio</td>
          <td width='150'>ID Cliente</td>
          <td width='150'>Nombre Cliente</td>
          <td width='150'>Fecha de realizacion</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['id_Servicio']."</td>
        <td width='150'>".$registro['nombre_Servicio']."</td>
        <td width='150'>".$registro['tipo_Servicio']."</td>
        <td width='150'>".$registro['descripcion_Servicio']."</td>
        <td width='150'>".$registro['precio_Servicio']."</td>
        <td width='150'>".$registro['id_Cliente']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['fecha_Realizacion']."</td>
        </tr>
        ";
      }

      echo "</table>";
        }

        if (isset($_POST['btn-todos'])) {
          $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
          $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $query = "SELECT s.id_Servicio, s.nombre_Servicio, s.tipo_Servicio, s.descripcion_Servicio, s.precio_Servicio,c.id_Cliente,c.nombre_Cliente,s.fecha_Realizacion, s.estado_Servicio FROM cat_clientes AS c INNER JOIN listado_servicio AS s ON c.id_Cliente = s.cliente_Servicio WHERE s.estado_Servicio!=3";

          $statement = $connect->prepare($query);
          $statement->execute();
          echo "<table>
          <tr>
          <td width='150'>Folio</td>
          <td width='150'>Nombre</td>
          <td width='150'>Tipo</td>
          <td width='150'>Descripcion</td>
          <td width='150'>Precio Servicio</td>
          <td width='150'>ID Cliente</td>
          <td width='150'>Nombre Cliente</td>
          <td width='150'>Fecha de realizacion</td>
          <td width='300'></td>
          </tr>";
          while($registro = $statement->fetch())
      {
        echo"
        <tr>
        <td width='150'>".$registro['id_Servicio']."</td>
        <td width='150'>".$registro['nombre_Servicio']."</td>
        <td width='150'>".$registro['tipo_Servicio']."</td>
        <td width='150'>".$registro['descripcion_Servicio']."</td>
        <td width='150'>".$registro['precio_Servicio']."</td>
        <td width='150'>".$registro['id_Cliente']."</td>
        <td width='150'>".$registro['nombre_Cliente']."</td>
        <td width='150'>".$registro['fecha_Realizacion']."</td>
        </tr>
        ";
      }

      echo "</table>";
          }


         ?>
      </div>

    </div>
  </body>
</html>