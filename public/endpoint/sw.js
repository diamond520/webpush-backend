'use strict';

var GCM_API_ENDPOINT = 'https://push.setddg.com/push/latest';
// GCM_API_ENDPOINT = 'http://localhost:8000/push/latest';
importScripts('./js/analytics.js');

self.analytics.trackingId = 'UA-84589149-2';

console.log('Started');

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

      const title = data.title || [];
      const notificationOptions = {
        body: data.body || [],
        icon: data.icon || "images/push.png",
        tag: data.action || "http://www.setddg.com/"
      };
      // var message = data.body || [];
      // var icon = data.icon || "images/push.png";
      // var click_url = data.action || "http://www.setddg.com/";
      // var notificationData = {
      //          url: click_url
      //     };
      // event.waitUntil(
      //   Promise.all([
      //     self.registration.showNotification(title, notificationOptions), self.analytics.trackEvent('push-received')
      //   ])
      // );
      return self.registration.showNotification(title, notificationOptions);

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