'use strict';
  if ('serviceWorker' in navigator) {
    console.log('Service Worker is supported');
    navigator.serviceWorker.register('sw.js').then(function() {
      return navigator.serviceWorker.ready;
    }).then(function(reg) {
      console.log('Service Worker is ready :^)', reg);
      reg.pushManager.subscribe({userVisibleOnly: true}).then(function(sub) {
        console.log('endpoint:', sub.endpoint);
        console.log("DEVICE_REGISTRATION_ID: ", sub.endpoint.substr(sub.endpoint.lastIndexOf('/') + 1));
        
        var endpoints = sub.endpoint.substr(sub.endpoint.lastIndexOf('/') + 1) ;
        var expire_days = 1;
        var d = new Date();
        d.setTime(d.getTime() + (expire_days * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();

        //document.cookie="uid="+endpoints+"; " +expires+"; path=/";
        location.href="https://www.mtv.com.tw/push_demo/pushServer/endPointReg.php?gcmRegID="+endpoints;

      });
    }).catch(function(error) {
      console.log('Service Worker error :^(', error);
    });

  }else{
    alert('the serviceWorker not supported ');
  }