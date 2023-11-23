<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="../Imagens/Logo/logo-small.png">
    <title>Relatorios</title>
    <?php
    include("../funcoes.php");
    $conn=startconnection();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["botao-1"])) {
                $query="SELECT C.nome AS Cliente, CO.data AS Data_Compra, CU.nome AS Curso
                FROM Cliente C
                INNER JOIN COMPRA CO ON C.id_Cliente = CO.id_cliente
                INNER JOIN Curso CU ON CO.id_curso = CU.id_curso;";

            }
            if (isset($_POST["botao-2"])) {
                $query= "SELECT P.nome AS Professor, CU.nome AS Curso
                FROM Professor P
                LEFT OUTER JOIN Curso CU ON P.id_professor = CU.id_professor;";

            }
            if (isset($_POST["botao-3"])) {
                $query= "SELECT P.nome AS Professor, COUNT(CU.id_curso) AS Total_Cursos, SUM(CO.valor) AS Vendas_Total
                FROM Professor P
                LEFT JOIN Curso CU ON P.id_professor = CU.id_professor
                JOIN COMPRA CO ON CU.id_curso = CO.id_curso
                JOIN Cliente C ON CO.id_cliente = C.id_Cliente
                GROUP BY P.nome;";
                

            }
            if (isset($_POST["botao-4"])) {
                $query= "SELECT P.nome AS Professor, COUNT(CU.id_curso) AS Total_Cursos, SUM(CO.valor) AS Vendas_Total
                FROM Professor P
                LEFT JOIN Curso CU ON P.id_professor = CU.id_professor
                JOIN COMPRA CO ON CU.id_curso = CO.id_curso
                JOIN Cliente C ON CO.id_cliente = C.id_Cliente
                GROUP BY P.nome
                HAVING Vendas_Total > 500;";
                

            }
            if (isset($_POST["botao-5"])) {
                $query= "SELECT C.nome AS Cliente, CO.data AS Data_Compra, CU.nome AS Curso
                FROM Cliente C
                JOIN COMPRA CO ON C.id_Cliente = CO.id_cliente
                JOIN Curso CU ON CO.id_curso = CU.id_curso
                WHERE CU.id_professor IN (
                    SELECT P.id_professor
                    FROM Professor P
                    LEFT JOIN Curso CU ON P.id_professor = CU.id_professor
                    JOIN COMPRA CO ON CU.id_curso = CO.id_curso
                    JOIN Cliente C ON CO.id_cliente = C.id_Cliente
                    GROUP BY P.nome
                    HAVING SUM(CO.valor) > 500);";
                

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
        <p class='texto'>Bem-vindo Administrador! Veja aqui alguns Relatorios do Sistemas</p>
        <img src="../Imagens/img_banner.png" alt="">
    </div>
    <form action="" method='POST'>
    <div class="botoes-relatorio">
        <button name='botao-1'>Visualizar compras</button>
        <button name='botao-2'>Relação cursos e professores</button>
        <button name='botao-3'>Relação professores e cursos vendidos</button>
        <button name='botao-4'>Relação de professores que venderam mais que R$500,00 em cursos</button>
        <button name='botao-5'>Relação cliente e compras que somaram mais que R$500,00, de um único professor</button>
        </div>
</form>
<?php
    imprimeTabela($conn,$query);
?>
<div class="body-wrapper"></div>
</body>

<?php
    include "../componentes/footer.php";
?> 
</html>