/**
 * Custom JavaScript for Open Library
 * Live Search Autocomplete with Internet Archive API
 */

document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput = document.getElementById('searchInput');
    const autocompleteDropdown = document.getElementById('autocompleteDropdown');
    const searchLoading = document.getElementById('searchLoading');
    const searchForm = document.getElementById('searchForm');
    
    let debounceTimer;
    let currentFocus = -1;
    let searchResults = [];
    
    if (searchInput && autocompleteDropdown) {
        
        // Input event dengan debouncing
        searchInput.addEventListener('input', function(e) {
            const query = this.value.trim();
            
            // Clear previous timer
            clearTimeout(debounceTimer);
            
            // Hide dropdown jika query kosong
            if (query.length < 2) {
                hideAutocomplete();
                return;
            }
            
            // Show loading
            showLoading();
            
            // Debounce 300ms
            debounceTimer = setTimeout(() => {
                fetchSuggestions(query);
            }, 300);
        });
        
        // Keyboard navigation (Arrow Up/Down, Enter, Escape)
        searchInput.addEventListener('keydown', function(e) {
            const items = autocompleteDropdown.querySelectorAll('.autocomplete-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentFocus++;
                addActive(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentFocus--;
                addActive(items);
            } else if (e.key === 'Enter') {
                if (currentFocus > -1 && items[currentFocus]) {
                    e.preventDefault();
                    items[currentFocus].click();
                }
            } else if (e.key === 'Escape') {
                hideAutocomplete();
            }
        });
        
        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-wrapper')) {
                hideAutocomplete();
            }
        });
    }
    
    // Fetch suggestions dari Internet Archive API
    async function fetchSuggestions(query) {
        try {
            const apiUrl = `https://archive.org/advancedsearch.php?q=(title:(${encodeURIComponent(query)}) OR creator:(${encodeURIComponent(query)})) AND mediatype:texts&fl=identifier,title,creator,year&rows=8&output=json`;
            
            const response = await fetch(apiUrl);
            const data = await response.json();
            
            hideLoading();
            
            if (data.response && data.response.docs) {
                searchResults = data.response.docs;
                displaySuggestions(searchResults, query);
            } else {
                displayNoResults();
            }
            
        } catch (error) {
            console.error('Autocomplete fetch error:', error);
            hideLoading();
            displayNoResults();
        }
    }
    
    // Display suggestions
    function displaySuggestions(books, query) {
        if (books.length === 0) {
            displayNoResults();
            return;
        }
        
        autocompleteDropdown.innerHTML = '';
        currentFocus = -1;
        
        books.forEach((book, index) => {
            const item = document.createElement('div');
            item.className = 'autocomplete-item';
            item.setAttribute('data-index', index);
            
            const title = book.title || 'Tidak ada judul';
            const creator = Array.isArray(book.creator) 
                ? book.creator.join(', ') 
                : (book.creator || 'Unknown');
            const year = book.year || '';
            
            // Highlight matched text
            const highlightedTitle = highlightMatch(title, query);
            const highlightedCreator = highlightMatch(creator, query);
            
            item.innerHTML = `
                <span class="book-icon">📚</span>
                <div class="book-details">
                    <div class="book-title-auto">${highlightedTitle}</div>
                    <div class="book-author-auto">${highlightedCreator}${year ? ` <span class="book-year">(${year})</span>` : ''}</div>
                </div>
            `;
            
            // Click event
            item.addEventListener('click', function() {
                searchInput.value = title;
                hideAutocomplete();
                searchForm.submit();
            });
            
            autocompleteDropdown.appendChild(item);
        });
        
        showAutocomplete();
    }
    
    // Display no results
    function displayNoResults() {
        autocompleteDropdown.innerHTML = `
            <div class="autocomplete-no-results">
                🔭 Tidak ada hasil ditemukan
            </div>
        `;
        showAutocomplete();
    }
    
    // Highlight matched text
    function highlightMatch(text, query) {
        if (!query) return text;
        
        const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
    }
    
    // Escape regex special characters
    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
    
    // Add active class for keyboard navigation
    function addActive(items) {
        if (!items || items.length === 0) return;
        
        removeActive(items);
        
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        
        items[currentFocus].classList.add('active');
        items[currentFocus].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
    
    // Remove active class
    function removeActive(items) {
        items.forEach(item => item.classList.remove('active'));
    }
    
    // Show/Hide functions
    function showAutocomplete() {
        autocompleteDropdown.classList.add('show');
    }
    
    function hideAutocomplete() {
        autocompleteDropdown.classList.remove('show');
        currentFocus = -1;
    }
    
    function showLoading() {
        if (searchLoading) {
            searchLoading.classList.add('show');
        }
    }
    
    function hideLoading() {
        if (searchLoading) {
            searchLoading.classList.remove('show');
        }
    }
    
    
    // ========================================
    // OTHER FEATURES
    // ========================================
    
    // Smooth scroll to top when clicking back button
    const backButtons = document.querySelectorAll('a[href*="back"]');
    backButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });

    // Add loading indicator for form submissions
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            if (button) {
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...';
                button.disabled = true;
            }
        });
    }

    // Image lazy loading fallback
    const bookImages = document.querySelectorAll('.book-cover img, .detail-cover img');
    bookImages.forEach(img => {
        img.addEventListener('error', function() {
            console.log('Image failed to load:', this.src);
        });
    });

    // Add tooltip to truncated titles
    const bookTitles = document.querySelectorAll('.book-title');
    bookTitles.forEach(title => {
        if (title.scrollHeight > title.clientHeight) {
            title.title = title.textContent;
        }
    });

    // Keyboard navigation for book cards
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                this.click();
            }
        });
    });

    // Add animation class when elements come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe book cards for fade-in animation
    if (bookCards.length > 0) {
        bookCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    }

    // Local storage for recent searches
    if (searchForm && searchInput) {
        // Save search to history
        searchForm.addEventListener('submit', function() {
            const query = searchInput.value.trim();
            if (query) {
                let searches = JSON.parse(localStorage.getItem('recentSearches') || '[]');
                searches = searches.filter(s => s !== query);
                searches.unshift(query);
                searches = searches.slice(0, 5);
                localStorage.setItem('recentSearches', JSON.stringify(searches));
            }
        });
    }

    console.log('📚 Open Library with Live Search Autocomplete initialized!');
});