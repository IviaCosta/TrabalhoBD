<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Menu Professor</title>
    <?php
    include("../funcoes.php");
    session_start();
    $email = $_SESSION["email"];
    $conn = startconnection();  
    $query = "SELECT * from PROFESSOR WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['id_professor'] = $rows[0]['id_professor'];
   // $_SESSION['id_curso'] = $rows[0]['id_curso'];

   // $id_cliente = $_SESSION["id_cliente"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_curso = null;
        for ($i=0; $i < 100; $i++) { 
            if (isset($_POST["botao-editar-$i"])) {
                header("Location: editarCurso.php?id_curso=$i");
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
        <p class='texto'>Bem-vindo Professor! O que deseja fazer hoje?</p>
        <img src="../Imagens/Cursos/React.png" alt="">
    </div>
    
    <div class="botoes">
    <a href="cadastrarCurso.php"><button>Cadastrar cursos</button></a>    
    
    <a href="editarCurso.php"><button>Consultar acessos</button></a>
        <button>Editar perfil</button>

    </div>
    <div class="cards">
        <?php
        $query = "SELECT  C.id_curso, C.nome, C.duracao as 'Duração', P.nome as 'Professor' FROM CURSO C join PROFESSOR P on C.id_professor=P.id_professor where P.email='$email';";
        imprimirCursos($conn,$query, 2);
        ?>
    </div>
</body>
<!-- <?php
    include "../componentes/footer.php";
?> -->
</html>