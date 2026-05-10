<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Jugador</title>
    <style>

        body{
            font-family: Arial;
            background:#dbeafe;
        }

        .container{
            background:white;
            width:300px;
            margin:100px auto;
            padding:20px;
            border-radius:10px;
            text-align:center;
            box-shadow:0px 4px 10px rgba(0,0,0,0.2);
        }

        a{
            display:inline-block;
            margin-top:15px;
            padding:8px 15px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        h3{
            color:#1e3a8a;
        }

    </style>
</head>
<body>
    <div class="container">
    <?php
        $nombre = $_POST['nombre'];
        $posicion = $_POST['posicion'];
        $equipo = $_POST['equipo'];
        $liga = $_POST['liga'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $imagen_vehiculo = $_FILES['imagen_vehiculo']['name'];
        $tmpVehiculo = $_FILES['imagen_vehiculo']['tmp_name'];
        move_uploaded_file($tmpVehiculo,"uploads/" . $imagen_vehiculo);


        $imagen = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];

        move_uploaded_file($tmp,"uploads/" . $imagen);
        $conection = new mysqli("localhost","root","","futbol");

        if ($conection->connect_error){
            die("Conexion fallida". $conection->connect_error);
        }

        $stmt = $conection->prepare("INSERT INTO jugadores(nombre,posicion,imagen) VALUES (?, ?, ?)");
        $stmt->bind_param("sss",$nombre,$posicion,$imagen);
        $stmt->execute();
        $jugador_id = $conection->insert_id;


        $stmt3 = $conection->prepare("INSERT INTO vehiculos(marca,modelo,imagen_vehiculo,dueno)VALUES (?, ?, ?,?)");
        $stmt3->bind_param("sssi",$marca,$modelo,$imagen_vehiculo,$jugador_id);
        $stmt3->execute();

        $stmt2 = $conection->prepare("INSERT INTO equipos(nombre_equipo,liga,jugador_id)VALUES (?, ?, ?)");
        $stmt2->bind_param("ssi",$equipo,$liga,$jugador_id);

        if ($stmt2->execute()){
            echo "<h3>Registro guardado correctamente</h3>";
        } else {
            echo "Error:" . $conection->error;
        }

    ?>
    <a href="List_players.php"> Volver a la lista </a>

    </div>
</body>
</html>