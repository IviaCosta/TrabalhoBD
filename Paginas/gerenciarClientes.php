<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Gerenciar perfil Clientes</title>
    <?php
    include("../funcoes.php");
    session_start();
    $conn = startconnection();
    $id_Adm = $_SESSION['id_Adm'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < 100; $i++) {
            if (isset($_POST["botao-excluir-$i"])) {
                echo"$i";
                $queryDelete = "DELETE FROM Cliente WHERE Cliente.id_Cliente=$i";
                $result = mysqli_query($conn, $queryDelete);
                header("Location: administrador.php");
            }
        }

    }

    ?>
</head>
<body class='body-gerenciamento'>
    <?php
        include '../Componentes/header_logged.php';
        ?>
<div class="tabela-gerenciamento">
<?php
        $query = "SELECT * from Cliente;";
        imprimeTabelaExcluir($conn, $query, 1);
        
    ?>

</div>


    
    
</body>
<?php
    include "../componentes/footer.php";
?>
</html>