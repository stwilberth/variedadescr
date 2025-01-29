// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyA6BB9zg58DPoy7uzGr5a96KgA_BhAI9TM",
    authDomain: "variedadescr-com.firebaseapp.com",
    projectId: "variedadescr-com",
    storageBucket: "variedadescr-com.appspot.com",
    messagingSenderId: "980821393488",
    appId: "1:980821393488:web:f29d3f91ba29da6221d155"
};

// Initialize Firebase
console.log('Initializing Firebase...');
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// Function to initialize notifications
async function initializeNotifications() {
    console.log('Starting notification initialization...');
    try {
        console.log('Requesting notification permission...');
        const permission = await Notification.requestPermission();
        console.log('Permission:', permission);
        
        if (permission === 'granted') {
            // Get FCM token
            console.log('Getting FCM token...');
            const token = await messaging.getToken({
                vapidKey: 'BLlrycWmFN_i9PgApBP6fTfiJd9V1HN2D_ghLtioKYqfOXzG1V7bDx8ajllhc_NKmCMOmZoGQ9aFTtBDs3NN2eA'
            });
            console.log('FCM Token:', token);
            
            // Save token to server
            console.log('Saving token to server...');
            await fetch('/api/save-fcm-token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ token })
            });
            
            // Handle foreground messages
            console.log('Setting up foreground message handler...');
            messaging.onMessage((payload) => {
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

// Make function available globally
window.initializeNotifications = initializeNotifications;

// Log when the script loads
console.log('Notifications script loaded!');
