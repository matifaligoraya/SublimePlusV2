/* Precast Al Turab — RFQ form (AJAX + multi-file) and small UI helpers */
(function () {
  'use strict';

  var MAX_FILES = 10;
  var ALLOWED = ['pdf', 'dwg', 'dxf', 'xls', 'xlsx', 'csv', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp', 'zip', 'rar', '7z'];

  function fmt(bytes) {
    if (bytes > 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
    if (bytes > 1024) return Math.round(bytes / 1024) + ' KB';
    return bytes + ' B';
  }

  function initForm(form) {
    var wrap   = form.closest('.pc-rfq');
    var msg    = form.querySelector('.pc-rfq__msg');
    var input  = form.querySelector('input[type="file"]');
    var list   = form.querySelector('.pc-rfq__filelist');
    var drop   = form.querySelector('.pc-rfq__drop');
    var files  = [];
    var maxBytes = parseInt(window.spRfq && window.spRfq.maxBytes || 31457280, 10);

    function render() {
      if (!list) return;
      list.innerHTML = '';
      files.forEach(function (f, i) {
        var ext = f.name.split('.').pop().toLowerCase();
        var bad = ALLOWED.indexOf(ext) === -1 || f.size > maxBytes;
        var li = document.createElement('li');
        li.className = bad ? 'is-bad' : '';
        li.innerHTML = '<span>' + f.name + (bad ? ' — not allowed / too large' : '') + '</span><span>' + fmt(f.size) + ' <a href="#" data-rm="' + i + '" aria-label="Remove">&times;</a></span>';
        list.appendChild(li);
      });
    }
    function addFiles(fl) {
      Array.prototype.slice.call(fl).forEach(function (f) {
        if (files.length >= MAX_FILES) return;
        if (!files.some(function (x) { return x.name === f.name && x.size === f.size; })) files.push(f);
      });
      render();
    }
    if (input) {
      input.addEventListener('change', function () { addFiles(input.files); input.value = ''; });
    }
    if (drop) {
      ['dragenter', 'dragover'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('is-over'); }); });
      ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('is-over'); }); });
      drop.addEventListener('drop', function (e) { if (e.dataTransfer && e.dataTransfer.files) addFiles(e.dataTransfer.files); });
    }
    if (list) {
      list.addEventListener('click', function (e) {
        var a = e.target.closest('[data-rm]'); if (!a) return;
        e.preventDefault(); files.splice(parseInt(a.getAttribute('data-rm'), 10), 1); render();
      });
    }

    function show(text, ok) {
      if (!msg) return;
      msg.textContent = text;
      msg.className = 'pc-rfq__msg ' + (ok ? 'is-ok' : 'is-err');
      msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      // Native validation first
      var invalid = form.querySelector(':invalid');
      if (invalid) { invalid.focus(); show('Please complete the required fields marked *.', false); return; }
      var pi = form.querySelectorAll('input[name="products[]"]');
      if (pi.length && !form.querySelector('input[name="products[]"]:checked')) { pi[0].focus(); show('Please select at least one product under Product Interest.', false); return; }
      var bad = files.some(function (f) { return ALLOWED.indexOf(f.name.split('.').pop().toLowerCase()) === -1 || f.size > maxBytes; });
      if (bad) { show('One or more files are not allowed or exceed the size limit. Remove them and try again.', false); return; }

      var fd = new FormData(form);
      fd.delete('files[]');
      files.forEach(function (f) { fd.append('files[]', f, f.name); });

      wrap && wrap.classList.add('is-sending');
      if (msg) { msg.className = 'pc-rfq__msg'; msg.textContent = ''; }

      var xhr = new XMLHttpRequest();
      xhr.open('POST', (window.spRfq && window.spRfq.ajax) || '/wp-admin/admin-ajax.php');
      xhr.onload = function () {
        wrap && wrap.classList.remove('is-sending');
        var res = null;
        try { res = JSON.parse(xhr.responseText); } catch (err) {}
        if (res && res.success) {
          show(res.data.message, true);
          form.reset(); files = []; render();
          if (typeof window.spTrack === 'function') window.spTrack('rfq_submit', { files: files.length });
          if (typeof gtag === 'function') gtag('event', 'generate_lead', { method: 'rfq_form' });
        } else {
          show((res && res.data && res.data.message) || 'Your request could not be sent. Please try again or WhatsApp our team.', false);
        }
      };
      xhr.onerror = function () { wrap && wrap.classList.remove('is-sending'); show('Network error. Please try again or WhatsApp our team.', false); };
      xhr.send(fd);
    });
  }

  // ── Language switch: English ⇄ Arabic (Google Translate, loaded only when Arabic is chosen) ──
  function getLang() { return /(^|;\s*)googtrans=\/en\/ar/.test(document.cookie) ? 'ar' : 'en'; }
  function setLang(lang) {
    var host = location.hostname, exp = lang === 'ar' ? '' : '; expires=Thu, 01 Jan 1970 00:00:00 GMT';
    var val = lang === 'ar' ? '/en/ar' : '';
    // Google reads the cookie on both the bare host and the dotted domain.
    document.cookie = 'googtrans=' + val + '; path=/' + exp;
    document.cookie = 'googtrans=' + val + '; path=/; domain=.' + host + exp;
    location.reload();
  }
  function initLang() {
    var lang = getLang();
    document.querySelectorAll('.pc-lang [data-lang]').forEach(function (a) {
      a.classList.toggle('is-active', a.getAttribute('data-lang') === lang);
      a.addEventListener('click', function (e) { e.preventDefault(); if (a.getAttribute('data-lang') !== getLang()) setLang(a.getAttribute('data-lang')); });
    });
    if (lang !== 'ar') return;
    document.documentElement.setAttribute('dir', 'rtl');
    document.documentElement.setAttribute('lang', 'ar');
    document.documentElement.classList.add('pc-rtl');
    var holder = document.createElement('div'); holder.id = 'pc-gt'; holder.style.display = 'none'; document.body.appendChild(holder);
    window.pcGtInit = function () { new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'ar', autoDisplay: false }, 'pc-gt'); };
    var s = document.createElement('script'); s.src = 'https://translate.google.com/translate_a/element.js?cb=pcGtInit'; s.async = true; document.body.appendChild(s);
  }

  document.addEventListener('DOMContentLoaded', function () {
    initLang();
    document.querySelectorAll('form[data-rfq]').forEach(initForm);

    // Scroll to the form when linked with #rfq-files / #rfq-form
    if (location.hash === '#rfq-files' || location.hash === '#rfq-form') {
      var el = document.querySelector(location.hash);
      if (el) setTimeout(function () { el.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 200);
    }

    // Shadow on sticky header after scroll
    var hdr = document.querySelector('.pc-hdr');
    if (hdr) {
      var onScroll = function () { hdr.classList.toggle('is-scrolled', window.scrollY > 10); };
      window.addEventListener('scroll', onScroll, { passive: true }); onScroll();
    }
  });
})();
