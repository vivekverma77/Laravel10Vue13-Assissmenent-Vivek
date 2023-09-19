import './bootstrap';
import '../sass/app.scss'
//import store from '@/stores'
import { createPinia } from "pinia";
import route from "./router";
import App from "./App.vue";
import { createApp } from "vue";

const app = createApp(App);
//app.use(store)
app.use(createPinia()); 
app.use(route);
app.mount("#app");
