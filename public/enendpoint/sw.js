'use strict';

var GCM_API_ENDPOINT = 'https://www.mtv.com.tw/push_demo/pushServer/gcmEndPoint.php';

console.log('Started', self);

self.addEventListener('install', function(event) {
  self.skipWaiting();
  console.log('Installed', event);
});

self.addEventListener('activate', function(event) {
  console.log('Activated', event);
});

self.addEventListener('push', function(event) {
  console.log('Received Push message', event);
  event.waitUntil(
    
    fetch(GCM_API_ENDPOINT).then(function(response) {
      if (response.status !== 200) {
        throw new Error('Invalid status code from  API: ' +
          response.status);
      }
      return response.json();
    }).then(function(data) {
      console.log('API data: ', data);

      var title = data.title || "";
      var message = data.message || "";
      var icon = data.icon || "images/mtv.jpg";
      var click_url = data.url || "https://www.mtv.com.tw/";
      var notificationData = {
               url: click_url
          };
        
      return self.registration.showNotification(title, {
          body: message,
          icon: icon,
          data: notificationData,
      });
    }).catch(function(err) {
      console.error('A Problem occured with handling the push msg', err);
    })
  );

});

self.addEventListener('notificationclick', function(event) {
  console.log('Notification click: tag', event.notification.tag);
  event.notification.close();
  let clickResponsePromise = Promise.resolve();
  if (event.notification.data && event.notification.data.url) {
    clickResponsePromise = clients.openWindow(event.notification.data.url);
  }
  event.waitUntil(
    Promise.all([
      clickResponsePromise,
      self.analytics.trackEvent('notification-click')
    ])
  );
});

self.addEventListener('notificationclose', function(event) {
  event.waitUntil(
    Promise.all([
      self.analytics.trackEvent('notification-close')
    ])
  );
});