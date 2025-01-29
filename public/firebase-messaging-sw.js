self.addEventListener('install', (event) => {
    console.log('Service Worker installing...');
});

self.addEventListener('activate', (event) => {
    console.log('Service Worker activating...');
});

importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyA6BB9zg58DPoy7uzGr5a96KgA_BhAI9TM",
  authDomain: "variedadescr-com.firebaseapp.com",
  projectId: "variedadescr-com",
  storageBucket: "variedadescr-com.firebasestorage.app",
  messagingSenderId: "980821393488",
  appId: "1:980821393488:web:f29d3f91ba29da6221d155"
});

const messaging = firebase.messaging();

self.addEventListener('push', function(event) {
    console.log('[Service Worker] Push Received:', event);
});

messaging.onBackgroundMessage((payload) => {
  console.log('[firebase-messaging-sw.js] Received background message:', payload);
  
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/icon.png',
    data: payload.data
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});
