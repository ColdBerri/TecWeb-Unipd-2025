var dettagli_form = {
  "nome_videogioco": [
    '',
    /^[a-zA-Z0-9\s]{2,70}$/,
    'Il nome del videogioco deve essere lungo tra 2 e 70 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "titolo_articolo": [
    'es: Miglioramento grafico',
    /^[a-zA-Z0-9\s]{2,50}$/,
    'Il titolo dell\'articolo deve essere lungo tra 2 e 50 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "autore": [
    'es: Mario Bianchi',
    /^[a-zA-Z\s]{2,40}$/,
    'Il nome dell\'autore deve essere lungo tra 2 e 40 caratteri e può contenere solo lettere e spazi'
  ],

  "data_pubblicazione": [
    'es: 2000-01-01',
    /^\d{4}-\d{2}-\d{2}$/,
    'La data di pubblicazione deve essere nel formato aaaa-mm-gg'
  ],

  "testo_articolo": [
    'es: Questo aggiornamento introduce nuovi effetti visivi e texture HD.',
    /^.{10,1000}$/,
    'Il testo dell\'articolo deve essere lungo almeno 10 caratteri'
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