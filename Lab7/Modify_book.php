<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Libro</title>
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
        if (!isset($_POST['book_id'])) {
            die("ID no recibido");
        }
        $book_id = $_POST['book_id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];
        $url = $_POST['url'];
        $specialty = $_POST['specialty'];
        $publisher = $_POST['publisher'];

        $conection = new mysqli("localhost","root","","library");

        if ($conection->connect_error){
            die("Conexion fallida". $conection->connect_error);
        }

        $stmt = $conection->prepare("UPDATE books SET title=?, author=?, year=?, url=?, specialty=?, publisher=? WHERE book_id=?");
        $stmt->bind_param("ssssssi", $title, $author, $year, $url, $specialty, $publisher, $book_id);

        if ($stmt->execute()){
            echo "<h3>Libro con el codigo $book_id actualizada correctamente</h3>";
        } else {
            echo "Error: ". $conection->error;
        }

        $stmt->close();
        $conection->close();
        ?>

    <a href="List_books.php">Volver</a>
    </div>   
</body>
</html>

