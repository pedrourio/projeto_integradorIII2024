var btv = document.getElementById('cadastrar');
var form = document.getElementById('form')
btv.addEventListener('click', validar);
form.addEventListener('submit', validar);

var subNome = document.getElementById("campoNome");
var subSobrenome = document.getElementById("campoSobrenome");
var subNomeDeUsu = document.getElementById("campoNomeUsuario");
var subTel = document.getElementById("campoTelefone");
var subEmail = document.getElementById("campoEmail");
var subSenha = document.getElementById("campoSenha");
var subCSenha = document.getElementById("campoCSenha");

function validar(e) {
  if ((validarNome() === false) || (validarSobrenome() == false) || (validarNomeUsuario() == false) || (validarTelefone() == false) || (validarEmail() == false) || (validarSenha() == false) || (confirmarSenha() == false)) {
    e.preventDefault(); // Cancela a submissão do formulário
  }
}

//Nome
function validarNome() {
  var nm1 = document.getElementById('nome').value;

  if (nm1 === '' || nm1 < 5) {
    subNome.innerHTML = "Nome inválido";
    subNome.classList.add("erro")
    return false;
  } else {
    subNome.classList.remove("erro")
    subNome.classList.add("certo")
    subNome.innerHTML = "Nome válido!";
    return true;
  }
}

//Sobrenome
function validarSobrenome() {
  var sobren = document.getElementById('sobrenome').value;


  if (sobren === '' || sobren.length < 5) {
    subSobrenome.innerHTML = "Sobrenome inválido (mínimo 5 caracteres)";
    subSobrenome.classList.add("erro");
    return false;
  }
  if (!isNaN(sobren.value)) {
      subSobrenome.innerHTML = "Sobrenome não pode conter dígitos númericos";
      subSobrenome.classList.add("erro");
      return false;
  }


  subSobrenome.classList.remove("erro");
  subSobrenome.classList.add("certo");
  subSobrenome.innerHTML = "Sobrenome válido!";
  return true;
}



// Nome de usuario
function validarNomeUsuario() {
  var nusuario = document.getElementById('nomeusuario').value;
  if (nusuario === '' || nusuario.length < 5) {
    subNomeDeUsu.innerHTML = "Não pode estar vazio, e deve conter no mínimo 5 carecteres";
    subNomeDeUsu.classList.add("erro");
    return false;
  }

  var regex = /[^a-z0-9_]/g;
  if (regex.test(nusuario)) {
    subNomeDeUsu.innerHTML = "Nome de usuário pode conter apenas letras minúsculas, números e sublinhados";
    subNomeDeUsu.classList.add("erro");
    return false;
  }

  subNomeDeUsu.classList.remove("erro");
  subNomeDeUsu.classList.add("certo");
  subNomeDeUsu.innerHTML = "Nome de Usuário válido!";
  return true;
}

//Validação Telefone
function validarTelefone() {
  var telefone = document.getElementById("telefone").value.replace(/\D/g, ''); // Remover não numéricos

  // Verificar se o telefone tem 11 dígitos após a formatação
  if (telefone.length !== 11) {
    subTel.innerHTML = "Telefone inválido, utilize um telefone válido de 11 dígitos ex: '54123456789'";
    subTel.classList.add("erro");
    return false;
  } else {
    subTel.classList.remove("erro");
    subTel.classList.add("certo");
    subTel.innerHTML = "Telefone válido!";
    return true;
  }
}

// Evento input para formatar o número de telefone em tempo real
document.getElementById("telefone").addEventListener("input", function() {
  var telefone = this.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
  var formattedTelefone;
  
  if (telefone.length >= 2 && telefone.length <= 11) {
    // Formatar com DDD
    formattedTelefone = "(" + telefone.substring(0, 2) + ") ";
    
    // Adicionar o restante do número
    if (telefone.length > 2 && telefone.length <= 7) {
      formattedTelefone += telefone.substring(2, 7);
    } else if (telefone.length > 7) {
      formattedTelefone += telefone.substring(2, 7) + "-" + telefone.substring(7);
    }
    
    // Definir o valor do campo de telefone com a formatação
    this.value = formattedTelefone;
  } else {
    // Se o número for menor que 2 ou maior que 11, não aplicar formatação
    this.value = telefone;
  }
});


//E-mail
function validarEmail() {
  var email = document.getElementById('email').value;
  var partesEmail = email.split("@"); // Correção aqui

  if (email.indexOf(".") === -1 || email.indexOf("@") === -1 ||  email.indexOf(" ") >= 0 || partesEmail.length !== 2 || partesEmail[0].length === 0 || partesEmail[1].length === 0) {
      subEmail.innerHTML = "Email inválido, utilize um email válido sem espaços, e certifique-se que contém caracteres antes e depois do @ e com pelo menos uma extensão no email '.', ex: 'xx.com'";
      subEmail.classList.add("erro")
      return false;
  } else {
      subEmail.classList.remove("erro")
      subEmail.classList.add("certo")
      subEmail.innerHTML = "Email válido!";
      return true;
  }
}

function validarSenha() {
  var senha = document.getElementById("senha").value;
  var confirmarSenha = document.getElementById("csenha").value;

  var caractereEspecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

  if (!caractereEspecial.test(senha) || senha.indexOf(" ") >= 0) {
      subSenha.innerHTML = "Senha inválida, é necessário ter um caractere especial para aumentar sua segurança.";
      subSenha.classList.add("erro"); return false;
  } else {
      subSenha.innerHTML = "Senha Forte!";
      subSenha.classList.remove("erro"); subSenha.classList.add("certo"); return true;
  }
}

function confirmarSenha() {
  var senha = document.getElementById("senha").value;
  var confirmarSenha = document.getElementById("csenha").value;

  if (senha !== confirmarSenha || confirmarSenha.indexOf(" ") >= 0) {
      subCSenha.innerHTML = "A confirmação de senha não coincide com a senha digitada.";
      subCSenha.classList.add("erro");
      return false;
  } else {
      subCSenha.innerHTML = "As senhas coincidem!";
      subCSenha.classList.remove("erro");
      subCSenha.classList.add("certo");
      return true;
  }
}



// Adicionando evento de clique ao botão "Mostrar Senha"
document.getElementById("btnsenha").addEventListener("click", function() {
  var senhaInput = document.getElementById("senha");
  if (senhaInput.type === "password") {
      senhaInput.type = "text";
      this.textContent = "Ocultar Senha";
  } else {
      senhaInput.type = "password";
      this.textContent = "Mostrar Senha";
  }
});

document.getElementById("btnCsenha").addEventListener("click", function() {
  var senhaInput = document.getElementById("csenha");
  if (senhaInput.type === "password") {
      senhaInput.type = "text";
      this.textContent = "Ocultar Senha";
  } else {
      senhaInput.type = "password";
      this.textContent = "Mostrar Senha";
  }
});























