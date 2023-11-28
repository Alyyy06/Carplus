<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iCar Plus</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="assets\css\estilo.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <style>
    body{
      background-color: white;
    }

    #parallax-inicio p {
      font-family: arial black;
      font-size: 35px;
      -webkit-text-stroke: 1.5px black;
      text-align: center;
    }


    .card.with-border {
      border: 4px solid white;
      border-radius: 7px; 
    }



    .card-image img {
      max-height: 100%;
      max-width: 100%;
      width: auto;
      height: auto;
    }

   
    .welcome-cards {
      height: 400px; 
    }
  </style>
</head>
<body>

  <nav class="#004d40 teal darken-4">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo left">iCar Plus</a>
      <ul id="nav-mobile" class="right">
        <li><a href="#">Inicio</a></li>
        <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </nav>

  <div class="container ">
    <h3 class="center-align">Bienvenido/a</h3>
    <div class="row ">

      <div class="col s12 m4 ">
        <div class="card  welcome-cards #004d40 teal darken-4">
          <div class="card-image">
            <br><br> <br>
            <a href="clientes.php"><img src="assets\img\c.png" alt="Descripción 1"></a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card  welcome-cards #004d40 teal darken-4">
          <br><br><br> <br>
          <div class="card-image">
            <a href="mecanicos.php"><img src="assets\img\m.png" alt="Descripción 2"></a>
          </div>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="card welcome-cards #004d40 teal darken-4">
          <br><br><br><br>
          <div class="card-image">
            <a href="repuestos.php"><img src="assets\img\r.png" alt="Descripción 3"></a>
          </div>
        </div>
      </div>

      <div class="col s12 m4 offset-l2">
        <div class="card welcome-cards #004d40 teal darken-4">
          <br><br><br><br>
          <div class="card-image">
            <a href="vehiculos.php"><img src="assets\img\v.png" alt="Descripción 4"></a>
          </div>
        </div>
      </div>


      <div class="col s12 m4">
        <div class="card welcome-cards #004d40 teal darken-4">
          <br><br><br><br>
          <div class="card-image">
            <a href="registros.php"><img src="assets\img\reg.png" alt="Descripción 6"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
<br><br>

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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="assets\js\init.js" ></script>
</body>
</html>
