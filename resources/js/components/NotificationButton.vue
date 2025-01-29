<template>
  <button 
    class="btn"
    :class="buttonClass"
    @click="requestNotifications"
    :disabled="isDisabled"
  >
    <i :class="iconClass"></i> {{ buttonText }}
  </button>
</template>

<script>
import { initializeNotifications } from '../firebase';

export default {
  name: 'NotificationButton',
  data() {
    return {
      isDisabled: false,
      status: 'default'
    }
  },
  computed: {
    buttonClass() {
      switch(this.status) {
        case 'success': return 'btn-success';
        case 'error':
        case 'blocked': return 'btn-danger';
        default: return 'btn-primary';
      }
    },
    iconClass() {
      switch(this.status) {
        case 'success': return 'fas fa-bell';
        case 'error':
        case 'blocked': return 'fas fa-bell-slash';
        default: return 'fas fa-bell';
      }
    },
    buttonText() {
      switch(this.status) {
        case 'success': return 'Notificaciones activadas';
        case 'error': return 'Error al activar notificaciones';
        case 'blocked': return 'Notificaciones bloqueadas';
        default: return 'Activar notificaciones';
      }
    }
  },
  methods: {
    async requestNotifications() {
      console.log('Button clicked!');
      this.isDisabled = true;

      try {
        console.log('Calling initializeNotifications...');
        const result = await initializeNotifications();
        console.log('Result:', result);
        
        this.status = result ? 'success' : 'blocked';
      } catch (error) {
        console.error('Error requesting notifications:', error);
        this.status = 'error';
      }

      setTimeout(() => {
        this.isDisabled = false;
      }, 2000);
    }
  },
  mounted() {
    console.log('Vue component mounted');
    if (Notification.permission === 'granted') {
      this.status = 'success';
    }
  }
}
</script>

<style scoped>
.btn {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  transition: all 0.3s ease;
}

.btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
}
</style>
