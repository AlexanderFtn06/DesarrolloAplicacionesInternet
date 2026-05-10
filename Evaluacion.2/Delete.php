<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Jugador</title>
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
        background:#dc2626;
        color:white;
        text-decoration:none;
        border-radius:5px;
    }

    h3{
        color:#b91c1c;
    }

</style>
</head>
<body>
    <div class="container">
    <?php 
    $jugador_id = $_GET['jugador_id'];
    $conection = new mysqli("localhost", "root","","futbol");
    
    if ($conection->connect_error){
        die("Conexion fallida: ". $conection->connect_error);
    }

    $stmtVehiculo = $conection->prepare("DELETE FROM vehiculos WHERE dueno = ?");
    $stmtVehiculo->bind_param("i", $jugador_id);
    $stmtVehiculo->execute();

    $stmt = $conection->prepare("DELETE FROM equipos WHERE jugador_id = ?");

    $stmt->bind_param("i",$jugador_id);
    $stmt->execute();

    $stmt2 = $conection->prepare("DELETE FROM jugadores WHERE jugador_id = ?");
    $stmt2->bind_param("i", $jugador_id);

    if ($stmt2->execute()) {
        echo "<h3> Jugador con el codigo $jugador_id eliminado correctamente</h3>";
    } else { 
        echo "Error:" . $conection->error;
    }
    $stmt->close();
    $stmt2->close();
    $stmtVehiculo->close();
    $conection->close();

    ?>

    <a href="List_players.php">Volver</a>

    </div>
</body>
</html>