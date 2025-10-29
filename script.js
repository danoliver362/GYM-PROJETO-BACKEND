  const btnContraste = document.getElementById("btn-contraste");
  const btnAumentar = document.getElementById("btn-aumentar-fonte");
  const btnDiminuir = document.getElementById("btn-diminuir-fonte");

  
  btnContraste.addEventListener("click", () => {
    document.body.classList.toggle("contraste");
    if (document.body.classList.contains("contraste")) {
      localStorage.setItem("modoContraste", "ativo");
    } else {
      localStorage.removeItem("modoContraste");
    }
  });

  // 
  window.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("modoContraste") === "ativo") {
      document.body.classList.add("contraste");
    }
  });

  
  let tamanhoPadrao = 100; 

  function atualizarTamanhoFonte() {
    document.body.style.fontSize = `${tamanhoPadrao}%`;
    localStorage.setItem("tamanhoFonte", tamanhoPadrao);
  }

  btnAumentar.addEventListener("click", () => {
    if (tamanhoPadrao < 140) { 
      tamanhoPadrao += 10;
      atualizarTamanhoFonte();
    }
  });

  btnDiminuir.addEventListener("click", () => {
    if (tamanhoPadrao > 80) { 
      tamanhoPadrao -= 10;
      atualizarTamanhoFonte();
    }
  });

  
  window.addEventListener("DOMContentLoaded", () => {
    const fonteSalva = localStorage.getItem("tamanhoFonte");
    if (fonteSalva) {
      tamanhoPadrao = parseInt(fonteSalva);
      atualizarTamanhoFonte();
    }
  });


    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  function mostrarSecao(id) {
      document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
      document.getElementById(id).classList.add('active');
      document.querySelectorAll('.sidebar a').forEach(link => link.classList.remove('active'));
      event.target.closest('a').classList.add('active');
    }


  // Simulando o nome do usuário logado (depois isso virá do back-end)
  const usuarioLogado = localStorage.getItem("usuario") || "Daniel"; 

  // Verifica se há login e altera o header
  if (usuarioLogado) {
    document.getElementById("loginLink").style.display = "none"; // esconde o botão Login
    document.getElementById("userInfo").style.display = "flex";  // mostra o nome
    document.getElementById("userName").textContent = usuarioLogado;
  }

