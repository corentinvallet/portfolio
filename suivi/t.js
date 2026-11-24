(function () {
  var s = document.currentScript;
  var key = s && s.getAttribute('data-site');
  if (!key || location.hostname === 'localhost') return;
  try {
    // Respect de « Ne pas me suivre » et du refus individuel
    if (navigator.doNotTrack === '1' || window.doNotTrack === '1' || navigator.globalPrivacyControl) return;
    if (localStorage.getItem('suivi-optout')) return;
  } catch (e) {}

  var endpoint = 'https://suivi.corentinvallet.fr/collect.php';
  var body = JSON.stringify({ k: key, p: location.pathname, r: document.referrer });
  if (navigator.sendBeacon) {
    navigator.sendBeacon(endpoint, body);
  } else {
    fetch(endpoint, { method: 'POST', body: body, keepalive: true, mode: 'no-cors' });
  }
})();