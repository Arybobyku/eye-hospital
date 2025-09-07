import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Main from './main.vue';
import router from './router.js';
import VueFeather from 'vue-feather';
import Loader from './section/Loader.vue';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp({});
app.config.globalProperties.$dbNameIndexDb = 'indexDbHospital';
app.config.globalProperties.$debugs = true;
// app.mixin({
// 	globalHelper: function (component) { 
// 		defineAsyncComponent(() => import(component));
// 		console.log("Hello world") 
// 	},
// });
import Pusher from 'pusher-js';
window.Pusher = Pusher;

import Echo from 'laravel-echo';
// TODO: PUSHER LOKAL
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'ABCDEFG',
// 		cluster: 'mt1',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     forceTLS: false,
//     disableStats: true,
// });


window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: true, // pusher.com butuh TLS
});

app.component('data-component', Main);
app.component(VueFeather.name, VueFeather);
app.component('VueDatePicker', VueDatePicker);
app.component('Loader', Loader)

app.use(router).mount('#app')
