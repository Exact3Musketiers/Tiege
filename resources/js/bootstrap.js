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
