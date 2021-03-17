const staticCacheName = 'site-static-v1';
//const dynamicCacheName = 'site-dynamic-v1';

const assets = [
    './login.php',
    './index2.php',
    './pages/userPage.php',
    './pages/AboutUs.html',
    './pages/fallback.html',
    './images/icons/bus.png',
    
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
    'https://web-class.auca.kg/~kushtar/BBus/css/style.css',
    'https://web-class.auca.kg/~kushtar/BBus/images/in_bus.jpg',
    'https://web-class.auca.kg/~kushtar/BBus/images/map.jpg',
    'https://web-class.auca.kg/~kushtar/BBus/images/waiting.jpg',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap',
];


// cache size limit function
const limitCacheSize = (name, size) => {
  caches.open(name).then(cache => {
    cache.keys().then(keys => {
      if(keys.length > size){
        cache.delete(keys[0]).then(limitCacheSize(name, size));
      }
    });
  });
};

// install event
self.addEventListener('install', evt => {
  //console.log('service worker installed');
  evt.waitUntil(
    caches.open(staticCacheName).then((cache) => {
      console.log('caching shell assets');
      cache.addAll(assets);
    })
  );
});

// activate event
self.addEventListener('activate', evt => {
  //console.log('service worker activated');
  evt.waitUntil(
    caches.keys().then(keys => {
      //console.log(keys);
      return Promise.all(keys
        .filter(key => key !== staticCacheName)
        .map(key => caches.delete(key))
      );
    })
  );
});

//// fetch event
//self.addEventListener('fetch', evt => {
//  //console.log('fetch event', evt);
//  evt.respondWith(
//    caches.match(evt.request).then(cacheRes => {
//      return cacheRes || fetch(evt.request).then(fetchRes => {
//        return caches.open(dynamicCacheName).then(cache => {
//
//          if(!evt.request.url.includes("Update.php") || !evt.request.url.includes("DeletePoint.php") || !evt.request.url.includes("Markers.php") || !evt.request.url.includes("UpdatePoint.php")){
//                cache.put(evt.request.url, fetchRes.clone());
//                console.log('fetch event', evt.request.url);
//                 // check cached items size
//                 limitCacheSize(dynamicCacheName, 15);
//                 return fetchRes;
//          }
//
//        })
//      });
//    }).catch(() => {
//      if(evt.request.url.indexOf('.html') > -1){
//        return caches.match('./pages/fallback.html');
//      }
//    })
//  );
//});
