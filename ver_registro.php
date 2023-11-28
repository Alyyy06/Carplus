<?php
include('conexion.php');

if (isset($_GET['id'])) {
    $idRegistro = $_GET['id'];


    function obtenerRegistroPorID($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM registros_icarplus WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    $registro = obtenerRegistroPorID($idRegistro);

    if (!$registro) {
        echo "Registro no encontrado.";
        exit();
    }
} else {
    echo "ID de registro no proporcionado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iCar Plus</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>


<nav class="#004d40 teal darken-4">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo left">iCar Plus</a>
      <ul id="nav-mobile" class="right">
        <li><a href="pagina_principal.php">Inicio</a></li>

      </ul>
    </div>
</nav>


<div class="container">

    <h3 class="center-align card-panel #004d40 teal darken-4 white-text">Detalles</h3>
    <div class="right">
    <a href="reporte.php?id=<?php echo $idRegistro; ?>" target="_blank"><i class="material-icons left">picture_as_pdf</i>Reporte PDF</a><hr>


    </div>

    <div class="row">
        <div class="col l8 offset-l2 s12">
            <div class="card">
                <div class="card-content">
                    <p><strong>Matrícula Vehículo:</strong> <?php echo $registro['matricula_vehiculos']; ?></p>
                    <p><strong>Cédula Mecánico:</strong> <?php echo $registro['cedula_mecanicos']; ?></p>
                    <p><strong>Serial Repuestos:</strong> <?php echo $registro['serial_repuestos']; ?></p>
                    <p><strong>Cantidad Repuestos:</strong> <?php echo $registro['cantidad_repuestos']; ?></p>
                    <p><strong>Fecha Ingreso:</strong> <?php echo $registro['fecha_ingreso']; ?></p>
                </div>
            </div>
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
<script src="assets\js\init.js"></script>
</body>
</html>