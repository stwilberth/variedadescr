<template>
    <div v-if="imagenes && imagenes.length > 0">
        <!-- Slider principal -->
        <swiper-container 
            :slides-per-view="1"
            :navigation="true"
            :pagination="true"
            ref="mainSwiper"
            @swiper="onSwiperInit"
        >
            <swiper-slide v-for="imagen in imagenes" :key="imagen.id">
                <a :href="`/storage/productos/${imagen.ruta}`" data-lightbox="roadtrip">
                    <img 
                        class="w-100" 
                        :src="`/storage/productos/${imagen.ruta}`" 
                        :alt="productoNombre"
                        loading="lazy"
                        @error="handleImageError"
                    >
                </a>
            </swiper-slide>
            
            <swiper-slide v-if="urlTiktok" v-html="urlTiktok"></swiper-slide>
        </swiper-container>

        <!-- Thumbnails -->
        <div class="d-flex justify-content-center gap-2 mt-3">
            <swiper-container
                :slides-per-view="'auto'"
                :space-between="THUMB_SPACE"
                :free-mode="true"
                :watch-slides-progress="true"
                class="thumbs-container"
            >
                <swiper-slide 
                    v-for="imagen in imagenes" 
                    :key="imagen.id"
                    class="thumb-slide"
                    @click="goToSlide(imagen.id)"
                >
                    <img 
                        :src="`/storage/productos/${imagen.ruta}`" 
                        :alt="productoNombre"
                        class="img-thumbnail"
                        :style="thumbnailStyle"
                        loading="lazy"
                        @error="handleImageError"
                    >
                </swiper-slide>
                
                <swiper-slide v-if="urlTiktok" @click="goToSlide(imagenes.length)">
                    <img 
                        src="../../img/tik-tok.png" 
                        :alt="productoNombre"
                        class="img-thumbnail"
                        :style="thumbnailStyle"
                        loading="lazy"
                        @error="handleImageError"
                    >
                </swiper-slide>
            </swiper-container>
        </div>
    </div>
    <img 
        v-else 
        src="../../img/sin_foto.png" 
        alt="Producto sin imagen"
        @error="handleImageError"
    >
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { register } from 'swiper/element/bundle';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import lightbox from 'lightbox2';
import 'lightbox2/dist/css/lightbox.min.css';

// Constantes
const THUMB_SIZE = 60;
const THUMB_SPACE = 10;

register();

const props = defineProps({
    imagenes: {
        type: Array,
        required: true
    },
    urlTiktok: {
        type: String,
        default: ''
    },
    productoNombre: {
        type: String,
        required: true
    }
});

const mainSwiper = ref(null);

// Computed properties
const thumbnailStyle = computed(() => ({
    height: `${THUMB_SIZE}px`,
    width: `${THUMB_SIZE}px`,
    cursor: 'pointer',
    objectFit: 'cover'
}));

const sanitizedTiktokUrl = computed(() => {
    // Sanitizar el HTML del TikTok para prevenir XSS
    return props.urlTiktok?.replace(/[<>]/g, '') || '';
});

// Methods
const goToSlide = (index) => {
    if (mainSwiper.value?.swiper) {
        const slideIndex = props.imagenes.findIndex(img => img.id === index);
        mainSwiper.value.swiper.slideTo(slideIndex >= 0 ? slideIndex : index);
    }
};

const handleImageError = (event) => {
    event.target.src = '../../img/sin_foto.png';
};

const onSwiperInit = (swiper) => {
    // Inicialización adicional del swiper si es necesaria
    console.log('Swiper initialized', swiper);
};

// Inicializar lightbox
onMounted(() => {
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': "Imagen %1 de %2"
    });
});
</script>

<style scoped>
.thumbs-container {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.thumb-slide {
    width: auto !important;
}

:deep(swiper-container) {
    --swiper-navigation-color: #000;
    --swiper-pagination-color: #000;
    --swiper-navigation-size: 25px;
}

.img-thumbnail {
    transition: transform 0.2s ease;
}

.img-thumbnail:hover {
    transform: scale(1.05);
}
</style> 