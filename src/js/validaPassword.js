document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registration-form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");

  // Crea il messaggio di errore una volta sola
  const errorMessage = document.createElement("div");
  errorMessage.textContent = "Le password non coincidono.";
  errorMessage.style.color = "red";
  errorMessage.style.display = "none";
  errorMessage.className = "password-error";

  // Inserisce il messaggio SOPRA il campo conferma
  confirmPassword.parentNode.insertBefore(errorMessage, confirmPassword);

  // Mostra errore se le password non coincidono al "blur"
  confirmPassword.addEventListener("blur", function () {
    if (password.value && confirmPassword.value && password.value !== confirmPassword.value) {
      errorMessage.style.display = "block";
    }
  });

  // Nasconde errore se si riseleziona il campo
  confirmPassword.addEventListener("focus", function () {
    errorMessage.style.display = "none";
  });

  // Controllo finale al submit
  form.addEventListener("submit", function (e) {
    if (password.value !== confirmPassword.value) {
      e.preventDefault();
      confirmPassword.value = "";
      confirmPassword.focus();
    }
  });
});


var form = {
  "username" : ['es:SuperMario45',/^[a-zA-Z0-9]{2,15}$/, 'L utente deve essere lungo tra 2 e 15 caratteri e può contenere solo lettere e numeri'],
  "password" : ['es:Password1',/^[a-zA-Z0-9]{4,}/, 'La password deve contenere almeno 4 caratteri alfanumerici'],
  "data-nascita": ['es:01-01-2000',/^(19|20)\d\d\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])$/,'La data di nascita deve essere nel formato gg-mm-aaaa']};

function riempimentoVar(){
  for(var key in form){
    var input = document.getElementById(key);
    errore(input, 0);
    input.addEventListener("blur", function() {
      checkInput(this);
    });
    input.addEventListener("change", function() {
      checkInput(this);
    });
  }
}

function checkInput(x){
  var regex = form[x.id][1]; 
  var tes = x.value;
  
  var r = x.parentNode;
  r.removeChild(r.children[1]); 

  if(!regex.test(tes)){  
    errore(x,1); 
    x.focus();
    x.select();
    return false;
  }
  if (!x.value) return true;

  return true;
}

function errore(x, y){
  var n;
  var r = x.parentNode;

  if(y == 1){
    n = document.createElement("span");
    n.className = "erroreForm";
    n.appendChild(document.createTextNode(form[x.id][2])); 
  } else {
    n = document.createElement("span");
    n.className = "suggForm"; 
    n.appendChild(document.createTextNode(form[x.id][0])); 
  }
  r.insertBefore(n,r.children[1])
}

function checkForm(){
  var check = true;
  for(var key in form){
    var input = document.getElementById(key);
    if(!checkInput(input)){
      check = false;
    }
  }
  return check;
}