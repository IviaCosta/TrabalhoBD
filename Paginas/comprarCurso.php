<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Comprar cursos</title>
    <?php
    include("../funcoes.php");
    session_start();
    $id_cliente = $_SESSION["id_cliente"];
    $conn = startconnection();  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_curso = null;
        $valor = null;
        for ($i=0; $i < 100; $i++) { 
            if (isset($_POST["botao-comprar-$i"])) {
                $id_curso = $i;
                $query = "SELECT * from CURSO WHERE id_Curso='$id_curso'";
                $result = mysqli_query($conn, $query);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $valor = $rows[0]['valor'];
                novaCompra($conn,$id_curso, $id_cliente, $valor);
            }
            if (isset($_POST["botao-ver-$i"])) {
                header("Location: verCurso.php?id_curso=$i");
            }
        }

    }
    ?>
</head>
<body>
    <?php
        include '../Componentes/header_logged.php';
        $query = "SELECT C.id_curso, C.nome, C.duracao, C.valor, P.nome as Professor 
        FROM CURSO C 
        JOIN PROFESSOR P ON C.id_professor = P.id_professor 
        WHERE C.id_curso NOT IN (SELECT id_curso FROM COMPRA);";
        imprimirCursos($conn, $query,1);
    ?>
    
    
    
</body>
<?php
    include "../componentes/footer.php";
?>
</html>