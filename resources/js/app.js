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
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ABCDEFG',
		cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

app.component('data-component', Main);
app.component(VueFeather.name, VueFeather);
app.component('VueDatePicker', VueDatePicker);
app.component('Loader', Loader)

app.use(router).mount('#app')
