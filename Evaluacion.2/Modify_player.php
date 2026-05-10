<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugador Actualizado</title>
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
            if (!isset($_POST['jugador_id'])) {
                die("ID no recibido");
            }

            $jugador_id = $_POST['jugador_id'];
            $nombre = $_POST['nombre'];
            $posicion = $_POST['posicion'];
            $equipo = $_POST['equipo'];
            $liga = $_POST['liga'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $imagen_vehiculo = $_FILES['imagen_vehiculo']['name'];
            $tmpVehiculo = $_FILES['imagen_vehiculo']['tmp_name'];   

            $imagen = $_FILES['imagen']['name'];
            $tmp = $_FILES['imagen']['tmp_name'];
            
            $conection = new mysqli("localhost", "root","","futbol");

            if ($conection->connect_error){
                die("Conexion fallida". $conection->connect_error);
            }

            if($imagen_vehiculo == ""){
                $stmtVehiculoImagen = $conection->prepare("SELECT imagen_vehiculo FROM vehiculos WHERE dueno=?");
                $stmtVehiculoImagen->bind_param("i",$jugador_id);

                $stmtVehiculoImagen->execute();

                $resultadoVehiculoImagen = $stmtVehiculoImagen->get_result();
                $filaVehiculoImagen = $resultadoVehiculoImagen->fetch_assoc();
                $imagen_vehiculo = $filaVehiculoImagen['imagen_vehiculo'];

            } else {
                move_uploaded_file(
                $tmpVehiculo,
                "uploads/" . $imagen_vehiculo
                );

            }

            if($imagen == ""){
                $stmtImagen = $conection->prepare("SELECT imagen FROM jugadores WHERE jugador_id=?");
                $stmtImagen->bind_param("i",$jugador_id);

                $stmtImagen->execute();
                $resultadoImagen = $stmtImagen->get_result();

                $filaImagen = $resultadoImagen->fetch_assoc();

                $imagen = $filaImagen['imagen'];

            } else {
                move_uploaded_file($tmp,"uploads/" . $imagen);
            }
            $stmt = $conection->prepare("UPDATE jugadores SET nombre=?, posicion=?, imagen = ? WHERE jugador_id=?");
            $stmt->bind_param("sssi", $nombre,$posicion,$imagen,$jugador_id);

            $stmt2 = $conection->prepare("UPDATE equipos SET nombre_equipo=?, liga=? WHERE jugador_id=?");
            $stmt2->bind_param("ssi",$equipo, $liga, $jugador_id);


            $stmt3 = $conection->prepare("UPDATE vehiculos SET marca=?, modelo=?, imagen_vehiculo=? WHERE dueno=?");
            $stmt3->bind_param("sssi", $marca, $modelo, $imagen_vehiculo, $jugador_id);

            $success1 = $stmt->execute();
            $success2 = $stmt2->execute();
            $success3 = $stmt3->execute();
            if ($success1 && $success2 && $success3){
                echo "<h3> Jugador con el codigo $jugador_id actualizado correctamente </h3>";
            } else {
                echo "Error:" . $conection->error;
            }

            $stmt->close();
            $stmt2->close();
            $conection->close();

        ?>

        <a href="List_players.php"> Volver </a>

    </div>
</body>
</html>