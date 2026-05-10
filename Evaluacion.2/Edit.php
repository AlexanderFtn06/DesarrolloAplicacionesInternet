<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Jugador</title>
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
        box-shadow:0px 4px 10px rgba(0,0,0,0.2);
    }

    input{
        width:90%;
        padding:8px;
        margin:8px 0;
        border:1px solid #93c5fd;
        border-radius:5px;
    }

    input[type="submit"]{
        background:#2563eb;
        color:white;
        border:none;
    }

    h3{
        text-align:center;
        color:#1e3a8a;
    }

    </style>


</head>
<body>
    <div class="container">
        <?php
            if (!isset($_GET['jugador_id'])) {
                die("ID no recibido");
            }

            $jugador_id = $_GET['jugador_id'];

            $conection = new mysqli("localhost","root","","futbol");

            if ($conection->connect_error){
                die("Conexion fallida: ". $conection->connect_error);
            }

            $stmt = $conection->prepare("SELECT * FROM jugadores INNER JOIN equipos ON jugadores.jugador_id = equipos.jugador_id INNER JOIN vehiculos ON jugadores.jugador_id = vehiculos.dueno WHERE jugadores.jugador_id = ?");
            $stmt->bind_param("i", $jugador_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $jugador = $result->fetch_assoc();

            $stmt->close();
            $conection->close();
        ?>

        <h3>Editar Jugador</h3>
        <form method="post" action="Modify_player.php" enctype="multipart/form-data">
                <input type="hidden" name="jugador_id" value="<?php echo $jugador['jugador_id']; ?>">
            Nombre:<input type="text" name="nombre" value="<?php echo $jugador['nombre']; ?>" required><br>
            Posición:<input type="text" name="posicion" value="<?php echo $jugador['posicion']; ?>" required><br>
            Equipo:<input type="text" name="equipo" value="<?php echo $jugador['nombre_equipo']; ?>"required><br>
            Liga:<input type="text" name="liga" value="<?php echo $jugador['liga']; ?>" required><br>
            Marca Vehículo:<input type="text" name="marca" value="<?php echo $jugador['marca']; ?>" required ><br>
            Modelo Vehículo:<input type="text" name="modelo" value="<?php echo $jugador['modelo']; ?> "required><br>
            Imagen Vehículo:<input type="file" name="imagen_vehiculo"><br>
            Imagen jugador:<input type="file" name="imagen"><br>
            <input type="submit" value="Actualizar">
        </form>
    </div>
</body>
</html>