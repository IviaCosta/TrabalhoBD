<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <link rel="stylesheet" href="style.css">
    <title>Header</title>
    <?php 
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['sair'])) {
            session_abort();
            header("Location: login.php");
        }
    }
    
    ?>

</head>

<body>
    <div class="header">
        <a href="../Paginas/principal.php" class="logo">
        <img class='img-logo' src="../Imagens/Logo/logo-nobg.png" alt="">
        </a>
        <form action="" method="post">
        <a href=''><button type="input" name='sair'>Sair</button></a>

        </form>


    </div>
</body>

</html>