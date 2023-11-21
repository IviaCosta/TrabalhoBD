<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Consultar Acesso</title>
    <?php
    include("../funcoes.php");
    session_start();
    $id_professor = $_SESSION['id_professor'];

    ?>
</head>
<body class='body-acessos'>
    <?php
        include '../Componentes/header_logged.php';
        ?>
<div class="tabela-acessos">
<?php
        $conn = startconnection();
        $query = "SELECT CL.nome as 'Cliente', CU.nome as 'Curso', AR.data_acesso as 'Data de Acesso' FROM Acesso_Realizado AR join Compra CO on AR.id_compra=CO.id_compra join Curso CU on CU.id_curso=CO.id_curso join Cliente CL on CL.id_cliente=CO.id_cliente where CU.id_professor='$id_professor'";
        imprimeTabela($conn, $query);
        
    ?>

</div>

    
    
</body>
<?php
    include "../componentes/footer.php";
?>
</html>