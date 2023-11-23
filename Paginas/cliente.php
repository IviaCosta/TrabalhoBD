<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Cliente: Menu</title>
    <?php
    include("../funcoes.php");
    session_start();
    $email = $_SESSION["email"];
    $conn = startconnection();  
    $query = "SELECT * from CLIENTE WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $rows0 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['id_Cliente'] = $rows0[0]['id_Cliente'];
    $id_cliente = $rows0[0]['id_Cliente'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_curso = null;
        for ($i = 0; $i < 100; $i++) {
            if (isset($_POST["botao-ver-$i"])) {

                $query0 = "SELECT id_compra FROM COMPRA CO join CLIENTE CL on CO.id_cliente = CL.id_cliente join CURSO CU on CU.id_curso=CO.id_curso where CL.id_cliente='$id_cliente' and CU.id_curso='$i'";
                $result = mysqli_query($conn, $query0);
                $rows1 = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $id_compra = $rows1[0]['id_compra'];            

                $query1 = "UPDATE Acesso_Realizado
                SET 
                data_acesso = current_timestamp()
                WHERE
                Acesso_Realizado.id_compra = '$id_compra'";
                mysqli_query($conn, $query1);
                header("Location: verCurso.php?id_curso=$i&tipo=cliente");
            }
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
        <p class='texto'>Bem-vindo Cliente! O que deseja fazer hoje?</p>
        <img src="../Imagens/img_banner.png" alt="">
    </div>
    
    <div class="botoes">
        <a href="comprarCurso.php"><button>Comprar cursos</button></a>
        <a href="consultarPendencias.php"><button>Consultar pendências</button></a>
        <a href="editarPerfil.php"><button>Editar perfil</button></a>

    </div>
    <div class="cards">
        <?php
        $query = "SELECT CO.id_compra, CU.id_curso, CU.nome, CU.duracao as 'Duração', PO.nome as 'Professor', CO.data as 'Data' FROM COMPRA CO join CLIENTE CL on CO.id_cliente=CL.id_cliente join CURSO CU on CO.id_curso=CU.id_curso join PROFESSOR PO on CU.id_professor=PO.id_professor where CO.aprovacao=1 and CL.email='$email';";
        imprimirCursos($conn,$query, 4);
        ?>
    </div>
    <div class="body-wrapper"></div>
</body>
<?php
    include "../componentes/footer.php";
?>
</html>