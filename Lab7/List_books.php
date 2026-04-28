<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Catalog</title>
    <style>
        body{
            font-family: Arial;
            background:#050505;
        }

        .container{
            background:white;
            width:70%;
            margin:50px auto;
            padding:20px;
            border-radius:10px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th{
            background:black;
            color:white;
            padding:10px;
        }

        td{
            padding:10px;
            text-align:center;
        }

        tr:nth-child(even){
            background:#f2f2f2;
        }

        a{
            display:inline-block;
            padding:6px 10px;
            margin:2px;
            background:black;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }

        h1{
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1> LIBROS DISPONIBLES</h1>
    <table>
    <tr><th>Codigo</th><th>Nombre</th><th>Autor</th><th>Año</th><th>URL</th><th>Especialidad</th><th>Editorial</th><th>Acciones</th></tr>
    <?php
    $conection = new mysqli("localhost","root","","library");

    if ($conection->connect_error){
        die("Conexion fallida: ". $conection->connect_error);
    }

    $stmt = $conection->prepare("SELECT * FROM books");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) { ?>
    <tr>
    <td><?= $row['book_id'] ?></td>
    <td><?= $row['title'] ?></td>
    <td><?= $row['author'] ?></td>
    <td><?= $row['year'] ?></td>
    <td><a href="<?= $row['url'] ?>" target="_blank">Ver</a></td>
    <td><?= $row['specialty'] ?></td>
    <td><?= $row['publisher'] ?></td>
    <td>
    <a href="Edit.php?book_id=<?= $row['book_id'] ?>">Editar</a>
    <a href="Delete.php?book_id=<?= $row['book_id'] ?>">Eliminar</a>
    <a href="<?= $row['url'] ?>" target="_blank">Leer</a>
    </td>
    </tr>
    <?php } 
    $stmt->close();
    $conection->close();
    ?>
    </table>
    <br>
    <a href="FormBooks.html">Agregar Libro</a>

    </div>
</body>
</html>