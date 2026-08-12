/**
 * Widget signature — Corentin Vallet
 * Usage : <script src="https://corentinvallet.fr/widget/signature.js" data-theme="light"></script>
 * Thèmes disponibles : "light" (défaut) ou "dark"
 * Le script s'injecte automatiquement en fin de <body>, dans un bloc <div id="cv-signature">.
 */
(function () {
  var currentScript = document.currentScript;
  var theme = (currentScript && currentScript.getAttribute('data-theme')) || 'light';

  var colors = {
    light: {
      bg: 'transparent',
      text: '#6b6b6b',
      accent: '#c17a4d', // terracotta, ajustable par site
      border: 'rgba(0,0,0,0.08)'
    },
    dark: {
      bg: 'transparent',
      text: '#c9c9c9',
      accent: '#d99b6c',
      border: 'rgba(255,255,255,0.12)'
    }
  };

  var c = colors[theme] || colors.light;

  var style = document.createElement('style');
  style.textContent = `
    .cv-signature {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 18px 12px;
      margin-top: 20px;
      border-top: 1px solid ${c.border};
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
      font-size: 13px;
      color: ${c.text};
      text-align: center;
      flex-wrap: wrap;
    }
    .cv-signature a {
      color: ${c.accent};
      text-decoration: none;
      font-weight: 600;
      border-bottom: 1px solid transparent;
      transition: border-color 0.2s ease;
    }
    .cv-signature a:hover,
    .cv-signature a:focus {
      border-bottom: 1px solid ${c.accent};
    }
    .cv-signature .cv-logo {
      width: 18px;
      height: 18px;
      flex-shrink: 0;
    }
    .cv-signature .cv-tagline {
      opacity: 0.75;
    }
    @media (max-width: 480px) {
      .cv-signature {
        flex-direction: column;
        gap: 4px;
      }
    }
  `;
  document.head.appendChild(style);

  var wrapper = document.createElement('div');
  wrapper.className = 'cv-signature';
  wrapper.innerHTML = `
    <img class="cv-logo" src="https://corentinvallet.fr/widget/cv-logo-orange.png" alt="Corentin Vallet" width="18" height="18" />
    <span>
      Site réalisé par <a href="https://corentinvallet.fr?utm_source=signature-widget" target="_blank" rel="noopener">Corentin Vallet</a>
      <span class="cv-tagline">— Création de sites pour artisans &amp; indépendants</span>
    </span>
  `;

  function inject() {
    var target = document.getElementById('cv-signature') || document.body;
    target.appendChild(wrapper);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inject);
  } else {
    inject();
  }
})();
