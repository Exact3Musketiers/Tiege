/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// window.Vue = require('vue').default;

try {
    window.Popper = require('@popperjs/core').default;

    require('bootstrap');
} catch (e) {}



import Echo from 'laravel-echo'

import Pusher from "pusher-js"

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '7e6ac8a8de72212bf68d',
  cluster: 'eu',
  forceTLS: true
});

window.Echo.channel('challengers')
    .listen('StartWikiChallenge', e => {
        console.log(e.user.name + ' HATH COMMETH!!!!');
    })
