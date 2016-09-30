'use strict';
console.log('test');
var parser = new UAParser();
console.log(parser.getResult());
if ('serviceWorker' in navigator) {
    console.log('Service Worker is supported');
    navigator.serviceWorker.register('sw.js').then(function() {
        return navigator.serviceWorker.ready;
    }).then(function(reg) {
        console.log('Service Worker is ready :^)', reg);
        reg.pushManager.subscribe({
            userVisibleOnly: true
        }).then(function(sub) {
            console.log('endpoint:', sub.endpoint);
            console.log("DEVICE_REGISTRATION_ID: ", sub.endpoint.substr(sub.endpoint.lastIndexOf('/') + 1));
            var endpoint = sub.endpoint.substr(sub.endpoint.lastIndexOf('/') + 1);
            // var url = 'GCMreg.php';
            var url = 'https://push.setddg.com/reg/' + endpoint;
            //url = 'http://localhost:8000/reg/'+endpoint;
            $.getJSON(url, endpoint, function() {
                console.log('done');
            });
        });
    }).catch(function(error) {
        console.log('Service Worker error :^(', error);
    });

} else {
    alert('the serviceWorker not supported ');
}
