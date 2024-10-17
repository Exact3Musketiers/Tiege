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
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: 'eu',
  forceTLS: true
});
