<?php
function startconnection()
{
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
            // echo "Bem-vindo, $tipo";
            header("Location: $tipo.php");
        } else {
            echo "Senha incorreta.";
        }
    }
}
function cadastrarUsuario($conn, $nome, $email, $senha, $tipo)
{

    $query = "INSERT INTO $tipo (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro ao cadastrar usuário: " . mysqli_error($conn));
    } else {
        header("Location: login.php");

    }
}

function cadastrarCurso($conn, $nome, $descricao, $valor, $duracao, $professor)
{

    $query = "INSERT INTO Curso (nome, descricao, valor, duracao, id_professor) VALUES ('$nome', '$descricao', '$valor','$duracao', '$professor');";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro ao cadastrar curso: " . mysqli_error($conn));
    } else {
        header("Location: professor.php");

    }
}

function novaCompra($conn, $id_curso, $id_cliente, $valor)
{

    $query = "INSERT INTO Compra (id_curso, id_cliente, valor) VALUES ('$id_curso', '$id_cliente', '$valor');";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erro ao realizar nova compra: " . mysqli_error($conn));

    } else {
        header("Location: cliente.php");

    }
}

function imprimirCursos($conn, $query, $tipo)
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
    echo "<form method='POST'>";
    $contador = 0; foreach ($rows as $row) {
        $contador++;
        echo "<td>
            <div class='card'>
                <img class='banner-curso' src='../Imagens/Cursos/{$row['nome']}.png' alt=''>
                <div class='dados'>
                ";
        foreach ($fieldsName as $field) {
            if ($field != 'id_curso' && $field != 'id_compra' && $field != 'descricao' && $field != 'duracao')
                echo "<p><strong>$field:</strong> {$row[$field]}</p>";
            if ($field == 'duracao')
                echo "<p><strong>Duração:</strong> {$row[$field]}</p>";

        }
        if ($tipo == 0) {
            echo "</div>
                <button name='botao-ver-{$row['id_curso']}'>Ver</button>
            </div>
            </td>";
        } else if ($tipo == 1) {
            echo "</div>
            <button name='botao-ver-{$row['id_curso']}'>Ver</button>
            <button name='botao-comprar-{$row['id_curso']}'>Comprar</button>
        </div>
        </td>";
        } else if ($tipo == 2) {
            echo "</div>
                <button name='botao-editar-{$row['id_curso']}'>Editar</button>
                </div>
                </td>";
        } else if ($tipo == 3) {
            echo "</td>";
        } else if ($tipo == 4) {
            echo "</div>
                <button name='botao-ver-{$row['id_curso']}'>Acessar curso</button>
            </div>
            </td>";
        }
        if ($contador == 4) {
            echo "</tr>";
            echo "<tr>";
            $contador = 0;
        }
    }
    echo "</form>";
    echo "</tr>";
    echo "</table>";
}

function imprimeCursoEditar($conn, $query)
{
    // Get the results of the query
    $result = mysqli_query($conn, $query);
    $fields = mysqli_fetch_fields($result);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fieldsName = array();
    foreach ($fields as $field)
        array_push($fieldsName, $field->name);
    echo "<div class='div-editar'>"; foreach ($rows as $row) {
        echo "
            <img class='curso-imagem' src='../Imagens/Cursos/{$row['nome']}.png' alt=''>
            <div class='dados'>
            <form action='' method='post'>";
        foreach ($fieldsName as $field) {
            if ($field != 'id_curso' && $field != 'id_professor')
                if ($field == 'nome')
                    echo "<div class='campo'><p>Nome:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "valor")
                    echo "<div class='campo'><p>Valor:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "duracao")
                    echo "<div class='campo'><p>Duração:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "descricao")
                    echo "<div class='campo'><p>Descrição:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";


        }
        echo "<section>
        <input type='submit' class='button' value='Editar'>
        </form>
        </section>";
        echo "</div>";
    }
}


function imprimePerfilEditar($conn, $query, $tipo)
{
    // Get the results of the query
    $result = mysqli_query($conn, $query);
    $fields = mysqli_fetch_fields($result);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fieldsName = array();
    foreach ($fields as $field)
        array_push($fieldsName, $field->name);
    echo "<div class='div-editar'>"; foreach ($rows as $row) {
        echo "
            <div class='dados'>
            <form action='' method='post'>";
        foreach ($fieldsName as $field) {
            if ($tipo == 0) {
                if ($field == 'email')
                    echo "<div class='campo'><p>Email:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "nome")
                    echo "<div class='campo'><p>Nome:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "senha")
                    echo "<div class='campo'><p>Senha:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
            } else if ($tipo == 1) {
                if ($field == 'email')
                    echo "<div class='campo'><p>Email:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "nome")
                    echo "<div class='campo'><p>Nome:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "senha")
                    echo "<div class='campo'><p>Senha:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
                else if ($field == "especialidade")
                    echo "<div class='campo'><p>Especialidade:</p>
                <input class='edicao' name='editar-$field' value='{$row[$field]}'></div>";
            }


        }
        echo "<section>
        <input type='submit' class='button' value='Editar'>
        </form>
        </section>";
        echo "</div>";
    }
}


function imprimeCurso($conn, $id)
{
    // Get the results of the query
    $query = "SELECT C.Nome as 'Nome', C.valor as 'Valor', C.duracao as 'Duração', C.descricao as 'Descrição', P.nome as 'Professor', P.especialidade as 'Especialidade' from CURSO C join PROFESSOR P on C.id_professor=P.id_professor where id_curso = '$id'";
    $result = mysqli_query($conn, $query);
    $fields = mysqli_fetch_fields($result);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fieldsName = array();
    foreach ($fields as $field)
        array_push($fieldsName, $field->name);
    echo "<table>";
    echo "<tr>";
    echo "<form method='POST'>";
    $contador = 0; foreach ($rows as $row) {
        $contador++;
        echo "<td>
            <div class='card'>
                <img class='banner-curso' src='../Imagens/Cursos/{$row['Nome']}.png' alt=''>
                <div class='dados'>
                ";
        foreach ($fieldsName as $field) {
            if ($field != 'id_curso' && $field != 'descricao' && $field != 'duracao')
                echo "<p><strong>$field:</strong> {$row[$field]}</p>";
            if ($field == 'duracao')
                echo "<p><strong>Duração:</strong> {$row[$field]}</p>";

        }
        echo "</td>";
        if ($contador == 4) {
            echo "</tr>";
            echo "<tr>";
            $contador = 0;
        }
    }
    echo "</form>";
    echo "</tr>";
    echo "</table>";
}



?>