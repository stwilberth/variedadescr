import './bootstrap';
import '../css/app.css';

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import '@popperjs/core';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import '@fortawesome/fontawesome-free/css/all.min.css';

import 'lightbox2/dist/js/lightbox';
import 'lightbox2/dist/css/lightbox.css';

import { createApp } from 'vue';

import InvenComp from './components/InvenComp.vue';
const app = createApp({});
app.component('inven-comp', InvenComp);
app.mount('#app');
