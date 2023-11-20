<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Menu Cliente</title>
    <?php
    include("../funcoes.php");
    session_start();
    $email = $_SESSION["email"];
    $conn = startconnection();  
    $query = "SELECT * from CLIENTE WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['id_cliente'] = $rows[0]['id_Cliente'];
    ?>
</head>
<body class="body-cliente">
    <?php
    include("../Componentes/header_logged.php");
    ?>    
    <br>
<div class="banner">
        <p class='texto'>Bem-vindo Cliente! O que deseja fazer hoje?</p>
        <img src="../Imagens/Cursos/React.png" alt="">
    </div>
    
    <div class="botoes">
        <a href="comprarCurso.php"><button>Comprar cursos</button></a>
        <button>Consultar pendências</button>
        <button>Editar perfil</button>

    </div>
    <div class="cards">
        <?php
        $query = "SELECT CU.nome, CU.duracao as 'Duração', PO.nome as 'Professor', CO.data as 'Data' FROM COMPRA CO join CLIENTE CL on CO.id_cliente=CL.id_cliente join CURSO CU on CO.id_curso=CU.id_curso join PROFESSOR PO on CU.id_professor=PO.id_professor where CO.aprovacao=1 and CL.email='$email';";
        imprimirCursos($conn,$query, 0);
        ?>
    </div>
</body>
<!-- <?php
    include "../componentes/footer.php";
?> -->
</html>