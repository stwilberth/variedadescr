import axios from 'axios';
import jQuery from 'jquery';
import '@popperjs/core';
import 'bootstrap';
import '../sass/app.scss';
import { createApp } from 'vue';

// Componentes Vue
import ProductImageSlider from './components/ProductImageSlider.vue';
import ProductsSlider from './components/ProductsSlider.vue';

const app = createApp({});
app.component('product-image-slider', ProductImageSlider);
app.component('products-slider', ProductsSlider);

app.mount('#app');

