<?php
    session_start();
    require 'db.php';


    $error = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = trim($_POST['username']);
        $password = $_POST['password'];
       

        if (empty($username) || empty($password)) $error = 'El usuario y la contraseña son campos requeridos';
        else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if($user && password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: dashboard.php');
                exit;
            }else{
                $error = 'Nombre de usuario o contraseña invalida';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
    <?php if ($error ): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif;?>
    <form method="POST">
        <label>Nombre de usuario: </label> <br>
        <input type="text" name="username" value="<? htmlspecialchars($_POST['username'] ?? '') ?>"<br><br>

        <label> Contraseña </label>
        <input type="password" name="password"> <br><br>
        <button type="submit"> Registrarse </button>

    </form>
    <p> Ya tienes una cuenta? <a href="register.php"> Registrarse </a> </p>
</body>
</html>