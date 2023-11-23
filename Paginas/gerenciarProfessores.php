<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Gerenciar perfil Professores</title>
    <?php
    include("../funcoes.php");
    session_start();
    $conn = startconnection();
    $id_Adm = $_SESSION['id_Adm'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < 100; $i++) {
            if (isset($_POST["botao-excluir-$i"])) {
                echo"$i";
                $queryDelete = "DELETE FROM Professor WHERE Professor.id_professor=$i";
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
        $query = "SELECT nome as 'Nome', email as 'Email', especialidade as 'Especialidade', salario as 'Salario', data_ingresso as 'Data', cursos_vendidos as 'Vendas' from Professor;";
        imprimeTabelaExcluir($conn, $query,2);
        
    ?>

</div>


    
    
</body>
<?php
    include "../componentes/footer.php";
?>
</html>