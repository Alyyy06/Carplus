<?php

include('conexion.php');

function agregarCliente($cedula, $nombre, $apellido, $edad, $licencia) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO clientes_icarplus (cedula, nombre, apellido, edad, licencia) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $cedula, $nombre, $apellido, $edad, $licencia);
    return $stmt->execute();
}

function obtenerClientePorCedula($cedula) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM clientes_icarplus WHERE cedula = ?");
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function eliminarCliente($cedula) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM clientes_icarplus WHERE cedula = ?");
    $stmt->bind_param("i", $cedula);
    return $stmt->execute();
}

function obtenerClientes() {
    global $conn;
    $result = $conn->query("SELECT * FROM clientes_icarplus");
    return $result->fetch_all(MYSQLI_ASSOC);
}

$clienteEditar = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_cliente"])) {
    $cedulaEditar = $_POST["cedula"];
    $clienteEditar = obtenerClientePorCedula($cedulaEditar);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_cliente"])) {
    $cedula = $_POST["cedula"];
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
    $edad = isset($_POST["edad"]) ? $_POST["edad"] : '';
    $licencia = isset($_POST["licencia"]) ? $_POST["licencia"] : '';

    if (agregarCliente($cedula, $nombre, $apellido, $edad, $licencia)) {
        echo "<script>alert('Cliente agregado con éxito');</script>";
    } else {
        echo "Error al agregar el cliente.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_cliente"])) {
    $cedula = $_POST["cedula"];

    if (eliminarCliente($cedula)) {
        echo "Cliente eliminado con éxito.";
    } else {
        echo "Error al eliminar el cliente.";
    }
}

$clientes = obtenerClientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <style>
            body{
      background-color: white;
    }

    </style>
</head>
<body>

<nav class="#303f9f #004d40 teal darken-4
">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo left">iCar Plus</a>
      <ul id="nav-mobile" class="right">
        <li><a href="pagina_principal.php">Inicio</a></li>
        <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </nav>

<div id="index-banner" class="parallax-container" >
    <div class="section no-pad-bot" id="inicio">
      <div class="container">
        <br><br><br><br><br><br>
        <h3 class="white-text center"></h3>
        <div class="row center">
          <h5 class="header col s12 light4"></h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="https://media.istockphoto.com/id/1221801611/es/v%C3%ADdeo/comprador-masculino-eligiendo-coche-nuevo-en-la-sala-de-exposici%C3%B3n-discutiendo-el-trato-con.jpg?b=1&s=640x640&k=20&c=TqS9qBhney_F1qB00JhJTYy0VpyZUNQNSONlmqCdQog="></div>
  </div>

<div class="container">
    <h3 class="center-align card-panel #004d40 teal darken-4
 white-text">Clientes</h3>

    <div class="row">
        <div class="col l8 s12 m6 offset-l2">
            <div class="card">
                <div class="card-content">
                    <span class="card-title #303f9f black-text center">Agregar Cliente</span>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="input-field">
                            <input id="cedula" type="text" name="cedula" required>
                            <label for="cedula">Cédula</label>
                        </div>
                        <div class="input-field">
                            <input id="nombre" type="text" name="nombre" required>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="input-field">
                            <input id="apellido" type="text" name="apellido" required>
                            <label for="apellido">Apellido</label>
                        </div>
                        <div class="input-field">
                            <input id="edad" type="number" name="edad" required>
                            <label for="edad">Edad</label>
                        </div>
                        <div class="input-field">
                            <input id="licencia" type="text" name="licencia" required>
                            <label for="licencia">Licencia</label>
                        </div>
                        <div class="center">
                            <button class="btn waves-effect waves-light #004d40 teal darken-4
 " type="submit" name="agregar_cliente">Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row #1de9b6 teal accent-3
">
        <div class="col s12 l12">
        <table class="striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Edad</th>
                    <th>Licencia</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $N_contador = 1;
                foreach ($clientes as $cliente) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . $N_contador . "</td>";
                    echo "<td class='text-center'>" . $cliente['cedula'] . "</td>";
                    echo "<td class='text-center'>" . $cliente['nombre'] . "</td>";
                    echo "<td class='text-center'>" . $cliente['apellido'] . "</td>";
                    echo "<td class='text-center'>" . $cliente['edad'] . "</td>";
                    echo "<td class='text-center'>" . $cliente['licencia'] . "</td>";
                    echo "<td class='text-center'>
                            <form action='editarC.php' method='get'>
                                <input type='hidden' name='cedula' value='" . $cliente['cedula'] . "'>
                                <button class='btn waves-effect waves-light' type='submit' name='editar_cliente'>Editar</button>
                            </form>
                        </td>";
                    echo "<td class='text-center'>
                            <form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
                                <input type='hidden' name='cedula' value='" . $cliente['cedula'] . "'>
                                <button class='btn red waves-effect waves-light' type='submit' name='eliminar_cliente'>Eliminar</button>
                            </form>
                    </td>";
                    echo "</tr>";

                    $N_contador++;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="center">

    <footer class="page-footer #303f9f #004d40 teal darken-4
">
        <div class="footer-copyright">
            <div class="container">
                <p> Alidsabeth Jimenez <br>
                    Todos los derechos son reservados <br>
                    Copyright © 2023</p>
            </div>
            <div></div>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems,);
  });

</script>
</body>
</html>
