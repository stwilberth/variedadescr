<template>
    <div class="products-slider">
        <h2 class="products-slider__title">{{ titulo }}</h2>
        <swiper-container :slides-per-view="4" :space-between="20" :navigation="true" :breakpoints="{
            320: { slidesPerView: 2, spaceBetween: 10 },
            640: { slidesPerView: 3, spaceBetween: 10 },
            768: { slidesPerView: 4, spaceBetween: 10 },
            1024: { slidesPerView: 6, spaceBetween: 10 }
        }">
            <swiper-slide v-for="product in products" :key="product.id" class="product-card">
                <div class="product-card__info">
                    <p class="price">¢{{ formatPrice(product.precio_venta) }}</p>
                </div>
                <div class="product-card__image" v-if="product.imagenes && product.imagenes.length > 0">
                    <a :href="`catalogo/${product.catalogo_m.slug}/${product.slug}`">
                        <img :src="`/storage/productos/${product.imagenes[0].ruta}`" :alt="product.nombre" loading="lazy"
                            @error="handleImageError">
                    </a>
                </div>
                <div class="product-card__info">
                    <h3>{{ product.nombre }}</h3>
                </div>
            </swiper-slide>
        </swiper-container>
    </div>
</template>

<script setup>
import { register } from 'swiper/element/bundle';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

register();

const props = defineProps({
    products: {
        type: Array,
        required: true
    },
    titulo: {
        type: String,
        required: true
    }
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('es-CR').format(price);
};

const handleImageError = (event) => {
    event.target.src = '../../img/sin_foto.png';
};
</script>

<style scoped>
.products-slider {
    margin: 2rem 0;
    padding: 0 1rem;
}

.products-slider__title {
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: #4caf50;
}

.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.5rem;
    border: 1px solid #eee;
    border-radius: 8px;
    transition: transform 0.2s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.product-card__image {
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.product-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-card__info {
    text-align: center;
    width: 100%;
}

.product-card__info h3 {
    font-size: 1rem;
    margin: 0.5rem 0;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

.price {
    font-weight: bold;
    color: #2c3e50;
    font-size: 1rem;
}

@media (max-width: 480px) {
    .product-card__info h3 {
        font-size: 0.75rem !important;
    }
    .price {
        font-size: 0.875rem !important;
    }
}

@media (min-width: 481px) and (max-width: 768px) {
    .product-card__info h3 {
        font-size: 0.875rem !important;
    }
    .price {
        font-size: 0.875rem !important;
    }
}

:deep(swiper-container) {
    --swiper-navigation-color: #000;
    --swiper-pagination-color: #000;
    --swiper-navigation-size: 25px;
}
</style>
