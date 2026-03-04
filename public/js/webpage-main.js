/**
 * main.js – Bhramani Khandavi House
 * Handles: AOS init, navbar scroll, back-to-top,
 *          active nav link, contact form validation & submission
 */
(function () {
  'use strict';

  /* ── Helpers ──────────────────────────────────────────────── */
  function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
  function qsa(sel, ctx) { return Array.from((ctx || document).querySelectorAll(sel)); }

  /** Sanitize a string – strip HTML tags to prevent XSS */
  function sanitize(str) {
    var d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
  }

  /* ── AOS (Animate on Scroll) ──────────────────────────────── */
  function initAOS() {
    if (typeof AOS === 'undefined') return;
    AOS.init({
      duration: 700,
      easing: 'ease-out-cubic',
      once: true,
      offset: 60,
      disable: function () {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      }
    });
  }

  /* ── Navbar: scroll shadow + active link ─────────────────── */
  function initNavbar() {
    var nav = qs('#mainNav');
    var links = qsa('.nav-link[href^="#"]');
    var sections = [];

    links.forEach(function (link) {
      var id = link.getAttribute('href').replace('#', '');
      var sec = qs('#' + id);
      if (sec) sections.push({ el: sec, link: link });
    });

    function onScroll() {
      var scrollY = window.scrollY;

      // Shadow on scroll
      if (nav) nav.classList.toggle('scrolled', scrollY > 20);

      // Active nav link based on section in viewport
      var current = '';
      sections.forEach(function (item) {
        var top = item.el.offsetTop - (nav ? nav.offsetHeight : 72) - 10;
        if (scrollY >= top) current = item.el.id;
      });

      links.forEach(function (link) {
        var href = link.getAttribute('href').replace('#', '');
        link.classList.toggle('active', href === current);
      });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load
  }

  /* ── Back to Top button ───────────────────────────────────── */
  function initBackToTop() {
    var btn = qs('#backToTop');
    if (!btn) return;

    window.addEventListener('scroll', function () {
      btn.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });

    btn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ── Smooth close mobile nav on link click ────────────────── */
  function initMobileNav() {
    var bsCollapse = qs('#navMenu');
    if (!bsCollapse) return;

    qsa('.nav-link', bsCollapse).forEach(function (link) {
      link.addEventListener('click', function () {
        var collapse = bootstrap.Collapse.getInstance(bsCollapse);
        if (collapse) collapse.hide();
      });
    });
  }

  /* ── Footer year ──────────────────────────────────────────── */
  function initYear() {
    var el = qs('#currentYear');
    if (el) el.textContent = new Date().getFullYear();
  }

  /* ── Lazy load images (native + IntersectionObserver fallback) */
  function initLazyImages() {
    // Native lazy loading is already set via loading="lazy" attributes.
    // For browsers that don't support it, use IntersectionObserver.
    if ('loading' in HTMLImageElement.prototype) return;
    if (!('IntersectionObserver' in window)) return;

    var imgs = qsa('img[loading="lazy"]');
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var img = entry.target;
        if (img.dataset.src) img.src = img.dataset.src;
        observer.unobserve(img);
      });
    }, { rootMargin: '200px' });

    imgs.forEach(function (img) { observer.observe(img); });
  }

  /* ── Contact Form ─────────────────────────────────────────── */
  function initContactForm() {
    var form    = qs('#contactForm');
    var msgBox  = qs('#formMsg');
    var submitBtn = qs('#submitBtn');
    if (!form) return;

    /** Show accessible feedback message */
    function showMsg(text, type) {
      if (!msgBox) return;
      msgBox.textContent = text;
      msgBox.className = 'form-message ' + type;
      msgBox.classList.remove('d-none');
      msgBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      setTimeout(function () { msgBox.classList.add('d-none'); }, 6000);
    }

    /** Validate a single field, return boolean */
    function validateField(field) {
      field.classList.remove('is-invalid', 'is-valid');
      var valid = field.checkValidity();
      // Extra: phone pattern check
      if (field.name === 'phone' && field.value) {
        valid = /^[0-9]{10}$/.test(field.value);
      }
      // Extra: email lenient check
      if (field.name === 'email' && field.value) {
        valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value);
      }
      field.classList.add(valid ? 'is-valid' : 'is-invalid');
      return valid;
    }

    // Live validation on blur
    qsa('[required], [type="email"]', form).forEach(function (field) {
      field.addEventListener('blur', function () { validateField(field); });
      field.addEventListener('input', function () {
        if (field.classList.contains('is-invalid')) validateField(field);
      });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      // Honeypot check
      var hp = form.querySelector('[name="website"]');
      if (hp && hp.value.length > 0) {
        // Silently ignore – bot submission
        showMsg('Thank you! We will get back to you.', 'success');
        return;
      }

      // Validate all required fields
      var requiredFields = qsa('[required]', form);
      var allValid = true;
      requiredFields.forEach(function (field) {
        if (!validateField(field)) allValid = false;
      });
      // Validate optional email if filled
      var emailField = qs('#contactEmail');
      if (emailField && emailField.value && !validateField(emailField)) allValid = false;

      if (!allValid) {
        showMsg('Please fill in all required fields correctly.', 'error');
        var firstInvalid = qs('.is-invalid', form);
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      // Collect & sanitize data
      var data = {
        name:    sanitize(qs('#contactName').value.trim()),
        phone:   sanitize(qs('#contactPhone').value.trim()),
        email:   sanitize(emailField ? emailField.value.trim() : ''),
        subject: sanitize(qs('#contactSubject').value),
        message: sanitize(qs('#contactMessage').value.trim())
      };

      // Show loading state
      if (submitBtn) {
        qs('.btn-text', submitBtn).classList.add('d-none');
        qs('.btn-loading', submitBtn).classList.remove('d-none');
        submitBtn.disabled = true;
      }

      // Build WhatsApp message as the "submission" (since no backend here)
      var waText = encodeURIComponent(
        'New Inquiry from Website\n\n' +
        'Name: ' + data.name + '\n' +
        'Phone: ' + data.phone + '\n' +
        (data.email ? 'Email: ' + data.email + '\n' : '') +
        (data.subject ? 'Order Type: ' + data.subject + '\n' : '') +
        'Message: ' + data.message
      );

      // Simulate async send (open WhatsApp)
      setTimeout(function () {
        window.open('https://wa.me/91XXXXXXXXXX?text=' + waText, '_blank', 'noopener,noreferrer');

        // Reset form
        form.reset();
        qsa('.is-valid, .is-invalid', form).forEach(function (f) {
          f.classList.remove('is-valid', 'is-invalid');
        });

        // Reset button
        if (submitBtn) {
          qs('.btn-text', submitBtn).classList.remove('d-none');
          qs('.btn-loading', submitBtn).classList.add('d-none');
          submitBtn.disabled = false;
        }

        showMsg('Message sent! We will contact you on WhatsApp shortly.', 'success');
      }, 800);
    });
  }

  /* ── Counter animation for hero stats ────────────────────── */
  function initCounters() {
    var counters = qsa('.stat-number');
    if (!counters.length || !('IntersectionObserver' in window)) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var target = parseInt(el.textContent, 10);
        if (isNaN(target)) return;
        var suffix = el.textContent.replace(/[0-9]/g, '');
        var start = 0;
        var duration = 1500;
        var step = Math.ceil(duration / target);
        var timer = setInterval(function () {
          start += Math.ceil(target / (duration / 16));
          if (start >= target) {
            start = target;
            clearInterval(timer);
          }
          el.textContent = start + suffix;
        }, 16);
        observer.unobserve(el);
      });
    }, { threshold: 0.5 });

    counters.forEach(function (el) { observer.observe(el); });
  }

  /* ── Product card hover ripple ────────────────────────────── */
  function initProductRipple() {
    qsa('.product-card').forEach(function (card) {
      card.addEventListener('mouseenter', function () {
        card.style.willChange = 'transform';
      });
      card.addEventListener('mouseleave', function () {
        card.style.willChange = '';
      });
    });
  }

  /* ── Navbar collapse close on outside click (mobile) ──────── */
  function initOutsideClick() {
    document.addEventListener('click', function (e) {
      var nav = qs('#mainNav');
      var menu = qs('#navMenu');
      if (!nav || !menu) return;
      if (!nav.contains(e.target) && menu.classList.contains('show')) {
        var collapse = bootstrap.Collapse.getInstance(menu);
        if (collapse) collapse.hide();
      }
    });
  }

  /* ── Init all ─────────────────────────────────────────────── */
  function init() {
    initAOS();
    initNavbar();
    initBackToTop();
    initMobileNav();
    initYear();
    initLazyImages();
    initContactForm();
    initCounters();
    initProductRipple();
    initOutsideClick();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
