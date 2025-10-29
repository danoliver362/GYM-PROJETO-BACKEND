
let alunos = [
  { id: 1, nome: "Fábio", matricula: "102", data: "2025-09-08", mensalidade: "pago", hora: "12/09 - 08h" },
  { id: 2, nome: "Daniela", matricula: "105", data: "2025-09-16", mensalidade: "atrasado", hora: "17/09 - 11h" },
  { id: 3, nome: "Roberta", matricula: "103", data: "2025-09-11", mensalidade: "aguardando", hora: "11/09 - 10h" },
  { id: 4, nome: "Patrícia", matricula: "104", data: "2025-09-14", mensalidade: "pago", hora: "14/09 - 09h" }
];

let logs = [
  {evento: "login", usuario: "admin", datetime: "2025-09-18 10:00", detalhes: "Login bem-sucedido" },
  {evento: "consulta", usuario: "admin", datetime: "2025-09-18 10:02", detalhes: "Consultou lista de alunos" }
];


const tabelaAlunos = document.getElementById("tabela-alunos");
const tabelaLogs = document.getElementById("tabela-logs");
const campoBusca = document.getElementById("buscar");
const btnNovoAluno = document.getElementById("btn-novo-aluno");


const modal = document.getElementById("modal");
const formAluno = document.getElementById("form-aluno");
const modalTitle = document.getElementById("modal-title");
const modalCancel = document.getElementById("modal-cancel");
let editarId = null;


const btnContraste = document.getElementById("btn-contraste");
const btnAumentar = document.getElementById("btn-aumentar-fonte");
const btnDiminuir = document.getElementById("btn-diminuir-fonte");


document.querySelectorAll('.sidebar a').forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const target = link.dataset.target;
    mostrarSecao(target);
    document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
    link.classList.add('active');
  });
});

function mostrarSecao(id){
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  const sec = document.getElementById(id);
  if(sec) sec.classList.add('active');
}

function renderAlunos(list = alunos){
  tabelaAlunos.innerHTML = '';
  if(list.length === 0){
    tabelaAlunos.innerHTML = `<tr><td colspan="6" style="text-align:center;color:#6b7280">Nenhum aluno encontrado</td></tr>`;
    return;
  }

  list.forEach(a => {
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${a.nome}</td>
      <td>${a.matricula}</td>
      <td>${formatData(a.data)}</td>
      <td><span class="status ${a.mensalidade}">${labelMensalidade(a.mensalidade)}</span></td>
      <td>${a.hora || '-'}</td>
      <td>
        <button title="Excluir" class="icon-btn delete" data-id="${a.id}"><i class="bi bi-x-circle"></i></button>
        <button title="Editar" class="icon-btn edit" data-id="${a.id}"><i class="bi bi-pencil"></i></button>
      </td>
    `;
    tabelaAlunos.appendChild(tr);
  });

  
  document.querySelectorAll('.delete').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const id = Number(btn.dataset.id);
      removerAluno(id);
    });
  });

  document.querySelectorAll('.edit').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = Number(btn.dataset.id);
      abrirModalEditar(id);
    });
  });
}


function renderLogs(){
  tabelaLogs.innerHTML = '';
  if(logs.length === 0){
    tabelaLogs.innerHTML = `<tr><td colspan="4" style="text-align:center;color:#6b7280">Sem logs</td></tr>`;
    return;
  }
  logs.slice().reverse().forEach(l => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${l.evento}</td><td>${l.usuario}</td><td>${l.datetime}</td><td>${l.detalhes}</td>`;
    tabelaLogs.appendChild(tr);
  });
}


function labelMensalidade(status){
  if(status === 'pago') return 'Pago ✔';
  if(status === 'atrasado') return 'Atrasado ⚠';
  return 'Aguardando 💳';
}
function formatData(iso){ 
  try {
    const d = new Date(iso);
    if (isNaN(d)) return iso;
    return d.toLocaleDateString('pt-BR', { day: '2-digit', month: 'short', year: 'numeric' });
  } catch(e) { return iso; }
}
function agora(){
  const d = new Date();
  return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
}
function pad(n){ return String(n).padStart(2,'0') }


function adicionarAluno(obj){
  const novo = {...obj, id: (alunos.length ? Math.max(...alunos.map(a=>a.id)) + 1 : 1)};
  alunos.push(novo);
  logs.push({evento:'criar_aluno', usuario:'admin', datetime: agora(), detalhes: `Criou aluno ${novo.nome}`});
  renderAlunos();
  renderLogs();
}

