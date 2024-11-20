// import './bootstrap';

import Echo from "laravel-echo";
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    cluster: import.meta.env.VITE_REVERB_APP_CLUSTER,
    forceTLS: true
});

window.Echo.private('chat.9d829585-50dc-4852-ae32-e209f6084751')
    .listen('GotMessage', (e) => {
        const messageList = document.getElementById('messages');
        const messageElement = document.createElement('li');
        messageElement.textContent = e.message;
        messageList.appendChild(messageElement);
    });

