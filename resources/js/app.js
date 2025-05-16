import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Laravel Echo and Pusher configuration
 */
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Enable Pusher logging to console
window.Pusher.logToConsole = true;

window.Pusher = Pusher;

// console.log(import.meta.env.VITE_PUSHER_APP_KEY);
// console.log(import.meta.env.VITE_PUSHER_APP_CLUSTER);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Subscribe to the channel and listen for the event
window.Echo.channel('sensor-alerts')
    .listen('.SensorAlertTriggered', (event) => {
        // console.log('Received event:', event);

        // Ensure that showToast is accessible
        if (typeof showToast === 'function') {
            showToast(event.alert_level, event.sensor_name, event.sensor_id);
        } else {
            console.error('showToast function is not defined');
        }
    });
