<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Principal</title>
    <?php
    include("../funcoes.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_curso = null;
        for ($i = 0; $i < 100; $i++) {
            if (isset($_POST["botao-ver-$i"])) {
                header("Location: verCurso.php?id_curso=$i");
            }
        }

    }
    ?>
</head>
<body>
<div class='body-wrapper'>
    <?php
        include '../Componentes/header.php';
        $conn = startconnection();
        $query = "SELECT C.id_curso, C.nome, C.duracao, C.valor, P.nome as Professor FROM CURSO C JOIN PROFESSOR P ON C.id_professor = P.id_PROFESSOR;";
        imprimirCursos($conn, $query,0);
        
    ?>

</div>
    
</body>
<?php
    include "../componentes/footer.php";
?>
</html>