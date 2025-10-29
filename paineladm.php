<?php
session_start();

// 🔒 Verifica se o usuário está logado e se é o admin (master)
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'master') {
    header("Location: LoginAdm.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Painel do Administrador - GYM</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styleadm.css">
</head>
<body>
  
  <div class="acessibilidade-bar">
    <div class="acessibilidade-controls">
      <button id="btn-contraste" title="Alternar contraste">Contraste</button>
      <button id="btn-diminuir-fonte" title="Diminuir fonte">A-</button>
      <button id="btn-aumentar-fonte" title="Aumentar fonte">A+</button>
    </div>
  </div>

  <div class="app">
    
    <aside class="sidebar">
      <div class="logo">GYM</div>
      <nav>
        <a href="#inicio" class="active" data-target="inicio"><i class="bi bi-house"></i> Início</a>
        <a href="#alunos" data-target="alunos"><i class="bi bi-people"></i> Consultar Aluno</a>
        <a href="#horarios" data-target="horarios"><i class="bi bi-calendar-week"></i> Quadro de horário</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
      </nav>
    </aside>

    <main class="main">
      <section id="inicio" class="section active">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?> 👋</h1>
        <p>Você está logado como administrador do sistema.</p>
      </section>

      <section id="alunos" class="section">
        <div class="header-row">
          <h1>Painel do Administrador</h1>
          <div class="actions">
            <button id="btn-novo-aluno" class="primary">+ Novo aluno</button>
          </div>
        </div>

        <h2>Consultar Aluno</h2>
        <div class="search-row">
          <label for="buscar">Buscar aluno</label>
          <input id="buscar" type="text" placeholder="Digite o nome do aluno..." />
        </div>

        <div class="table-wrap">
          <table class="alunos-table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Data da Matrícula</th>
                <th>Mensalidade</th>
                <th>Hora / Aula</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody id="tabela-alunos"></tbody>
          </table>
        </div>

        <h2>Logs de acesso / ações</h2>
        <div class="table-wrap">
          <table class="logs-table">
            <thead>
              <tr>
                <th>Evento</th>
                <th>Usuário</th>
                <th>Data / Hora</th>
                <th>Detalhes</th>
              </tr>
            </thead>
            <tbody id="tabela-logs"></tbody>
          </table>
        </div>
      </section>

      <section id="horarios" class="section">
        <h1>Quadro de horário do professor</h1>
      </section>
    </main>
  </div>

  <div id="modal" class="modal hidden" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true">
      <h3 id="modal-title">Editar aluno</h3>
      <form id="form-aluno">
        <label>Nome
          <input type="text" name="nome" required />
        </label>
        <label>Matrícula
          <input type="text" name="matricula" required />
        </label>
        <label>Data da Matrícula
          <input type="date" name="data" required />
        </label>
        <label>Mensalidade
          <select name="mensalidade" required>
            <option value="pago">Pago</option>
            <option value="atrasado">Atrasado</option>
            <option value="aguardando">Aguardando</option>
          </select>
        </label>
        <label>Hora / Aula
          <input type="text" name="hora" placeholder="ex: 12/09 - 08h" />
        </label>

        <div class="modal-actions">
          <button type="button" id="modal-cancel">Cancelar</button>
          <button type="submit" class="primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
