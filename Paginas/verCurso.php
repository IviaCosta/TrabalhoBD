<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Ver cursos</title>
</head>

<body>

</body>
<?php
include "../funcoes.php";
$id = $_GET['id_curso'];
$conn = startconnection();
?>
</head>

<body>
    <?php
    if ($_GET['tipo'] == "cliente") {
        include "../componentes/header_logged.php";
        echo "
        <section>
        <div class='boas-vindas'>
            <p>Visualizando curso comprado</p>
        </div>
    </section>";
    } else {
        include "../componentes/header.php";
        echo "
        <section>
        <div class='boas-vindas'>
            <p>Descrição do Curso</p>
        </div>
    </section>";
    }
    ?>
    <section class='chega'>
        <?php
        imprimeCurso($conn, $id);
        ?>
    </section>

</body>

</html>