function atualizarAluno(id, obj){
  const idx = alunos.findIndex(a => a.id === id);
  if(idx === -1) return;
  alunos[idx] = {...alunos[idx], ...obj};
  logs.push({evento:'editar_aluno', usuario:'admin', datetime: agora(), detalhes: `Editou aluno ${alunos[idx].nome}`});
  renderAlunos();
  renderLogs();
}

function removerAluno(id){
  const aluno = alunos.find(a => a.id === id);
  if(!aluno) return;
  if(!confirm(`Confirma exclusão do aluno ${aluno.nome}?`)) return;
  alunos = alunos.filter(a => a.id !== id);
  logs.push({evento:'excluir_aluno', usuario:'admin', datetime: agora(), detalhes: `Excluiu aluno ${aluno.nome}`});
  renderAlunos();
  renderLogs();
}


function abrirModalEditar(id){
  const aluno = alunos.find(a => a.id === id);
  if(!aluno) return;
  editarId = id;
  modalTitle.textContent = 'Editar aluno';
  formAluno.nome.value = aluno.nome;
  formAluno.matricula.value = aluno.matricula;
  formAluno.data.value = aluno.data;
  formAluno.mensalidade.value = aluno.mensalidade;
  formAluno.hora.value = aluno.hora || '';
  modal.classList.remove('hidden');
  modal.setAttribute('aria-hidden', 'false');
}

function abrirModalNovo(){
  editarId = null;
  modalTitle.textContent = 'Novo aluno';
  formAluno.reset();

  formAluno.mensalidade.value = 'pago';
  modal.classList.remove('hidden');
  modal.setAttribute('aria-hidden', 'false');
}

modalCancel.addEventListener('click', fecharModal);
modal.addEventListener('click', (e) => {
  if(e.target === modal) fecharModal();
});
function fecharModal(){
  modal.classList.add('hidden');
  modal.setAttribute('aria-hidden', 'true');
}

formAluno.addEventListener('submit', (e) => {
  e.preventDefault();
  const form = e.target;
  const obj = {
    nome: form.nome.value.trim(),
    matricula: form.matricula.value.trim(),
    data: form.data.value,
    mensalidade: form.mensalidade.value,
    hora: form.hora.value.trim()
  };
  if(editarId){
    atualizarAluno(editarId, obj);
  } else {
    adicionarAluno(obj);
  }
  fecharModal();
});


campoBusca.addEventListener('input', () => {
  const termo = campoBusca.value.trim().toLowerCase();
  const filtrados = alunos.filter(a => a.nome.toLowerCase().includes(termo) || a.matricula.includes(termo));
  renderAlunos(filtrados);
});


btnNovoAluno.addEventListener('click', abrirModalNovo);


document.getElementById('confirm-logout').addEventListener('click', () => {
  logs.push({evento:'logout', usuario:'admin', datetime: agora(), detalhes: 'Logout efetuado'});
  renderLogs();
  alert('Logout (demo). Implemente rota no backend.');
  mostrarSecao('inicio');
});


btnContraste.addEventListener('click', () => {
  document.body.classList.toggle('contraste');
  if(document.body.classList.contains('contraste')) localStorage.setItem('modoContraste','ativo');
  else localStorage.removeItem('modoContraste');
});


let tamanhoFonte = Number(localStorage.getItem('tamanhoFonte') || 100);
function aplicarTamanhoFonte(){
  document.documentElement.style.fontSize = `${tamanhoFonte}%`;
  localStorage.setItem('tamanhoFonte', String(tamanhoFonte));
}
btnAumentar.addEventListener('click', () => {
  if(tamanhoFonte < 140){ tamanhoFonte += 10; aplicarTamanhoFonte(); }
});
btnDiminuir.addEventListener('click', () => {
  if(tamanhoFonte > 80){ tamanhoFonte -= 10; aplicarTamanhoFonte(); }
});


window.addEventListener('DOMContentLoaded', () => {
  if(localStorage.getItem('modoContraste') === 'ativo') document.body.classList.add('contraste');
  aplicarTamanhoFonte();
  renderAlunos();
  renderLogs();
});


window.addEventListener('load', () => {
  const hash = location.hash.replace('#','');
  if(hash && document.getElementById(hash)) {
    mostrarSecao(hash);
    document.querySelectorAll('.sidebar a').forEach(a => a.classList.toggle('active', a.dataset.target === hash));
  }
});
