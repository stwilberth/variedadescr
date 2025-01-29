import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';

const firebaseConfig = {
    apiKey: "AIzaSyA6BB9zg58DPoy7uzGr5a96KgA_BhAI9TM",
    authDomain: "variedadescr-com.firebaseapp.com",
    projectId: "variedadescr-com",
    storageBucket: "variedadescr-com.firebasestorage.app",
    messagingSenderId: "980821393488",
    appId: "1:980821393488:web:f29d3f91ba29da6221d155"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Handle foreground messages
onMessage(messaging, (payload) => {
    console.log('Mensaje recibido en primer plano:', payload);
    
    // Mostrar notificación usando la API de Notifications
    if (Notification.permission === 'granted') {
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: '/icon.png',
            badge: '/badge.png',
            data: payload.data,
            requireInteraction: true,
            vibrate: [100, 50, 100]
        };

        new Notification(notificationTitle, notificationOptions);
    }
});

// Request permission and get token
export async function requestNotificationPermission() {
    try {
        console.log('Solicitando permiso de notificaciones...');
        const permission = await Notification.requestPermission();
        console.log('Permiso de notificaciones:', permission);
        
        if (permission === 'granted') {
            // Get token
            console.log('Obteniendo token...');
            const currentToken = await getToken(messaging, {
                vapidKey: 'BLlrycWmFN_i9PgApBP6fTfiJd9V1HN2D_ghLtioKYqfOXzG1V7bDx8ajllhc_NKmCMOmZoGQ9aFTtBDs3NN2eA'
            });

            if (currentToken) {
                console.log('Token obtenido:', currentToken);
                // Send token to server
                await saveTokenToServer(currentToken);
                console.log('Token guardado en el servidor');
                return currentToken;
            } else {
                console.error('No se pudo obtener el token');
                return null;
            }
        } else {
            console.log('Permiso de notificaciones denegado');
            return null;
        }
    } catch (err) {
        console.error('Error al obtener el token:', err);
        return null;
    }
}

// Save token to server
async function saveTokenToServer(token) {
    try {
        console.log('Guardando token en el servidor...');
        const response = await fetch('/fcm/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token })
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const data = await response.json();
        console.log('Token guardado exitosamente:', data);
        return data;
    } catch (error) {
        console.error('Error al guardar el token:', error);
        throw error;
    }
}
