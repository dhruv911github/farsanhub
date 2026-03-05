/**
 * translations.js
 * Bilingual (English / Gujarati) language switcher
 * Uses data-en / data-gu attributes on DOM elements
 */
(function () {
  'use strict';

  const STORAGE_KEY = 'bkh_lang';
  const DEFAULT_LANG = 'en';

  /** Apply language to every translatable element */
  function applyLang(lang) {
    const isGu = lang === 'gu';

    // Update all elements with data-en / data-gu
    document.querySelectorAll('[data-en], [data-gu]').forEach(function (el) {
      const val = isGu ? el.dataset.gu : el.dataset.en;
      if (val === undefined) return;

      // For inputs / selects update placeholder; for options use textContent
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
        el.placeholder = val;
      } else if (el.tagName === 'OPTION') {
        el.textContent = val;
      } else {
        // Check if element has child ELEMENT nodes (e.g. <i> icons, <span>s)
        // If so, only update direct TEXT nodes to preserve the child elements
        var hasChildElements = false;
        for (var ci = 0; ci < el.childNodes.length; ci++) {
          if (el.childNodes[ci].nodeType === 1) { hasChildElements = true; break; }
        }
        if (hasChildElements) {
          // Update the first non-whitespace text node only
          for (var ti = 0; ti < el.childNodes.length; ti++) {
            var node = el.childNodes[ti];
            if (node.nodeType === 3 && node.textContent.trim() !== '') {
              node.textContent = val;
              break;
            }
          }
        } else {
          // No child elements — safe to replace innerHTML (handles &amp; entities)
          el.innerHTML = val;
        }
      }
    });

    // Toggle body class for font switching
    document.body.classList.toggle('lang-gu', isGu);

    // Update html lang attribute
    document.documentElement.lang = isGu ? 'gu' : 'en';

    // Update toggle button label
    const label = document.getElementById('langLabel');
    if (label) label.textContent = isGu ? 'English' : 'ગુજરાતી';

    // Persist choice
    try { localStorage.setItem(STORAGE_KEY, lang); } catch (_) {}

    // Dispatch custom event for other scripts
    document.dispatchEvent(new CustomEvent('langChanged', { detail: { lang: lang } }));
  }

  /** Read persisted or browser preference */
  function detectLang() {
    try {
      const stored = localStorage.getItem(STORAGE_KEY);
      if (stored === 'en' || stored === 'gu') return stored;
    } catch (_) {}
    // Browser preference: prefer Gujarati if navigator language starts with 'gu'
    if (navigator.language && navigator.language.toLowerCase().startsWith('gu')) return 'gu';
    return DEFAULT_LANG;
  }

  function init() {
    const toggleBtn = document.getElementById('langToggle');
    let currentLang = detectLang();

    // Apply on load
    applyLang(currentLang);

    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', function () {
      currentLang = currentLang === 'en' ? 'gu' : 'en';
      applyLang(currentLang);

      // Brief visual feedback
      toggleBtn.style.transform = 'scale(.9)';
      setTimeout(function () { toggleBtn.style.transform = ''; }, 150);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
