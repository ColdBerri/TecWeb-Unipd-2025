var dettagli_form = {
  "nome_videogioco": [
    '',
    /^[a-zA-Z0-9\s]{2,50}$/, 
    'Il nome del gioco deve essere lungo tra 2 e 50 caratteri e può contenere solo lettere, numeri e spazi'
  ],
  
  "nome_evento": [
    'es: Torneo Nazionale Peggle',
    /^[a-zA-Z0-9\s]{2,50}$/, 
    'Il nome dell\'evento deve essere lungo tra 2 e 50 caratteri e può contenere solo lettere, numeri e spazi'
  ],

  "data_inizio_evento": [
    'es: 2000-01-01',
    /^\d{4}-\d{2}-\d{2}$/,  
    'La data di inizio deve essere nel formato aaaa-mm-gg'
  ],

  "data_fine_evento": [
    'es: 2000-01-01',
    /^\d{4}-\d{2}-\d{2}$/, 
    'La data di fine deve essere nel formato aaaa-mm-gg'
  ],

  "squadre_coinvolte": [
    'es: M80, Falcon, Sentinel',
    /^[a-zA-Z0-9,\s]{2,100}$/, 
    'Le squadre devono essere una lista separata da virgole e contenere solo lettere, numeri e spazi'
  ],

  "vincitore_evento": [
    'es: M80',
    /^[a-zA-Z0-9\s]{2,30}$/,  
    'Il nome del vincitore deve essere lungo tra 2 e 30 caratteri e può contenere solo lettere, numeri e spazi'
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