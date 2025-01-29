import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, onMessage } from 'firebase/messaging';
import { registerServiceWorker } from './service-worker';

const firebaseConfig = {
    apiKey: "AIzaSyA6BB9zg58DPoy7uzGr5a96KgA_BhAI9TM",
    authDomain: "variedadescr-com.firebaseapp.com",
    projectId: "variedadescr-com",
    storageBucket: "variedadescr-com.firebasestorage.app",
    messagingSenderId: "980821393488",
    appId: "1:980821393488:web:f29d3f91ba29da6221d155"
};

// Initialize Firebase
console.log('Initializing Firebase...');
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Function to initialize notifications
export async function initializeNotifications() {
    console.log('Starting notification initialization...');
    
    if (!('Notification' in window)) {
        console.error('This browser does not support notifications');
        return false;
    }

    try {
        console.log('Requesting notification permission...');
        const permission = await Notification.requestPermission();
        console.log('Permission:', permission);
        
        if (permission === 'granted') {
            // Register service worker first
            console.log('Registering service worker...');
            const registration = await registerServiceWorker();
            console.log('Service worker registered successfully');

            // Get FCM token
            console.log('Getting FCM token...');
            const token = await getToken(messaging, {
                vapidKey: 'BLlrycWmFN_i9PgApBP6fTfiJd9V1HN2D_ghLtioKYqfOXzG1V7bDx8ajllhc_NKmCMOmZoGQ9aFTtBDs3NN2eA',
                serviceWorkerRegistration: registration
            });
            
            if (!token) {
                console.error('No registration token available');
                return false;
            }
            
            console.log('FCM Token:', token);
            
            // Save token to server
            console.log('Saving token to server...');
            const response = await fetch('/api/save-fcm-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ token })
            });

            if (!response.ok) {
                console.error('Failed to save token:', await response.text());
                return false;
            }
            
            // Handle foreground messages
            onMessage(messaging, (payload) => {
                console.log('Message received:', payload);
                new Notification(payload.notification.title, {
                    body: payload.notification.body,
                    icon: '/icon.png'
                });
            });
            
            console.log('Notification initialization complete!');
            return true;
        }
        console.log('Notification permission denied');
        return false;
    } catch (error) {
        console.error('Error initializing notifications:', error);
        return false;
    }
}

// Make function available globally for the service worker
window.initializeNotifications = initializeNotifications;
