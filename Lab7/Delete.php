<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
    <style>
        body{
            font-family: Arial;
            background:#050505;
        }

        .container{
            background:white;
            width:300px;
            margin:100px auto;
            padding:20px;
            border-radius:10px;
            text-align:center;
        }

        a{
            display:inline-block;
            margin-top:15px;
            padding:8px 15px;
            background:black;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
    $book_id = $_GET['book_id'];

    $conection = new mysqli("localhost","root","","library");

    if ($conection->connect_error){
        die("Conexion fallida: ". $conection->connect_error);
    }

    $stmt = $conection->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);
    
    if ($stmt->execute()) {
        echo "<h3>Libro con el codigo $book_id eliminado correctamente</h3>";
    }else{ 
        echo "Error: ". $conection->error;
    } 
    ?>
    <a href="List_books.php">Volver</a>
    </div>
</body>
</html>
  