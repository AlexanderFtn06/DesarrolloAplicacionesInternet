<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LISTA DE JUGADORES</title>
    <style>

    body{
        font-family: Arial;
        background:#bfdbfe;
    }

    .container{
        background:white;
        width:70%;
        margin:50px auto;
        padding:20px;
        border-radius:10px;
        box-shadow:0px 4px 10px rgba(0,0,0,0.2);
    }

    table{
        width:100%;
        border-collapse: collapse;
    }

    th{
        background:#1d4ed8;
        color:white;
        padding:10px;
    }

    td{
        padding:10px;
        text-align:center;
    }

    tr:nth-child(even){
        background:#dbeafe;
    }

    a{
        display:inline-block;
        padding:6px 10px;
        margin:2px;
        background:#2563eb;
        color:white;
        text-decoration:none;
        border-radius:5px;
    }

    h1{
        text-align:center;
        color:#1e3a8a;
    }

    img{
        border-radius:10px;
    }

</style>
</head>
<body>
    <div class="container">
        <h1> JUGADORES DISPONIBLES </h1>
        <table>
        <tr><th>Codigo</th><th>Nombre</th><th>Posicion</th><th>Equipo</th><th>Liga</th><th>Marca</th><th>Modelo</th><th>Imagen del Vehiculo</th><th>Imagen del Jugador</th><th>Acciones</th></tr>
        
        <?php
        $conection = new mysqli("localhost","root","","futbol");
        
        if ($conection->connect_error){
            die("Conexion fallida: ". $conection->connect_error);
        }        

        $stmt = $conection->prepare("SELECT * FROM jugadores INNER JOIN equipos ON jugadores.jugador_id = equipos.jugador_id INNER JOIN vehiculos ON jugadores.jugador_id = vehiculos.dueno");     
        $stmt->execute();
        $result = $stmt->get_result();        

        while ($row = $result->fetch_assoc()) {?>
            <tr>
            <td><?= $row['jugador_id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['posicion'] ?></td>
            <td><?= $row['nombre_equipo'] ?></td>
            <td><?= $row['liga'] ?></td>
            <td><?= $row['marca'] ?></td>
            <td><?= $row['modelo'] ?></td>
            <td><img src="uploads/<?= $row['imagen_vehiculo'] ?>" width="100"></td>
            <td><img src="uploads/<?= $row['imagen'] ?>"width="100"></td>
            <td>
            <a href="Edit.php?jugador_id=<?= $row['jugador_id'] ?>">Editar</a>
            <a href="Delete.php?jugador_id=<?= $row['jugador_id'] ?>"> Eliminar</a>
            </td>
            </tr>
            <?php }
                $stmt->close();
                $conection->close();
            ?>
        </table>
        <br>
        <a href="FormPlayers.html">Agregar Jugador</a>

    </div>
</body>
</html>


