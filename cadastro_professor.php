<?php
include_once('config.php'); 

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $modalidade = $_POST['especialidade'];

    
    $sqlInsert = "INSERT INTO professor (nome, modalidade) VALUES ('$nome', '$modalidade')";
    $result = mysqli_query($conexao, $sqlInsert);

    if ($result) {
        echo "<p style='color:green;'>✅ Professor cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>❌ Erro ao cadastrar professor: " . mysqli_error($conexao) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Professor</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            padding: 20px;
        }
        .cadastro {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 10px #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #aaa;
        }
        .botao {
            width: 100%;
            padding: 10px;
            background-color: #2d89ef;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .botao:hover {
            background-color: #1b5fa7;
        }
    </style>

    
</head>
<body>

<div class="cadastro">
    <h1>Cadastrar Professor</h1>

    <form action="cadastro_professor.php" method="post">
        <label for="nome">Nome do Professor:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="especialidade">Especialidade:</label>
        <input type="text" name="especialidade" id="especialidade" required>

        <input class="botao" type="submit" name="submit" value="Cadastrar">
    </form>
</div>

</body>
</html>
