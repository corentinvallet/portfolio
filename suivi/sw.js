// Service worker minimal : rend l'application installable.
// Aucune donnée n'est mise en cache, les chiffres restent toujours à jour.
self.addEventListener('install', () => self.skipWaiting());
self.addEventListener('activate', e => e.waitUntil(self.clients.claim()));
self.addEventListener('fetch', () => {});