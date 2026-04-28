<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Libros</title>
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

        $stmt = $conection->prepare("INSERT INTO books(title, author ,year, url,specialty,publisher) VALUES (?, ?, ?, ?,?,?)");
        $stmt->bind_param("ssssss", $title, $author, $year, $url, $specialty,$publisher);

        if ($stmt->execute()){
            echo "<h3>Registro guardado correctamente</h3>";
        } else {
            "Error: ". $conection->error;
        }
        ?>

        <a href="List_books.php">Volver a la lista</a>

</div>
</body>
</html>
