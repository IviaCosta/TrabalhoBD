<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Administrador: Menu</title>
    <?php
    include("../funcoes.php");
    session_start();
    $email = $_SESSION["email"];
    $conn = startconnection();  
    $query = "SELECT * from Administrador WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $rows0 = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['id_Adm'] = $rows0[0]['id_Adm'];
    $id_Adm = $rows0[0]['id_Adm'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        for ($i = 0; $i < 100; $i++) {
            if (isset($_POST["botao-aprovar-$i"])) {
                $query = "UPDATE Compra
                SET 
                aprovacao = 1
                WHERE
                Compra.id_compra = '$i'";
                mysqli_query($conn, $query);
                header("Location: administrador.php");
            }
            if (isset($_POST["botao-reprovar-$i"])) {
                $query = "UPDATE Compra
                SET 
                aprovacao = 2
                WHERE
                Compra.id_compra = '$i'";
                mysqli_query($conn, $query);
                header("Location: administrador.php");
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
        <p class='texto'>Bem-vindo Administrador! O que deseja fazer hoje?</p>
        <img src="../Imagens/img_banner.png" alt="">
    </div>
    
    <div class="botoes">
        <a href="gerenciarClientes.php"><button>Gerenciar clientes</button></a>
        <a href="gerenciarProfessores.php"><button>Gerenciar professores</button></a>
        <a href="relatorios.php"><button>Emitir Relatorios</button></a>
        <a href="editarPerfilAdm.php"><button>Editar perfil</button></a>
        
        </div>
<?php
    $query = "SELECT  CL.nome as 'Cliente', CO.id_compra, CU.nome as 'Curso',CO.valor from Compra CO join Curso CU on CO.id_curso=CU.id_curso join Cliente CL on CO.id_cliente=CL.id_cliente WHERE CO.aprovacao='0'";
    $result = mysqli_query($conn, $query);
    imprimeTabelaAprovacao($conn, $query);
?>
</body>
</body>
<?php
    include "../componentes/footer.php";
?> 
</html>