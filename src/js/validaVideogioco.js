var dettagli_form = {
  "nome_gioco": [
    'es: Peggle 2',
    /^[a-zA-Z0-9\s]{2,30}$/, 
    'Il nome del gioco deve essere lungo tra 2 e 30 caratteri e può contenere solo lettere, numeri e spazi'
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
    'Preferibilmente .png',
    /^[\w,\s-]+\.(png|jpg|jpeg|gif)$/,
    'Il nome del file immagine deve terminare con .png, .jpg, .jpeg o .gif'
  ]
};

function riempimentoVar() {
      for(var key in dettagli_form){
			  var input = document.getElementById(key);
			  messaggio(input, 0);
			  input.onblur = function() {validazioneCampo(this);};
		   }
		}

		function validazioneCampo(input) {		
      var regex = dettagli_form[input.id][1];
			var text = input.value;

			var p = input.parentNode;
			p.removeChild(p.children[2]);

			if(text.search(regex) != 0){
                messaggio(input, 1);
				input.focus(); 
				input.select();
				return false;
			}

			return true;
		}
		
		function validazioneForm() {
			for (var key in dettagli_form){
				var input = document.getElementById(key);
				if(!validazioneCampo(input)){
					return false;
				}
			}
			return true;
		}
			
		function messaggio(input, mode) {

			var node;
			var p=input.parentNode; 
			

      if (!mode) {
          node = document.createElement('span');
          node.className = 'suggForm';
          node.appendChild(document.createTextNode(dettagli_form[input.id][0]));
      } else {
          node = document.createElement('span');
          node.className = 'erroreForm';
          node.setAttribute('aria-live', 'assertive'); 
          node.appendChild(document.createTextNode(dettagli_form[input.id][2]));
      }
			
			p.appendChild(node);
		}