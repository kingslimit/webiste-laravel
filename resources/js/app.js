/**
 * ================================================================================
 * UnduhPustaka - JavaScript Application
 * ================================================================================
 * File: resources/js/app.js
 * 
 * DAFTAR FITUR:
 * 1. Live Search Autocomplete
 * 2. Keyboard Navigation
 * 3. Highlight Matched Text
 * 4. Click Outside to Close
 * 5. Debouncing
 * 6. Loading Indicator
 * 7. API Integration
 * 8. Auto-dismiss Alerts
 * ================================================================================
 */

import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    
    // Get DOM elements
    const searchInput = document.getElementById('searchInput');
    const autocompleteDropdown = document.getElementById('autocompleteDropdown');
    const searchLoading = document.getElementById('searchLoading');
    
    if (!searchInput || !autocompleteDropdown) return;
    
    let debounceTimer;
    let currentFocus = -1;
    
    
    // ============================================================================
    // FITUR 1: LIVE SEARCH AUTOCOMPLETE
    // ============================================================================
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // FITUR 5: Debouncing - Clear previous timer
        clearTimeout(debounceTimer);
        
        if (query.length < 2) {
            autocompleteDropdown.classList.remove('show');
            return;
        }
        
        // FITUR 6: Loading Indicator - Show spinner
        searchLoading?.classList.remove('hidden');
        
        // FITUR 5: Debouncing - Wait 300ms before search
        debounceTimer = setTimeout(() => {
            fetchAutocomplete(query);
        }, 300);
    });
    
    
    // ============================================================================
    // FITUR 2: KEYBOARD NAVIGATION
    // ============================================================================
    searchInput.addEventListener('keydown', function(e) {
        const items = autocompleteDropdown.querySelectorAll('.autocomplete-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus++;
            addActive(items);
        } 
        else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus--;
            addActive(items);
        } 
        else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            } else {
                document.getElementById('searchForm').submit();
            }
        } 
        else if (e.key === 'Escape') {
            autocompleteDropdown.classList.remove('show');
            currentFocus = -1;
        }
    });
    
    // Helper functions untuk keyboard navigation
    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        items[currentFocus].classList.add('bg-gray-100');
    }
    
    function removeActive(items) {
        items.forEach(item => item.classList.remove('bg-gray-100'));
    }
    
    
    // ============================================================================
    // FITUR 3: HIGHLIGHT MATCHED TEXT
    // ============================================================================
    function highlightText(text, query) {
        const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
        return text.replace(regex, '<mark class="bg-yellow-200 font-semibold">$1</mark>');
    }
    
    function escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }
    
    
    // ============================================================================
    // FITUR 4: CLICK OUTSIDE TO CLOSE
    // ============================================================================
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
            autocompleteDropdown.classList.remove('show');
        }
    });
    
    
    // ============================================================================
    // FITUR 5: DEBOUNCING
    // ============================================================================
    // Sudah diimplementasikan di FITUR 1 (line 44-49)
    // Menggunakan setTimeout dengan delay 300ms
    
    
    // ============================================================================
    // FITUR 6: LOADING INDICATOR
    // ============================================================================
    // Sudah diimplementasikan di FITUR 1 (line 47) dan FITUR 7 (line 112)
    // Show spinner saat fetch, hide setelah selesai
    
    
    // ============================================================================
    // FITUR 7: API INTEGRATION
    // ============================================================================
    async function fetchAutocomplete(query) {
        try {
            const apiUrl = `https://archive.org/advancedsearch.php?q=title:(${encodeURIComponent(query)})%20OR%20creator:(${encodeURIComponent(query)})&fl=identifier,title,creator&rows=10&output=json`;
            
            const response = await fetch(apiUrl);
            const data = await response.json();
            
            // FITUR 6: Hide loading indicator
            searchLoading?.classList.add('hidden');
            
            if (data.response && data.response.docs.length > 0) {
                displayAutocomplete(data.response.docs, query);
            } else {
                autocompleteDropdown.innerHTML = '<div class="p-4 text-center text-gray-500">Tidak ada hasil ditemukan</div>';
                autocompleteDropdown.classList.add('show');
            }
        } catch (error) {
            console.error('Autocomplete error:', error);
            searchLoading?.classList.add('hidden');
            autocompleteDropdown.classList.remove('show');
        }
    }
    
    // Display autocomplete results
    function displayAutocomplete(books, query) {
        let html = '';
        
        books.forEach(book => {
            const title = book.title || 'No Title';
            const author = Array.isArray(book.creator) ? book.creator[0] : (book.creator || 'Unknown');
            const identifier = book.identifier;
            
            // FITUR 3: Highlight matched text
            const highlightedTitle = highlightText(title, query);
            const highlightedAuthor = highlightText(author, query);
            
            html += `
                    <div class="autocomplete-item flex items-center gap-3" onclick="window.location='/buku/${identifier}'">
              <img src="/image/buku2.png" alt="buku" style="height: 22px; width: 22px;">
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold truncate">${highlightedTitle}</div>
                        <div class="text-sm text-gray-600 truncate">${highlightedAuthor}</div>
                    </div>
                </div>
            `;
        });
        
        autocompleteDropdown.innerHTML = html;
        autocompleteDropdown.classList.add('show');
        currentFocus = -1;
    }
});


// ================================================================================
// FITUR 8: AUTO-DISMISS ALERTS
// ================================================================================
setTimeout(() => {
    document.querySelectorAll('.alert-dismissible').forEach(alert => {
        alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);