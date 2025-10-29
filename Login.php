<?php
include_once('config.php');

$login = $_POST['login'];
$senha = $_POST['senha'];

$result = mysqli_query($conexao, "SELECT * FROM aluno WHERE login = '$login'");
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($senha, $user['senha_hash'])) {
    session_start();
    $_SESSION['usuario'] = $user['login'];
    header("Location: painel.php");
    exit;
} else {
    echo "<script>alert('Login ou senha incorretos!'); window.history.back();</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GYM System</title>

  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">

  <style>
    
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 40px;
      text-align: center;
      letter-spacing: 1px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 80%;
      max-width: 500px;
    }

    label {
      font-weight: 700;
      margin-bottom: 5px;
      text-transform: uppercase;
    }

    input {
      padding: 10px 15px;
      border: none;
      border-radius: 25px;
      background: linear-gradient(90deg, #000428, #004e92);
      color: #fff;
      font-size: 1rem;
      outline: none;
    }

    input::placeholder {
      color: #ddd;
    }

    .botoes {
      display: flex;
      justify-content: center;
      gap: 50px;
      margin-top: 30px;
    }

    .botoes button {
      background: none;
      border: none;
      color: #fff;
      font-weight: 700;
      font-size: 1.2rem;
      cursor: pointer;
      transition: 0.3s;
      text-transform: uppercase;
    }

    .botoes button:hover {
      color: #ff2e63;
    }

    .acessibilidade {
      margin-top: 30px;
      background: #1a1aff;
      color: #fff;
      padding: 8px 16px;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      transition: 0.3s;
    }

    .acessibilidade:hover {
      background: #004e92;
    }
  </style>
</head>
<body>


  <header>
    <div class="logo">
      <span>GYM</span><i class="bi bi-bicycle"></i>
    </div>
    <nav>
      <a href="login.html"><i class="bi bi-person-circle"></i>LOGIN</a>
      <a href="#"><i class="bi bi-box-arrow-right"></i>LOGOUT</a>
      <a href="cadastroacademia.php"><i class="bi bi-person-plus"></i>CADASTRE-SE</a>
    </nav>
  </header>

  
  <main>
    <h1>LOGIN</h1>
    <form action="#" method="post">
      <label for="email">E-MAIL</label>
      <input type="email" id="email" name="email" placeholder="Digite seu e-mail">

      <label for="senha">SENHA</label>
      <input type="password" id="senha" name="senha" placeholder="Digite sua senha">

      <div class="botoes">
        <button type="submit">ENTRAR</button>
        <button type="reset">LIMPAR</button>
      </div>

      <button class="acessibilidade">ACESSIBILIDADE</button>
    </form>
  </main>

 
  <footer>
    GYM
  </footer>

  <script src="script.js"></script>
</body>
</html>
