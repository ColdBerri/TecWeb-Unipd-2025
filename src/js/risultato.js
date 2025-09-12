document.addEventListener('DOMContentLoaded', function() {
    const risultatoDiv = document.getElementById('risultato-form');
    const params = new URLSearchParams(window.location.search);

    if (params.has('success')) {
        const messaggio = document.createElement('p');

        if (params.get('success') === '1') {
            messaggio.textContent = 'Elemento aggiunto correttamente!';
            messaggio.classList.add('okForm');
        } else {
            messaggio.textContent = 'Si è verificato un errore durante l\'aggiunta dell\'elemento.';
            messaggio.classList.add('erroreForm');
        }

        risultatoDiv.appendChild(messaggio);

        document.addEventListener('click', function(event) {
            const formContainer = event.target.closest('.form-box');

            if (formContainer && formContainer.id === 'registration-form' && risultatoDiv.contains(messaggio)) {
                risultatoDiv.removeChild(messaggio);
            }
        });

        document.addEventListener('input', function(event) {
            const formContainer = event.target.closest('.form-box');
            if (formContainer && formContainer.id === 'registration-form' && risultatoDiv.contains(messaggio)) {
                risultatoDiv.removeChild(messaggio);
            }
        });
    }
});