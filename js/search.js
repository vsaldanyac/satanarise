/**
 * Global band search — SatanArise.com
 */
(function () {
    'use strict';

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }

    function initSearch() {
        var input        = document.getElementById('search-input');
        var overlay      = document.getElementById('search-overlay');
        var resultsDiv   = document.getElementById('search-results');
        var closeBtn     = document.getElementById('search-close');
        var clearBtn     = document.getElementById('search-clear');
        var mobileToggle = document.getElementById('searchMobileToggle');
        var searchBar    = document.getElementById('search-bar');

        if (!input || !overlay || !searchBar) return;

        var timer;

        /* ---- input handler with debounce ---- */
        input.addEventListener('input', function () {
            clearTimeout(timer);
            var q = input.value.trim();
            searchBar.classList.toggle('has-text', input.value.length > 0);
            if (q.length < 3) { closeOverlay(); return; }
            timer = setTimeout(function () { doSearch(q); }, 350);
        });

        /* ---- overlay close button ---- */
        if (closeBtn) {
            closeBtn.addEventListener('click', closeOverlay);
        }

        /* ---- clear button: wipes input and closes overlay ---- */
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                input.value = '';
                searchBar.classList.remove('has-text');
                closeOverlay();
                input.focus();
            });
        }

        /* ---- click outside closes overlay ---- */
        document.addEventListener('click', function (e) {
            if (overlay.style.display !== 'block') return;
            if (!overlay.contains(e.target) && !searchBar.contains(e.target)) {
                closeOverlay();
            }
        });

        /* ---- mobile search toggle ---- */
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                if (searchBar.classList.contains('search-open')) {
                    searchBar.classList.remove('search-open');
                    mobileToggle.classList.remove('active');
                    closeOverlay();
                } else {
                    searchBar.classList.add('search-open');
                    mobileToggle.classList.add('active');
                    setTimeout(function () { input.focus(); }, 50);
                }
            });
        }

        /* ---- reposition overlay on resize ---- */
        window.addEventListener('resize', function () {
            if (overlay.style.display === 'block') positionOverlay();
        });

        /* ---- core functions ---- */

        function doSearch(q) {
            var ln = getLang();
            fetch('search_ajax.php?q=' + encodeURIComponent(q) + '&ln=' + ln)
                .then(function (r) { return r.json(); })
                .then(function (data) { renderResults(data.results, q); })
                .catch(function () { /* silent — network error */ });
        }

        function getLang() {
            var m = window.location.search.match(/[?&]ln=([^&]+)/);
            return (m && m[1] === 'CAT') ? 'CAT' : 'ES';
        }

        function renderResults(results, q) {
            var cat = getLang() === 'CAT';
            var sections = {
                noticias:    cat ? 'Notícies'   : 'Noticias',
                conciertos:  cat ? 'Concerts'   : 'Conciertos',
                criticas:    cat ? 'Crítiques'  : 'Críticas',
                cronicas:    cat ? 'Cròniques'  : 'Crónicas',
                entrevistas: cat ? 'Entrevistes' : 'Entrevistas'
            };
            var html  = '';
            var total = 0;

            Object.keys(sections).forEach(function (key) {
                var items = results[key];
                if (!items || items.length === 0) return;
                total += items.length;
                html += '<div class="search-section"><h3>' + sections[key] + '</h3><ul>';
                items.forEach(function (item) {
                    html += '<li><a href="' + esc(item.url) + '">' + esc(item.title) + '</a></li>';
                });
                html += '</ul></div>';
            });

            if (total === 0) {
                html = '<p class="search-noresults">No se encontraron resultados para &ldquo;<strong>'
                     + esc(q) + '</strong>&rdquo;</p>';
            }

            resultsDiv.innerHTML = html;
            positionOverlay();
            overlay.style.display = 'block';
        }

        function positionOverlay() {
            var rect = searchBar.getBoundingClientRect();
            overlay.style.top   = rect.bottom + 'px';
            overlay.style.left  = rect.left   + 'px';
            overlay.style.width = rect.width  + 'px';
        }

        function closeOverlay() {
            overlay.style.display = 'none';
            resultsDiv.innerHTML  = '';
        }

        function esc(s) {
            return String(s)
                .replace(/&/g,  '&amp;')
                .replace(/</g,  '&lt;')
                .replace(/>/g,  '&gt;')
                .replace(/"/g,  '&quot;');
        }
    }
})();
