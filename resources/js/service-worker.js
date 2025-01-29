export async function registerServiceWorker() {
    if (!('serviceWorker' in navigator)) {
        throw new Error('Service workers are not supported');
    }

    try {
        // Get the base URL
        const baseUrl = window.location.origin;
        const swUrl = new URL('./firebase-messaging-sw.js', baseUrl).href;

        console.log('Registering service worker from:', swUrl);

        // Check if the service worker is already registered
        const existingRegistration = await navigator.serviceWorker.getRegistration(swUrl);
        if (existingRegistration) {
            console.log('Service worker already registered:', existingRegistration);
            return existingRegistration;
        }

        // Register the new service worker
        const registration = await navigator.serviceWorker.register(swUrl, {
            scope: './'
        });

        console.log('Service worker registration successful with scope:', registration.scope);

        // Wait for the service worker to be ready
        await navigator.serviceWorker.ready;
        console.log('Service worker is ready');

        // Handle service worker updates
        registration.addEventListener('updatefound', () => {
            const newWorker = registration.installing;
            newWorker.addEventListener('statechange', () => {
                if (newWorker.state === 'activated') {
                    console.log('New service worker activated');
                }
            });
        });

        return registration;
    } catch (error) {
        console.error('Service worker registration failed:', error);
        throw error;
    }
}