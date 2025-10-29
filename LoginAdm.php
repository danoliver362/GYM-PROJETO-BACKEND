<?php
session_start();
include 'config.php'; // Conexão com o banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    // Consulta o administrador
    $sql = "SELECT * FROM administração WHERE nome = '$nome' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

    if (mysqli_num_rows($resultado) == 1) {
        $admin = mysqli_fetch_assoc($resultado);

        // Cria a sessão do admin
        $_SESSION['id_usuario'] = $admin['id_usuario'];
        $_SESSION['nome'] = $admin['nome'];
        $_SESSION['tipo'] = 'master';

        // Redireciona para o painel
        header("Location: paineladm.php");
        exit();
    } else {
        echo "<script>alert('Nome ou senha incorretos!'); window.location='LoginAdm.html';</script>";
    }
} else {
    header("Location: LoginAdm.html");
    exit();
}
?>
