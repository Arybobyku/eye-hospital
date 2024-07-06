import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler';
import Main from './main.vue';
import router from './router.js';
import VueFeather from 'vue-feather';
import Loader from './section/Loader.vue';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueDatePicker from '@vuepic/vue-datepicker';
import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi';

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

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      mdi,
    },
  },
});


app.use(vuetify);
app.component('data-component', Main);
app.component(VueFeather.name, VueFeather);
app.component('VueDatePicker', VueDatePicker);
app.component('Loader', Loader)

app.use(router).mount('#app')
