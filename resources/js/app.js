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

    window.errorLogUrl = "{{ route('error-log.index') }}";
    window.Echo.channel('notification-channel')
        .listen('.notification-event', (event) => {
            console.log('🔔 Notification Event:', event);
    
            const badge = document.getElementById('notification-count');
            const list = document.getElementById('notification-list');
    
            if (badge && list) {
                // Create notification item
                const item = document.createElement('li');
                item.innerHTML = `
                    <a href="" class="dropdown-item">
                        <i class="bi bi-bell-fill text-warning"></i>
                        <strong>${event.title}</strong><br>
                        <span>${event.body}</span><br>
                        <small class="text-muted">${event.timestamp}</small>
                    </a>
                `;
    
                // Add to list
                list.prepend(item);
                
                // Update badge count and make sure it's visible
                const currentCount = parseInt(badge.textContent || 0) + 1;
                badge.textContent = currentCount;
                
                // Show badge if it was hidden
                if (currentCount > 0) {
                    badge.style.display = 'inline';
                    // or if using Bootstrap classes:
                    // badge.classList.remove('d-none');
                }
            }
        });

