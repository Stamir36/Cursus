// Installing service worker
const CACHE_NAME = 'Cursus';
const resourcesToCache = [
  "./cursus.png",
  "./style.css",
  "./landing.html",
  "./landing.css",
  "./dist/style.css",
  "./dist/script.js",
  "./dist/noChatImg.png",
  "./dist/stilus.png",
  "./dist/flowbite.min.css",
  "./dist/abstract-lines.svg",
  "./../assets/vendor/nucleo/css/nucleo.css"
];

self.addEventListener("install", e=>{
    e.waitUntil(
        caches.open(CACHE_NAME).then(cache =>{
            return cache.addAll(resourcesToCache);
        })
    );
});

// Cache and return requests
self.addEventListener("fetch", e=>{
    e.respondWith(
        caches.match(e.request).then(response=>{
            return response || fetch(e.request);
        })
    );
});

// Update a service worker
const cacheWhitelist = ['Cursus'];
self.addEventListener('activate', event => {
    event.waitUntil(
      caches.keys().then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName);
            }
          })
        );
      })
    );
  });
self.addEventListener('message', event => {
    // Обработка сообщений от клиента
    // Выполнение необходимых действий, например, отправка уведомлений
});

self.addEventListener('periodicsync', event => {
    // Обработка периодической синхронизации
    // Выполнение необходимых задач в фоновом режиме
});

self.addEventListener('sync', event => {
    // Обработка фоновой синхронизации
    // Выполнение необходимых задач в фоновом режиме
});



/* Add relative URL of all the static content you want to store in
const CACHE_NAME  = 'Cursus';
let resourcesToCache = ["./cursus.png", "./style.css", "./dist/style.css", "./dist/script.js", "./dist/noChatImg.png", "./dist/stilus.png", "./../assets/vendor/nucleo/css/nucleo.css"];

* cache storage (this will help us use our app offline)*/