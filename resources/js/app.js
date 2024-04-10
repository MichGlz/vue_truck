import './bootstrap';

import { createApp } from 'vue';
import App from "./Vue/App.vue";

// Vuetify
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    components,
    directives,
})


const app = createApp({
    components: {
        App,
    }
}).use(vuetify).mount("#app");
