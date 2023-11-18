<?php
function startconnection(){
$servername = "localhost";
$database = "TrabalhoBD";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
return $conn;
}

function verificarUsuario($conn, $email, $senha, $tipo)
{
    $query = "SELECT * FROM $tipo where email='$email'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (sizeof($rows) == 0) {
        echo "Usuário não encontrado.";
    } else {
        $query = "SELECT * FROM $tipo where email='$email' and senha='$senha'";
        $result = mysqli_query($conn, $query);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if (sizeof($rows) > 0) {
            echo "Connected";
            //header("Location: painel_de_controle.php");
        } else {
            echo "Senha incorreta.";
        }
    }
}
function cadastrarUsuario($conn, $nome, $email, $senha, $tipo) {

    $query = "INSERT INTO $tipo (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro ao cadastrar usuário: " . mysqli_error($conn));
    }
}

function imprimirCursos($conn, $query)
{
    // Get the results of the query
    $result = mysqli_query($conn, $query);
    $fields = mysqli_fetch_fields($result);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fieldsName = array();
    foreach ($fields as $field)
        array_push($fieldsName, $field->name);
    echo "<table>";
    echo "<tr>";
    $contador = 0;
    foreach ($rows as $row) {
        $contador++;
        echo "<td>
            <div class='card'>
                <img class='banner-curso' src='../Imagens/Cursos/{$row['nome']}.png' alt=''>
                <div class='dados'>
                ";
        foreach ($fieldsName as $field) {
            if ($field != 'id_curso' && $field != 'descricao' && $field != 'duracao')
                echo "<p><strong>$field:</strong> {$row[$field]}</p>";
            if ($field == 'duracao')
            echo "<p><strong>Duração:</strong> {$row[$field]}</p>";
            
        }
        echo "</div>
                <a href=''><button>Ver</button></a>
            </div>
        </td>";
        if($contador==4){
            echo "</tr>";
            echo "<tr>";
            $contador=0;
        }
    }
    echo "</tr>";
    echo "</table>";
}  


?>