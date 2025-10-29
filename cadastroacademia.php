<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    // --- Dados do formulário ---
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $plano = $_POST['plano'];

    // --- Campos de login e senha ---
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $confirmarsenha = $_POST['confirmarsenha'];

    // --- 1️⃣ Verifica se as senhas conferem ---
    if ($senha !== $confirmarsenha) {
        echo "<script>alert('As senhas não conferem!'); window.history.back();</script>";
        exit;
    }

    // --- 2️⃣ Verifica se o login já existe ---
    $checkLogin = mysqli_query($conexao, "SELECT * FROM aluno WHERE login = '$login'");
    if (mysqli_num_rows($checkLogin) > 0) {
        echo "<script>alert('Este login já está em uso! Escolha outro.'); window.history.back();</script>";
        exit;
    }

    // --- 3️⃣ Criptografa a senha ---
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    


    // --- 4️⃣ Insere os dados no banco ---
    $sql = "INSERT INTO aluno 
            (nome, cpf, email, telefone, cep, endereco, plano, login, senha_hash)
            VALUES 
            ('$nome', '$cpf', '$email', '$telefone', '$cep', '$endereco', '$plano', '$login', '$senha_hash')";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo 'Erro ao cadastrar: ' . mysqli_error($conexao);
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GYM Cadastro</title>

  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  
  <link rel="stylesheet" href="stylecadastro.css">
</head>
<body>

  
  <header>
    <div class="logo">
      <i class="bi bi-lightning-charge-fill"></i> GYM 
    </div>
    <nav>
      <a href="agendamento.php?matricula=<?=$row['matricula']?>&id_professor=<?=$row['id_professor']?>">Agendar aula</a>
      <a href="PaginaInicial.html">Início</a>
      <a href="login.html">Login</a>
      <a href="cadastro.html" class="active">Cadastro</a>
      <a href="paineladm.html">Painel Administrador</a>
    </nav>
  </header>

  
  <main>
    <section class="container">
      <h1 id="titulo">Cadastro de Aluno</h1>
      <div class="conteúdo">

        
        <div class="img">
          <img src="https://cdn-icons-png.flaticon.com/512/2966/2966481.png" alt="Imagem de cadastro">
        </div>

        
        <form class="formulario" action="cadastroacademia.php" method="post" >

          <fieldset>
            <div class="campo">
              <label for="nome">Nome completo</label>
              <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
            </div>

            <div class="campo">
              <label for="cpf">CPF</label>
              <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="000.000.000-00" required>
            </div>

            <div class="campo">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>

            <div class="campo">
              <label for="telefone">Telefone</label>
              <input type="tel" id="telefone" name="telefone" maxlength="15" placeholder="(00) 00000-0000" required>
            </div>

            <div class="campo">
              <label for="cep">CEP</label>
              <input type="text" id="cep" name="cep" maxlength="9" placeholder="00000-000" required>
            </div>

            <div class="campo">
              <label for="endereco">Endereço</label>
              <input type="text" id="endereco" name="endereco" placeholder="digite o endereco">
            </div>

            <div class="campo" id="plano">
              <label for="plano">Plano</label>
              <select id="plano" name="plano" required>
                <option value="">Selecione...</option>
                <option value="mensal">Mensal</option>
                <option value="trimestral">Trimestral</option>
                <option value="anual">Anual</option>
              </select>
            </div>

            <div class="campo">
               <label for="login">Login</label>
               <input type="text" name="login" id="login" placeholder="Digite seu login" required >

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
                 
                <label for="confirmarsenha">confirmarsenha</label>
                <input type="password" name="confirmarsenha" id="confirmarsenha"  placeholder="Confirme sua senha" required>
            </div>
          </fieldset>

          <div class="botoes">
            <input class="botao" type="submit" name="submit" id="submit">
            <button type="reset" class="botao">Limpar</button>
          </div>
        </form>
      </div>
    </section>
  </main>

  
  <footer>
    <p>© 2025 GYM </p>
  </footer>

  
  
</body>
</html>
