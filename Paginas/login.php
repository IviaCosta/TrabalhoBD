<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
<?php
include '../funcoes.php';
    $conn = startconnection();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['botao'])) {
            $email = $_POST['email'];
          
  $senha = $_POST['senha'];
            $tipo = $_POST['user'];

            //$conn = startConnection();
            
            $_SESSION["email"] = $email;
            $_SESSION['senha'] = $senha;
            verificarUsuario($conn, $email, $senha,$tipo);
        }
    }
?>
    
</head>


<body>
    <div class='div-login'>
    
    <img class='img-logo' src="../Imagens/Logo/logo.png" alt="">
    <form class='info' action="" method="POST">

        <select class="login" name="user" id="user">
        <option value="Administrador">Administrador</option>
        <option value="Cliente">Cliente</option>
        <option value="Professor">Professor</option>
        </select>

        <input class="login" type="text" name="email" placeholder="Email">
        <input class="login" type="password" name="senha" placeholder="Senha">
        <button class="login" type="submit" name="botao">Entrar</button>
        <p><a href="cadastro.php">Cadastre-se aqui</a></p>
    </form>
</div>
</body>
</html> 