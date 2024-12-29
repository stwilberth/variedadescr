import axios from 'axios';
import jQuery from 'jquery';
import '@popperjs/core';
import 'bootstrap';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$ = window.jQuery = jQuery; 