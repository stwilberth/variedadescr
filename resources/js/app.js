import axios from 'axios';
import { createApp } from 'vue';

// Componentes Vue
import ProductImageSlider from './components/ProductImageSlider.vue';
import ProductsSlider from './components/ProductsSlider.vue';

const app = createApp({});
app.component('product-image-slider', ProductImageSlider);
app.component('products-slider', ProductsSlider);

app.mount('#app');

