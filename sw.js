/**
 * CB Mishra Portfolio - Service Worker (PWA)
 * Caches assets for offline support
 */

const CACHE_NAME = 'cbmishra-v1.0.0';
const STATIC_ASSETS = [
  '/',
  '/wp-content/themes/cbmishra-theme/assets/css/main.css',
  '/wp-content/themes/cbmishra-theme/assets/js/main.js',
  'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,600;0,9..40,700&family=Manrope:wght@700;800&display=swap',
];

// Install: Cache static assets
self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      return cache.addAll(STATIC_ASSETS.filter(Boolean));
    }).catch(function (err) {
      console.warn('[SW] Cache install error:', err);
    })
  );
  self.skipWaiting();
});

// Activate: Clean old caches
self.addEventListener('activate', function (event) {
  event.waitUntil(
    caches.keys().then(function (keys) {
      return Promise.all(
        keys.filter(function (key) { return key !== CACHE_NAME; })
            .map(function (key) { return caches.delete(key); })
      );
    })
  );
  self.clients.claim();
});

// Fetch: Network first, fallback to cache
self.addEventListener('fetch', function (event) {
  // Skip non-GET and admin/API requests
  if (event.request.method !== 'GET') return;
  if (event.request.url.includes('/wp-admin/')) return;
  if (event.request.url.includes('/wp-json/')) return;
  if (event.request.url.includes('admin-ajax.php')) return;

  event.respondWith(
    fetch(event.request).then(function (response) {
      // Cache successful responses for static assets
      if (response && response.status === 200) {
        var url = event.request.url;
        if (url.match(/\.(css|js|woff2?|png|jpg|jpeg|svg|ico)$/)) {
          var clone = response.clone();
          caches.open(CACHE_NAME).then(function (cache) {
            cache.put(event.request, clone);
          });
        }
      }
      return response;
    }).catch(function () {
      // Fallback to cache on network failure
      return caches.match(event.request).then(function (cached) {
        if (cached) return cached;
        // Return offline page for navigation requests
        if (event.request.mode === 'navigate') {
          return caches.match('/');
        }
        return new Response('Offline', { status: 503, statusText: 'Service Unavailable' });
      });
    })
  );
});
