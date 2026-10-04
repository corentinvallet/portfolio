/* Thème clair/sombre (même clé localStorage que index.php) */
(function () {
  var html = document.documentElement;
  var btn  = document.getElementById('themeToggle');
  try {
    var saved = localStorage.getItem('theme');
    if (saved) html.dataset.theme = saved;
  } catch (e) {}
  if (btn) {
    btn.addEventListener('click', function () {
      html.dataset.theme = html.dataset.theme === 'dark' ? 'light' : 'dark';
      try { localStorage.setItem('theme', html.dataset.theme); } catch (e) {}
    });
  }
})();