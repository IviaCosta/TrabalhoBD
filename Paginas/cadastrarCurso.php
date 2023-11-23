<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Cadastro de Curso</title>
    <?php
    session_start();
    include '../funcoes.php';
    
    $conn = startconnection();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['botao'])) {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $valor = $_POST['valor'];
            $duracao = $_POST['duracao'];
            $professor = $_SESSION['id_professor'];
            
            cadastrarCurso($conn, $nome, $descricao, $valor, $duracao, $professor);
            // Aqui você deve inserir o código para cadastrar o usuário no banco de dados
            
            // Redirecionar para a página de login ou qualquer outra página após o cadastro
            header("Location: professor.php");
            exit();
        }
    }
    ?>
</head>
<body class="body-cliente">
    <?php
    include("../Componentes/header_logged.php");
    
    ?>    
    <br>
<div class="banner">
        <p class='texto'>Preencha as informaçōes abaixo para cadastrar um novo curso</p>
        <img src="../Imagens/img_banner.png" alt="">
    </div>
<div class="cadastro">
        <form class='cadastro' action="" method="POST">
            <input class="login" type="text" name="nome" placeholder="Nome">
            <input class="login" type="text" name="descricao" placeholder="Descrição">
            <input class="login" type="number" name="valor" placeholder="Valor">
            <input class="login" type="number" min="20" name="duracao" placeholder="Duração">
            <button class="login" type="submit" name="botao">Cadastrar</button>
        </form>
</div>
</body>
 <?php
    include "../componentes/footer.php";
?> 
</html>