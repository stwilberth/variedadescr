import axios from 'axios';
import jQuery from 'jquery';
import '@popperjs/core';
import 'bootstrap';
import '../sass/app.scss';
import { createApp } from 'vue';

// Configuración de axios
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 

// Configuración de jQuery
window.$ = window.jQuery = jQuery;

// Componentes Vue
import ProductImageSlider from './components/ProductImageSlider.vue';
import ProductsSlider from './components/ProductsSlider.vue';

const app = createApp({});
app.component('product-image-slider', ProductImageSlider);
app.component('products-slider', ProductsSlider);

app.mount('#app');

