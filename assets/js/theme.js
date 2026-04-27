(function () {
  'use strict';

  /* ── TOC: auto-generate from h2/h3 in #post-content ── */
  function buildToc() {
    var content = document.getElementById('post-content');
    var nav     = document.getElementById('toc-nav');
    if (!content || !nav) return;

    var headings = content.querySelectorAll('h2');
    if (headings.length < 2) {
      var wrap = nav.closest('.toc-sticky');
      if (wrap) wrap.style.display = 'none';
      return;
    }

    var frag = document.createDocumentFragment();
    headings.forEach(function (h, i) {
      if (!h.id) h.id = 'toc-' + i;
      var a       = document.createElement('a');
      a.href      = '#' + h.id;
      a.textContent = h.textContent;
      a.addEventListener('click', function (e) {
        e.preventDefault();
        h.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.replaceState(null, '', '#' + h.id);
      });
      frag.appendChild(a);
    });
    nav.appendChild(frag);
  }

  /* ── TOC: highlight active heading via IntersectionObserver ── */
  function initTocObserver() {
    var links = document.querySelectorAll('#toc-nav a');
    if (!links.length || !window.IntersectionObserver) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        links.forEach(function (l) { l.classList.remove('toc-active'); });
        var active = document.querySelector('#toc-nav a[href="#' + entry.target.id + '"]');
        if (active) active.classList.add('toc-active');
      });
    }, { rootMargin: '-80px 0px -60% 0px', threshold: 0 });

    document.querySelectorAll('#post-content h2').forEach(function (h) {
      observer.observe(h);
    });
  }

  /* ── Share: copy link to clipboard ── */
  function initShareCopy() {
    document.querySelectorAll('.share-copy').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var url   = btn.dataset.url || location.href;
        var label = btn.querySelector('.btn-label');
        var orig  = label ? label.textContent : '';

        function onCopied() {
          if (label) label.textContent = '✓ 복사됨';
          setTimeout(function () { if (label) label.textContent = orig; }, 2000);
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(url).then(onCopied).catch(fallbackCopy);
        } else {
          fallbackCopy();
        }

        function fallbackCopy() {
          var ta        = document.createElement('textarea');
          ta.value      = url;
          ta.style.cssText = 'position:fixed;opacity:0;pointer-events:none';
          document.body.appendChild(ta);
          ta.focus();
          ta.select();
          try { document.execCommand('copy'); onCopied(); } catch (_) {}
          document.body.removeChild(ta);
        }
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    buildToc();
    initTocObserver();
    initShareCopy();
  });
})();
