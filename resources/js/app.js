import axios from 'axios';
import jQuery from 'jquery';
import '@popperjs/core';
import 'bootstrap';
import { createApp } from 'vue';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 
window.$ = window.jQuery = jQuery;

import ProductImageSlider from './components/ProductImageSlider.vue';
import ProductsSlider from './components/ProductsSlider.vue';
const app = createApp({});
app.component('product-image-slider', ProductImageSlider);
app.component('products-slider', ProductsSlider);

app.mount('#app');

