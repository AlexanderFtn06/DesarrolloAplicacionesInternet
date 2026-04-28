<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
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
        }

        input{
            width:90%;
            padding:8px;
            margin:8px 0;
        }

        input[type="submit"]{
            background:black;
            color:white;
        }
        </style>
</head>
<body>
    <div class="container">

        <?php
        if (!isset($_GET['book_id'])) {
            die("ID no recibido");
        }
        $book_id = $_GET['book_id'];

        $conection = new mysqli("localhost","root","","library");

        if ($conection->connect_error){
            die("Conexion fallida: ". $conection->connect_error);
        }

        $stmt = $conection->prepare("SELECT * FROM books WHERE book_id = ?");
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        $stmt->close();
        $conection->close();
?>
    <h3>Editar Libro</h3>
    <form method="post" action="Modify_book.php">
                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
        Titulo: <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
        Autor: <input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
        Año: <input type="number" name="year" value="<?php echo $book['year']; ?>"><br>
        URL: <input type="text" name="url" value="<?php echo $book['url']; ?>"><br>
        Especialidad: <input type="text" name="specialty" value="<?php echo $book['specialty']; ?>"><br>
        Editorial: <input type="text" name="publisher" value="<?php echo $book['publisher']; ?>"><br>
        <input type="submit" value="Actualizar">
    </form>
</div>
</body>
</html>