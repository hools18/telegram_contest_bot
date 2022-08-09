window.$ = window.jQuery = require('jquery');
window._ = require('lodash');
window.Popper = require('popper.js').default;
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.moment = require('moment');
require('admin-lte');
require('tempusdominus-bootstrap-4');

