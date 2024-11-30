import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "c1cd5aa79bd5acc2e762",
    cluster: "ap2",
    encrypted: true,
});

