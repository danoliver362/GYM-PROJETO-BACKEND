<?php
include_once('config.php');


$matricula = $_GET['matricula'] ?? null;


$nomeAluno = "Aluno não encontrado";
if ($matricula) {
    $sqlAluno = "SELECT nome FROM aluno WHERE matricula = '$matricula'";
    $resultAluno = mysqli_query($conexao, $sqlAluno);
    if ($resultAluno && mysqli_num_rows($resultAluno) > 0) {
        $rowAluno = mysqli_fetch_assoc($resultAluno);
        $nomeAluno = $rowAluno['nome'];
    }
}


$sqlProfessores = "SELECT id_professor, nome, modalidade FROM professor ORDER BY nome ASC";
$resultProfessores = mysqli_query($conexao, $sqlProfessores);

if (isset($_POST['submit'])) {
    $data_aula = $_POST['data_aula'];
    $hora_aula = $_POST['hora_aula'];
    $tipo_aula = $_POST['tipo_aula'];
    $id_professor = $_POST['id_professor'];

    $sqlInsert = "INSERT INTO agendamento (data_aula, hora_aula, tipo_aula, matricula, id_professor)
                  VALUES ('$data_aula', '$hora_aula', '$tipo_aula', '$matricula', '$id_professor')";

    $result = mysqli_query($conexao, $sqlInsert);

    if ($result) {
        echo "<p style='color:green;'>✅ Agendamento salvo com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>❌ Erro ao agendar: " . mysqli_error($conexao) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Aula</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; }
        .Agendamento { background: white; width: 400px; margin: 50px auto; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #aaa; }
        h1 { text-align: center; }
        input, select { width: 100%; padding: 8px; margin: 8px 0; }
        .botao { background-color: #007bff; color: white; border: none; padding: 10px; cursor: pointer; }
        .botao:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<div class="Agendamento">
    <h1>Agendar Aula</h1>

    <form action="agendamento.php?matricula=<?=$matricula?>" method="post">
        <p><strong>Matrícula:</strong> <?=$matricula?></p>
        <p><strong>Aluno:</strong> <?=$nomeAluno?></p>

        <label for="data_aula">Data da aula:</label>
        <input type="date" name="data_aula" id="data_aula" required>

        <label for="hora_aula">Hora da aula:</label>
        <input type="time" name="hora_aula" id="hora_aula" required>

        <label for="tipo_aula">Tipo de aula:</label>
        <input type="text" name="tipo_aula" id="tipo_aula" required>

        <label for="id_professor">Professor:</label>
        <select name="id_professor" id="id_professor" required>
            <option value="">Selecione um professor</option>
            <?php while ($row = mysqli_fetch_assoc($resultProfessores)) { ?>
                <option value="<?=$row['id_professor']?>">
                    <?=$row['nome']?> — <?=$row['modalidade']?>
                </option>
            <?php } ?>
        </select>

        <input class="botao" type="submit" name="submit" value="Agendar">
    </form>
</div>

</body>
</html>
