<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Editar cursos</title>
    </head>
<body>
   
</body>
<?php
    include "../funcoes.php";
    $id = $_GET['id_curso'];
    $query = "SELECT * FROM Curso where id_curso = $id";
    $conn = startconnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['editar-nome'];
        $descricao = $_POST['editar-descricao'];
        $valor = $_POST['editar-valor'];
        $duracao = $_POST['editar-duracao'];

        $query = "UPDATE Curso
        SET 
        nome = '$nome',
        descricao='$descricao', 
        valor='$valor',
        duracao='$duracao'
        WHERE
        Curso.id_curso = '$id'";
        mysqli_query($conn, $query);
        header("Location: professor.php");
        
    }
    ?>
</head>

<body>
    <?php
    include "../componentes/header.php";
    ?>
    <section>
        <div class="boas-vindas">
            <p>Você está editando um curso</p>
        </div>
    </section>


    <section class='chega'>
    <?php
    imprimeCursoEditar($conn, $query);
    ?>
    </section>

</body>

</html>