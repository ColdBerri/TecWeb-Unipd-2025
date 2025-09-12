var dettagli_form = {
    "testoRecenzione": [
        'Testo minimo 6 caratteri e massimo 200',
        /^.{6,200}$/,
        'il testo deve essere tra i 6 e 200 caratteri'
    ],
	"stelle": [
  		'',
		/^[1-5]$/,
	  'Il valore delle stelle deve essere tra 1 e 5'
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

			if (p.children[3] && p.children[3].tagName.toLowerCase() === 'p') {
                p.removeChild(p.children[3]);
            }

			if(text.search(regex) != 0){
                messaggio(input, 1);
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
          node = document.createElement('p');
          node.className = 'suggFormM';
          node.appendChild(document.createTextNode(dettagli_form[input.id][0]));
        } else {
          node = document.createElement('p');
          node.className = 'erroreForm';
          node.setAttribute('role', 'alert'); 
          node.setAttribute('aria-live', 'assertive');
          node.appendChild(document.createTextNode(dettagli_form[input.id][2]));
        }
			
        p.insertBefore(node, p.children[3]);
	}