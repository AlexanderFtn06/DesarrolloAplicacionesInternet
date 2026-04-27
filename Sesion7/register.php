<?php
    require 'db.php';
    $error = '';
    $success = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        if (empty($username) || empty($password)) $error = 'El usuario y la contraseña son campos requeridos';
        elseif($password !== $confirm) $error = 'Las contraseñas no son inguales';
        elseif (strlen($password) < 6) $error = 'La contraseña debe tener al menos 6 digitos';
        else{
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);

            if ($stmt->fetch()) {
                $error = 'El nombre de usuario ya existe';
            }else{
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
                $stmt->execute([$username]);
                $success = 'La cuenta a sido creada <a href="login.php">Entra aqui </a>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio 7</title>
</head>
<body>
    <?php if ($error ): ?>
        <p style="color:red;"><?= $error ?></p>
        <?php endif;?>
    <?php if ($success ): ?>
        <p style="color:green;"><?= $success ?></p>
        <?php endif;?>    
    <form method="POST">
        <label>Nombre de usuario: </label> <br>
        <input type="text" name="username" value="<? htmlspecialchars($_POST['username'] ?? '') ?>"<br><br>

        <label> Contraseña </label>
        <input type="password" name="password"> <br><br>

        <label> Confirmar contraseña </label> <br>
        <input type="password" name="confirm"> <br><br>

        <button type="submit"> Registrarse </button>
    </form>
</body>
</html>