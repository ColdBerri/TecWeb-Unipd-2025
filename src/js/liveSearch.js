document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.post-ricerca');
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('live-search-results');
    const categoryResultsContainer = document.getElementById('category-results');

    let debounceTimeout;
    let isStaticSearch = false;

    function debounce(func, delay) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(func, delay);
    }


    //aggiorna i risultati in live
    function performSearch(query) {
        if (categoryResultsContainer) {
            categoryResultsContainer.style.display = 'none';
        }

        fetch(`categorie.php?ajax_search=1&query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Errore di rete');
                }
                return response.text();
            })
            .then(html => {
                resultsContainer.innerHTML = html;
                resultsContainer.setAttribute('aria-label', 'Risultati della ricerca aggiornati');
            })
            .catch(error => {
                console.error('Errore durante la ricerca:', error);
                resultsContainer.innerHTML = '<p class="erroreRicerca">Si è verificato un errore durante la ricerca.</p>';
            });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            isStaticSearch = false; 

            if (query.length === 0) {
                resultsContainer.innerHTML = '';
                resultsContainer.setAttribute('aria-label', 'Risultati azzerati');
                if (categoryResultsContainer) {
                    categoryResultsContainer.style.display = 'block';
                }
                return;
            }

            debounce(() => {
                performSearch(query);
            }, 300);
        });
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const query = searchInput.value.trim();
            if (query.length > 0) {
                isStaticSearch = true;
                performSearch(query);
                searchInput.value = ''; 
                searchInput.blur(); 
            } else {
                isStaticSearch = false;
                resultsContainer.innerHTML = '';
                if (categoryResultsContainer) {
                    categoryResultsContainer.style.display = 'block';
                }
            }
        });
    }

    searchInput.addEventListener('input', function() {
        if (this.value.trim() === '') {
            isStaticSearch = false;
            resultsContainer.innerHTML = '';
            if (categoryResultsContainer) {
                categoryResultsContainer.style.display = 'block';
            }
        }
    });
});