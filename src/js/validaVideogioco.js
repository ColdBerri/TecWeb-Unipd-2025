var dettagli_form = {
  "nome_gioco": [
    'es: Peggle 2',
    /^[a-zA-Z0-9\s:-]{2,40}$/,
    'Il nome del videogioco deve essere lungo tra 2 e 40 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "casa_produttrice": [
    'es: From Software',
    /^[a-zA-Z0-9\s]{2,30}$/,
    'Il nome della casa produttrice deve essere lungo tra 2 e 30 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "console_compatibili": [
    'es: PS4, PS5, XBOX ONE',
    /^[a-zA-Z0-9,\s]{2,100}$/,
    'Le console devono essere elencate separando con virgole e possono contenere solo lettere, numeri e spazi'
  ],

  "descrizione": [
    'es: Gioco di avventura open-world con elementi RPG',
    /^.{10,500}$/,
    'La descrizione deve essere lunga almeno 10 caratteri e massimo 500'
  ],

  "anno_di_pubblicazione": [
    'es: 2000-01-01',
    /^\d{4}-\d{2}-\d{2}$/,
    'La data di pubblicazione deve essere nel formato aaaa-mm-gg'
  ],

  "categoria": [
    'es: RPG',
    /^[a-zA-Z0-9\s]{2,30}$/,
    'La categoria deve essere lunga tra 2 e 30 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "immagine": [
    'es: nomefile.png',
    (valore) => {
      if (!valore) return false;
      const estensione = valore.split(".").pop().toLowerCase();
      return ["png", "jpg", "jpeg", "gif"].includes(estensione);
    },
    'Il file deve avere estensione png, jpg, jpeg o gif'
  ]
};

function riempimentoVar() {
  for (var key in dettagli_form) {
    var input = document.getElementById(key);
    messaggio(input, 0);
    input.onblur = function () { validazioneCampo(this); };
  }
}

function validazioneCampo(input) {
  var validator = dettagli_form[input.id][1];

  var text = input.type === "file" && input.files.length > 0 ? input.files[0].name : input.value;

  rimuoviMessaggi(input);

  let valido;
  if (typeof validator === "function") {
    valido = validator(text);
  } else {
    valido = validator.test(text);
  }

  if (!valido) {
    messaggio(input, 1);
    input.focus(); 
    return false;
  }

  return true;
}

function validazioneForm() {
  for (var key in dettagli_form) {
    var input = document.getElementById(key);
    if (!validazioneCampo(input)) {
      return false;
    }
  }
  return true;
}

function messaggio(input, mode) {
  var node = document.createElement('span');
  var config = dettagli_form[input.id];

  if (!mode) {
    node.className = 'suggForm';
    node.textContent = config[0];
  } else {
    node.className = 'erroreForm';
    node.setAttribute("role", "alert");
    node.setAttribute("aria-live", "assertive");
    node.textContent = config[2];
  }

  input.parentNode.appendChild(node);
}

function rimuoviMessaggi(input) {
  var p = input.parentNode;
  var spans = p.querySelectorAll(".suggForm, .erroreForm");
  spans.forEach(s => p.removeChild(s));
}