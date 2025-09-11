document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.post-ricerca');
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('live-search-results');
    const categoryResultsContainer = document.getElementById('category-results');

    let debounceTimeout;

    //ripristinare la visualizzazione iniziale
    function resetToDefaultView() {
        resultsContainer.innerHTML = '';
        resultsContainer.setAttribute('aria-label', 'Risultati azzerati');
        if (categoryResultsContainer) {
            categoryResultsContainer.classList.remove('hide-category-results');
            categoryResultsContainer.classList.add('show-category-results');
        }
    }

    // ricerca e aggiorna risultati
    function performSearch(query) {
        if (categoryResultsContainer) {
            categoryResultsContainer.classList.remove('show-category-results');
            categoryResultsContainer.classList.add('hide-category-results');
        }

    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length === 0) {
                clearTimeout(debounceTimeout); 
                resetToDefaultView();
                return;
            }

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });
    }

    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault(); 
            const query = searchInput.value.trim();
            
            if (query.length > 0) {
                performSearch(query);
                
                searchInput.value = '';
                searchInput.blur();

            } else {
                resetToDefaultView();
            }
        });
    }
});