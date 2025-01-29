<template>
    <div class="notification-permission">
        <div v-if="!token" class="mb-3">
            <button @click="requestPermission" class="btn btn-primary" :disabled="loading">
                {{ loading ? 'Solicitando permiso...' : 'Activar notificaciones' }}
            </button>
        </div>
        <div v-else class="mb-3">
            <div class="alert alert-success">
                <strong>Token del dispositivo:</strong>
                <div class="mt-2">
                    <small class="text-break">{{ token }}</small>
                </div>
            </div>
        </div>
        <div v-if="error" class="alert alert-danger">
            {{ error }}
        </div>
    </div>
</template>

<script>
import { requestNotificationPermission } from '../firebase-init';

export default {
    name: 'NotificationPermission',
    data() {
        return {
            token: null,
            loading: false,
            error: null
        }
    },
    methods: {
        async requestPermission() {
            this.loading = true;
            this.error = null;
            try {
                const token = await requestNotificationPermission();
                if (token) {
                    this.token = token;
                } else {
                    this.error = 'No se pudo obtener el token. Por favor, asegúrate de permitir las notificaciones.';
                }
            } catch (err) {
                this.error = 'Error al solicitar permiso: ' + err.message;
            } finally {
                this.loading = false;
            }
        }
    },
    async mounted() {
        // Intentar obtener el token automáticamente si ya hay permiso
        if (Notification.permission === 'granted') {
            await this.requestPermission();
        }
    }
}
</script>
