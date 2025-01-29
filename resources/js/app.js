import axios from 'axios';
import { createApp } from 'vue';

// Componentes Vue
import ProductImageSlider from './components/ProductImageSlider.vue';
import ProductsSlider from './components/ProductsSlider.vue';
import NotificationButton from './components/NotificationButton.vue';
import NotificationPermission from './components/NotificationPermission.vue';

const app = createApp({});
app.component('product-image-slider', ProductImageSlider);
app.component('products-slider', ProductsSlider);
app.component('notification-button', NotificationButton);
app.component('notification-permission', NotificationPermission);

app.mount('#app');
