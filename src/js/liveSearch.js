document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.post-ricerca');
    const searchInput = document.getElementById('live-search-input');
    const resultsContainer = document.getElementById('live-search-results');
    const categoryResultsContainer = document.getElementById('category-results');

    let debounceTimeout;

    function resetToDefaultView() {
        resultsContainer.innerHTML = '';
        if (categoryResultsContainer) {
            categoryResultsContainer.classList.remove('hide-category-results');
            categoryResultsContainer.classList.add('show-category-results');
        }
    }

    function performSearch(query) {
        if (categoryResultsContainer) {
            categoryResultsContainer.classList.remove('show-category-results');
            categoryResultsContainer.classList.add('hide-category-results');
        }

        const encodedQuery = encodeURIComponent(query);
        const url = `categorie.php?ajax_search=1&query=${encodedQuery}`;

        fetch(url)
            .then(response => {
                return response.text();
            })
            .then(html => {
                resultsContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Errore durante la ricerca:', error);
            });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(debounceTimeout);
            
            if (query.length === 0) {
                resetToDefaultView();
                return;
            }

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