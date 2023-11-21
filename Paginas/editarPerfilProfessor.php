<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Editar perfil</title>
    </head>
<body>
   
</body>
<?php
    include "../funcoes.php";
    session_start();
    $id = $_SESSION["id_professor"];
    $query = "SELECT email, nome, senha, especialidade FROM Professor where id_professor = $id";
    $conn = startconnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['editar-nome'];
        $email = $_POST['editar-email'];
        $senha = $_POST['editar-senha'];
        $especialidade = $_POST['editar-especialidade'];


        $query = "UPDATE Professor
        SET 
        nome = '$nome',
        email='$email', 
        senha='$senha',
        especialidade='$especialidade'
        WHERE
        Professor.id_professor = '$id'";
        mysqli_query($conn, $query);
        header("Location: professor.php");
        
    }
    ?>
</head>

<body>
    <?php
    include "../componentes/header_logged.php";
    ?>
    <section>
        <div class="boas-vindas">
            <p>Você está editando seu perfil</p>
        </div>
    </section>


    <section class='chega'>
    <?php
    imprimePerfilEditar($conn, $query, 1);
    ?>
    </section>

</body>

</html>