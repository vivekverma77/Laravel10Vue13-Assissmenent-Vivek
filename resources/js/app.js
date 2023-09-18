import './bootstrap';
import '../sass/app.scss'
import Router from '@/router'
import store from '@/store'
import { createPinia } from 'pinia';

import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({})
app.use(Router)
app.use(store)
app.use(createPinia()); 
app.mount('#app')