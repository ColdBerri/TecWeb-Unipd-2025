var dettagli_form = {
  "username" : ['es:SuperMario45',/^[a-zA-Z0-9]{2,15}$/, 'L utente deve essere lungo tra 2 e 15 caratteri e può contenere solo lettere e numeri'],
  "password" : ['es:Password1',/^[a-zA-Z0-9]{4,}/, 'La password deve contenere almeno 4 caratteri alfanumerici'],
  "data-nascita" : ['es:01/01/2000',/\d{4}\-\d{2}\-\d{2}$/, 'La data di nascita deve essere nel formato gg/mm/aaaa'],
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
          node.setAttribute("role", "alert");
          node.setAttribute("aria-live", "assertive");
          node.appendChild(document.createTextNode(dettagli_form[input.id][2]));
      }
			
			p.appendChild(node);
		}