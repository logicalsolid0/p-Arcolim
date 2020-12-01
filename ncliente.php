<?php
session_start();
include("conexion.php");
include_once 'sesion.php';
$sesion = new sesion ();
?>
<?php
try {
  if (!isset($_SESSION['user'])){
    header('Location: index.php');
  }
  else {
    $currentUser = $sesion->getCurrentUser();
    echo '<h2> Bienvenido </h2>' .$currentUser ;

    if(isset($_POST["btn-regCliente"])){

          $id_Cliente = trim($_POST['id_Cliente']);
          $name_Cliente= trim($_POST['name_Cliente']);
          $apellido_Paterno = trim($_POST['apellido_Paterno']);
          $razonSocial_Cliente = trim($_POST['razonSocial_Cliente']);
          $rfc_Cliente = trim($_POST['rfc_Cliente']);
          $email_Cliente = trim($_POST['email_Cliente']);
          $tel_Cliente = trim($_POST['tel_Cliente']);
          $calle_Cliente = trim($_POST['calle_Cliente']);
          $numeroExt_Cliente = trim($_POST['numeroExt_Cliente']);
          $numeroInt_Cliente = trim($_POST['numeroInt_Cliente']);
          $colonia_Cliente = trim($_POST['colonia_Cliente']);
          $ciudad_Cliente = trim($_POST['ciudad_Cliente']);
          $estado_Cliente = trim($_POST['estado_Cliente']);

          if(empty($id_Cliente))
          {
           $error = "Por favor ingresa un ID";
           $code = 1;
          }
          else if(!is_numeric($id_Cliente))
          {
           $error = "Solo se admiten numeros";
           $code = 1;
          }
           else if(empty($name_Cliente))
           {
            $error = "Ingresa tu nombre";
            $code = 2;
           }
           else if(!ctype_alpha($name_Cliente))
           {
            $error = "Solo se admiten letras";
            $code = 2;
           }
           else if(empty($apellido_Paterno))
           {
            $error = "Ingresa tu apellido Paterno";
            $code = 3;
           }
           else if(!ctype_alpha($apellido_Paterno))
           {
            $error = "Solo se admiten letras en este campo";
            $code = 3;
           }
           else if(empty($razonSocial_Cliente))
           {
            $error = "Ingresa la razon social";
            $code = 4;
           }
           else if(empty($rfc_Cliente))
            {
            $error = "Ingresa el RFC";
            $code = 5;
            }
           else if(empty($email_Cliente))
           {
            $error = "Ingresa tu Correo electronico";
            $code = 6;
           }
           else if(!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email_Cliente))
           {
            $error = "La direccion de correo no es valida";
            $code = 6;
           }
           else if(empty($tel_Cliente))
           {
            $error = "Ingresa tu numero telefonico";
            $code = 7;
           }
           else if(!is_numeric($tel_Cliente))
           {
            $error = "Solo se admiten numeros";
            $code = 7;
           }
           else if(strlen($tel_Cliente)!=10)
           {
            $error = "Solo se admiten 10 caracteres";
            $code = 7;
           }
           else if(empty($calle_Cliente))
           {
            $error = "Ingresa la calle";
            $code = 8;
           }
            else if(empty($numeroExt_Cliente))
            {
             $error = "Ingresa un numero exterior";
             $code = 9;
           }
           else if(empty($numeroInt_Cliente))
            {
            $error = "Ingresa un numero interior";
            $code = 10;
            }
            else if(empty($colonia_Cliente))
             {
             $error = "Ingresa la colonia";
             $code = 11;
             }
             else if(empty($ciudad_Cliente))
              {
              $error = "Ingresa la ciudad";
              $code = 12;
              }
              else if(empty($estado_Cliente))
               {
               $error = "Ingresa el estado";
               $code = 13;
               }
           else {
             $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
             $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $query = "SELECT * FROM cat_clientes WHERE id_Cliente = :id_Cliente";
             $statement = $connect->prepare($query);
             $statement->execute(
                 [
                   'id_Cliente' => $id_Cliente,
                 ]
                );
               $count = $statement->rowCount();
               if($count > 0)
               {
                 echo '<script language="javascript">';
                 echo 'alert("El id de este cliente ya existe")';
                 echo '</script>';
               }
               else
               {
                 $message = "Exito";
                 $data=[
                 'id_Direccion'=>$id_Cliente,
                 'calle_Cliente' => $calle_Cliente,
                 'numeroExt_Cliente'=>$numeroExt_Cliente,
                 'numeroInt_Cliente'=>$numeroInt_Cliente,
                 'colonia_Cliente'=>$colonia_Cliente,
                 'ciudad_Cliente'=>$ciudad_Cliente,
                 'estado_Cliente'=>$estado_Cliente,
                 ];
                 $data1 = [
                 'id_Cliente' => $id_Cliente,
                 'name_Cliente' => $name_Cliente,
                 'apellido_Paterno' => $apellido_Paterno,
                 'razonSocial_Cliente' => $razonSocial_Cliente,
                 'rfc_Cliente' => $rfc_Cliente,
                 'direccion_Cliente'=>$id_Cliente,
                 'email_Cliente' => $email_Cliente,
                 'tel_Cliente'=>$tel_Cliente,
                 'tipo_Entidad' => '1',
                 ];



                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "INSERT INTO cat_direccionclientes(id_Direccion, calle_Cliente, numeroEx_Cliente, numeroInt_Cliente, colonia_Cliente, ciudad_Cliente, estado_Cliente) VALUES (:id_Direccion, :calle_Cliente, :numeroExt_Cliente, :numeroInt_Cliente, :colonia_Cliente, :ciudad_Cliente, :estado_Cliente)";
                 $statement = $connect->prepare($query);
                 $statement->execute($data);

                 $connect = new PDO("mysql:host=$hostBD; dbname=$dataBD", $userBD, $passBD);
                 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $query = "INSERT INTO cat_clientes (id_Cliente, nombre_Cliente, pApellido_Cliente, razonSocial_Cliente, rfc_Cliente, direccion_Cliente, correo_Cliente, tel_Cliente, tipo_Entidad) VALUES (:id_Cliente, :name_Cliente, :apellido_Paterno, :razonSocial_Cliente, :rfc_Cliente, :direccion_Cliente, :email_Cliente,:tel_Cliente,:tipo_Entidad)";
                 $statement = $connect->prepare($query);
                 $statement->execute($data1);

                 echo '<script language="javascript">';
                 echo 'alert("Cliente Registrado Exitosamente")';
                 echo '</script>';

               }
           }


    }


  }



} catch(PDOException $error)
  {
       $message = $error->getMessage();
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/main.css">
    <style type="text/css">
    <?php
    if(isset($error))
    {
     ?>
     input:focus
     {
      border:solid red 1px;
     }
     <?php
    }
    ?>
    </style>

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
        <nav>
          <ul>
            <li> <a>Productos</a>
                <ul>

                  <li><a href="listadoproducts.php">Listado</a></li>
                  <li><a href="nproducts.php">Registrar Producto</a></li>

                </ul>
            </li>
            <li> <a href="/listadoproducts.php">Venta</a>
              <ul>
                <li><a href="#">Registrar Venta</a></li>
              </ul>
            </li>
            <li> <a href="/listadoproducts.php">Proveedores</a>
              <ul>
                <li><a href="listadoproveedores.php">Listado</a></li>
                <li><a href="nproveedor.php">Registrar Proveedor</a></li>
              </ul>
            </li>
            <li> <a>Clientes</a>
              <ul>
                <li><a href="listadoclientes.php">Lista</a></li>
                <li><a href="ncliente.php">Registrar Clientes</a></li>
              </ul>
            </li>
            <li> <a href="/nproducts.php">Reportes</a></li>
            <li> <a href="#">Panel de control</a></li>
          </ul>
        </nav>
      </div>

      <div class="Main">
        <h1>Registrar Cliente</h1>
      </div>

      <div class="">
        <form class="" action="" method="post">

          <?php
          if(isset($error))
          {
           ?>
              <tr>
              <td id="error"><?php echo $error; ?></td>
              </tr>
              <?php
          }
          ?>
          <tr>
            <h3>Datos del cliente</h3>
          <td><input type="text" name="id_Cliente" placeholder="ID Cliente" value="<?php if(isset($id_Cliente)){echo $id_Cliente;} ?>"  <?php if(isset($code) && $code == 1){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="name_Cliente" placeholder="Nombre del cliente" value="<?php if(isset($name_Cliente)){echo $name_Cliente;} ?>"  <?php if(isset($code) && $code == 2){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="apellido_Paterno" placeholder="Apellido Paterno" value="<?php if(isset($apellido_Paterno)){echo $apellido_Paterno;} ?>"  <?php if(isset($code) && $code == 3){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="razonSocial_Cliente" placeholder="Razon Social" value="<?php if(isset($razonSocial_Cliente)){echo $razonSocial_Cliente;} ?>"  <?php if(isset($code) && $code == 4){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="rfc_Cliente" placeholder="RFC" value="<?php if(isset($rfc_Cliente)){echo $rfc_Cliente;} ?>"  <?php if(isset($code) && $code == 5){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="email_Cliente" placeholder="Correo Electronico" value="<?php if(isset($email_Cliente)){echo $email_Cliente;} ?>"  <?php if(isset($code) && $code == 6){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="tel_Cliente" placeholder="Numero Telefonico" value="<?php if(isset($tel_Cliente)){echo $tel_Cliente;} ?>"  <?php if(isset($code) && $code == 7){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <h3>Direccion</h3>
          <td><input type="text" name="calle_Cliente" placeholder="Calle" value="<?php if(isset($calle_Cliente)){echo $calle_Cliente;} ?>"  <?php if(isset($code) && $code == 8){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="numeroExt_Cliente" placeholder="Numero Exterior" value="<?php if(isset($numeroExt_Cliente)){echo $numeroExt_Cliente;} ?>"  <?php if(isset($code) && $code == 9){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="numeroInt_Cliente" placeholder="Numero Interior" value="<?php if(isset($numeroInt_Cliente)){echo $numeroInt_Cliente;} ?>"  <?php if(isset($code) && $code == 10){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="colonia_Cliente" placeholder="Colonia" value="<?php if(isset($colonia_Cliente)){echo $colonia_Cliente;} ?>"  <?php if(isset($code) && $code == 11){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="ciudad_Cliente" placeholder="Ciudad" value="<?php if(isset($ciudad_Cliente)){echo $ciudad_Cliente;} ?>"  <?php if(isset($code) && $code == 12){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
          <td><input type="text" name="estado_Cliente" placeholder="Estado" value="<?php if(isset($estado_Cliente)){echo $estado_Cliente;} ?>"  <?php if(isset($code) && $code == 13){ echo "autofocus"; }  ?> /></td>
          </tr>
          <tr>
            <td><button type="submit" name="btn-regCliente">Registrar Cliente</button></td>
          </tr>
        </form>


      </div>

    </div>
  </body>
</html>